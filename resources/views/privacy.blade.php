@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacy Policy - BasilStar</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#005550',
                        limeGreen: '#B4FF57',
                        darkGreen: '#022f2e',
                    }
                }
            }
        }
    </script>

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
</head>

<body class="bg-white text-gray-800">

    <!-- Privacy Policy Section -->
    <section class="bg-gray-50 py-20 px-4 mt-10 md:px-10 lg:px-20">
        <div class="max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
    
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4">Privacy Policy</h1>
            <p class="text-primary font-semibold mb-8">Effective Date: June 28, 2025</p>
    
            <div class="space-y-10 text-gray-700 text-[1.05rem] leading-relaxed">
                <p>
                    At <strong>BasilStar Private Limited</strong>, we prioritize your privacy. As a SEBI-registered Research
                    Analyst firm,
                    we are committed to protecting your personal data and maintaining full transparency about how your
                    information is used.
                </p>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">1. Information We Collect</h2>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Full name, email address, phone number</li>
                        <li>Browsing activity such as pages visited and session duration</li>
                        <li>Technical details like IP address, device, and browser type</li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">2. How We Use Your Information</h2>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Deliver personalized financial research and stock insights</li>
                        <li>Communicate important updates, newsletters, and service notices</li>
                        <li>Analyze platform performance and user behavior for improvement</li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">3. Cookies and Tracking</h2>
                    <p>
                        We use cookies to tailor your experience and enhance website functionality.
                        Cookies help us understand your preferences and improve our research delivery.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">4. Data Security</h2>
                    <p>
                        Your data security is our priority. We implement industry-standard encryption, access control,
                        and secure infrastructure to prevent unauthorized access or misuse.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">5. Third-Party Services</h2>
                    <p>
                        We may use trusted third-party tools like analytics and payment gateways. These partners follow
                        their own privacy protocols. We advise reviewing their policies where relevant.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">6. Your Rights</h2>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Request access to your stored personal data</li>
                        <li>Correct or update any inaccurate information</li>
                        <li>Withdraw consent or unsubscribe from communications</li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">7. Updates to This Policy</h2>
                    <p>
                        This Privacy Policy may be updated from time to time to reflect regulatory or service changes.
                        We encourage you to check this page periodically for the latest version.
                    </p>
                </div>
    
                <div>
                    <h2 class="text-2xl font-semibold text-primary mb-3">8. Contact Us</h2>
                    <p>
                        For questions, concerns, or privacy-related inquiries, please get in touch with our team:
                    </p>
                    <p class="mt-2">
                        <strong>Email:</strong>
                        <a href="mailto:Basilstarhyd@gmail.com"
                            class="text-primary hover:underline">Basilstarhyd@gmail.com</a><br />
                        <strong>Office Location:</strong> Hyderabad, Telangana, India
                    </p>
                </div>
            </div>
        </div>
    </section>
      

    

    <!-- AOS JS + Init (loaded last, correctly) -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
@endsection