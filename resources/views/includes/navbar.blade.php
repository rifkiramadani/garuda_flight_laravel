   <nav class="relative flex justify-center px-[75px] mt-[30px]">
        <div class="flex items-center w-full max-w-[1130px] rounded-[20px] justify-between py-4 px-5 bg-dark">
            <a href="{{route('home')}}">
                <span class="font-bold text-9xl text-white">GARUDA</span>
            </a>
            <ul class="flex items-center gap-[30px] flex-wrap">
                <li>
                    <a href="{{route('flight.index')}}" class="font-bold transition-all duration-300 hover:font-bold text-white">Flights</a>
                </li>
                <li>
                    <a href="#" class="transition-all duration-300 hover:font-bold text-white">Hotels</a>
                </li>
                <li>
                    <a href="#" class="transition-all duration-300 hover:font-bold text-white">Schedule</a>
                </li>
                <li>
                    <a href="#" class="transition-all duration-300 hover:font-bold text-white">Testimonials</a>
                </li>
            </ul>
            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px]">
                    {{-- <img src="{{asset('assets/images/icons/call-calling-black.svg')}}" class="flex w-5 h-5 shrink-0" alt="icon"> --}}
                    <span class="font-semibold  text-white">Call Us</span>
                </a>
                <a href="{{route('booking.checkBooking')}}"
                    class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] bg-garuda-black">
                    <img src="{{asset('assets/images/icons/note-favorite-white.svg')}}" class="flex w-5 h-5 shrink-0" alt="icon">
                    <span class="font-semibold text-white">My Booking</span>
                </a>
            </div>
        </div>
    </nav>
