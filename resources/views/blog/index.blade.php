@extends('layouts.app')

@section('title', 'Inspirasi Perjalanan - Happy Journey')
@section('meta_description', 'Temukan artikel inspiratif, tips perjalanan, dan panduan destinasi wisata dari Happy Journey Tour & Travel.')

@section('content')
<div x-data="{}">

@include('partials.navbar', ['breadcrumbs' => [['label' => 'Inspirasi', 'url' => null]]])

{{-- Hero Section --}}
<div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-blue-700 py-20 text-white text-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-blog.jpg') }}" class="w-full h-full object-cover scale-105 blur-sm" alt="">
        <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(14,50,104,0.82) 0%, rgba(30,64,175,0.65) 100%)"></div>
    </div>
    {{-- Decorative circles --}}
    <div class="absolute top-0 right-0 w-72 h-72 bg-amber-400/10 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/10 rounded-full translate-y-1/2 -translate-x-1/3 blur-3xl"></div>
    <div class="relative max-w-3xl mx-auto px-4">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-amber-400/20 border border-amber-400/30 text-amber-300 rounded-full text-xs font-bold tracking-wider uppercase mb-5">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
            Blog &amp; Inspirasi
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight">Inspirasi Perjalanan</h1>
        <p class="text-white/70 text-lg max-w-xl mx-auto">Cerita, tips, dan panduan lengkap untuk merencanakan perjalanan impian Anda</p>
    </div>
</div>

