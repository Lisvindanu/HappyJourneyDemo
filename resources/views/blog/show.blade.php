@extends('layouts.app')

@section('title', $article->title . ' - Happy Journey')
@section('meta_description', $article->excerpt)
@section('og_type', 'article')
@section('og_image', $article->display_image)

@section('content')
<div x-data="{}">

@include('partials.navbar', [
    'breadcrumbs' => [
        ['label' => 'Inspirasi', 'url' => route('blog.index')],
        ['label' => $article->title, 'url' => null],
    ]
])

{{-- Hero: Full-width article image with overlay --}}
<div class="relative h-72 sm:h-80 overflow-hidden">
    <img src="{{ $article->display_image }}" alt="{{ $article->title }}"
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>

    {{-- Overlaid meta at bottom --}}
    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
        <div class="max-w-7xl mx-auto">
            @php
            $categoryColors = [
                'China'     => 'bg-red-100 text-red-700',
                'Vietnam'   => 'bg-emerald-100 text-emerald-700',
                'Jepang'    => 'bg-pink-100 text-pink-700',
                'Inspirasi' => 'bg-amber-100 text-amber-700',
                'Corporate' => 'bg-slate-100 text-slate-700',
            ];
            @endphp
            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full mb-3 {{ $categoryColors[$article->category] ?? 'bg-slate-100 text-slate-700' }}">
                {{ $article->category }}
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3 max-w-3xl leading-tight">
                {{ $article->title }}
            </h1>
            <div class="flex items-center gap-4 text-white text-sm drop-shadow">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $article->formatted_date }}
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $article->read_time }} baca
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content Area --}}
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            {{-- Article Content (2/3 width) --}}
            <div class="lg:col-span-2">
                {{-- Excerpt / Lead --}}
                <p class="text-lg text-slate-600 font-medium mb-6 pb-6 border-b border-slate-100 leading-relaxed">
                    {{ $article->excerpt }}
                </p>

                {{-- Full Content --}}
                <div class="article-content text-slate-700 leading-relaxed">
                    {!! $article->content !!}
                </div>

                {{-- CTA Box --}}
                <div class="mt-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-6 sm:p-8 text-white">
                    <h3 class="text-xl font-bold mb-2">Tertarik dengan destinasi ini?</h3>
                    <p class="text-blue-200 mb-5 text-sm">
                        Lihat paket tour kami ke {{ $article->category !== 'Inspirasi' && $article->category !== 'Corporate' ? $article->category : 'berbagai destinasi' }} dengan harga terbaik dan panduan berbahasa Indonesia.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        @if(!in_array($article->category, ['Inspirasi', 'Corporate']))
                        <a href="{{ route('packages.index', ['destination' => $article->category]) }}"
                           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-md">
                            Lihat Paket Tour {{ $article->category }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('packages.index') }}"
                           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-md">
                            Lihat Semua Paket Tour
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @endif
                        <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20tertarik%20dengan%20artikel%20{{ urlencode($article->title) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Konsultasi WhatsApp
                        </a>
                    </div>
                </div>

                {{-- Back link --}}
                <div class="mt-8">
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center gap-2 text-blue-900 hover:text-amber-600 font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                        </svg>
                        Kembali ke Inspirasi
                    </a>
                </div>
            </div>

            {{-- Sidebar (1/3 width) --}}
            <div class="mt-10 lg:mt-0">
                <div class="lg:sticky lg:top-24 space-y-6">

                    {{-- Related Articles --}}
                    @if($related->count() > 0)
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <h3 class="text-base font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <span class="w-1 h-5 bg-amber-500 rounded-full inline-block"></span>
                            Artikel Terkait
                        </h3>
                        <div class="space-y-4">
                            @foreach($related as $rel)
                            <a href="{{ route('blog.show', $rel->slug) }}"
                               class="flex gap-3 group">
                                <div class="flex-shrink-0 w-20 h-16 rounded-xl overflow-hidden">
                                    <img src="{{ $rel->display_image }}" alt="{{ $rel->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-blue-900 group-hover:text-amber-600 transition-colors line-clamp-2 leading-tight mb-1">
                                        {{ $rel->title }}
                                    </h4>
                                    <p class="text-xs text-slate-400">{{ $rel->formatted_date }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <a href="{{ route('blog.index', ['category' => $article->category]) }}"
                               class="text-sm font-semibold text-amber-600 hover:text-amber-700 transition-colors flex items-center gap-1">
                                Lihat semua artikel {{ $article->category }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Quick Consult Widget --}}
                    <div class="bg-gradient-to-b from-amber-50 to-amber-100 rounded-2xl p-5 border border-amber-200">
                        <h3 class="text-base font-bold text-blue-900 mb-2">Mau Liburan?</h3>
                        <p class="text-sm text-slate-600 mb-4">Konsultasi gratis dengan tim Happy Journey untuk merencanakan perjalanan impian Anda.</p>
                        <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20ingin%20konsultasi%20paket%20tour" target="_blank"
                           class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-semibold text-sm transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Chat WhatsApp Sekarang
                        </a>
                    </div>

                    {{-- Browse Categories --}}
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                        <h3 class="text-base font-bold text-blue-900 mb-3 flex items-center gap-2">
                            <span class="w-1 h-5 bg-blue-700 rounded-full inline-block"></span>
                            Kategori Artikel
                        </h3>
                        @php
                        $catList = [
                            'China'     => ['color' => 'bg-red-100 text-red-700', 'hover' => 'hover:bg-red-50'],
                            'Vietnam'   => ['color' => 'bg-emerald-100 text-emerald-700', 'hover' => 'hover:bg-emerald-50'],
                            'Jepang'    => ['color' => 'bg-pink-100 text-pink-700', 'hover' => 'hover:bg-pink-50'],
                            'Inspirasi' => ['color' => 'bg-amber-100 text-amber-700', 'hover' => 'hover:bg-amber-50'],
                            'Corporate' => ['color' => 'bg-slate-100 text-slate-700', 'hover' => 'hover:bg-slate-50'],
                        ];
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach($catList as $catName => $catStyle)
                            <a href="{{ route('blog.index', ['category' => $catName]) }}"
                               class="px-3 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $catStyle['color'] }} {{ $catStyle['hover'] }}">
                                {{ $catName }}
                            </a>
                            @endforeach
                        </div>
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

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/6285941167415" target="_blank"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

</div>

@push('head')
<style>
    .article-content p { margin-bottom: 1rem; color: #475569; line-height: 1.75; }
    .article-content h3 { font-weight: 700; color: #1e3a5f; margin-bottom: 0.5rem; margin-top: 1.5rem; font-size: 1.1rem; }
    .article-content ul { list-style-type: disc; padding-left: 1.25rem; margin-bottom: 1rem; }
    .article-content li { margin-bottom: 0.25rem; color: #475569; }
</style>
@endpush

@endsection
