@extends('layouts.app')

@section('title', 'Happy Journey Tour & Travel')
@section('meta_description', 'Temukan destinasi impian Anda bersama Happy Journey. Paket tour domestik dan internasional terpercaya dengan kualitas premium dan harga kompetitif.')

@section('content')
{{-- =========================================================
     FULL PAGE WRAPPER – Alpine.js root for modals
     ========================================================= --}}
<div
    x-data="{
        bookingModal: false,
        inquiryModal: false,
        selectedPackage: { name: '', price: '', destination: '', slug: '', dates: [] },
        activeTab: 'all',
        bookingForm: { customer_name: '', phone: '', email: '', passengers: '2', travel_date: '', notes: '' },
        bookingSubmitting: false,
        bookingSuccess: false,
        bookingError: '',
        inquiryForm: { name: '', phone: '', email: '', destination: '', message: '' },
        inquirySubmitting: false,
        inquirySuccess: false,
        inquiryError: '',

        openBooking(pkg) {
            this.selectedPackage = pkg;
            this.bookingSuccess = false;
            this.bookingError = '';
            this.bookingForm = { customer_name: '', phone: '', email: '', passengers: '2', travel_date: '', notes: '' };
            this.bookingModal = true;
        },

        async submitBooking() {
            this.bookingSubmitting = true;
            this.bookingError = '';
            try {
                const res = await fetch('/booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        package_slug: this.selectedPackage.slug,
                        package_name: this.selectedPackage.name,
                        destination: this.selectedPackage.destination,
                        customer_name: this.bookingForm.customer_name,
                        email: this.bookingForm.email,
                        phone: this.bookingForm.phone,
                        passengers: parseInt(this.bookingForm.passengers),
                        travel_date: this.bookingForm.travel_date,
                        notes: this.bookingForm.notes,
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.bookingSuccess = true;
                    setTimeout(() => { this.bookingModal = false; this.bookingSuccess = false; }, 2500);
                } else {
                    this.bookingError = data.error || 'Terjadi kesalahan. Silakan coba lagi.';
                }
            } catch(e) {
                this.bookingError = 'Koneksi gagal. Silakan coba lagi.';
            } finally {
                this.bookingSubmitting = false;
            }
        },

        async submitInquiry() {
            this.inquirySubmitting = true;
            this.inquiryError = '';
            try {
                const res = await fetch('/inquiry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.inquiryForm)
                });
                const data = await res.json();
                if (data.success) {
                    this.inquirySuccess = true;
                    setTimeout(() => { this.inquiryModal = false; this.inquirySuccess = false; }, 2500);
                } else {
                    this.inquiryError = data.error || 'Terjadi kesalahan. Silakan coba lagi.';
                }
            } catch(e) {
                this.inquiryError = 'Koneksi gagal. Silakan coba lagi.';
            } finally {
                this.inquirySubmitting = false;
            }
        },

        filteredPackages(packages) {
            if (this.activeTab === 'all') return packages;
            return packages.filter(p => p.category === this.activeTab);
        }
    }"
>

@include('partials.navbar')

