<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Subscription Plan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .col-md-4 {
            padding: 15px;
        }
        .btn-block {
            padding: 15px 20px;
            font-size: 1.1rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-block:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #343a40; /* Adjust text color for warning button */
        }
        #messageDisplay {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
            display: none; /* Hidden by default */
        }
        .message-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Choose Your Subscription Plan</h2>
        <div id="messageDisplay" class="alert"></div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form data-plan-duration="monthly">
                    @csrf
                    <input type="hidden" name="amount" value="10000">
                    <input type="hidden" name="plan_duration" value="monthly">
                    <input type="hidden" name="force_renewal" value="false">
                    <input type="hidden" name="email" value="" id="email-monthly">
                    <button type="submit" class="btn btn-primary btn-block">Monthly Subscription - ₹100</button>
                </form>
            </div>
            <div class="col-md-4">
                <form data-plan-duration="3months">
                    @csrf
                    <input type="hidden" name="amount" value="25000">
                    <input type="hidden" name="plan_duration" value="3months">
                    <input type="hidden" name="force_renewal" value="false">
                    <input type="hidden" name="email" value="" id="email-3months">
                    <button type="submit" class="btn btn-success btn-block">3 Months Subscription - ₹250</button>
                </form>
            </div>
            <div class="col-md-4">
                <form data-plan-duration="yearly">
                    @csrf
                    <input type="hidden" name="amount" value="90000">
                    <input type="hidden" name="plan_duration" value="yearly">
                    <input type="hidden" name="force_renewal" value="false">
                    <input type="hidden" name="email" value="" id="email-yearly">
                    <button type="submit" class="btn btn-warning btn-block">Yearly Subscription - ₹900</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get user email directly from the Blade template
            const userEmail = "{{ $userEmail ?? '' }}";
            const messageDisplay = document.getElementById('messageDisplay');

            function showMessage(message, type) {
                messageDisplay.textContent = message;
                messageDisplay.className = `alert ${type === 'success' ? 'message-success' : 'message-error'}`;
                messageDisplay.style.display = 'block';
                setTimeout(() => {
                    messageDisplay.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }

            if (userEmail) {
                document.querySelectorAll('form').forEach(form => {
                    form.querySelector('input[name="email"]').value = userEmail;
                });
            } else {
                showMessage("User email not found. Please log in.", "error");
                // Optionally disable forms if no email is found
                document.querySelectorAll('form button').forEach(button => button.disabled = true);
            }

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const formData = new FormData(form);
                    const headers = {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json' // Explicitly request JSON
                    };

                    const body = {
                        amount: parseInt(formData.get('amount')),
                        email: formData.get('email'),
                        force_renewal: formData.get('force_renewal') === 'true'
                    };

                    try {
                        const response = await fetch("{{ route('create.razorpay.order') }}", {
                            method: "POST",
                            headers,
                            body: JSON.stringify(body)
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error("Error creating Razorpay order:", response.status, errorText);
                            try {
                                const errorData = JSON.parse(errorText);
                                showMessage(errorData.message || "Failed to create payment order.", "error");
                            } catch (e) {
                                showMessage("Failed to create payment order. Server returned unexpected response.", "error");
                                console.error("Server returned non-JSON response:", errorText);
                            }
                            return;
                        }

                        const data = await response.json();

                        if (data.order_id) {
                            const options = {
                                key: "{{ env('RAZORPAY_KEY') }}",
                                amount: data.amount,
                                currency: data.currency,
                                name: "MetaWish",
                                description: "Subscription Payment",
                                order_id: data.order_id,
                                prefill: {
                                    email: formData.get('email')
                                },
                                handler: async function (response) {
                                    try {
                                        const verification = await fetch("{{ route('verify.razorpay.payment') }}", {
                                            method: "POST",
                                            headers,
                                            body: JSON.stringify({
                                                payment_id: response.razorpay_payment_id,
                                                order_id: response.razorpay_order_id,
                                                signature: response.razorpay_signature,
                                                email: formData.get('email'),
                                                amount: formData.get('amount'),
                                                plan_duration: formData.get('plan_duration')
                                            })
                                        });

                                        if (!verification.ok) {
                                            const verifyErrorText = await verification.text();
                                            console.error("Error verifying Razorpay payment:", verification.status, verifyErrorText);
                                            try {
                                                const verifyErrorData = JSON.parse(verifyErrorText);
                                                showMessage(verifyErrorData.message || "Payment verification failed.", "error");
                                            } catch (e) {
                                                showMessage("Payment verification failed. Server returned unexpected response.", "error");
                                                console.error("Server returned non-JSON response for verification:", verifyErrorText);
                                            }
                                            return;
                                        }

                                        const verifyResult = await verification.json();
                                        showMessage(verifyResult.message || "Payment successful!", "success");

                                    } catch (error) {
                                        console.error("Error during payment verification process:", error);
                                        showMessage("An error occurred during payment verification.", "error");
                                    }
                                }
                            };
                            const rzp = new Razorpay(options);
                            rzp.open();
                        } else if (data.message) {
                            // Handle specific messages from the backend, e.g., active subscription exists
                            showMessage(data.message, "info"); // Use 'info' for non-error messages
                        } else {
                            showMessage("Failed to initiate payment. No order ID received.", "error");
                        }
                    } catch (error) {
                        console.error("Network or unexpected error during payment initiation:", error);
                        showMessage("A network error occurred. Please try again.", "error");
                    }
                });
            });
        });
    </script>
</body>
</html>