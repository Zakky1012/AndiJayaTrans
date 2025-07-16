@extends('layouts.app')

@section('include')
    <div id="Background" class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="{{ asset('assets/images/backgrounds/Mobil.png') }}" class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>
@endsection

@section('content')
    <main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
        <a href="{{ route('keberangkatan.index') }}" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
            <img src="{{ asset('assets/images/icons/arrow-left-white.svg') }}" class="w-6 h-6" alt="icon">
            <p class="font-semibold text-white">Back to Choose Flight</p>
        </a>
        <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Choose Tiers</h1>
        <div class="flex gap-[30px] mt-[30px]">
            <div id="Flight-Info" class="flex flex-col w-[470px] shrink-0 h-fit rounded-[20px] bg-white p-5 gap-5">
                <h2 class="font-bold text-xl leading-[30px]">Your Booking</h2>
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-garuda-grey">Departure</p>
                        <p class="font-semibold text-lg">
                            {{ $keberangkatan->segmentKeberangkatan->first()->destinasi->kota }} (
                            {{ $keberangkatan->segmentKeberangkatan->first()->destinasi->iata_code }} )</p>
                    </div>
                    <div class="text-end">
                        <p class="text-sm text-garuda-grey">Arrival</p>
                        <p class="font-semibold text-lg">
                            {{ $keberangkatan->segmentKeberangkatan->last()->destinasi->kota }} (
                            {{ $keberangkatan->segmentKeberangkatan->last()->destinasi->iata_code }} )</p>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-garuda-grey">Date</p>
                        <p class="font-semibold text-lg">
                            {{ $keberangkatan->segmentKeberangkatan->first()->time->format('d F y') }}
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="text-sm text-garuda-grey">Quantity</p>
                        <p class="font-semibold text-lg">3 people</p>
                    </div>
                </div>
                <div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-[10px]">
                                <div>
                                    <p class="font-semibold">
                                        {{ $keberangkatan->mobil->nama_mobil }}
                                    </p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $keberangkatan->segmentKeberangkatan->first()->time->format('H:i') }} -
                                        {{ $keberangkatan->segmentKeberangkatan->last()->time->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                                <p class="font-semibold text-white">Details</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-[2px] items-center justify-center">
                                <p class="text-sm text-garuda-grey">
                                    {{ number_format($keberangkatan->segmentKeberangkatan->first()->time->diffInHours($keberangkatan->segmentKeberangkatan->last()->time), 0) }} hours
                                </p>
                                <div class="flex items-center gap-[6px]">
                                    <p class="font-semibold">
                                        {{ $keberangkatan->segmentKeberangkatan->first()->destinasi->iata_code }}
                                    </p>
                                    @if ($keberangkatan->segmentKeberangkatan->count() > 2)
                                        <img src="{{ asset('assets/images/icons/transit-black.svg') }}" alt="icon">
                                    @else
                                        <img src="{{ asset('assets/images/icons/direct-black.svg') }}" alt="icon">
                                    @endif
                                    <p class="font-semibold">
                                        {{ $keberangkatan->segmentKeberangkatan->last()->destinasi->iata_code }}
                                    </p>
                                </div>

                                @if ($keberangkatan->segmentKeberangkatan->count() > 2)
                                    <p class="text-sm text-garuda-grey">
                                        {{ $keberangkatan->segmentKeberangkatan->count() - 2}} x
                                    </p>
                                @else
                                    <p class="text-sm text-garuda-grey">
                                        direct
                                    </p>
                                @endif
                            </div>
                            <p class="font-semibold text-garuda-green text-center">
                                {{ 'Rp. '. number_format($keberangkatan->classKeberangkatan->first()->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('booking', $keberangkatan->nomor_keberangkatan) }}" id="Tiers" class="grid grid-cols-2 gap-x-[30px]">
                <input type="hidden" name="keberangkatan_class_id" value="" id="class_keberangkatan_id">
                @foreach ($keberangkatan->classKeberangkatan as $class)
                    <div id="Economy" class="flex flex-col h-fit rounded-[20px] p-5 pb-[30px] gap-5 bg-white">
                    <div class="w-[260px] h-[180px] rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                        @if ($class->tipe_kelas === 'ekonomi')
                            <img src="{{ asset('assets/images/thumbnails/economy-seat.png') }}" class="w-full h-full object-cover" alt="thumbnails">
                        @else
                            <img src="{{ asset('assets/images/thumbnails/business-seat.png') }}" class="w-full h-full object-cover" alt="thumbnails">
                        @endif
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-semibold text-lg">{{ \Str::ucfirst($class->tipe_kelas) }} Class</p>
                        <p class="font-extrabold text-[32px] leading-[48px]">
                            {{-- {{ 'Rp. '. number_format($keberangkatan->classKeberangkatan->first()->harga, 0, ',', '.') }} --}}
                            {{ 'Rp. '. number_format($class->harga, 0, ',', '.') }}
                        </p>
                    </div>
                    <hr class="border-[#E8EFF7]">
                    @foreach ($class->fasilitas as $fasilitas)
                        <div class="flex items-center gap-[10px]">
                            <img src="{{ asset('storage/'. $fasilitas->gambar) }}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <p class="font-semibold">{{ $fasilitas->nama }}</p>
                        </div>
                    @endforeach
                    <button class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300" onclick="document.getElementById('class_keberangkatan_id').value = {{ $class->id }}">
                        <span class="font-semibold text-white">Choose</span>
                    </button>
                    </div>
                @endforeach
            </form>
        </div>
    </main>
@endsection
