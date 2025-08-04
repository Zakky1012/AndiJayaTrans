@extends('layouts.app')

@section('include')
    <div id="Background" class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="{{ asset('assets/images/backgrounds/Mobil.png') }}" class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>
@endsection

@section('content')
    <main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
        <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Booking Details</h1>
        <div class="flex gap-[30px] mt-[30px]"> {{-- Ini adalah flex container utama --}}
            <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
                <div id="Flight-Info"
                    class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
                        <img src="assets/images/icons/arrow-up-circle-black.svg"
                            class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                        <input type="checkbox" class="hidden">
                    </label>
                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Departure</p>
                                <p class="font-semibold text-lg">
                                    {{ $transaction->keberangkatan->segmentKeberangkatan->first()->destinasi->kota }}
                                    (
                                    {{ $transaction->keberangkatan->segmentKeberangkatan->first()->destinasi->iata_code }}
                                    )
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="text-sm text-garuda-grey">Arrival</p>
                                <p class="font-semibold text-lg">
                                    {{ $transaction->keberangkatan->segmentKeberangkatan->last()->destinasi->kota }}
                                    (
                                    {{ $transaction->keberangkatan->segmentKeberangkatan->last()->destinasi->iata_code }}
                                    )
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Date</p>
                                <p class="font-semibold text-lg">
                                    {{ $transaction->keberangkatan->segmentKeberangkatan->first()->time->format('d F y') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p class="font-semibold text-lg">
                                    {{ $transaction->nomor_pessenger }} people
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
                            <div class="flex items-center justify-between">
                            <div class="flex items-center gap-[10px]">
                                <div>
                                    <p class="font-semibold">
                                        {{ $transaction->keberangkatan->mobil->nama_mobil }}
                                    </p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $transaction->keberangkatan->segmentKeberangkatan->first()->time->format('H:i') }} -
                                        {{ $transaction->keberangkatan->segmentKeberangkatan->last()->time->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                                <p class="font-semibold text-white">Details</p>
                            </a>
                        </div>
                    </div>
                </div>
                </div> {{-- Penutup untuk #Flight-Info --}}

                <div id="Transaction-Info" class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                <label class="flex items-center justify-between p-5">
                    <h2 class="font-bold text-xl leading-[30px]">Transaction Details</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}" class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-garuda-grey">Quantity</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ $transaction->nomor_pessenger }} people</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Tiers</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ \Str::ucfirst($transaction->classKeberangkatan->tipe_kelas) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Seats</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                @foreach ($transaction->transaksiPessenger as $passenger)
                                    {{ $passenger->kursi->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-garuda-grey">Price</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($transaction->classKeberangkatan->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Govt. Tax</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">11%</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Sub Total</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($transaction->classKeberangkatan->harga * $transaction->nomor_pessenger, 0, ',', '.')}}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-garuda-grey">Diskon</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px] text-garuda-green" id="discount">
                                @if ($transaction->promoCode)
                                @php
                                    $discountAmount = 0 ;
                                    if ($transaction->promoCode->tipe_diskon === 'percentage') {
                                        $discountAmount =
                                            $transaction->sub_total * ($transaction->promoCode->diskon / 100);
                                    } else {
                                        $discountAmount = $transaction->promoCode->diskon;
                                    }
                                @endphp
                                    @if ($transaction->promoCode->tipe_diskon === 'fixed')
                                        {{ 'Rp .' . number_format($discountAmount, 0, ',', '.') }}
                                    @else
                                        {{ 'Rp .' . number_format($discountAmount, 0, ',', '.') }}
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Promo Code</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="promo-code">
                                @if ($transaction->promoCode)
                                    {{ $transaction->promoCode->kode }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-garuda-grey">Total Tax</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($transaction->classKeberangkatan->harga * $transaction->nomor_pessenger * 0.11, 0, ',', '.')}}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Grand Total</p>
                            <p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]" id="grand-total">
                                {{ 'Rp. '. number_format($transaction->classKeberangkatan->harga * $transaction->nomor_pessenger * 1.11, 0, ',', '.')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div> {{-- Penutup untuk #Transaction-Info --}}
        </div> {{-- Penutup untuk #Left-Content --}}

        <div id="Right-Content" class="flex flex-col gap-[30px] w-[490px] shrink-0">
            <div id="Customer-Info"
                class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                <label class="flex items-center justify-between p-5">
                    <h2 class="font-bold text-xl leading-[30px]">Customer Information</h2>
                    <img src="assets/images/icons/arrow-up-circle-black.svg"
                        class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Complete Name</p>
                        <div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                            <img src="assets/images/icons/profile-black.svg" class="w-5 flex shrink-0" alt="icon">
                            <p class="font-semibold">
                                {{ $transaction->nama }}
                            </p>
                        </div>
                    </label>
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Email Address</p>
                        <div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                            <img src="assets/images/icons/sms-black.png" class="w-5 flex shrink-0" alt="icon">
                            <p class="font-semibold">
                                {{ $transaction->email }}
                            </p>
                        </div>
                    </label>
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Phone No.</p>
                        <div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                            <img src="assets/images/icons/call-black.svg" class="w-5 flex shrink-0" alt="icon">
                            <p class="font-semibold">
                                {{ $transaction->nomor }}
                            </p>
                        </div>
                    </label>
                </div>
            </div>
            @foreach ($transaction->transaksiPessenger as $passenger)
            <div id="Passenger-1"
                class="accordion-with-select group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden transition-all duration-300">
                <button type="button" class="accordion-btn flex items-center justify-between p-5">
                    <h2 class="font-bold text-xl leading-[30px]">Passenger 1</h2>
                    <img src="assets/images/icons/arrow-up-circle-black.svg"
                        class="arrow w-9 h-8 transition-all duration-300" alt="icon">
                </button>
                <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Complete Name</p>
                        <div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                            <img src="assets/images/icons/profile-black.svg" class="w-5 flex shrink-0" alt="icon">
                            <p class="font-semibold">
                                {{ $passenger->nama }}
                            </p>
                        </div>
                    </label>
                    <div class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Date of Birth</p>
                        <div class="flex items-center gap-[10px]">
                            <div
                                class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                                <img src="assets/images/icons/note-add-black.svg" class="w-5 flex shrink-0"
                                    alt="icon">
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d') }}
                                </p>
                            </div>
                            <div
                                class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                                <img src="assets/images/icons/note-add-black.svg" class="w-5 flex shrink-0"
                                    alt="icon">
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('M') }}
                                </p>
                            </div>
                            <div
                                class="flex items-center w-full rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                                <img src="assets/images/icons/note-add-black.svg" class="w-5 flex shrink-0"
                                    alt="icon">
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <label class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Nationality</p>
                        <div class="flex items-center rounded-full py-3 px-5 gap-[10px] bg-garuda-bg-grey">
                            <img src="assets/images/icons/global-black.svg" class="w-5 flex shrink-0" alt="icon">
                            <p class="font-semibold">
                                {{ $passenger->kewarganeraan }}
                            </p>
                        </div>
                    </label>
                </div>
            </div>
            @endforeach
            <a href="#"
                class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                <span class="font-semibold text-white">Download .PDF Version</span>
            </a>
        </div>
    </div> {{-- Ini adalah penutup yang benar untuk flex container utama --}}
    </main>
@endsection
