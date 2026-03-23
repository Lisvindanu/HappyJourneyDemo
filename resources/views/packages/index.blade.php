@extends('layouts.app')

@section('title', 'Paket Tour - Happy Journey')
@section('og_image', asset('images/og-image.webp'))
@section('meta_description', 'Temukan paket tour terbaik Happy Journey ke Asia, Eropa, dan destinasi impian Anda. Harga terjangkau, kualitas premium.')

@section('content')
<div x-data="{
    activeFilter: '{{ $category }}',
    bookingModal: false,
    selectedPackage: { name: '', price: '', destination: '', slug: '', dates: [] },
    bookingForm: { customer_name: '', phone: '', email: '', passengers: '2', travel_date: '', notes: '' },
    bookingSubmitting: false,
    bookingSuccess: false,
    bookingError: '',
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ package_slug: this.selectedPackage.slug, package_name: this.selectedPackage.name, destination: this.selectedPackage.destination, customer_name: this.bookingForm.customer_name, email: this.bookingForm.email, phone: this.bookingForm.phone, passengers: parseInt(this.bookingForm.passengers), travel_date: this.bookingForm.travel_date, notes: this.bookingForm.notes })
            });
            const data = await res.json();
            if (data.success) { this.bookingSuccess = true; setTimeout(() => { this.bookingModal = false; this.bookingSuccess = false; }, 2500); }
            else { this.bookingError = data.error || 'Terjadi kesalahan.'; }
        } catch(e) { this.bookingError = 'Koneksi gagal.'; }
        finally { this.bookingSubmitting = false; }
    }
}">

@include('partials.navbar', [
    'breadcrumbs' => array_filter([
        ['label' => 'Paket Tour', 'url' => route('packages.destinations')],
        $destination ? ['label' => $destination, 'url' => null] : null,
        !$destination && $category !== 'all' ? ['label' => ucfirst($category), 'url' => null] : null,
    ])
])

{{-- Hero Banner --}}
<div class="relative bg-gradient-to-r from-blue-900 to-blue-700 py-16 text-white text-center overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="{{ asset('images/hero-packages.jpg') }}" class="w-full h-full object-cover" alt="">
    </div>
    <div class="relative max-w-3xl mx-auto px-4">
        <span class="inline-block px-4 py-1 bg-white/20 text-amber-300 rounded-full text-sm font-semibold mb-4">PAKET TOUR HAPPY JOURNEY</span>
        @if($destination)
        <h1 class="text-3xl sm:text-4xl font-bold mb-4">Paket Tour {{ $destination }}</h1>
        <p class="text-white/80">Pilihan paket tour terbaik ke {{ $destination }} dengan pemandu berbahasa Indonesia</p>
        @else
        <h1 class="text-3xl sm:text-4xl font-bold mb-4">Temukan Paket Wisata Impian Anda</h1>
        <p class="text-white/80">Berbagai pilihan paket tour berkualitas ke destinasi terbaik di Asia dan Eropa</p>
        @endif
    </div>
</div>

{{-- Filter & Sort Bar --}}
@php
    $sortBase = $destination
        ? ['destination' => $destination]
        : ($category !== 'all' ? ['category' => $category] : []);