{{-- =========================================================
     HERO SECTION
     ========================================================= --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/packages/japan-featured.jpg') }}" alt="Travel destinations" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/40 via-blue-900/20 to-white"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/30 to-transparent"></div>
    </div>

    {{-- Floating Particles (CSS) --}}
    <div class="absolute inset-0 z-10 overflow-hidden pointer-events-none" aria-hidden="true">
        @for($i = 0; $i < 20; $i++)
        <div class="particle" style="left: {{ rand(0, 100) }}%; animation-duration: {{ rand(12, 22) }}s; animation-delay: {{ rand(0, 8) }}s; width: {{ rand(5, 10) }}px; height: {{ rand(5, 10) }}px; opacity: {{ number_format(rand(2, 7) / 10, 1) }};"></div>
        @endfor
    </div>

    {{-- Content --}}
    <div class="relative z-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-32">

        {{-- Badge --}}
        <div data-aos="fade-down" data-aos-delay="100" class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg mb-6">
            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <span class="text-sm font-semibold text-blue-900">Premium Travel Experience</span>
        </div>

        {{-- Headline --}}
        <h1 data-aos="fade-up" data-aos-delay="200" class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
            <span class="text-white drop-shadow-lg">Gateway To</span><br>
            <span class="bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 bg-clip-text text-transparent drop-shadow-lg">Fabulous Destinations</span>
        </h1>

        {{-- Subtitle --}}
        <p data-aos="fade-up" data-aos-delay="300" class="text-lg sm:text-xl text-white/90 max-w-2xl mx-auto mb-10 drop-shadow-md">
            Temukan destinasi impian Anda bersama kami dengan cepat dan mudah!<br class="hidden sm:block">
            Masukan nama kota atau negara yang ingin Anda kunjungi.
        </p>

        {{-- Search Box --}}
        <div data-aos="fade-up" data-aos-delay="400" class="max-w-2xl mx-auto mb-8">
            <div class="bg-white rounded-2xl shadow-2xl p-2 sm:p-3 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <input type="text" placeholder="Ke mana Anda ingin pergi?" class="w-full pl-12 pr-4 py-4 text-base border-0 focus:outline-none bg-slate-50 rounded-xl text-slate-700 placeholder-slate-400">
                </div>
                <a href="{{ route('packages.index') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-900 to-blue-700 hover:from-blue-800 hover:to-blue-600 text-white px-8 py-4 text-base font-semibold rounded-xl shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Destinasi
                </a>
            </div>
        </div>

        {{-- CTA Button --}}
        <div data-aos="fade-up" data-aos-delay="500">
            <button @click="openBooking({ name: 'Happy Journey Tour', price: 'Hubungi kami', destination: 'Pilihan Anda', slug: '' })" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white px-10 py-5 text-lg font-bold rounded-full shadow-2xl hover:shadow-amber-500/25 transition-all duration-300 hover:scale-105">
                BOOK YOUR JOURNEY NOW
            </button>
        </div>

        {{-- Stats --}}
        <div data-aos="fade-up" data-aos-delay="600" class="flex flex-wrap justify-center gap-8 sm:gap-16 mt-12">
            @foreach([['50+', 'Destinasi'], ['10K+', 'Traveler Bahagia'], ['99%', 'Kepuasan']] as [$val, $label])
            <div class="text-center">
                <div class="text-3xl sm:text-4xl font-bold text-white drop-shadow-lg">{{ $val }}</div>
                <div class="text-sm text-white/80 font-medium">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 scroll-indicator">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex items-start justify-center p-1">
            <div class="w-1.5 h-3 bg-white rounded-full scroll-dot"></div>
        </div>
    </div>
</section>

{{-- =========================================================
     DESTINASI TOUR
     ========================================================= --}}
<section id="destinasi" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">DESTINASI PILIHAN</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-blue-900 mb-3">Destinasi Tour Pilihan</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">Jelajahi dunia bersama Happy Journey — dari Asia hingga Eropa, dari pantai tropis hingga salju musim dingin.</p>
        </div>

        @php
        $grads = ['135deg,#1e3a5f,#1d4ed8','135deg,#155e75,#0891b2','135deg,#7f1d1d,#dc2626','135deg,#064e3b,#059669','135deg,#6b21a8,#7c3aed','135deg,#78350f,#d97706'];
        @endphp

        <style>
        @media (min-width: 1024px) {
            .dest-bento { grid-template-columns: repeat(3, 1fr); grid-template-rows: 300px 300px 260px; }
            .dest-bento .dest-card { aspect-ratio: unset !important; }
            .dest-bento .dest-card:nth-child(1) { grid-column: 1 / 3; grid-row: 1 / 3; }
            .dest-bento .dest-card:nth-child(2) { grid-column: 3; grid-row: 1; }
            .dest-bento .dest-card:nth-child(3) { grid-column: 3; grid-row: 2; }
            .dest-bento .dest-card:nth-child(4) { grid-column: 1; grid-row: 3; }
            .dest-bento .dest-card:nth-child(5) { grid-column: 2; grid-row: 3; }
            .dest-bento .dest-card:nth-child(6) { grid-column: 3; grid-row: 3; }
        }
        </style>

        {{-- Mobile: 2-col uniform | Desktop: bento (featured card top-left) --}}
        <div class="dest-bento grid grid-cols-2 gap-4 lg:gap-5">
            @foreach($featuredDestinations as $i => $dest)
            <a href="{{ route('packages.index', ['destination' => $dest['name']]) }}"
               data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}"
               class="dest-card relative group rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500"
               style="aspect-ratio:4/3;">

                @if($dest['image'])
                <img src="{{ asset($dest['image']) }}" alt="{{ $dest['label'] }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                <div class="absolute inset-0" style="background:linear-gradient({{ $grads[$i % count($grads)] }})"></div>
                <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(255,255,255,0.12) 1px,transparent 1px);background-size:20px 20px;"></div>
                <div class="absolute inset-0 flex items-center justify-center" style="pointer-events:none;">
                    <span style="font-size:4rem;opacity:0.1;transform:rotate(-10deg);line-height:1;">{{ $dest['flag'] }}</span>
                </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-transparent"></div>
                <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-all duration-500"></div>

                <div class="absolute bottom-0 left-0 right-0 p-4 {{ $i === 0 ? 'lg:p-8' : '' }}">
                    <div class="text-2xl {{ $i === 0 ? 'lg:text-4xl' : '' }} mb-1">{{ $dest['flag'] }}</div>
                    <div class="text-white font-bold text-base {{ $i === 0 ? 'lg:text-3xl' : 'lg:text-lg' }} leading-tight">{{ $dest['label'] }}</div>
                    @if($dest['count'] > 0)
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="text-white/70 text-xs">{{ $dest['count'] }} paket tersedia</span>
                        @if($i === 0)
                        <span class="hidden lg:inline-flex items-center gap-1 text-xs bg-amber-500 text-white px-2.5 py-0.5 rounded-full font-semibold">⭐ Terpopuler</span>
                        @endif
                    </div>
                    @else
                    <div class="text-amber-300 text-xs mt-0.5 font-semibold">Segera Hadir</div>
                    @endif
                    @if($i === 0)
                    <div class="hidden lg:block mt-3 opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-300">
                        <span class="inline-flex items-center gap-1.5 text-white text-sm font-semibold">
                            Lihat Paket <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                    @endif
                </div>

                <div class="absolute inset-0 ring-0 group-hover:ring-2 ring-amber-400/60 rounded-2xl transition-all duration-300 pointer-events-none"></div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8" data-aos="fade-up">
            <a href="{{ route('packages.destinations') }}" class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white px-8 py-3 rounded-full font-semibold transition-all shadow-lg">
                Lihat Semua Destinasi (15+)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =========================================================
     FEATURED PACKAGES
     ========================================================= --}}
