<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $package->name }} - Happy Journey Itinerary</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #334155;
            line-height: 1.6;
            background: #ffffff;
        }

        /* ── HEADER ── */
        .header {
            background: #0e3268;
            color: white;
            padding: 18px 28px;
            display: table;
            width: 100%;
        }
        .header-left  { display: table-cell; vertical-align: middle; width: 55%; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .logo-wrap { display: table; }
        .logo-img-cell { display: table-cell; vertical-align: middle; padding-right: 10px; }
        .logo-text-cell { display: table-cell; vertical-align: middle; }
        .logo-happy    { font-size: 20px; font-weight: 900; color: #ffffff; }
        .logo-journey  { font-size: 20px; font-weight: 900; color: #fbbf24; }
        .tagline       { font-size: 8px; color: rgba(255,255,255,0.7); font-style: italic; margin-top: 2px; }
        .contact-info  { font-size: 8.5px; color: rgba(255,255,255,0.85); line-height: 1.9; }

        /* ── HERO BANNER ── */
        .hero {
            background: #f1f5f9;
            border-left: 5px solid #f59e0b;
            padding: 14px 28px;
            margin-bottom: 0;
        }
        .badge {
            display: inline-block;
            background: #fbbf24;
            color: #0e3268;
            font-size: 8px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            margin-bottom: 5px;
        }
        .package-name { font-size: 15px; font-weight: 900; color: #0e3268; margin-bottom: 7px; }
        .meta-table   { width: 100%; border-collapse: collapse; }
        .meta-td      { font-size: 9px; color: #64748b; padding-right: 14px; white-space: nowrap; }
        .meta-td strong { color: #0e3268; }

        /* ── PRICE BOX ── */
        .price-box {
            background: #0e3268;
            color: white;
            padding: 10px 20px;
            display: table;
            width: 100%;
        }
        .price-main  { display: table-cell; vertical-align: middle; }
        .price-other { display: table-cell; vertical-align: middle; text-align: right; }
        .price-label { font-size: 8px; color: rgba(255,255,255,0.7); }
        .price-value { font-size: 18px; font-weight: 900; color: #fbbf24; }
        .price-note  { font-size: 8px; color: rgba(255,255,255,0.65); }
        .price-row   { font-size: 9px; color: rgba(255,255,255,0.85); line-height: 2; }

        /* ── SECTION ── */
        .section { margin: 16px 28px 0; }
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #0e3268;
            border-bottom: 2px solid #f59e0b;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        /* ── HIGHLIGHTS ── */
        .hl-pill {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 5px;
            padding: 3px 7px;
            font-size: 8.5px;
            color: #0e3268;
        }

        /* ── PRICING TABLE ── */
        .price-table { width: 100%; border-collapse: collapse; font-size: 9.5px; }
        .price-table th {
            background: #e2e8f0;
            color: #0e3268;
            padding: 6px 10px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #cbd5e1;
        }
        .price-table td {
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .price-table tr:nth-child(even) td { background: #f8fafc; }
        .price-note-text { font-size: 8.5px; font-style: italic; color: #64748b; margin-top: 6px; }

        /* ── ITINERARY TABLE ── */
        .itin-table { width: 100%; border-collapse: collapse; }
        .itin-table th {
            background: #0e3268;
            color: white;
            padding: 7px 10px;
            text-align: left;
            font-size: 9.5px;
        }
        .itin-table td {
            padding: 7px 10px;
            vertical-align: top;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5px;
        }
        .itin-table tr:nth-child(even) td { background: #f8fafc; }
        .day-badge {
            background: #f59e0b;
            color: white;
            font-weight: 700;
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        /* ── INCLUDE / EXCLUDE (two-col table, no flex) ── */
        .two-col      { display: table; width: 100%; }
        .col-left     { display: table-cell; width: 50%; padding-right: 10px; vertical-align: top; }
        .col-right    { display: table-cell; width: 50%; vertical-align: top; }
        .col-title    { font-size: 10px; font-weight: 700; color: #0e3268; margin-bottom: 7px; padding: 3px 8px; background: #eff6ff; border-radius: 4px; }
        .col-title-red { background: #fef2f2; color: #b91c1c; }
        .list-row     { display: table; width: 100%; margin-bottom: 4px; }
        .list-icon    { display: table-cell; width: 14px; vertical-align: top; font-weight: 700; }
        .list-text    { display: table-cell; vertical-align: top; font-size: 9.5px; color: #334155; }
        .check        { color: #10b981; }
        .cross        { color: #ef4444; }

        /* ── NOTES BOX ── */
        .notes-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 5px;
            padding: 9px 12px;
            font-size: 8.5px;
            color: #92400e;
            line-height: 1.9;
        }

        /* ── BOOKING CTA ── */
        .cta-box {
            background: #0e3268;
            color: white;
            border-radius: 6px;
            padding: 12px 20px;
            text-align: center;
        }
        .cta-title   { font-size: 12px; font-weight: 900; margin-bottom: 3px; }
        .cta-sub     { font-size: 9px; color: rgba(255,255,255,0.75); margin-bottom: 6px; }
        .cta-contact { font-size: 10px; font-weight: 700; color: #fbbf24; }
        .cta-web     { font-size: 8.5px; color: rgba(255,255,255,0.6); margin-top: 3px; }

        /* ── FOOTER ── */
        .footer {
            background: #0f172a;
            color: rgba(255,255,255,0.65);
            padding: 10px 28px;
            margin-top: 18px;
            display: table;
            width: 100%;
            font-size: 8.5px;
        }
        .footer-left  { display: table-cell; vertical-align: middle; }
        .footer-right { display: table-cell; vertical-align: middle; text-align: right; }
        .footer-hl    { color: #fbbf24; font-weight: 700; }

        .page-break { page-break-after: always; }
        .mt { margin-top: 14px; }
    </style>
</head>
<body>

@php
    $logoPath = public_path('images/logo/cropped-logo_happy_journey.png');
    $logoSrc  = file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : '';
@endphp

{{-- HEADER --}}
<div class="header">
    <div class="header-left">
        <div class="logo-wrap">
            <div class="logo-img-cell">
                @if($logoSrc)<img src="{{ $logoSrc }}" alt="Logo" style="width:44px; height:44px;">@endif
            </div>
            <div class="logo-text-cell">
                <div><span class="logo-happy">Happy</span><span class="logo-journey">Journey</span></div>
                <div class="tagline">PT. Rihlah Global Wisata &bull; It's Not Just Travel, It's a Happy Journey</div>
            </div>
        </div>
    </div>
    <div class="header-right">
        <div class="contact-info">
            Menara Cakrawala Lt. 15, Jl. M.H. Thamrin No.9, Jakarta Pusat<br>
            Tel: 0859-4116-7415 &bull; info@happyjourney.co.id<br>
            Senin – Minggu: 09:00 – 17:00 WIB
        </div>
    </div>
</div>

{{-- HERO --}}
<div class="hero">
    <div class="badge">PAKET TOUR HAPPY JOURNEY</div>
    <div class="package-name">{{ $package->name }}</div>
    <table class="meta-table">
        <tr>
            <td class="meta-td"><strong>Destinasi:</strong> {{ $package->destination }}</td>
            <td class="meta-td"><strong>Durasi:</strong> {{ $package->duration }}</td>
            @if($package->airline)
            <td class="meta-td"><strong>Maskapai:</strong> {{ $package->airline }}</td>
            @endif
            <td class="meta-td"><strong>Min. Peserta:</strong> {{ $package->min_participants }} orang</td>
            @if($package->deposit)
            <td class="meta-td"><strong>Deposit:</strong> Rp {{ number_format($package->deposit, 0, ',', '.') }}</td>
            @endif
        </tr>
    </table>
</div>

{{-- PRICE BOX --}}
<div class="price-box">
    <div class="price-main">
        <div class="price-label">Harga Mulai Dari</div>
        <div class="price-value">Rp {{ number_format($package->price_adult, 0, ',', '.') }}</div>
        <div class="price-note">per orang / dewasa</div>
    </div>
    <div class="price-other">
        <div class="price-row">
            @if($package->price_child)Anak (no bed): <strong style="color:#fbbf24;">Rp {{ number_format($package->price_child, 0, ',', '.') }}</strong><br>@endif
            @if($package->price_single_supplement)Single Supplement: <strong style="color:#fbbf24;">+Rp {{ number_format($package->price_single_supplement, 0, ',', '.') }}</strong><br>@endif
            @if($package->price_infant)Infant (no seat): <strong style="color:#fbbf24;">Rp {{ number_format($package->price_infant, 0, ',', '.') }}</strong><br>@endif
        </div>
    </div>
</div>

{{-- HIGHLIGHTS --}}
@if($package->highlights && count($package->highlights) > 0)
<div class="section">
    <div class="section-title">Highlight Perjalanan</div>
    <table style="width:100%; border-collapse:collapse;">
        @foreach(array_chunk($package->highlights, 4) as $row)
        <tr>
            @foreach($row as $hl)
            <td style="width:25%; padding:3px 5px 3px 0; vertical-align:top;">
                <div class="hl-pill">&#9733; {{ $hl }}</div>
            </td>
            @endforeach
            @for($i = count($row); $i < 4; $i++)
            <td style="width:25%;"></td>
            @endfor
        </tr>
        @endforeach
    </table>
</div>
@endif

{{-- PRICING TABLE --}}
@if($package->departure_dates && count($package->departure_dates) > 0)
@php
    $grouped = [];
    foreach ($package->departure_dates as $d) {
        $key = \Carbon\Carbon::parse($d)->format('Y-m');
        $grouped[$key][] = \Carbon\Carbon::parse($d)->format('d');
    }
@endphp
<div class="section">
    <div class="section-title">Pricing Detail & Tanggal Keberangkatan</div>
    <p style="font-size:9px; color:#475569; margin-bottom:6px;">
        Keberangkatan Minimal {{ $package->min_participants }} Pax (Didampingi 1 Tour Leader)
        @if($package->deposit) &nbsp;&bull;&nbsp; Deposit Rp {{ number_format($package->deposit, 0, ',', '.') }} (First Come First Serve)@endif
    </p>
    @if($package->airline && str_contains(strtolower($package->airline), 'charter'))
    <p style="font-size:9px; font-weight:700; color:#dc2626; margin-bottom:6px;">**PRODUCT INI MENGGUNAKAN CHARTER FLIGHT, TIDAK BISA EXTEND**</p>
    @endif
    <table class="price-table">
        <thead>
            <tr>
                <th style="width:35%;">Keberangkatan</th>
                <th>ADULT</th>
                @if($package->price_child)<th>Child No Bed</th>@endif
                @if($package->price_single_supplement)<th>Single Supp<br><span style="font-weight:400;">(Jika sekamar sendiri)</span></th>@endif
            </tr>
        </thead>
        <tbody>
            @foreach($grouped as $yearMonth => $days)
            <tr>
                <td>{{ strtoupper(\Carbon\Carbon::parse($yearMonth.'-01')->translatedFormat('M')) }} : {{ implode(' , ', $days) }}</td>
                <td>Rp {{ number_format($package->price_adult, 0, ',', '.') }}</td>
                @if($package->price_child)<td>Rp {{ number_format($package->price_child, 0, ',', '.') }}</td>@endif
                @if($package->price_single_supplement)<td>Rp {{ number_format($package->price_single_supplement, 0, ',', '.') }}</td>@endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($package->price_infant)
    <p class="price-note-text">*HARGA UNTUK INFANT DIBAWAH 23 BULAN (FLAT RATE) : Rp {{ number_format($package->price_infant, 0, ',', '.') }} (Tipping Mandatory Free Of Charge) HARGA DAPAT BERUBAH SEWAKTU-WAKTU</p>
    @endif
    <p class="price-note-text">*Acara Perjalanan, Harga Tour/Visa/Apt Tax &amp; YQ serta flight detail dapat berubah sewaktu-waktu tanpa pemberitahuan lebih lanjut.</p>
</div>
@endif

{{-- ITINERARY --}}
@if($package->itinerary && count($package->itinerary) > 0)
<div class="section page-break">
    <div class="section-title">Program Perjalanan (Itinerary)</div>
    <table class="itin-table">
        <thead>
            <tr>
                <th style="width:9%;">Hari</th>
                <th style="width:26%;">Rute</th>
                <th>Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($package->itinerary as $day)
            <tr>
                <td><span class="day-badge">Hari {{ $day['day'] }}</span></td>
                <td><strong>{{ $day['title'] }}</strong></td>
                <td>{{ $day['description'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- INCLUSIONS & EXCLUSIONS --}}
@if(($package->inclusions && count($package->inclusions) > 0) || ($package->exclusions && count($package->exclusions) > 0))
<div class="section mt">
    <div class="section-title">Termasuk &amp; Tidak Termasuk dalam Paket</div>
    <div class="two-col">
        <div class="col-left">
            <div class="col-title">&#10003; Biaya Include</div>
            @foreach($package->inclusions ?? [] as $item)
            <div class="list-row">
                <div class="list-icon check">&#10003;</div>
                <div class="list-text">{{ $item }}</div>
            </div>
            @endforeach
        </div>
        <div class="col-right">
            <div class="col-title col-title-red">&#10007; Biaya Exclude</div>
            @foreach($package->exclusions ?? [] as $item)
            <div class="list-row">
                <div class="list-icon cross">&#10007;</div>
                <div class="list-text">{{ $item }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- IMPORTANT NOTES --}}
<div class="section mt">
    <div class="section-title">Catatan Penting</div>
    <div class="notes-box">
        &bull; Harga dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya<br>
        &bull; Dokumen perjalanan (paspor) minimal berlaku 6 bulan dari tanggal kembali<br>
        &bull; Dokumen visa wajib diserahkan minimal 1 bulan sebelum keberangkatan<br>
        &bull; Tour berjalan minimal {{ $package->min_participants }} peserta. Jika tidak tercapai, akan diberitahukan H-14<br>
        &bull; Pembatalan setelah DP: DP hangus &nbsp;|&nbsp; Setelah full payment: seluruh pembayaran hangus<br>
        &bull; Untuk informasi lebih lanjut, hubungi tim Happy Journey
    </div>
</div>

{{-- CTA --}}
<div class="section mt">
    <div class="cta-box">
        <div class="cta-title">Tertarik dengan paket ini?</div>
        <div class="cta-sub">Hubungi kami sekarang untuk informasi lebih lanjut dan pemesanan</div>
        <div class="cta-contact">WhatsApp: 0859-4116-7415 &bull; Email: info@happyjourney.co.id</div>
        <div class="cta-web">Website: happyjourney.co.id</div>
    </div>
</div>

{{-- FOOTER --}}
<div class="footer">
    <div class="footer-left">
        <span class="footer-hl">Happy Journey</span> Tour &amp; Travel &bull; PT. Rihlah Global Wisata
        &bull; Dicetak: {{ now()->translatedFormat('d F Y') }}
    </div>
    <div class="footer-right">
        &copy; {{ date('Y') }} Happy Journey &bull;
        <span class="footer-hl">It's Not Just Travel, It's a Happy Journey</span>
    </div>
</div>

</body>
</html>
