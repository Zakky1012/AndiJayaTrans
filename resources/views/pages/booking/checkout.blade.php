@extends('layouts.app')

@section('include')
    <div id="Background" class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="{{ asset('assets/images/backgrounds/Mobil.png') }}" class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>
@endsection

@section('content')
    <main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
        <a href="choose-seats-economy.html"
            class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
            <p class="font-semibold text-white">Back to Choose Seats</p>
        </a>
        <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Passenger Details</h1>
        <div class="flex gap-[30px] mt-[30px]">
            <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
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
                        <p class="font-semibold text-lg">{{ count($transaction['selected_seats']) }} people</p>
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
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ count($transaction['selected_seats']) }} people</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Tiers</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ \Str::ucfirst($tier->tipe_kelas) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Seats</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ implode(', ', $keberangkatan->kursiKeberangkatan->whereIn('id', $transaction['selected_seats'])->pluck('name')->toArray() )}}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-garuda-grey">Price</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($tier->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Govt. Tax</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">11%</p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Sub Total</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($tier->harga * count($transaction['selected_seats']), 0, ',', '.')}}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-garuda-grey">Diskon</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px] text-garuda-green" id="discount"> Rp 0

                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Promo Code</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="promo-code">

                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-garuda-grey">Total Tax</p>
                            <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                {{ 'Rp. '. number_format($tier->harga * count($transaction['selected_seats']) * 0.11, 0, ',', '.')}}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-garuda-grey">Grand Total</p>
                            <p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]" id="grand-total">
                                {{ 'Rp. '. number_format($tier->harga * count($transaction['selected_seats']) * 1.11, 0, ',', '.')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                <span class="font-semibold text-white">Continue Booking</span>
            </button>
            </div>
            <form action="success-booking.html" id="Right-Content" class="flex flex-col gap-[30px] w-[490px] shrink-0">
                <div id="Customer-Info"
                    class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Customer Information</h2>
                        <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}"
                            class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                        <input type="checkbox" class="hidden">
                    </label>
                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Complete Name</p>
                            <div
                                class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
                                <input type="text" name="" id="" value="{{ $transaction['nama'] }}"
                                    readonly
                                    class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                    placeholder="Write your complete name">
                            </div>
                        </label>
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Email Address</p>
                            <div
                                class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/sms-black.png') }}" class="w-5 flex shrink-0" alt="icon">
                                <input type="email" name="" id="" value="{{ $transaction['email'] }}"
                                    readonly
                                    class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                    placeholder="Write your valid email">
                            </div>
                        </label>
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Phone No.</p>
                            <div
                                class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/call-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
                                <input type="tel" name="" id="" value="{{ $transaction['nomor'] }}"
                                    readonly
                                    class="appearance-none outline-none w-full font-semibold placeholder:font-normal"
                                    placeholder="Write your active number">
                            </div>
                        </label>
                    </div>
                </div>
                <!-- for accordions with select input inside, the script was different from the normal accordion -->
                @foreach ($transaction['passengers'] as $passenger)
                <div id="Passenger-{{ $loop->index + 1 }}" class="accordion-with-select group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden transition-all duration-300">
                    <button type="button" class="accordion-btn flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Passenger {{ $loop->index + 1 }}</h2>
                        <img src="{{ asset('assets/images/icons/arrow-up-circle-black.svg') }}" class="arrow w-9 h-8 transition-all duration-300" alt="icon">
                    </button>
                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Complete Name</p>
                            <div class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] focus-within:border-[#0068FF] transition-all duration-300"
                            @error('passangers.' . $loop->index . '.nama') border-red-500 @enderror>
                                <img src="{{ asset('assets/images/icons/profile-black.svg') }}" class="w-5 flex shrink-0" alt="icon">
                                <input type="text" name="passengers[{{ $loop->index }}][nama]" id="" class="appearance-none outline-none w-full font-semibold placeholder:font-normal" placeholder="Write your complete name" value="{{ $passenger['nama'] }}" >
                            </div>
                            @error('passengers.' . $loop->index . '.nama')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </label>
                        <div class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Date of Birth</p>
                            <input type="hidden" name="passengers[{{ $loop->index }}][date_of_birth]" id="dateOfBirth-{{ $loop->index }}" data-index="{{ $loop->index }}" class=""/>

                            <div class="flex items-center gap-[10px]">
                                <label
                                    class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300"
                                    @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror>
                                        <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                            class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="day-select-{{ $loop->index }}" name=""
                                        class="date-select day-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}"
                                        onchange="updateDateOfBirth({{ $loop->index }})">
                                        @for ($i = 1 ; $i <= 31 ; $i++)
                                            <option value="{{ $i }}"
                                                {{ \Carbon\Carbon::parse($passenger['date_of_birth'])->format('d') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </label>

                                <label class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300"
                                @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror>
                                    <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                        class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="month-select-{{ $loop->index }}" name=""
                                        class="date-select month-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}"
                                        onchange="updateDateOfBirth({{ $loop->index }})">
                                        @for ($i = 1 ; $i <= 12 ; $i++)
                                            <option value="{{ $i }}"
                                                {{ \Carbon\Carbon::parse($passenger['date_of_birth'])->format('m') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </label>

                                <label class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300"
                                @error('passengers.' . $loop->index . '.date_of_birth') border-red-500 @enderror>
                                    <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                        class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                    <select id="year-select-{{ $loop->index }}" name=""
                                        class="date-select year-select appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal"
                                        data-index="{{ $loop->index }}"
                                        onchange="updateDateOfBirth({{ $loop->index }})">
                                        @for ($i = date('Y') ; $i >= 1900 ; $i--)
                                            <option value="{{ $i }}"
                                                {{ \Carbon\Carbon::parse($passenger['date_of_birth'])->format('Y') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </label>
                            </div>
                            @error('passengers.' . $loop->index . '.date_of_birth')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror

                        </div>
                        <label class="flex flex-col gap-[10px]">
                            <p class="font-semibold">Nationality</p>
                            <div class="relative flex items-center w-full rounded-full overflow-hidden border border-garuda-black gap-[10px] focus-within:border-[#0068FF] transition-all duration-300"
                            @error('passengers.' . $loop->index . '.kewarganeraan') border-red-500 @enderror>
                                <img src="{{ asset('assets/images/icons/global-black.svg') }}" class="absolute transform -translate-y-1/2 top-1/2 left-5 w-5 shrink-0" alt="icon">
                                <select name="passengers[{{ $loop->index }}][kewarganeraan]" id=""
                                    class="appearance-none w-full outline-none pl-[50px] py-3 px-5 font-semibold indeterminate:!font-normal">
                                    <option hidden>Select country region</option>
                                    <option value="Singapore"
                                        {{ $passenger['kewarganeraan'] === 'Singapore' ? 'selected' : '' }}>Singapore
                                    </option>
                                    <option value="Japan"
                                        {{ $passenger['kewarganeraan'] === 'Japan' ? 'selected' : '' }}>Japan
                                    </option>
                                    <option value="Indonesia"
                                        {{ $passenger['kewarganeraan'] === 'Indonesia' ? 'selected' : '' }}>Indonesia
                                    </option>
                                </select>
                            </div>
                            @error('passengers.' . $loop->index . '.kewarganeraan')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                    </div>
                </div>
                @endforeach
                @livewire('check-promo-code')
                <div id="Payment-Method" class="flex flex-col rounded-[20px] p-5 gap-5 bg-white overflow-hidden">
                    <h2 class="font-bold text-xl leading-[30px]">Payment Method</h2>
                    <div class="flex flex-col gap-[10px]">
                        <p class="font-semibold">Choose Payment</p>
                        <div class="flex items-center flex-nowrap gap-[10px]">
                            <label
                                class="group relative flex items-center w-full rounded-full py-3 px-5 bg-garuda-bg-dark-grey gap-[10px] has-[:checked]:bg-garuda-orange transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                    class="w-5 flex shrink-0 group-has-[:checked]:invert transition-all duration-300"
                                    alt="icon">
                                <span class="font-semibold group-has-[:checked]:text-white">Midtrans Gateway</span>
                                <input type="radio" name="payment-method" class="absolute opacity-0 left-1/2" required>
                            </label>
                            {{-- <label
                                class="group relative flex items-center w-full rounded-full py-3 px-5 bg-garuda-bg-dark-grey gap-[10px] has-[:checked]:bg-garuda-orange transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/note-add-black.svg') }}"
                                    class="w-5 flex shrink-0 group-has-[:checked]:invert transition-all duration-300"
                                    alt="icon">
                                <span class="font-semibold group-has-[:checked]:text-white">Transfer to Bank</span>
                                <input type="radio" name="payment-method" class="absolute opacity-0 left-1/2" disabled>
                            </label> --}}
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                    <span class="font-semibold text-white">Continue to Payment</span>
                </button>
            </form>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        window.addEventListener('promoCodeUpdated', event => {
            // ambil harga produk dan jumlah seat yang dipilih
            const price     = parseFloat('{{ $tier->harga }}');
            const quantity  = parseInt('{{ count($transaction['selected_seats']) }}');
            const totalWithoutDiscount = price * quantity;

            // variable menyimpan total baru dan totla diskon
            let newTotal;
            let totalPromo = 0;

            // Cek tipe diskon dan hitung total serta diskon yang ditetapkan
            const promoCode     = event.detail[0].promo_code;
            const discountType  = event.detail[0].tipe_diskon;
            const discountValue = event.detail[0].diskon;

            if (discountType == 'percentage') {
                totalPromo = totalWithoutDiscount * (discountValue / 100);
            } else {
                totalPromo = discountValue;
            }

            newTotal = totalWithoutDiscount - totalPromo;

            // tampilan hasil perhitungan
            document.getElementById('promo-code').innerHTML = promoCode;
            document.getElementById('grand-total').innerHTML = 'Rp ' + newTotal.toLocaleString('id-ID');
            document.getElementById('discount').innerHTML = '- Rp ' + totalPromo.toLocaleString('id-ID');
        })
    </script>
@endsection
