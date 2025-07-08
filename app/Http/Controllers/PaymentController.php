<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use App\Http\Controllers\SubscriptionController; // Ensure SubscriptionController is imported
use App\Models\Subscription; // Ensure Subscription model is imported
use Illuminate\Support\Facades\Log; // Ensure Log facade is imported

class PaymentController extends Controller
{
    /**
     * Create a Razorpay order.
     * Requires authentication via 'auth:sanctum' middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRazorpayOrder(Request $request)
    {
        // Validate request parameters for creating an order
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'email' => 'required|email',
            'force_renewal' => 'required|boolean',
            'plan_duration' => 'required|in:monthly,threeM,yearly', // Ensure plan_duration is included in validation
        ]);

        // Check for existing active subscription if force_renewal is false
        $activeSubscription = Subscription::where('user_id', $request->user()->id)->where('status', 'active')->first();
        if ($activeSubscription && $request->force_renewal === false) {
            return response()->json([
                'message' => 'Active subscription already exists. Please cancel it before creating a new order.',
            ], 200); // 200 OK, as it's a valid condition
        }

        try {
            // Instantiate Razorpay API with keys from environment variables
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // Amount must be in the smallest currency unit (e.g., paise for INR)
            $amount = (int) $request->amount;

            $orderData = [
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => 'receipt_' . rand(1000, 9999), // Generate a unique receipt ID
            ];

            // Create the order with Razorpay
            $razorpayOrder = $api->order->create($orderData);

            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'amount' => $razorpayOrder['amount'],
                'currency' => $razorpayOrder['currency'],
            ]);
        } catch (\Exception $e) {
            // Log any errors that occur during order creation
            Log::error('Error creating Razorpay order: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating Razorpay order', 'details' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    /**
     * Verify a Razorpay payment and store subscription information.
     * Requires authentication via 'auth:sanctum' middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyRazorpayPayment(Request $request)
    {
        // Validate incoming payment verification parameters
        $request->validate([
            'payment_id' => 'required|string',
            'order_id' => 'required|string',
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'signature' => 'required|string',
            'plan_duration' => 'required|in:monthly,threeM,yearly', // Ensure plan_duration is validated here for subscription
        ]);

        try {
            // Get user ID from the authenticated request.
            // This should be available if 'auth:sanctum' middleware passes.
            $userId = $request->user()->id ?? null;

            // If user ID is missing (meaning user is not authenticated or a problem occurred),
            // return an appropriate error.
            if (!$userId) {
                return response()->json(['error' => 'User ID is missing or user not authenticated to verify payment.'], 400); // 400 Bad Request
            }

            // Instantiate Razorpay API
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $paymentId = $request->payment_id;
            $orderId = $request->order_id;
            $signature = $request->signature;

            // Generate the expected signature for verification against Razorpay's signature
            $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, env('RAZORPAY_SECRET'));

            // Compare the generated signature with the signature received from Razorpay
            if ($generatedSignature !== $signature) {
                return response()->json(['error' => 'Invalid payment signature'], 400); // 400 Bad Request
            }

            // Fetch payment details from Razorpay to confirm status
            $payment = $api->payment->fetch($paymentId);

            // Check if the payment status is 'captured'
            if ($payment->status !== 'captured') {
                return response()->json(['error' => 'Payment not captured or failed. Current status: ' . $payment->status], 400); // 400 Bad Request
            }

            // Prepare payment information to be stored in the local database
            $payInfo = [
                'payment_id' => $paymentId,
                'user_id' => $userId,
                'amount' => $request->amount,
                'email' => $request->email,
                'order_id' => $orderId,
                'be_event_id' => 1, // Assuming a default value or deriving it from logic
                'status' => $payment->status,
            ];

            // Create a new Payment record in your database
            Payment::create($payInfo);

            // Instantiate SubscriptionController and call its store method to record the user's subscription.
            // Pass the userId explicitly along with the request.
            $subscriptionController = new SubscriptionController();
            $subscriptionController->store($request, $userId); // Pass userId here

            return response()->json(['message' => 'Payment verified successfully and subscription updated.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors specifically
            Log::error('Validation error verifying Razorpay payment: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Catch any other general exceptions during payment verification
            Log::error('Error verifying Razorpay payment: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error verifying Razorpay payment',
                'details' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Deprecated method for initiating payment.
     * This endpoint is marked as deprecated as Razorpay integration is now frontend-driven.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function initiatePayment(Request $request)
    {
        return response()->json([
            'message' => 'This endpoint is deprecated. Please use createRazorpayOrder and verifyRazorpayPayment endpoints.'
        ], 410); // 410 Gone indicates the resource is no longer available
    }
}
