<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Laporan - {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</title>
    <style>
        @page { margin: 20mm }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #222; font-size:12px }
        .header { display:flex; align-items:center; justify-content:space-between; margin-bottom: 8px }
        .brand { display:flex; align-items:center; gap:10px }
        .brand h2 { margin:0; font-size:16px }
        .meta { text-align:right; font-size:12px }
        .summary { display:flex; gap:10px; margin:12px 0 18px 0 }
        .card { flex:1; padding:10px; border-radius:8px; background:#f3f4f6 }
        .card .label { font-size:11px; color:#64748b; margin-bottom:6px }
        .card .value { font-weight:700; font-size:15px }
        table { width:100%; border-collapse:collapse; margin-bottom:12px }
        th, td { padding:8px 10px; border:1px solid #e6e9ee }
        thead th { background:#f8fafc; font-weight:700 }
        tbody tr:nth-child(odd) { background:#ffffff }
        tbody tr:nth-child(even) { background:#fbfbfd }
        .right { text-align:right }
        .small { font-size:11px; color:#475569 }
        footer { position: fixed; bottom: 10px; left: 0; right:0; text-align:center; font-size:10px; color:#94a3b8 }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            {{-- optionally add logo: <img src="/path/to/logo.png" style="height:36px"> --}}
                <div>
                <h2>Setyo Barbershop</h2>
                <div class="small">Laporan Bulanan Internal</div>
            </div>
        </div>
        <div class="meta">
            <div><strong>{{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</strong></div>
            <div class="small">Generated: {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <div class="summary">
        <div class="card">
            <div class="label">Total Pendapatan (bulan ini)</div>
            <div class="value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Total Pemesanan</div>
            <div class="value">{{ $totalBookings ?? 0 }}</div>
        </div>
        <div class="card">
            <div class="label">Periode</div>
            <div class="value">{{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</div>
        </div>
    </div>

    <section>
        <h3 style="margin:0 0 8px 0">Pendapatan Harian</h3>
        <table>
                    <thead>
                <tr>
                    <th style="width:80px">Hari</th>
                    <th class="right">Pendapatan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $daysInMonth = \Carbon\Carbon::create($year, $month)->endOfMonth()->day; @endphp
                @for($d=1;$d<=$daysInMonth;$d++)
                    <tr>
                        <td>{{ $d }}</td>
                        <td class="right">{{ number_format($dailyRevenueData[$d] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endfor
                <tr>
                    <th>Total</th>
                    <th class="right">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </section>

    <section style="page-break-inside: avoid">
        <h3 style="margin:0 0 8px 0">Rincian Status Pemesanan</h3>
        <table>
            <thead>
                <tr><th>Status</th><th class="right">Count</th></tr>
            </thead>
            <tbody>
                @foreach($statusBreakdown as $s)
                <tr>
                    <td>{{ ucfirst($s->status) }}</td>
                    <td class="right">{{ $s->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section style="page-break-inside: avoid">
        <h3 style="margin:0 0 8px 0">Kapster Teratas (Sesi)</h3>
        <table>
            <thead><tr><th>Kapster</th><th class="right">Sesi</th></tr></thead>
            <tbody>
                @foreach($kapsterPerformance as $k)
                <tr>
                    <td>{{ $k->nama }}</td>
                    <td class="right">{{ $k->bookings_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section style="page-break-inside: avoid">
        <h3 style="margin:0 0 8px 0">Layanan Terpopuler</h3>
        <table>
            <thead><tr><th>Layanan</th><th class="right">Pesanan</th></tr></thead>
            <tbody>
                @foreach($popularServices as $p)
                <tr>
                    <td>{{ $p->nama_service }}</td>
                    <td class="right">{{ $p->bookings_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <footer>
        Page <span class="pageNumber"></span> of <span class="totalPages"></span>
    </footer>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont("DejaVu Sans", "normal");
            $pdf->page_text(520, 820, "Page {PAGE_NUM} / {PAGE_COUNT}", $font, 9, array(0,0,0));
        }
    </script>

</body>
</html>
