@extends('layouts.app')

@section('title', $package->name . ' - Happy Journey')
@section('meta_description', 'Paket tour ' . $package->name . ' - ' . $package->duration . '. Mulai Rp ' . number_format($package->price_adult, 0, ',', '.') . '. Book sekarang bersama Happy Journey.')
@section('og_image', asset('images/packages/' . $package->image))

@section('content')
<div x-data="{
    activeTab: 'itinerary',
    bookingModal: false,
    bookingForm: { customer_name: '', phone: '', email: '', passengers: '2', travel_date: '', notes: '' },
    bookingSubmitting: false,
    bookingSuccess: false,
    bookingError: '',
    openAccordion: null,
    toggleAccordion(i) { this.openAccordion = this.openAccordion === i ? null : i; },
    async submitBooking() {
        this.bookingSubmitting = true;
        this.bookingError = '';
        try {
            const res = await fetch('/booking', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ package_slug: '{{ $package->slug }}', package_name: '{{ addslashes($package->name) }}', destination: '{{ $package->destination }}', customer_name: this.bookingForm.customer_name, email: this.bookingForm.email, phone: this.bookingForm.phone, passengers: parseInt(this.bookingForm.passengers), travel_date: this.bookingForm.travel_date, notes: this.bookingForm.notes })
            });
            const data = await res.json();
            if (data.success) { this.bookingSuccess = true; setTimeout(() => { this.bookingModal = false; this.bookingSuccess = false; }, 2500); }
            else { this.bookingError = data.error || 'Terjadi kesalahan.'; }
        } catch(e) { this.bookingError = 'Koneksi gagal.'; }
        finally { this.bookingSubmitting = false; }
    }
}">

@include('partials.navbar', [
    'breadcrumbs' => [
        ['label' => 'Paket Tour',                      'url' => route('packages.destinations')],
        ['label' => 'Tour '.$package->destination,     'url' => route('packages.index', ['destination' => $package->destination])],
        ['label' => $package->name,                    'url' => null],
    ]
])

