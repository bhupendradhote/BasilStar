
@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terms & Conditions - BasilStar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#005550',
                        limeGreen: '#B4FF57',
                        darkGreen: '#022f2e'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-gray-800 font-sans">

    <section class="bg-white py-20 px-4 mt-10 md:px-10 lg:px-20">
        <div class="max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
    
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">Terms and Conditions</h1>
            <p class="text-primary font-semibold mb-8">Effective Date: June 28, 2025</p>
    
            <div class="space-y-10 text-gray-700 text-[1.05rem] leading-relaxed">
    
                <p>
                    Welcome to <strong>BasilStar Private Limited</strong>. These Terms and Conditions govern your access to
                    and use of our website, tools, insights, and services.
                    By using our platform, you agree to be bound by these terms. If you do not agree, please refrain from
                    using our services.
                </p>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">1. Eligibility & Compliance</h2>
                    <p>
                        Users must be 18 years or older and legally capable of entering binding contracts. All users are
                        expected to comply with SEBI regulations while interacting with our services.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">2. SEBI Disclaimer</h2>
                    <p>
                        BasilStar is a SEBI-registered Research Analyst (RA) firm. We provide stock research and market
                        insights for educational and informational purposes.
                        Investment decisions should always be made with consideration of personal financial goals and
                        consultation with a certified advisor.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">3. Use of Content</h2>
                    <p>
                        All data, visuals, tools, and reports are the intellectual property of BasilStar. Reproduction,
                        redistribution, or commercial use without permission is strictly prohibited.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">4. User Responsibilities</h2>
                    <ul class="list-disc list-inside space-y-1 mt-2">
                        <li>You agree to provide accurate information while registering or communicating with us.</li>
                        <li>You will not engage in any activity that disrupts or harms the website or services.</li>
                        <li>You are solely responsible for evaluating risks before making financial decisions.</li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">5. Limitation of Liability</h2>
                    <p>
                        BasilStar shall not be liable for any financial loss, market impact, or personal damages resulting
                        from the use of our analysis or content. All insights are subject to market risk.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">6. Termination</h2>
                    <p>
                        We reserve the right to restrict or terminate access to any user found violating these terms or
                        engaging in misuse of the platform, without prior notice.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">7. Changes to Terms</h2>
                    <p>
                        BasilStar may update these Terms and Conditions at any time. Continued use of the platform after
                        updates implies acceptance of the revised terms.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">8. Contact Us</h2>
                    <p>If you have any questions about these terms, please contact our team:</p>
                    <p class="mt-2">
                        <strong>Email:</strong>
                        <a href="mailto:Basilstarhyd@gmail.com"
                            class="text-primary hover:underline">Basilstarhyd@gmail.com</a><br />
                        <strong>Registered Office:</strong> Hyderabad, Telangana, India
                    </p>
                </div>
    
            </div>
        </div>
    </section>
      

    

</body>

</html>
@endsection