<section id="packages" class="py-20 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div data-aos="fade-up" class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-blue-100 text-blue-900 rounded-full text-sm font-semibold mb-4">PAKET UNGGULAN</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-900 mb-4">Featured Happy Journey Packages</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Pilih paket perjalanan terbaik dengan harga terjangkau dan pengalaman tak terlupakan</p>
        </div>

        {{-- Filter Tabs --}}
        <div data-aos="fade-up" data-aos-delay="100" class="mb-10">
            <div class="flex justify-center">
                <div class="inline-flex bg-slate-100 rounded-full p-1 gap-1">
                    @foreach([['all','Semua'],['asia','Asia'],['eropa','Eropa']] as [$tab, $label])
                    <button
                        @click="activeTab = '{{ $tab }}'"
                        :class="activeTab === '{{ $tab }}' ? 'bg-blue-900 text-white shadow-sm' : 'text-slate-600 hover:text-blue-900'"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                    >{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Package Cards --}}
        @php
        $packageData = $packages->map(function($pkg) {
            return [
                'id'       => $pkg->id,
                'slug'     => $pkg->slug,
                'name'     => $pkg->name,
                'destination' => $pkg->destination,
                'duration' => $pkg->duration,
                'price_adult' => $pkg->price_adult,
                'highlights'  => $pkg->highlights ?? [],
                'image'       => $pkg->display_image,
                'category'    => $pkg->category,
                'discount_percent' => $pkg->discount_percent,
                'original_price'   => $pkg->original_price,
            ];
        })->toArray();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($packages as $index => $pkg)
            <div
                data-aos="fade-up"
                data-aos-delay="{{ $index * 80 }}"
                x-show="activeTab === 'all' || activeTab === '{{ $pkg->category }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100/50"
            >
                {{-- Image (clickable to detail) --}}
                <a href="{{ route('packages.show', $pkg->slug) }}" class="relative h-56 overflow-hidden block">
                    <img src="{{ $pkg->display_image }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover img-zoom group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    {{-- Discount Badge --}}
                    @if($pkg->discount_percent)
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-{{ $pkg->discount_percent }}%</span>
                    @endif

                    {{-- Destination Badge --}}
                    <div class="absolute top-4 right-4 flex items-center gap-1 bg-white/90 text-blue-900 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $pkg->destination }}
                    </div>

                    {{-- Price Badge --}}
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg">
                            <div class="text-xs text-slate-500">Mulai dari</div>
                            <div class="text-lg font-bold text-blue-900">Rp {{ number_format($pkg->price_adult, 0, ',', '.') }}</div>
                            @if($pkg->original_price)
                            <div class="text-xs text-slate-400 line-through">Rp {{ number_format($pkg->original_price, 0, ',', '.') }}</div>
                            @endif
                        </div>
                    </div>
                </a>

                {{-- Content --}}
                <div class="p-5">
                    <a href="{{ route('packages.show', $pkg->slug) }}" class="block">
                    <h3 class="text-base font-bold text-blue-900 mb-3 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $pkg->name }}</h3>
                    </a>

                    {{-- Duration --}}
                    <div class="flex items-center gap-2 text-slate-600 mb-3">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm">{{ $pkg->duration }}</span>
                    </div>

                    {{-- Highlights --}}
                    @if($pkg->highlights && count($pkg->highlights) > 0)
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach(array_slice($pkg->highlights, 0, 3) as $highlight)
                        <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-full">{{ $highlight }}</span>
                        @endforeach
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <a href="{{ route('packages.show', $pkg->slug) }}" class="flex-1 flex items-center justify-center gap-1.5 border-2 border-blue-200 text-blue-900 hover:bg-blue-50 hover:border-blue-300 text-xs font-semibold py-2.5 px-3 rounded-xl transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            LIHAT DETAIL
                        </a>
                        @php
                            $pkgDatesHome = collect($pkg->departure_dates ?? [])
                                ->map(fn($d) => [
                                    'value' => $d,
                                    'label' => \Carbon\Carbon::parse($d)->translatedFormat('D, d M Y'),
                                ])->values()->toArray();
                        @endphp
                        <button
                            @click="openBooking({ name: '{{ addslashes($pkg->name) }}', price: 'Rp {{ number_format($pkg->price_adult, 0, ',', '.') }}', destination: '{{ $pkg->destination }}', slug: '{{ $pkg->slug }}', dates: {{ Js::from($pkgDatesHome) }} })"
                            class="flex-1 flex items-center justify-center gap-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-semibold py-2.5 px-3 rounded-xl transition-all shadow-sm"
                        >
                            BOOKING SEKARANG
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- View All --}}
        <div data-aos="fade-up" data-aos-delay="200" class="text-center mt-12">
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 border-2 border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white px-8 py-4 text-base font-semibold rounded-full transition-all duration-300">
                Lihat Semua Paket
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =========================================================
     INSPIRASI PERJALANAN
     ========================================================= --}}
