@extends('layouts.app')

@section('title', 'Destinasi Tour - Happy Journey')
@section('og_image', asset('images/og-image.webp'))
@section('meta_description', 'Temukan berbagai pilihan paket tour Happy Journey berdasarkan destinasi — Jepang, Korea, China, Vietnam, Eropa, dan lebih banyak lagi.')

@section('content')

@include('partials.navbar', [
    'breadcrumbs' => [
        ['label' => 'Paket Tour', 'url' => null],
    ]
])

{{-- Hero --}}
<div class="relative bg-blue-950 overflow-hidden" style="min-height:280px;">
    <div class="absolute inset-0 opacity-30">
        <img src="{{ asset('images/hero-destinations.jpg') }}" class="w-full h-full object-cover" alt="">
    </div>
    <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(14,50,104,0.85) 0%, rgba(30,64,175,0.7) 100%)"></div>
    {{-- Decorative circles --}}
    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full opacity-10" style="background:white;"></div>
    <div class="absolute -bottom-20 -left-10 w-80 h-80 rounded-full opacity-5" style="background:white;"></div>
    <div class="relative max-w-4xl mx-auto px-4 py-16 text-center">
        <div class="inline-flex items-center gap-2 bg-white/15 text-amber-300 text-xs font-bold px-4 py-1.5 rounded-full mb-5">
            ✈️ &nbsp;15+ DESTINASI TERSEDIA
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
            Destinasi Tour Pilihan<br><span class="text-amber-400">Happy Journey</span>
        </h1>
        <p class="text-white text-base max-w-2xl mx-auto">
            Temukan berbagai pilihan liburan seru yang sudah dikategorikan berdasarkan negara tujuan — mulai dari Jepang, China, Hong Kong, Taiwan, hingga destinasi favorit seperti Asia Tenggara, Turki, Dubai, dan Eropa.
        </p>
        <div class="flex items-center justify-center gap-6 mt-8 text-white text-sm">
            <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span> {{ \App\Models\TourPackage::where('is_active',true)->count() }} Paket Aktif</div>
            <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-amber-400 rounded-full inline-block"></span> Pemandu Berbahasa Indonesia</div>
            <div class="flex items-center gap-1.5"><span class="w-2 h-2 bg-blue-400 rounded-full inline-block"></span> Harga Terjangkau</div>
        </div>
    </div>
</div>

@php
$gradients = [
    'linear-gradient(135deg,#1e3a5f,#1d4ed8)',
    'linear-gradient(135deg,#155e75,#0891b2)',
    'linear-gradient(135deg,#6b21a8,#7c3aed)',
    'linear-gradient(135deg,#064e3b,#059669)',
    'linear-gradient(135deg,#7f1d1d,#dc2626)',
    'linear-gradient(135deg,#78350f,#d97706)',
    'linear-gradient(135deg,#1e3a5f,#0f766e)',
    'linear-gradient(135deg,#3b0764,#6d28d9)',
];
// Landmark icon per destination name for gradient cards
$landmarks = [
    'Taiwan'        => '🏙️',
    'Hong Kong'     => '🌉',
    'Dubai'         => '🕌',
    'Thailand'      => '🛕',
    'Australia'     => '🦘',
    'Holyland'      => '🕍',
    'Indonesia'     => '🌴',
    'Cruise'        => '🚢',
];
@endphp

{{-- Destination Grid --}}
<div class="bg-slate-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section label --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="h-px flex-1 bg-slate-200"></div>
            <span class="text-xs font-bold text-slate-400 tracking-widest uppercase">Pilih Destinasi Impianmu</span>
            <div class="h-px flex-1 bg-slate-200"></div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 pb-4">
            @foreach($destinations as $index => $dest)
            <a href="{{ route('packages.index', ['destination' => $dest['name']]) }}"
               class="relative group rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-1"
               style="aspect-ratio: 4/3;">

                @if($dest['image'])
                <img src="{{ asset($dest['image']) }}" alt="{{ $dest['label'] }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                {{-- Gradient background --}}
                <div class="absolute inset-0" style="background: {{ $gradients[$index % count($gradients)] }};"></div>
                {{-- Dot grid pattern --}}
                <div class="absolute inset-0" style="background-image:radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px); background-size:22px 22px;"></div>
                {{-- Large decorative landmark --}}
                <div class="absolute inset-0 flex items-center justify-center" style="pointer-events:none;">
                    <span style="font-size:6rem; opacity:0.12; transform:rotate(-10deg) scale(1.2); line-height:1;">{{ $landmarks[$dest['name']] ?? $dest['flag'] }}</span>
                </div>
                {{-- Shine top-right --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full" style="background:rgba(255,255,255,0.06);"></div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                {{-- Bottom content --}}
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <div class="text-2xl mb-1">{{ $dest['flag'] }}</div>
                    <h2 class="text-white font-bold text-lg leading-tight">{{ $dest['label'] }}</h2>
                    <div class="flex items-center justify-between mt-1">
                        @if($dest['count'] > 0)
                        <span class="text-white/70 text-xs">{{ $dest['count'] }} paket</span>
                        @else
                        <span class="text-amber-300 text-xs font-semibold">Segera Hadir</span>
                        @endif
                        <span class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </div>

                {{-- Hover ring --}}
                <div class="absolute inset-0 rounded-2xl ring-0 group-hover:ring-2 ring-amber-400/50 transition-all duration-300 pointer-events-none"></div>
            </a>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="mt-12 rounded-2xl overflow-hidden shadow-xl" style="background:linear-gradient(135deg,#0e3268 0%,#1d4ed8 60%,#0891b2 100%);">
            <div class="relative px-6 sm:px-12 py-10 text-center">
                <div class="absolute -top-8 -left-8 w-40 h-40 rounded-full" style="background:rgba(255,255,255,0.05);"></div>
                <div class="absolute -bottom-10 -right-6 w-52 h-52 rounded-full" style="background:rgba(255,255,255,0.04);"></div>

                <div class="relative">
                    <div class="text-4xl mb-3">✈️</div>
                    <h3 class="text-2xl font-bold text-white mb-2">Belum menemukan destinasi yang cocok?</h3>
                    <p class="text-white/65 text-sm mb-7 max-w-md mx-auto">Lihat semua paket tour kami atau konsultasikan langsung dengan tim Happy Journey — gratis!</p>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white px-6 py-3 rounded-full font-bold transition-all shadow-lg text-sm whitespace-nowrap">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Lihat Semua Paket
                        </a>
                        <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20ingin%20konsultasi%20paket%20tour" target="_blank"
                           class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 text-white px-6 py-3 rounded-full font-bold transition-all text-sm whitespace-nowrap">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

@endsection
