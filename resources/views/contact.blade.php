
@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
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

    <!-- Contact Section -->
<section class="bg-[#005550] py-16 px-6 mt-10">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

    <!-- Left: Contact Info -->
    <div>
      <p class="text-[#a0f4d9] font-semibold uppercase tracking-wide mb-3">Connect with Basil Star</p>
      <h2 class="text-4xl lg:text-5xl font-extrabold text-white leading-snug mb-6">
        We're Here to Help <br /> With Every Market Move
      </h2>
      <p class="text-[#cde6df] mb-8 max-w-xl">
        Have questions about our research, services, or potential collaborations? Basil Star's expert team is just a message away. Whether you're an investor, partner, or simply curious — reach out to experience clarity, guidance, and results-driven support.
      </p>

      <div class="space-y-8 max-w-md">
        <!-- Email -->
        <div class="flex items-start space-x-5">
          <div class="w-12 h-12 bg-[#49c9a3] text-white flex items-center justify-center rounded-full shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 12H8m0 0l4-4m-4 4l4 4m-2 4a9 9 0 110-18 9 9 0 010 18z" />
            </svg>
          </div>
          <div>
            <h4 class="text-white font-semibold text-lg mb-1">Email Us</h4>
            <p class="text-[#b8d8ce] select-text">Basilstarhyd@gmail.com</p>
          </div>
        </div>

        <!-- Phone -->
        <div class="flex items-start space-x-5">
          <div class="w-12 h-12 bg-[#49c9a3] text-white flex items-center justify-center rounded-full shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 5h2l3 5-2 2a16 16 0 006 6l2-2 5 3v2a2 2 0 01-2 2A18 18 0 013 7a2 2 0 012-2z" />
            </svg>
          </div>
          <div>
            <h4 class="text-white font-semibold text-lg mb-1">Call Us</h4>
            <p class="text-[#b8d8ce] select-text">+91 8698099612</p>
          </div>
        </div>

        <!-- Address -->
        <div class="flex items-start space-x-5">
          <div class="w-12 h-12 bg-[#49c9a3] text-white flex items-center justify-center rounded-full shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 0v10m0 0H9m3 0h3" />
            </svg>
          </div>
          <div>
            <h4 class="text-white font-semibold text-lg mb-1">Office</h4>
            <p class="text-[#b8d8ce] leading-relaxed max-w-sm">
              3rd Floor, Office No.3D, Plot 46 & 46/A, Sirimalle Gardens, Hyderguda, Hyderabad, Telangana (500048)
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Contact Form -->
    <div class="bg-[#52fcb1] p-10 rounded-3xl shadow-lg">
      <form class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-[#10443f] mb-2">Your Name</label>
          <input
            type="text"
            placeholder="Enter your name"
            class="w-full px-5 py-3 rounded-md border border-gray-300 bg-[#e4f9e1] text-[#10443f] placeholder:text-[#5c7e75] focus:ring-2 focus:ring-[#49c9a3] focus:outline-none transition"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium text-[#10443f] mb-2">Email Address</label>
          <input
            type="email"
            placeholder="you@example.com"
            class="w-full px-5 py-3 rounded-md border border-gray-300 bg-[#e4f9e1] text-[#10443f] placeholder:text-[#5c7e75] focus:ring-2 focus:ring-[#49c9a3] focus:outline-none transition"
            required>
        </div>
        <div>
          <label class="block text-sm font-medium text-[#10443f] mb-2">Your Message</label>
          <textarea rows="4" placeholder="Type your message..."
            class="w-full px-5 py-3 rounded-md border border-gray-300 bg-[#e4f9e1] text-[#10443f] placeholder:text-[#5c7e75] focus:ring-2 focus:ring-[#49c9a3] focus:outline-none transition"
            required></textarea>
        </div>
        <button type="submit"
          class="w-full bg-[#00443e] hover:bg-[#00332d] text-white font-bold py-3 rounded-full transition duration-300">
          Send Message
        </button>
      </form>
    </div>
  </div>
</section>



    <section class="bg-[#e4f9e1] py-16 px-6 md:px-12 lg:px-24">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
     <div class="w-full">
                <img src="https://cdn-images-1.medium.com/v2/resize:fit:1121/1*NKyrYaZjK3eSGzDKnXCXDg.jpeg" alt="About Basil Star"
                    class="rounded-2xl shadow-md w-full object-cover h-auto max-h-[400px]" />
            </div>
            <!-- Text Content -->
            <div>
                <p class="text-green-500 text-lg font-semibold mb-2">Who We Are</p>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Basil Star Private Limited</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Basil Star Private Limited is a SEBI-registered Research Analyst firm dedicated to empowering our
                    clients with superior stock market insights.
                    Our team comprises skilled professionals with profound experience in research and analysis.
                    We leverage innovation, creativity, and deep knowledge to provide thorough, results-oriented research
                    that consistently leads to client satisfaction.
                </p>
            </div>
    
            <!-- Image Section -->
           
        </div>
    </section>
      


    

</body>

</html>

@endsection