<section id="inspirasi" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div data-aos="fade-up" class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold mb-4">INSPIRASI PERJALANAN</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-900 mb-4">Temukan Cerita & Tips Travel</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Baca artikel inspiratif dan panduan lengkap untuk merencanakan perjalanan impian Anda</p>
        </div>

        @php
        $categoryColors = [
            'China'    => 'bg-red-100 text-red-700',
            'Vietnam'  => 'bg-emerald-100 text-emerald-700',
            'Jepang'   => 'bg-pink-100 text-pink-700',
            'Korea'    => 'bg-blue-100 text-blue-700',
            'Eropa'    => 'bg-purple-100 text-purple-700',
            'Inspirasi'=> 'bg-amber-100 text-amber-700',
            'Corporate'=> 'bg-slate-100 text-slate-700',
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @foreach($articles as $index => $article)
            <div data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100/50 flex flex-col">
                {{-- Image --}}
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $article->display_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover img-zoom group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                    {{-- Category Badge --}}
                    <span class="absolute top-4 left-4 text-xs font-semibold px-3 py-1 rounded-full {{ $categoryColors[$article->category] ?? 'bg-slate-100 text-slate-700' }}">
                        {{ $article->category }}
                    </span>

                    {{-- Bookmark --}}
                    <button class="absolute top-4 right-4 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-md">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </button>
                </div>

                {{-- Content --}}
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $article->formatted_date }}
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $article->read_time }}
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-blue-900 mb-2 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $article->title }}</h3>
                    <p class="text-slate-600 text-sm line-clamp-2 mb-4 flex-1">{{ $article->excerpt }}</p>

                    <a href="{{ route('blog.show', $article->slug) }}" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-semibold text-sm transition-colors">
                        Baca Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div data-aos="fade-up" data-aos-delay="200" class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 border-2 border-amber-500 text-amber-600 hover:bg-amber-500 hover:text-white px-8 py-4 text-base font-semibold rounded-full transition-all duration-300">
                Lihat Semua Artikel
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- =========================================================
     TESTIMONIALS
     ========================================================= --}}