{{-- Category Filter Pills --}}
<div class="bg-white border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 py-3 overflow-x-auto scrollbar-hide">
            <a href="{{ route('blog.index') }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ !$activeCategory ? 'bg-blue-900 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>
            @foreach($categories as $cat)
            @php
                $catColors = [
                    'China'     => $activeCategory === $cat ? 'bg-red-600 text-white shadow' : 'bg-red-50 text-red-700 hover:bg-red-100',
                    'Vietnam'   => $activeCategory === $cat ? 'bg-emerald-600 text-white shadow' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100',
                    'Jepang'    => $activeCategory === $cat ? 'bg-pink-600 text-white shadow' : 'bg-pink-50 text-pink-700 hover:bg-pink-100',
                    'Inspirasi' => $activeCategory === $cat ? 'bg-amber-500 text-white shadow' : 'bg-amber-50 text-amber-700 hover:bg-amber-100',
                    'Corporate' => $activeCategory === $cat ? 'bg-slate-700 text-white shadow' : 'bg-slate-100 text-slate-700 hover:bg-slate-200',
                ];
                $catIcons = [
                    'China'     => '🇨🇳',
                    'Vietnam'   => '🇻🇳',
                    'Jepang'    => '🇯🇵',
                    'Inspirasi' => '✨',
                    'Corporate' => '🏢',
                ];
            @endphp
            <a href="{{ route('blog.index', ['category' => $cat]) }}"
               class="flex-shrink-0 flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ $catColors[$cat] ?? 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span>{{ $catIcons[$cat] ?? '' }}</span>
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Articles --}}
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
        $categoryColors = [
            'China'     => 'bg-red-100 text-red-700',
            'Vietnam'   => 'bg-emerald-100 text-emerald-700',
            'Jepang'    => 'bg-pink-100 text-pink-700',
            'Inspirasi' => 'bg-amber-100 text-amber-700',
            'Corporate' => 'bg-slate-100 text-slate-700',
        ];
        $categoryBadge = [
            'China'     => 'bg-red-600 text-white',
            'Vietnam'   => 'bg-emerald-600 text-white',
            'Jepang'    => 'bg-pink-600 text-white',
            'Inspirasi' => 'bg-amber-500 text-white',
            'Corporate' => 'bg-slate-700 text-white',
        ];
        @endphp

        @if($articles->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Belum ada artikel untuk kategori ini</h2>
            <p class="text-slate-500 mb-6">Silakan pilih kategori lain atau lihat semua artikel kami</p>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition-colors">
                Lihat Semua Artikel
            </a>
        </div>
        @else

        {{-- Count info --}}
        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-slate-500">
                Menampilkan <strong class="text-slate-700">{{ $articles->total() }}</strong>
                @if($activeCategory)
                artikel kategori <strong class="text-slate-700">{{ $activeCategory }}</strong>
                @else
                artikel
                @endif
            </p>
        </div>

        @php $allArticles = $articles->items(); $featured = $allArticles[0] ?? null; $rest = array_slice($allArticles, 1); @endphp

        {{-- Featured Article (first on page 1) --}}
        @if($featured && $articles->currentPage() === 1)
        <a href="{{ route('blog.show', $featured->slug) }}"
           class="group block mb-10 bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-slate-100">
            <div class="grid grid-cols-1 lg:grid-cols-5">
                <div class="lg:col-span-3 relative h-52 lg:h-60 overflow-hidden">
                    <img src="{{ $featured->display_image }}" alt="{{ $featured->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent to-black/20 lg:block hidden"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent lg:hidden"></div>
                    <span class="absolute top-4 left-4 text-xs font-bold px-3 py-1.5 rounded-full {{ $categoryBadge[$featured->category] ?? 'bg-slate-700 text-white' }}">
                        {{ $featured->category }}
                    </span>
                    <span class="absolute top-4 right-4 bg-amber-400 text-blue-950 text-xs font-bold px-3 py-1.5 rounded-full">
                        ✦ ARTIKEL PILIHAN
                    </span>
                </div>
                <div class="lg:col-span-2 p-5 lg:p-7 flex flex-col justify-center">
                    <div class="flex items-center gap-4 text-xs text-slate-400 mb-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $featured->formatted_date }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $featured->read_time }}
                        </span>
                    </div>
                    <h2 class="text-xl lg:text-2xl font-extrabold text-blue-900 mb-3 group-hover:text-amber-600 transition-colors leading-snug">
                        {{ $featured->title }}
                    </h2>
                    <p class="text-slate-500 text-sm line-clamp-3 mb-6 leading-relaxed">{{ $featured->excerpt }}</p>
                    <span class="inline-flex items-center gap-2 text-amber-600 group-hover:text-amber-700 font-bold text-sm transition-colors">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
        @endif

        {{-- Rest of articles grid --}}
        @php $gridArticles = $articles->currentPage() === 1 ? $rest : $allArticles; @endphp
        @if(count($gridArticles) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($gridArticles as $index => $article)
            <a href="{{ route('blog.show', $article->slug) }}"
               data-aos="fade-up" data-aos-delay="{{ min($index * 60, 240) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-400 border border-slate-100 flex flex-col">

                {{-- Image --}}
                <div class="relative h-48 overflow-hidden flex-shrink-0">
                    <img src="{{ $article->display_image }}" alt="{{ $article->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                    <span class="absolute bottom-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full {{ $categoryBadge[$article->category] ?? 'bg-slate-700 text-white' }}">
                        {{ $article->category }}
                    </span>
                </div>

                {{-- Content --}}
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $article->formatted_date }}
                        </span>
                        <span class="text-slate-200">•</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $article->read_time }}
                        </span>
                    </div>

                    <h3 class="text-sm font-bold text-blue-900 mb-2 group-hover:text-amber-600 transition-colors line-clamp-2 leading-snug flex-1">
                        {{ $article->title }}
                    </h3>
                    <p class="text-slate-500 text-xs line-clamp-2 mb-4 leading-relaxed">{{ $article->excerpt }}</p>

                    <span class="inline-flex items-center gap-1.5 text-amber-600 group-hover:text-amber-700 font-semibold text-xs transition-colors mt-auto">
                        Baca
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif

        @endif
    </div>
</div>

{{-- Footer --}}
<footer class="bg-blue-950 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 flex flex-col items-center gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo/cropped-logo_happy_journey.png') }}" alt="Happy Journey" class="w-10 h-10 object-contain">
            <span class="text-xl font-bold"><span class="text-white">Happy</span><span class="text-amber-400">Journey</span></span>
        </div>
        <p class="text-white/50 text-sm">Copyright &copy; {{ date('Y') }} - Happy Journey Tour & Travel.</p>
    </div>
</footer>

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/6285941167415" target="_blank"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

</div>
@endsection
