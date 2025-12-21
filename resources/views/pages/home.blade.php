@extends('layouts.app')

@section('include')
    <div id="Background-home" class="absolute top-0 w-full h-full bg-white">
        <div
            class="absolute top-0 w-full h-[1020px] bg-purple">
            <img src="assets/images/backgrounds/Jumbo Jet Sky (1) 1.png"
                class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
        </div>
    </div>
@endsection

@section('content')
       <div id="Hero-Text" class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto gap-[30px] mt-[86px]">
        <div class="Badge flex items-center w-fit rounded-full p-[8px_14px] gap-[10px] bg-white">
            <img src="assets/images/icons/crown-black.svg" class="flex w-5 h-5 shrink-0" alt="icon">
            <p class="text-sm font-semibold">Top Flight Awards Fly Group Sky 500</p>
        </div>
        <h1 class="font-extrabold text-[50px] leading-[75px] text-white">Begin a remarkable <br> journey with us,</h1>
        <p class="text-lg leading-8 text-white">Start your next great adventure with us, <br>with exclusive experiences that truly matter.</p>
    </div>
    <form action="{{route('flight.index')}}" method="GET"
        class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[86px]">
        <div class="flex flex-col rounded-[30px] p-[30px] gap-4 bg-white">
            <h2 class="font-bold text-xl leading-[30px]">Book Your Next Flight</h2>
            <div class="flex items-center gap-5">
                <div class="grid grid-cols-4 items-center rounded-[20px] border border-[#E8EFF7]">
                    <div id="Departure"
                        class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                        <button type="button"
                            class="flex items-center gap-4 p-5 dropdown first:pl-6 first:border-l-0 last:pr-6 last:border-r-0"
                            data-dropdown-target="#Departure-Dropdown">
                            <img src="assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Departure</p>
                                <p id="Departure-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Select Departure
                                </p>
                            </div>
                        </button>
                        <div id="Departure-Dropdown"
                            class="dropdown-content hidden absolute z-10 top-full mt-4 h-[232px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                            <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                                @foreach ($airports as $airport)
                                <label
                                    class="relative flex items-center rounded-[10px] gap-[10px] p-0 has-[:checked]:p-[10px] has-[:checked]:bg-garuda-bg-grey transition-all duration-300">
                                    <input type="radio" name="departure" id="{{$airport->iata_code}}"
                                        class="absolute opacity-0 top-1/2 left-1/2" value="{{$airport->iata_code}}">
                                    <img src="assets/images/icons/airplane-black.svg" class="flex shrink-0 w-[34px]"
                                        alt="icon">
                                    <div class="flex flex-col gap-[2px]">
                                        <p class="font-semibold">{{$airport->name}} ({{$airport->iata_code}})</p>
                                        <p class="text-sm text-garuda-grey">{{$airport->city}}, {{$airport->country}}</p>
                                    </div>
                                </label>
                                <hr class="border-[#E8EFF7]">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="Arrival"
                        class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                        <button type="button" class="flex items-center gap-4 p-5 dropdown first:pl-6 last:pr-6"
                            data-dropdown-target="#Arrival-Dropdown">
                            <img src="assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Arrival</p>
                                <p id="Arrival-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Select Arrival</p>
                            </div>
                        </button>
                        <div id="Arrival-Dropdown"
                            class="dropdown-content hidden absolute z-10 top-full mt-4 h-[232px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                            <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                              @foreach ($airports as $airport)
                                <label
                                    class="relative flex items-center rounded-[10px] gap-[10px] p-0 has-[:checked]:p-[10px] has-[:checked]:bg-garuda-bg-grey transition-all duration-300">
                                    <input type="radio" name="arrival" id="{{$airport->iata_code}}"
                                        class="absolute opacity-0 top-1/2 left-1/2" value="{{$airport->iata_code}}">
                                    <img src="assets/images/icons/airplane-black.svg" class="flex shrink-0 w-[34px]"
                                        alt="icon">
                                    <div class="flex flex-col gap-[2px]">
                                        <p class="font-semibold">{{$airport->name}} ({{$airport->iata_code}})</p>
                                        <p class="text-sm text-garuda-grey">{{$airport->city}}, {{$airport->country}}</p>
                                    </div>
                                </label>
                                <hr class="border-[#E8EFF7]">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="Date"
                        class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                        <input type="date" name="date" id="date" class="absolute top-1/2 -z-10">
                        <button type="button" id="Date-Button"
                            class="relative flex items-center gap-4 p-5 first:pl-6 last:pr-6">
                            <img src="assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Date</p>
                                <p id="Date-Label" class="font-semibold text-lg mt-[2px] text-nowrap"></p>
                            </div>
                        </button>
                    </div>
                    <div id="Quantity"
                        class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7] last:border-r-0">
                        <button type="button" class="flex items-center gap-4 p-5 dropdown first:pl-6 last:pr-6"
                            data-dropdown-target="#Quantity-Dropdown">
                            <img src="assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p id="Quantity-Label" class="font-semibold text-lg mt-[2px] text-nowrap"><span
                                        class="number">1</span> people</p>
                            </div>
                        </button>
                        <div id="Quantity-Dropdown" class="absolute z-10 hidden mt-4 dropdown-content top-full">
                            <div
                                class="flex items-center rounded-[18px] border border-[#E8EFF7] p-5 gap-[28px] bg-white">
                                <button type="button" id="minus" class="w-[38px] h-[38px] flex shrink-0">
                                    <img src="assets/images/icons/minus.svg" alt="icon">
                                </button>
                                <p class="font-semibold text-nowrap"><span class="number">1</span> people</p>
                                <input type="number" name="quantity" id="quantity" value="1" class="hidden">
                                <button type="button" id="plus" class="w-[38px] h-[38px] flex shrink-0 bg-airline-purple">
                                    <img src="{{asset('assets/images/icons/plus.svg')}}" alt="icon">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="flex flex-col items-center gap-[6px] rounded-[30px] py-3 px-5 bg-airline-purple-soft hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                    <img src="assets/images/icons/search-status-white.svg" class="flex shrink-0 w-[30px]" alt="icon">
                    <p class="text-sm font-semibold text-center text-white">Explore</p>
                </button>
            </div>
        </div>
    </form>
    <section id="Popular" class="relative flex flex-col gap-[30px] mt-[70px] mb-[86px]">
        <div class="w-full max-w-[1280px] px-[75px] mx-auto">
            <h2 class="font-bold text-[28px] leading-[42px]">Popular This Year</h2>
            <p class="text-lg mt-[6px]">You are missing out lorem dolor come</p>
        </div>
        <div class="swiper !w-full overflow-x-hidden">
            <div class="swiper-wrapper">
                @foreach ($airports as $airport)
                <div class="swiper-slide !w-fit first:ml-[calc(((100%-1280px)/2)+75px-24px)]">
                    <a href="#" class="card">
                        <div
                            class="flex items-end w-[230px] h-[280px] shrink-0 rounded-[30px] bg-white overflow-hidden hover:border-2 hover:border-[#6D28D9] hover:p-[10px] transition-all duration-300">
                            <img src="{{asset('storage/'. $airport->image)}}"
                                class="w-full h-full object-cover rounded-[30px]" alt="{{$airport->image}}">
                            <div
                                class="absolute flex w-[210px] items-center bottom-[10px] left-[10px] right-[10px] rounded-[20px] p-[10px] gap-[10px] bg-white">
                                <img src="{{asset('assets/images/icons/global-black.svg')}}" class="flex w-6 shrink-0" alt="icon">
                                <div>
                                    <p class="font-semibold">{{$airport->name}} ({{$airport->iata_code}})</p>
                                    <p class="text-sm text-garuda-grey">{{$airport->city}}, {{$airport->country}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
