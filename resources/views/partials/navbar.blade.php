{{--
    Shared Navbar Partial
    Usage: @include('partials.navbar', ['breadcrumbs' => [...]])
    $breadcrumbs: optional array of ['label' => '...', 'url' => '...']  (last item has url = null)
--}}
@php $breadcrumbs = $breadcrumbs ?? []; @endphp

<div x-data="{
    mobileMenuOpen: false,
    consultDropdown: false,
    inquiryModal: false,
    inquiryForm: { name: '', phone: '', email: '', destination: '', message: '' },
    inquirySubmitting: false,
    inquirySuccess: false,
    inquiryError: '',
    openInquiry() {
        this.inquiryModal = true;
        this.consultDropdown = false;
        this.mobileMenuOpen = false;
        this.inquirySuccess = false;
        this.inquiryError = '';
        this.inquiryForm = { name: '', phone: '', email: '', destination: '', message: '' };
    },
    async submitInquiry() {
        this.inquirySubmitting = true;
        this.inquiryError = '';
        try {
            const res = await fetch('/inquiry', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                body: JSON.stringify(this.inquiryForm)
            });
            const data = await res.json();
            if (data.success) { this.inquirySuccess = true; setTimeout(() => { this.inquiryModal = false; this.inquirySuccess = false; }, 2500); }
            else { this.inquiryError = data.error || 'Terjadi kesalahan.'; }
        } catch(e) { this.inquiryError = 'Koneksi gagal.'; }
        finally { this.inquirySubmitting = false; }
    }
}">

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0">
                <img src="{{ asset('images/logo/cropped-logo_happy_journey.png') }}" alt="Happy Journey" class="w-10 h-10 lg:w-12 lg:h-12 object-contain">
                <div class="hidden sm:block leading-tight">
                    <div>
                        <span class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-900 to-blue-700 bg-clip-text text-transparent">Happy</span><span class="text-xl lg:text-2xl font-bold text-amber-500">Journey</span>
                    </div>
                    <div class="text-xs text-slate-400 italic font-medium tracking-wide">It's Not Just Travel, It's a Happy Journey.</div>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-amber-600 bg-amber-50' : 'text-blue-900 hover:text-amber-600 hover:bg-blue-50' }}">
                    BERANDA
                </a>

                {{-- Paket Tour dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                    <a href="{{ route('packages.destinations') }}"
                       class="flex items-center gap-1 px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ request()->routeIs('packages.*') ? 'text-amber-600 bg-amber-50' : 'text-blue-900 hover:text-amber-600 hover:bg-blue-50' }}">
                        PAKET TOUR
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full left-0 mt-1 w-52 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">
                        @foreach([['Korea','🇰🇷'],['Jepang','🇯🇵'],['China','🇨🇳'],['Vietnam','🇻🇳'],['Eropa','🌍'],['Turki','🇹🇷']] as [$dest, $flag])
                        <a href="{{ route('packages.index', ['destination' => $dest]) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors">
                            <span>{{ $flag }}</span>
                            <span class="font-medium">Tour {{ $dest }}</span>
                        </a>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1 mx-2">
                            <a href="{{ route('packages.index') }}" class="flex items-center gap-3 px-2 py-2 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors rounded-lg hover:bg-blue-50">
                                ✈️ &nbsp;Lihat Semua Paket
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('blog.index') }}"
                   class="px-4 py-2 text-sm font-semibold {{ request()->routeIs('blog.*') ? 'text-amber-600' : 'text-blue-900 hover:text-amber-600' }} hover:bg-blue-50 rounded-lg transition-colors">
                    INSPIRASI
                </a>
                <a href="{{ route('home') }}#about"
                   class="px-4 py-2 text-sm font-semibold text-blue-900 hover:text-amber-600 hover:bg-blue-50 rounded-lg transition-colors">
                    TENTANG KAMI
                </a>
            </nav>

            {{-- Right: Search + CTA --}}
            <div class="hidden lg:flex items-center gap-3 flex-shrink-0">
                <form action="{{ route('packages.index') }}" method="GET" style="position:relative;display:inline-flex;align-items:center;">
                    <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;pointer-events:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Cari Destinasi Impian..." style="width:220px;padding:8px 16px 8px 36px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:999px;font-size:14px;color:#1e293b;outline:none;transition:border-color 0.2s,box-shadow 0.2s;" onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                </form>

                {{-- KONSULTASI GRATIS with dropdown --}}
                <div class="relative" @click.outside="consultDropdown = false">
                    <button @click="consultDropdown = !consultDropdown"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 rounded-full shadow-md transition-all whitespace-nowrap">
                        KONSULTASI GRATIS
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="consultDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="consultDropdown"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute top-full right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">

                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Hubungi Kami</p>
                        </div>

                        <button @click="openInquiry()"
                            class="w-full flex items-center gap-3 px-4 py-3 text-left text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <div class="font-semibold text-sm">Isi Formulir</div>
                                <div class="text-xs text-slate-400">Kami hubungi dalam 1x24 jam</div>
                            </div>
                        </button>

                        <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20ingin%20konsultasi%20paket%20tour" target="_blank"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-green-50 hover:text-green-800 transition-colors">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <div class="font-semibold text-sm">Chat WhatsApp</div>
                                <div class="text-xs text-slate-400">Respon cepat & langsung</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-blue-900 hover:bg-blue-50 rounded-lg transition-colors">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden bg-white border-t border-slate-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <div class="relative mb-3">
                <form action="{{ route('packages.index') }}" method="GET">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Cari Destinasi Impian..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none rounded-xl text-sm">
                </form>
            </div>
            <a href="{{ route('home') }}" @click="mobileMenuOpen=false" class="flex items-center gap-3 px-4 py-3 text-blue-900 font-semibold hover:bg-blue-50 rounded-xl transition-colors {{ request()->routeIs('home') ? 'bg-amber-50 text-amber-700' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                BERANDA
            </a>
            <a href="{{ route('packages.destinations') }}" @click="mobileMenuOpen=false" class="flex items-center gap-3 px-4 py-3 text-blue-900 font-semibold hover:bg-blue-50 rounded-xl transition-colors {{ request()->routeIs('packages.*') ? 'bg-amber-50 text-amber-700' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                PAKET TOUR
            </a>
            <a href="{{ route('blog.index') }}" @click="mobileMenuOpen=false" class="flex items-center gap-3 px-4 py-3 text-blue-900 font-semibold hover:bg-blue-50 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                INSPIRASI
            </a>
            <a href="{{ route('home') }}#about" @click="mobileMenuOpen=false" class="flex items-center gap-3 px-4 py-3 text-blue-900 font-semibold hover:bg-blue-50 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                TENTANG KAMI
            </a>

            {{-- Mobile konsultasi 2 tombol --}}
            <div class="pt-2 grid grid-cols-2 gap-2">
                <button @click="openInquiry()"
                    class="flex items-center justify-center gap-2 px-4 py-3 text-blue-900 font-bold border-2 border-blue-200 hover:bg-blue-50 rounded-xl transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Isi Formulir
                </button>
                <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20ingin%20konsultasi%20paket%20tour" target="_blank"
                    class="flex items-center justify-center gap-2 px-4 py-3 text-white font-bold bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl transition-colors text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- Breadcrumb --}}
    @if(count($breadcrumbs) > 0)
    <div class="border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1.5 py-2.5 text-xs overflow-x-auto scrollbar-hide">
                <a href="{{ route('home') }}" class="flex items-center gap-1 text-slate-400 hover:text-blue-700 transition-colors whitespace-nowrap flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                @foreach($breadcrumbs as $crumb)
                <svg class="w-3 h-3 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                @if($crumb['url'])
                <a href="{{ $crumb['url'] }}" class="text-slate-400 hover:text-blue-700 transition-colors whitespace-nowrap flex-shrink-0">{{ $crumb['label'] }}</a>
                @else
                <span class="text-blue-900 font-semibold whitespace-nowrap flex-shrink-0">{{ $crumb['label'] }}</span>
                @endif
                @endforeach
            </nav>
        </div>
    </div>
    @endif