<section class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div data-aos="fade-up" class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">TESTIMONI</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-900 mb-4">Apa Kata Traveler Kami?</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Ribuan traveler Indonesia telah mempercayakan perjalanan mereka kepada kami</p>
        </div>

        {{-- Stats Bar --}}
        <div data-aos="fade-up" data-aos-delay="100" class="flex flex-wrap justify-center gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg px-8 py-6 text-center">
                <div class="text-4xl font-bold text-blue-900">4.9</div>
                <div class="flex items-center justify-center gap-1 my-2">
                    @for($s = 0; $s < 5; $s++)
                    <svg class="w-5 h-5 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                </div>
                <div class="text-sm text-slate-500">Rating Rata-rata</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg px-8 py-6 text-center">
                <div class="text-4xl font-bold text-blue-900">10,000+</div>
                <div class="text-sm text-slate-500 mt-2">Ulasan Positif</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg px-8 py-6 text-center">
                <div class="text-4xl font-bold text-blue-900">99%</div>
                <div class="text-sm text-slate-500 mt-2">Rekomendasi</div>
            </div>
        </div>

        {{-- Testimonial Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials as $index => $testimonial)
            <div data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 flex flex-col">
                {{-- Quote Icon --}}
                <div class="mb-4">
                    <svg class="w-8 h-8 text-amber-400 rotate-180" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>

                <p class="text-slate-600 text-sm leading-relaxed mb-4 flex-1">"{{ $testimonial->review }}"</p>

                {{-- Stars --}}
                <div class="flex items-center gap-1 mb-4">
                    @for($s = 0; $s < $testimonial->rating; $s++)
                    <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                </div>

                {{-- Tour Badge --}}
                <div class="inline-flex items-center gap-1 bg-blue-50 text-blue-900 text-xs font-medium px-3 py-1 rounded-full mb-4 w-fit">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $testimonial->tour_name }}
                </div>

                {{-- Author --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-semibold text-sm">{{ $testimonial->initials }}</span>
                    </div>
                    <div>
                        <div class="font-semibold text-blue-900 text-sm">{{ $testimonial->name }}</div>
                        <div class="text-xs text-slate-500">{{ $testimonial->location }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     ABOUT / WHY HAPPY JOURNEY
     ========================================================= --}}
<section id="about" class="py-20 bg-gradient-to-b from-blue-900 via-blue-900 to-blue-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-aos="fade-up" class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-white/10 text-amber-400 rounded-full text-sm font-semibold mb-4">TENTANG KAMI</span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">Mengapa Memilih Happy Journey?</h2>
            <p class="text-white/70 max-w-2xl mx-auto">{{ config('happyjourney.description', 'PT. Rihlah Global Wisata — Perusahaan tour & travel terpercaya yang berkomitmen menghadirkan pengalaman perjalanan yang berkesan, nyaman, dan berkualitas.') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['🏆', 'Terpercaya', 'Perusahaan tour travel terpercaya dengan ribuan pelanggan puas sejak berdiri.'],
                ['✈️', 'Pengalaman', 'Tim tour leader profesional berbahasa Indonesia yang berpengalaman.'],
                ['💰', 'Harga Kompetitif', 'Harga terbaik tanpa mengorbankan kualitas layanan dan kenyamanan.'],
                ['🛡️', 'Bergaransi', 'Asuransi perjalanan dan jaminan keamanan selama wisata.'],
            ] as [$icon, $title, $desc])
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}" class="bg-white/10 hover:bg-white/15 rounded-2xl p-6 text-center transition-colors">
                <div class="text-4xl mb-4">{{ $icon }}</div>
                <h3 class="text-lg font-bold text-amber-400 mb-2">{{ $title }}</h3>
                <p class="text-white/70 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =========================================================
     FOOTER
     ========================================================= --}}
