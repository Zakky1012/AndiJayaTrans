<nav class="relative flex justify-center px-[75px] mt-[30px]">
        <div class="flex items-center w-full max-w-[1130px] rounded-[20px] justify-between py-4 px-5 bg-white">
            <a href="{{ route('home') }}">
                ANDI JAYA TRANS
            </a>
            <ul class="flex items-center gap-[30px] flex-wrap">
                <li>
                    <a href=" {{ route('keberangkatan.index') }} " class="hover:font-bold transition-all duration-300 font-bold">Keberangkatan</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300 ">Hotel</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300 ">Jadwal</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300 ">Testimoni</a>
                </li>
            </ul>
            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px]">
                    <img src="{{ asset('assets/images/icons/call-calling-black.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold">Call Us</span>
                </a>
                <a href="{{ route('booking.check') }}" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] bg-garuda-black">
                    <img src="{{ asset('assets/images/icons/note-favorite-white.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold text-white">My Booking</span>
                </a>
            </div>
        </div>
</nav>