{{-- Hero --}}
<div class="relative h-72 sm:h-96 overflow-hidden">
    <img src="{{ $package->display_image }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-2 mb-3">
                <span class="bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $package->destination }}</span>
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full">{{ $package->duration }}</span>
                @if($package->airline)
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full hidden sm:inline">{{ $package->airline }}</span>
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">{{ $package->name }}</h1>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Tabs Content --}}
        <div class="lg:col-span-2">

            {{-- Tab Nav --}}
            <div class="flex gap-1 bg-slate-100 rounded-2xl p-1 mb-8">
                @foreach([['itinerary','📋 Itinerary'],['pricing','💵 Pricing Detail'],['inclusions','📌 Ketentuan']] as [$tab, $label])
                <button @click="activeTab='{{ $tab }}'" :class="activeTab==='{{ $tab }}' ? 'bg-white text-blue-900 shadow-sm font-bold' : 'text-slate-600 hover:text-blue-900'" class="flex-1 py-2.5 px-4 rounded-xl text-sm font-medium transition-all">{{ $label }}</button>
                @endforeach
            </div>

            {{-- Itinerary Tab --}}
            <div x-show="activeTab === 'itinerary'">
                <h2 class="text-xl font-bold text-blue-900 mb-6">Program Perjalanan</h2>
                @if($package->itinerary && count($package->itinerary) > 0)
                <div class="space-y-3">
                    @foreach($package->itinerary as $day)
                    <div class="border border-slate-200 rounded-2xl overflow-hidden">
                        <button @click="toggleAccordion({{ $day['day'] }})" class="w-full flex items-center justify-between p-4 text-left hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-900 to-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-sm font-bold">{{ $day['day'] }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-amber-600 font-semibold uppercase">Hari {{ $day['day'] }}</span>
                                    <h3 class="font-semibold text-blue-900 text-sm">{{ $day['title'] }}</h3>
                                </div>
                            </div>
                            <svg :class="openAccordion === {{ $day['day'] }} ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="openAccordion === {{ $day['day'] }}" x-transition class="px-4 pb-4">
                            <p class="text-slate-600 text-sm leading-relaxed pl-13">{{ $day['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                    <p class="text-amber-700">Detail itinerary tersedia setelah menghubungi tim kami.</p>
                    <a href="https://wa.me/6285941167415" target="_blank" class="inline-flex items-center gap-2 mt-3 bg-green-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-green-600 transition-colors">
                        Hubungi via WhatsApp
                    </a>
                </div>
                @endif
            </div>

            {{-- Pricing Detail Tab --}}
            <div x-show="activeTab === 'pricing'">
                {{-- Notes --}}
                <p class="text-sm font-semibold text-slate-700 mb-1">
                    Keberangkatan Minimal {{ $package->min_participants }} Pax (Didampingi 1 Tour Leader)
                    @if($package->deposit)
                    &nbsp;Pendaftaran Deposit Rp {{ number_format($package->deposit, 0, ',', '.') }} (First Come First Serve)
                    @endif
                </p>
                @if($package->airline && str_contains(strtolower($package->airline), 'charter'))
                <p class="text-sm font-bold text-red-600 mb-3">**PRODUCT INI MENGGUNAKAN CHARTER FLIGHT, TIDAK BISA EXTEND**</p>
                @endif

                {{-- Price Table --}}
                @if($package->departure_dates && count($package->departure_dates) > 0)
                @php
                    // Group dates by month
                    $grouped = [];
                    foreach ($package->departure_dates as $d) {
                        $key = \Carbon\Carbon::parse($d)->format('Y-m');
                        $grouped[$key][] = \Carbon\Carbon::parse($d)->format('d');
                    }
                @endphp
                <div class="overflow-x-auto rounded-xl border border-slate-200 mb-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="text-left px-4 py-3 font-semibold text-slate-700 w-1/3">Keberangkatan</th>
                                <th class="text-left px-4 py-3 font-semibold text-slate-700">ADULT</th>
                                @if($package->price_child)
                                <th class="text-left px-4 py-3 font-semibold text-slate-700">Child No Bed</th>
                                @endif
                                @if($package->price_single_supplement)
                                <th class="text-left px-4 py-3 font-semibold text-slate-700">Single Supp<br><span class="font-normal text-xs text-slate-500">(Jika sekamar sendiri)</span></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grouped as $yearMonth => $days)
                            <tr class="border-b border-slate-100 {{ $loop->even ? 'bg-slate-50/50' : 'bg-white' }}">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ strtoupper(\Carbon\Carbon::parse($yearMonth.'-01')->translatedFormat('M')) }} : {{ implode(' , ', $days) }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($package->price_adult, 0, ',', '.') }}</td>
                                @if($package->price_child)
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($package->price_child, 0, ',', '.') }}</td>
                                @endif
                                @if($package->price_single_supplement)
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($package->price_single_supplement, 0, ',', '.') }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- Infant note --}}
                @if($package->price_infant)
                <p class="text-sm italic text-slate-500">
                    *HARGA UNTUK INFANT DIBAWAH 23 BULAN (FLAT RATE) : Rp {{ number_format($package->price_infant, 0, ',', '.') }}
                    (Tipping Mandatory Free Of Charge) HARGA DAPAT BERUBAH SEWAKTU-WAKTU
                </p>
                @endif
                <p class="text-xs italic text-slate-400 mt-2">*Acara Perjalanan, Harga Tour/Visa/Apt Tax &amp;YQ serta flight detail dapat berubah sewaktu-waktu tanpa pemberitahuan lebih lanjut.</p>
            </div>

            {{-- Inclusions + Exclusions Tab --}}
            <div x-show="activeTab === 'inclusions'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Include --}}
                    <div>
                        <h3 class="text-base font-bold text-emerald-700 mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Biaya Include
                        </h3>
                        @if($package->inclusions && count($package->inclusions) > 0)
                        <ul class="space-y-2">
                            @foreach($package->inclusions as $item)
                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-slate-400 italic text-sm">Hubungi kami untuk info detail.</p>
                        @endif
                    </div>

                    {{-- Exclude --}}
                    <div>
                        <h3 class="text-base font-bold text-red-600 mb-3 flex items-center gap-2">
                            <span class="w-6 h-6 bg-red-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </span>
                            Biaya Exclude
                        </h3>
                        @if($package->exclusions && count($package->exclusions) > 0)
                        <ul class="space-y-2">
                            @foreach($package->exclusions as $item)
                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-slate-400 italic text-sm">Hubungi kami untuk info detail.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Sidebar --}}
        <div class="space-y-6">

            {{-- Price Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden sticky top-24">
                <div class="bg-gradient-to-r from-blue-900 to-blue-700 p-5">
                    <p class="text-blue-200 text-xs mb-1">Harga mulai dari</p>
                    <div class="text-3xl font-bold text-white">Rp {{ number_format($package->price_adult, 0, ',', '.') }}</div>
                    <p class="text-blue-200 text-xs mt-1">per orang / dewasa</p>

                    @if($package->price_child)
                    <div class="mt-3 pt-3 border-t border-white/20 text-xs text-blue-200">
                        Anak (no bed): Rp {{ number_format($package->price_child, 0, ',', '.') }}
                    </div>
                    @endif
                    @if($package->price_single_supplement)
                    <div class="text-xs text-blue-200">
                        Single supplement: +Rp {{ number_format($package->price_single_supplement, 0, ',', '.') }}
                    </div>
                    @endif
                </div>

                <div class="p-5 space-y-4">
                    {{-- Quick Info --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $package->duration }}</span>
                        </div>
                        @if($package->airline)
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span>{{ $package->airline }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Min. {{ $package->min_participants }} peserta</span>
                        </div>
                        @if($package->deposit)
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span>DP: Rp {{ number_format($package->deposit, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Departure Dates --}}
                    @if($package->departure_dates && count($package->departure_dates) > 0)
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-2">Tanggal Keberangkatan</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($package->departure_dates, 0, 6) as $date)
                            <span class="bg-blue-50 text-blue-900 text-xs px-3 py-1 rounded-full font-medium">
                                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                            </span>
                            @endforeach
                            @if(count($package->departure_dates) > 6)
                            <span class="bg-slate-100 text-slate-600 text-xs px-3 py-1 rounded-full">+{{ count($package->departure_dates) - 6 }} lainnya</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- CTA Buttons --}}
                    <div class="space-y-3 pt-2">
                        <button @click="bookingModal = true; bookingSuccess = false; bookingError = ''" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white py-4 font-bold rounded-xl shadow-lg transition-all hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            BOOKING SEKARANG
                        </button>
                        <a href="{{ route('packages.pdf', $package->slug) }}" class="w-full flex items-center justify-center gap-2 border-2 border-blue-200 text-blue-900 hover:bg-blue-50 py-3 font-semibold rounded-xl transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download PDF Itinerary
                        </a>
                        <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20tertarik%20dengan%20paket%20{{ urlencode($package->name) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-3 font-semibold rounded-xl transition-colors text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Highlights Section --}}
@if($package->highlights && count($package->highlights) > 0)
<div class="bg-slate-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-blue-900 mb-6">Highlight Perjalanan</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($package->highlights as $highlight)
            <div class="flex items-center gap-2 bg-white rounded-xl p-3 border border-slate-200 shadow-sm">
                <div class="w-6 h-6 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <span class="text-sm text-slate-700 font-medium">{{ $highlight }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Footer --}}
<footer class="bg-blue-950 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 flex flex-col items-center gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo/cropped-logo_happy_journey.png') }}" alt="Happy Journey" class="w-10 h-10 object-contain">
            <span class="text-xl font-bold"><span class="text-white">Happy</span><span class="text-amber-400">Journey</span></span>
        </div>
        <p class="text-white/50 text-sm">Copyright &copy; {{ date('Y') }} - Happy Journey Tour &amp; Travel.</p>
    </div>
</footer>

{{-- WhatsApp --}}
<a href="https://wa.me/6285941167415" target="_blank" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

{{-- Booking Modal --}}
<div x-show="bookingModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="bookingModal=false"></div>
    <div x-show="bookingModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10">
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <div><h3 class="text-xl font-bold text-white">Booking Tour</h3><p class="text-blue-200 text-sm">{{ $package->name }}</p></div>
            <button @click="bookingModal=false" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div x-show="bookingSuccess" class="p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <h3 class="text-xl font-bold text-blue-900 mb-2">Booking Berhasil!</h3>
            <p class="text-slate-600">Tim kami akan segera menghubungi Anda.</p>
        </div>
        <div x-show="!bookingSuccess" class="p-6 space-y-4">
            <div x-show="bookingError" class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-red-700 text-sm" x-text="bookingError"></p>
            </div>
            <form @submit.prevent="submitBooking()" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-blue-900 mb-1.5">Nama Lengkap *</label><input type="text" x-model="bookingForm.customer_name" placeholder="Nama lengkap" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500"></div>
                    <div><label class="block text-sm font-medium text-blue-900 mb-1.5">No. Telepon *</label><input type="tel" x-model="bookingForm.phone" placeholder="08xxxxxxxxxx" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500"></div>
                </div>
                <div><label class="block text-sm font-medium text-blue-900 mb-1.5">Email *</label><input type="email" x-model="bookingForm.email" placeholder="email@example.com" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-blue-900 mb-1.5">Jumlah Orang *</label>
                        <select x-model="bookingForm.passengers" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                            @for($n=1;$n<=10;$n++)<option value="{{ $n }}">{{ $n }} Orang</option>@endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">Tanggal Keberangkatan *</label>
                        @php
                            $showDates = collect($package->departure_dates ?? [])
                                ->map(fn($d) => ['value' => $d, 'label' => \Carbon\Carbon::parse($d)->translatedFormat('D, d M Y')])
                                ->values()->toArray();
                        @endphp
                        @if(count($showDates) > 0)
                        <select x-model="bookingForm.travel_date" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                            <option value="">-- Pilih Tanggal --</option>
                            @foreach($showDates as $d)
                            <option value="{{ $d['value'] }}">{{ $d['label'] }}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="date" x-model="bookingForm.travel_date" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                        <p class="text-xs text-slate-400 mt-1">Jadwal belum tersedia.</p>
                        @endif
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-blue-900 mb-1.5">Catatan</label><textarea x-model="bookingForm.notes" rows="3" placeholder="Permintaan khusus..." class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 resize-none"></textarea></div>
                <button type="submit" :disabled="bookingSubmitting" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 disabled:opacity-60 text-white py-4 font-semibold rounded-xl shadow-lg transition-all">
                    <svg x-show="!bookingSubmitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <svg x-show="bookingSubmitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="bookingSubmitting ? 'Memproses...' : 'Kirim Booking'"></span>
                </button>
            </form>
        </div>
    </div>
</div>

</div>
@endsection