<footer id="contact" class="bg-gradient-to-b from-blue-900 via-blue-900 to-blue-950 text-white">

    {{-- Newsletter --}}
    <div class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div data-aos="fade-up" class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-center lg:text-left">
                    <h3 class="text-2xl font-bold mb-2">Dapatkan Promo Eksklusif!</h3>
                    <p class="text-white/70">Subscribe newsletter kami untuk info promo dan tips travel terbaru</p>
                </div>
                <form class="flex w-full max-w-md gap-3" @submit.prevent="">
                    <input type="email" placeholder="Masukkan email Anda" class="flex-1 bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-amber-500 focus:outline-none rounded-xl px-4 py-3 text-sm transition-colors">
                    <button type="submit" class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-3 rounded-xl font-semibold text-sm transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Footer Grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">

            {{-- Company Info --}}
            <div data-aos="fade-up">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                    <div class="relative w-12 h-12">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl rotate-6"></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-white">Happy</span><span class="text-2xl font-bold text-amber-400">Journey</span>
                    </div>
                </a>
                <p class="text-white/70 text-sm leading-relaxed mb-6">Happy Journey adalah travel agent terpercaya yang menyediakan paket tour domestik dan internasional dengan kualitas premium dan harga kompetitif.</p>
                <div class="flex gap-3">
                    {{-- Facebook --}}
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    {{-- YouTube --}}
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div data-aos="fade-up" data-aos-delay="80">
                <h4 class="text-lg font-bold mb-6 text-amber-400">Quick Links</h4>
                <ul class="space-y-3">
                    @foreach([['BERANDA', route('home')], ['PAKET TOUR', route('packages.index')], ['INSPIRASI', '#inspirasi'], ['TENTANG KAMI', '#about'], ['KONTAK', '#contact']] as [$name, $href])
                    <li><a href="{{ $href }}" class="text-white/70 hover:text-amber-400 transition-colors text-sm">{{ $name }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Destinasi Populer --}}
            <div data-aos="fade-up" data-aos-delay="160">
                <h4 class="text-lg font-bold mb-6 text-amber-400">Destinasi Populer</h4>
                <ul class="space-y-3">
                    @foreach(['Tour Jepang', 'Tour Korea', 'Tour China', 'Tour Eropa', 'Tour Vietnam', 'Tour Hainan'] as $dest)
                    <li>
                        <a href="{{ route('packages.index') }}" class="flex items-center gap-2 text-white/70 hover:text-amber-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $dest }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact Info --}}
            <div data-aos="fade-up" data-aos-delay="240">
                <h4 class="text-lg font-bold mb-6 text-amber-400">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span class="text-white/70 text-sm">Menara Cakrawala, Lantai 15, Jl. M.H. Thamrin No.9, Jakarta Pusat 10340</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div class="text-sm">
                            <div class="text-white/70">0859-4116-7415</div>
                            <div class="text-white/70">0812-9670-9603</div>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:info@happyjourney.co.id" class="text-white/70 hover:text-amber-400 text-sm transition-colors">info@happyjourney.co.id</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-white/70 text-sm">Senin - Minggu: 09:00 - 17:00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-white/60 text-sm text-center md:text-left">
                    Copyright &copy; {{ date('Y') }} - Happy Journey Tour & Travel Agent. All rights reserved.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="text-white/60 hover:text-amber-400 text-sm transition-colors">PRIVACY POLICY</a>
                    <a href="#" class="text-white/60 hover:text-amber-400 text-sm transition-colors">SYARAT &amp; KETENTUAN</a>
                    <a href="#" class="text-white/60 hover:text-amber-400 text-sm transition-colors">KEBIJAKAN PENGEMBALIAN</a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- =========================================================
     WHATSAPP FLOATING BUTTON
     ========================================================= --}}