</header>

{{-- Inquiry Modal --}}
<div x-show="inquiryModal"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="inquiryModal = false"></div>
    <div x-show="inquiryModal"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto z-10">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-white">Konsultasi Gratis</h3>
                <p class="text-blue-200 text-xs mt-0.5">Kami akan menghubungi Anda dalam 1×24 jam</p>
            </div>
            <button @click="inquiryModal = false" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Success --}}
        <div x-show="inquirySuccess" class="p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-2">Pesan Terkirim!</h3>
            <p class="text-slate-600 text-sm">Tim Happy Journey akan segera menghubungi Anda.</p>
        </div>

        {{-- Form --}}
        <div x-show="!inquirySuccess" class="p-6 space-y-4">
            <div x-show="inquiryError" class="bg-red-50 border border-red-200 rounded-xl p-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-red-700 text-sm" x-text="inquiryError"></p>
            </div>
            <form @submit.prevent="submitInquiry()" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama *</label>
                        <input type="text" x-model="inquiryForm.name" placeholder="Nama lengkap" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. Telepon *</label>
                        <input type="tel" x-model="inquiryForm.phone" placeholder="08xxxxxxxxxx" required class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                    <input type="email" x-model="inquiryForm.email" placeholder="email@example.com" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Destinasi yang Diminati</label>
                    <select x-model="inquiryForm.destination" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Destinasi --</option>
                        @foreach(['Jepang','Korea','China','Vietnam','Eropa','Turki','Dubai','Taiwan','Hong Kong','Asia Tenggara','Holyland','Australia','Lainnya'] as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pesan / Pertanyaan</label>
                    <textarea x-model="inquiryForm.message" rows="3" placeholder="Ceritakan kebutuhan perjalanan Anda..." class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 resize-none"></textarea>
                </div>

                {{-- Also quick WA option --}}
                <div class="flex gap-2 pt-1">
                    <button type="submit" :disabled="inquirySubmitting"
                        class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-blue-900 to-blue-700 hover:from-blue-800 hover:to-blue-600 disabled:opacity-60 text-white py-3 font-semibold rounded-xl shadow transition-all text-sm">
                        <svg x-show="!inquirySubmitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <svg x-show="inquirySubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <span x-text="inquirySubmitting ? 'Mengirim...' : 'Kirim Pesan'"></span>
                    </button>
                    <a href="https://wa.me/6285941167415?text=Halo%20Happy%20Journey%2C%20saya%20ingin%20konsultasi%20paket%20tour" target="_blank"
                        class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-xl font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WA
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
