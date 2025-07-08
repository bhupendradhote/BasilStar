<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log; // Ensure Log facade is imported

class SubscriptionController extends Controller
{

    public function index(Request $request)
    {
        try {
            $authUser = $request->user();
            if (!$authUser) {
                return response()->json(['error' => 'Authentication required. User not logged in to fetch subscriptions.'], 401);
            }

            $subscription = Subscription::where('user_id', $authUser->id)->get();
            return response()->json([
                'message' => 'User Subscriptions Retrieved Successfully',
                'Subscription' => $subscription,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching subscription', 'details' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $authUser = $request->user();

            if (!$authUser) {
                return response()->json(['error' => 'Authentication required to subscribe. Please log in.'], 401);
            }

            $validated = $request->validate([
                'plan_duration' => 'required|in:monthly,threeM,yearly', // Ensure valid plan durations
            ]);

            $start_date = now();
            $end_date = null; // Initialize end_date

            if ($validated['plan_duration'] === "monthly") {
                $end_date = $start_date->copy()->addDays(30);
            } else if ($validated['plan_duration'] === "threeM") {
                $end_date = $start_date->copy()->addDays(90);
            } else if ($validated['plan_duration'] === "yearly") {
                $end_date = $start_date->copy()->addDays(365);
            }

            $activeSubscriptions = Subscription::where('user_id', $authUser->id)->where('status', 'active')->get();
            if ($activeSubscriptions->isNotEmpty()) {
                foreach ($activeSubscriptions as $subscription) {
                    $subscription->status = 'inactive';
                    $subscription->save(); // Save changes to deactivate old subscriptions
                }
            }
            $subscription = Subscription::create([
                'user_id' => $authUser->id,
                // 'plan_type' => $validated['plan_type'], // Uncomment if plan_type is used
                'status' => 'active',
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            return response()->json([
                'message' => 'User Subscription Created Successfully',
                'Subscription' => $subscription,
            ], 201); // 201 Created status code for successful creation
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error creating subscription: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error('Error creating subscription: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating subscription', 'details' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }
}