<a href="https://wa.me/6285941167415" target="_blank" rel="noopener noreferrer"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-2xl hover:shadow-green-500/40 transition-all duration-300 hover:scale-110"
   title="Chat WhatsApp">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

{{-- =========================================================
     BOOKING MODAL
     ========================================================= --}}
<div x-show="bookingModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="bookingModal = false"></div>

    {{-- Modal --}}
    <div x-show="bookingModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Booking Tour</h3>
                    <p class="text-blue-200 text-sm mt-0.5" x-text="selectedPackage.name"></p>
                </div>
                <button @click="bookingModal = false" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Success State --}}
        <div x-show="bookingSuccess" class="p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-2">Booking Berhasil!</h3>
            <p class="text-slate-600">Tim kami akan segera menghubungi Anda.</p>
        </div>

        {{-- Form --}}
        <div x-show="!bookingSuccess" class="p-6 space-y-4">
            {{-- Error --}}
            <div x-show="bookingError" class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-red-700 text-sm" x-text="bookingError"></p>
            </div>

            {{-- Package Info --}}
            <div class="bg-slate-50 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-blue-900 text-sm" x-text="selectedPackage.destination"></div>
                        <div class="text-xs text-slate-500 line-clamp-1" x-text="selectedPackage.name"></div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-blue-900 text-sm" x-text="selectedPackage.price"></div>
                    <div class="text-xs text-slate-500">per orang</div>
                </div>
            </div>

            <form @submit.prevent="submitBooking()" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" x-model="bookingForm.customer_name" placeholder="Nama lengkap" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" x-model="bookingForm.phone" placeholder="08xxxxxxxxxx" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" x-model="bookingForm.email" placeholder="email@example.com" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">Jumlah Orang <span class="text-red-500">*</span></label>
                        <select x-model="bookingForm.passengers" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            @for($n = 1; $n <= 10; $n++)
                            <option value="{{ $n }}">{{ $n }} Orang</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">Tanggal Keberangkatan <span class="text-red-500">*</span></label>
                        <template x-if="selectedPackage.dates && selectedPackage.dates.length > 0">
                            <select x-model="bookingForm.travel_date" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">-- Pilih Tanggal --</option>
                                <template x-for="d in selectedPackage.dates" :key="d.value">
                                    <option :value="d.value" x-text="d.label"></option>
                                </template>
                            </select>
                        </template>
                        <template x-if="!selectedPackage.dates || selectedPackage.dates.length === 0">
                            <div>
                                <input type="date" x-model="bookingForm.travel_date" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <p class="text-xs text-slate-400 mt-1">Jadwal belum tersedia, masukkan tanggal yang diinginkan.</p>
                            </div>
                        </template>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1.5">Catatan (Opsional)</label>
                    <textarea x-model="bookingForm.notes" rows="3" placeholder="Permintaan khusus atau pertanyaan..." class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"></textarea>
                </div>
                <button type="submit" :disabled="bookingSubmitting" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 disabled:opacity-60 text-white py-4 text-base font-semibold rounded-xl shadow-lg transition-all">
                    <template x-if="bookingSubmitting">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </template>
                    <template x-if="!bookingSubmitting">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </template>
                    <span x-text="bookingSubmitting ? 'Memproses...' : 'Kirim Booking'"></span>
                </button>
                <p class="text-xs text-slate-500 text-center">Dengan mengirim form ini, Anda menyetujui Syarat &amp; Ketentuan kami</p>
            </form>
        </div>
    </div>
