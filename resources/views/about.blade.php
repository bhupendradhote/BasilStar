@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About</title>
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

<body class="bg-white text-gray-800">

    <!-- Main Container -->
    <section class="mt-10 py-16 px-4 bg-[#005550]">

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            <!-- Left Content -->
            <div>
                <p class="text-primary font-bold mb-2">About Us</p>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-6">
                    
                    At Basil Star Pvt Ltd, we are a SEBI Registered Research Analyst.
                </h2>
                <p class="text-gray-300 mb-4">
                    
                    
                    At Basil Star Pvt Ltd, we are a SEBI Registered Research Analyst dedicated to empowering Indian
                    stock market investors
                    and traders.
                    We stand out as a premier equity research and service provider, offering unique and
                    advanced features that
                    help our clients make informed decisions.
                </p>
                <p class="text-gray-300 text-xs truncate mb-6">
                    Our commitment is to our customers, ensuring they receive
                    unparalleled
                    service and support.
                </p>

            </div>

            <!-- Right Column -->
            <div class="space-y-10">
                <img src="https://www.sabrehospitality.com/wp/wp-content/uploads/studios-page-onboarding-training-100-min-2.webp" alt="Solar Worker"
                    class="rounded-3xl w-full object-cover h-[250px] md:h-[300px]" />

                <div>
                    <h3 class="text-2xl md:text-3xl font-semibold mb-4 text-white">
                        

                        Experienced & Knowledgeable Team: You benefit from the expertise of our seasoned professionals.

                    </h3>
                </div>
            </div>
        </div>

        <!-- Mission and Vision Cards -->
        <div class="max-w-7xl mx-auto mt-16 grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Mission Card -->
            <div class="bg-[#005550] text-white p-8 rounded-3xl shadow-lg border border-[#52fcb1]">
                <div class="text-limeGreen text-3xl font-bold mb-2">01</div>
                <h4 class="text-xl font-semibold mb-3">Our Mission</h4>
                <p>
                    We stand out as a premier equity research and service provider, offering unique and advanced
                    features that help our
                    clients make informed decisions.
                </p>
            </div>

            <!-- Vision Card -->
            <div class="bg-[#51fcb1] text-gray-900 p-8 rounded-3xl shadow-lg">
                <div class="text-3xl font-bold mb-2">02</div>
                <h4 class="text-xl font-semibold mb-3">Our Vision</h4>
                <p>
                    We leverage innovation, creativity, and deep knowledge to provide thorough, results-oriented
                    research that consistently
                    leads to client satisfaction.
                </p>
            </div>
        </div>
    </section>

    <!-- Service Section -->
    <section class="py-16 px-4 bg-[#e2f7df]">

        <div class="max-w-7xl mx-auto">
            <p class="text-primary font-bold mb-2">Our Services</p>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-10">Why Choose Us?</h2>
            <p class="text-gray-700 text-lg mb-8 max-w-4xl">
                At our core, we're dedicated to your success. We value our clients above all else, placing your
                interests,
                integrity, and fiduciary needs at the forefront of everything we do.
            </p>

            <!-- Values Section -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div class="bg-[#005550] shadow-md p-6 rounded-2xl border border-gray-200 text-white">
                    <h3 class="text-2xl font-semibold mb-4">Our Values</h3>
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Trust:</strong> We believe in actions over words. We're committed to transparency in our
                            services and fees, ensuring you always know what to expect.</li>
                        <li><strong>Process-Driven Solutions:</strong> Our focus is on finding the right solutions for you,
                            not just selling products. Our strategies are practical, realistic, and time-bound, all
                            while adhering to SEBI RIA guidelines. Every recommendation we provide is backed by thorough
                            research.
                        </li>
                    </ul>
                </div>
                

                <!-- Strengths -->
                <div class="bg-[#51fcb1] shadow-md p-6 rounded-2xl border border-gray-200">
                    <h3 class="text-2xl font-semibold text-primary mb-4">Our Strengths</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>Client-Centric Approach:</strong> Every aspect of our service is designed with you
                            in
                            mind.</li>
                        <li><strong>Market Insights:</strong> Our team stays ahead of market dynamics and possesses
                            crucial
                            insights into various industry products.</li>
                        <li><strong>Technologically Advanced:</strong> We leverage advanced technology to create
                            solutions
                            and strategies that align with your goals and maximize your wealth.</li>
                        <li><strong>Experienced & Knowledgeable Team:</strong> You benefit from the expertise of our
                            seasoned professionals.</li>
                    </ul>
                </div>
            </div>

            <p class="text-gray-700 text-lg max-w-4xl">
                We believe these principles and strengths allow us to build lasting relationships and achieve the best
                outcomes for our clients.
            </p>
        </div>
    </section>


    



</body>

</html>

@endsection