@endphp
<div class="bg-white border-b border-slate-100 sticky top-16 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Desktop: single row (category pills + sort pills) --}}
        {{-- Mobile: two rows stacked --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">

            {{-- Row 1: Category pills --}}
            <div class="flex items-center gap-2 py-3 overflow-x-auto scrollbar-hide border-b border-slate-100 lg:border-0 lg:flex-1 lg:min-w-0">
                @foreach([['all','Semua Paket'],['asia','Asia'],['eropa','Eropa'],['holyland','Holyland'],['domestik','Domestik']] as [$tab, $label])
                @php
                    $tabParams = $tab !== 'all'
                        ? ['category' => $tab, 'sort' => $sort]
                        : ['sort' => $sort];
                @endphp
                <a href="{{ route('packages.index', $tabParams) }}"
                   class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ $category === $tab || ($tab === 'all' && $category === 'all') ? 'bg-blue-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            {{-- Row 2 (mobile) / Right side (desktop): Sort pills --}}
            <div class="flex items-center gap-2 py-2 lg:py-3 overflow-x-auto scrollbar-hide lg:flex-shrink-0 lg:pl-6 lg:border-l lg:border-slate-100 lg:ml-4">
                <span class="flex-shrink-0 text-xs font-medium text-slate-400 uppercase tracking-wide">Urutkan</span>
                <div class="flex items-center gap-1.5">
                    @foreach([
                        ['price_asc',  'Termurah',  '↑'],
                        ['price_desc', 'Termahal',  '↓'],
                        ['newest',     'Terbaru',   '✦'],
                    ] as [$val, $lbl, $icon])
                    <a href="{{ route('packages.index', array_merge($sortBase, ['sort' => $val])) }}"
                       class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 border
                              {{ $sort === $val
                                  ? 'bg-blue-900 text-white border-blue-900 shadow-sm'
                                  : 'bg-white text-slate-600 border-slate-200 hover:border-blue-300 hover:text-blue-900 hover:bg-blue-50' }}">
                        <span class="text-[10px] leading-none">{{ $icon }}</span>
                        {{ $lbl }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Packages Grid --}}
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($packages->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🗺️</div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Belum ada paket untuk kategori ini</h2>
            <p class="text-slate-500 mb-6">Silakan pilih kategori lain atau lihat semua paket kami</p>
            <a href="{{ route('packages.index') }}" class="inline-flex items-center gap-2 bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition-colors">Lihat Semua Paket</a>
        </div>
        @else
        <p class="text-sm text-slate-500 mb-6">Menampilkan <strong>{{ $packages->count() }}</strong> paket tour</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($packages as $index => $pkg)
            <div data-aos="fade-up" data-aos-delay="{{ min($index * 60, 300) }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100/50 flex flex-col">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $pkg->display_image }}" alt="{{ $pkg->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    @if($pkg->discount_percent)
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-{{ $pkg->discount_percent }}%</span>
                    @endif

                    <div class="absolute top-4 right-4 flex items-center gap-1 bg-white/90 text-blue-900 text-xs font-semibold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $pkg->destination }}
                    </div>

                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg">
                            <div class="text-xs text-slate-500">Mulai dari</div>
                            <div class="text-lg font-bold text-blue-900">Rp {{ number_format($pkg->price_adult, 0, ',', '.') }}</div>
                            @if($pkg->original_price)
                            <div class="text-xs text-slate-400 line-through">Rp {{ number_format($pkg->original_price, 0, ',', '.') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-base font-bold text-blue-900 mb-3 group-hover:text-amber-600 transition-colors line-clamp-2 flex-1">{{ $pkg->name }}</h3>

                    <div class="flex items-center gap-2 text-slate-600 mb-3">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm">{{ $pkg->duration }}</span>
                        @if($pkg->airline)
                        <span class="text-slate-400">•</span>
                        <span class="text-xs text-slate-500 truncate">{{ $pkg->airline }}</span>
                        @endif
                    </div>

                    @if($pkg->highlights && count($pkg->highlights) > 0)
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach(array_slice($pkg->highlights, 0, 3) as $highlight)
                        <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-full">{{ $highlight }}</span>
                        @endforeach
                        @if(count($pkg->highlights) > 3)
                        <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full">+{{ count($pkg->highlights) - 3 }} lagi</span>
                        @endif
                    </div>
                    @endif

                    @if($pkg->departure_dates && count($pkg->departure_dates) > 0)
                    <p class="text-xs text-slate-500 mb-4">
                        <span class="font-medium text-slate-700">Keberangkatan terdekat:</span>
                        {{ \Carbon\Carbon::parse($pkg->departure_dates[0])->translatedFormat('d M Y') }}
                    </p>
                    @endif

                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('packages.show', $pkg->slug) }}" class="flex-1 flex items-center justify-center gap-1.5 border-2 border-blue-200 text-blue-900 hover:bg-blue-50 hover:border-blue-300 text-xs font-semibold py-2.5 px-3 rounded-xl transition-colors">
                            Detail
                        </a>
                        <a href="{{ route('packages.pdf', $pkg->slug) }}" class="flex items-center justify-center gap-1 border-2 border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold py-2.5 px-3 rounded-xl transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            PDF
                        </a>
                        @php
                            $pkgDates = collect($pkg->departure_dates ?? [])
                                ->map(fn($d) => [
                                    'value' => $d,
                                    'label' => \Carbon\Carbon::parse($d)->translatedFormat('D, d M Y'),
                                ])->values()->toArray();
                        @endphp
                        <button
                            @click="openBooking({ name: '{{ addslashes($pkg->name) }}', price: 'Rp {{ number_format($pkg->price_adult, 0, ',', '.') }}', destination: '{{ $pkg->destination }}', slug: '{{ $pkg->slug }}', dates: {{ Js::from($pkgDates) }} })"
                            class="flex-1 flex items-center justify-center gap-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-semibold py-2.5 px-3 rounded-xl transition-all shadow-sm"
                        >
                            BOOKING
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
            <div><h3 class="text-xl font-bold text-white">Booking Tour</h3><p class="text-blue-200 text-sm" x-text="selectedPackage.name"></p></div>
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
                        {{-- Dropdown tanggal jika tersedia --}}
                        <template x-if="selectedPackage.dates && selectedPackage.dates.length > 0">
                            <select x-model="bookingForm.travel_date" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                                <option value="">-- Pilih Tanggal --</option>
                                <template x-for="d in selectedPackage.dates" :key="d.value">
                                    <option :value="d.value" x-text="d.label"></option>
                                </template>
                            </select>
                        </template>
                        {{-- Fallback input bebas jika tidak ada jadwal --}}
                        <template x-if="!selectedPackage.dates || selectedPackage.dates.length === 0">
                            <div>
                                <input type="date" x-model="bookingForm.travel_date" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500">
                                <p class="text-xs text-slate-400 mt-1">Jadwal belum tersedia, masukkan tanggal yang diinginkan.</p>
                            </div>
                        </template>
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
