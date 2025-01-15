<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <!-- Wrapper dengan max-width yang lebih besar untuk desktop -->
    <div class="relative flex flex-col w-full max-w-[1200px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
        <!-- Top bar dengan navigasi responsif -->
        <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px] lg:mt-[80px]">
            <a href="{{ route('front.index') }}">
                <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
            </a>
            <p class="font-bold text-lg md:text-xl lg:text-2xl leading-[27px]">Look Details</p>
            <div class="dummy-btn w-10"></div>
        </div>

        <!-- Container untuk layout desktop -->
        <div class="lg:flex lg:gap-8 lg:px-8">
            <!-- Gallery section dengan ukuran yang responsif -->
            <section id="gallery" class="flex flex-col gap-[10px] lg:w-1/2">
                <div class="flex w-full h-[250px] md:h-[350px] lg:h-[450px] shrink-0 overflow-hidden px-4 lg:px-0">
                    <img id="main-thumbnail" src="{{ Storage::url($shoe->photos()->latest()->first()->photo) }}"
                        class="w-full h-full object-contain object-center" alt="thumbnail">
                </div>
                <div class="swiper w-full overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($shoe->photos as $itemPhoto)
                            <div class="swiper-slide !w-fit py-[2px]">
                                <label
                                    class="thumbnail-selector flex flex-col shrink-0 w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28 rounded-[20px] p-[10px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700] has-[:checked]:ring-2 has-[:checked]:ring-[#FFC700]">
                                    <input type="radio" name="image" class="hidden" checked>
                                    <img src="{{ Storage::url($itemPhoto->photo) }}" class="w-full h-full object-contain"
                                        alt="thumbnail">
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Container untuk informasi produk di desktop -->
            <div class="lg:w-1/2 lg:flex lg:flex-col lg:justify-between">
                <!-- Info section dengan spacing yang responsif -->
                <section id="info" class="flex flex-col gap-[14px] px-4 lg:px-0">
                    <div class="flex items-center justify-between">
                        <h1 id="title" class="font-bold text-2xl md:text-3xl lg:text-4xl leading-9">
                            {{ $shoe->name }}
                        </h1>
                        <div class="flex flex-col items-end shrink-0">
                            <div class="flex items-center gap-1">
                                <img src="{{ asset('assets/images/icons/Star 1.svg') }}" class="w-[26px] h-[26px] lg:w-[30px] lg:h-[30px]"
                                    alt="star">
                                <span class="font-semibold text-xl lg:text-2xl leading-[30px]">4.5</span>
                            </div>
                            <p class="text-sm lg:text-base leading-[21px] text-[#878785]">(18,485 reviews)</p>
                        </div>
                    </div>
                    <p id="desc" class="leading-[30px] lg:text-lg">
                        {{ $shoe->about }}
                    </p>
                </section>

                <!-- Brand section dengan ukuran yang responsif -->
                <div id="brand" class="flex items-center gap-4 px-4 lg:px-0 mt-4">
                    <div class="w-[70px] h-[70px] md:w-[80px] md:h-[80px] lg:w-[90px] lg:h-[90px] rounded-[20px] bg-white overflow-hidden">
                        <img src="{{ Storage::url($shoe->brand->logo) }}" class="w-full h-full object-contain" alt="brand logo">
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-sm md:text-base lg:text-lg leading-[21px]">{{ $shoe->brand->name }}</h2>
                        <div class="flex items-center gap-1">
                            <h3 class="font-bold text-lg md:text-xl lg:text-2xl leading-[27px]">{{ $shoe->name}}</h3>
                            <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-5 h-5 lg:w-6 lg:h-6" alt="icon">
                        </div>
                    </div>
                </div>
                <!-- Form dengan layout yang responsif -->
                <form action="{{ route('front.save_order', $shoe->slug) }}" method="POST" class="flex flex-col gap-3 mt-6">
                    @csrf
                    <div class="flex flex-col gap-3 px-4 lg:px-0">
                        <h2 class="font-bold md:text-lg lg:text-xl">Choose Size</h2>
                        <div class="flex items-center flex-wrap gap-[10px]">
                            @foreach ($shoe->sizes as $itemSize)
                                <label
                                    class="relative flex justify-center min-w-[83px] md:min-w-[90px] lg:min-w-[100px] w-fit rounded-2xl ring-1 ring-[#2A2A2A] p-[14px] transition-all duration-300 has-[:checked]:bg-white has-[:checked]:ring-2 has-[:checked]:ring-[#FFC700] hover:ring-2 hover:ring-[#FFC700]">
                                    <input type="radio" data-size-id="{{$itemSize->id }}" name="shoe_size" value="{{$itemSize->size}}"
                                        class="absolute top-1/2 left-1/2 opacity-0" required>
                                    <span class="font-semibold md:text-lg">EU {{$itemSize->size}}</span>
                                </label>
                            @endforeach
                            <input type="hidden" name="size_id" id="size_id" value="">
                        </div>
                    </div>

                    <!-- Bottom navigation yang tetap responsif -->
                    <div id="form-bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                        <div class="fixed bottom-5 lg:relative lg:bottom-0 w-full max-w-[1200px] z-30 px-4 lg:px-0">
                            <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-[10px] pl-6">
                                <div class="flex flex-col gap-[2px]">
                                    <p class="font-bold text-[20px] md:text-[22px] lg:text-[24px] leading-[30px] text-white">
                                        Rp {{ number_format($shoe->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm md:text-base leading-[21px] text-[#878785]">One pair shoes</p>
                                </div>
                                <button type="submit" class="rounded-full p-[12px_20px] md:p-[14px_24px] lg:p-[16px_28px] bg-[#C5F277] font-bold md:text-lg">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/details.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const sizeRadios = document.querySelectorAll('input[name="shoe_size"]');
            const sizeIdInput = document.getElementById('size_id');

            sizeRadios.forEach(radio => {
                radio.addEventListener('change', function(){
                    const selectedSizeId = this.getAttribute('data-size-id');
                    sizeIdInput.value = selectedSizeId;
                })
            })
        })
    </script>
</body>

</html>