</div>

{{-- =========================================================
     INQUIRY MODAL
     ========================================================= --}}
<div x-show="inquiryModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="inquiryModal = false"></div>

    <div x-show="inquiryModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10">

        <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Konsultasi Gratis</h3>
                    <p class="text-blue-200 text-sm mt-0.5">Tim kami siap membantu Anda</p>
                </div>
                <button @click="inquiryModal = false" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Success --}}
        <div x-show="inquirySuccess" class="p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-2">Pesan Terkirim!</h3>
            <p class="text-slate-600">Tim kami akan segera menghubungi Anda.</p>
        </div>

        <div x-show="!inquirySuccess" class="p-6 space-y-4">
            <div x-show="inquiryError" class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-red-700 text-sm" x-text="inquiryError"></p>
            </div>

            <form @submit.prevent="submitInquiry()" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" x-model="inquiryForm.name" placeholder="Nama lengkap" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" x-model="inquiryForm.phone" placeholder="08xxxxxxxxxx" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" x-model="inquiryForm.email" placeholder="email@example.com" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1.5">Destinasi Impian</label>
                    <select x-model="inquiryForm.destination" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih destinasi</option>
                        @foreach(['Jepang','Korea','China','Vietnam','Eropa','Hainan','Holyland','Domestik Indonesia','Belum Tentu','Lainnya'] as $dest)
                        <option value="{{ $dest }}">{{ $dest }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1.5">Pesan <span class="text-red-500">*</span></label>
                    <textarea x-model="inquiryForm.message" rows="4" placeholder="Ceritakan kebutuhan perjalanan Anda..." required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"></textarea>
                </div>
                <button type="submit" :disabled="inquirySubmitting" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 disabled:opacity-60 text-white py-4 text-base font-semibold rounded-xl shadow-lg transition-all">
                    <template x-if="inquirySubmitting">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </template>
                    <template x-if="!inquirySubmitting">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </template>
                    <span x-text="inquirySubmitting ? 'Memproses...' : 'Kirim Pesan'"></span>
                </button>
                <p class="text-xs text-slate-500 text-center">Dengan mengirim form ini, Anda menyetujui Syarat &amp; Ketentuan kami</p>
            </form>
        </div>
    </div>
</div>

</div>{{-- end x-data wrapper --}}
@endsection
