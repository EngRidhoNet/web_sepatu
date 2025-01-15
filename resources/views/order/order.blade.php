<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

<body class="bg-[#F5F5F0] min-h-screen antialiased">
    <!-- Main Container with Smart Breakpoints -->
    <div
        class="relative flex flex-col w-full min-h-screen mx-auto
                bg-[#F5F5F0] transition-all duration-300
                sm:max-w-[540px]
                md:max-w-[640px]
                lg:max-w-[640px]">

        <!-- Responsive Top Bar -->
        <div id="top-bar"
            class="sticky top-0 z-50 flex justify-between items-center
                    px-3 sm:px-4
                    mt-4 sm:mt-6 md:mt-[60px]
                    py-2 sm:py-3
                    bg-[#F5F5F0]/80 backdrop-blur-sm">
            <!-- Back Button with Touch Target -->
            <a href="{{ route('front.details', $shoe->slug) }}"
                class="flex items-center justify-center
                      w-8 h-8 sm:w-10 sm:h-10
                      rounded-full hover:bg-black/5
                      transition-all duration-300
                      active:scale-95">
                <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-6 h-6 sm:w-8 sm:h-8" alt="Back">
            </a>

            <!-- Title -->
            <p class="font-bold text-base sm:text-lg md:text-lg leading-normal">
                Booking
            </p>

            <!-- Placeholder for layout balance -->
            <div class="w-8 h-8 sm:w-10 sm:h-10"></div>
        </div>

        <!-- Livewire Component Integration with Responsive Container -->
        <main
            class="flex-1 flex flex-col
                     px-3 sm:px-4
                     pb-4 sm:pb-6
                     gap-4 sm:gap-5">
            @livewire('order-form', [
                'shoe' => $shoe,
                'orderData' => $orderData,
            ])
        </main>
    </div>

    {{-- <script src="{{ asset('js/booking.js') }}"></script> --}}
</body>

</html>
