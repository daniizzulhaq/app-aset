<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Aset</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #333; background: #fff; }

        .header { background-color: #1e3a5f; color: #fff; padding: 14px 20px; }
        .header h1 { font-size: 16px; font-weight: bold; letter-spacing: 1px; margin-bottom: 2px; }
        .header p { font-size: 9px; opacity: 0.8; }

        .info-bar { background: #eef2f7; border-bottom: 2px solid #1e3a5f; padding: 6px 20px; font-size: 8.5px; color: #555; margin-bottom: 14px; }
        .info-bar strong { color: #1e3a5f; }

        .table-wrap { margin: 0 20px 20px 20px; }

        table { width: 100%; border-collapse: collapse; font-size: 9px; }

        /* summary cards */
        .summary-table { width: calc(100% - 40px); margin: 0 20px 14px 20px; border-spacing: 6px; border-collapse: separate; }
        .summary-table td { padding: 8px 10px; border-radius: 4px; vertical-align: middle; }

        /* total nilai */
        .total-table { width: calc(100% - 40px); margin: 0 20px 14px 20px; border-left: 4px solid #1e3a5f; background: #f8fafc; border-collapse: collapse; }
        .total-table td { padding: 7px 12px; }

        thead tr { background-color: #1e3a5f; color: #fff; }
        thead th { padding: 7px 5px; text-align: left; font-weight: bold; font-size: 8px; border: 1px solid #162d4a; }
        thead th.center { text-align: center; }
        thead th.right  { text-align: right; }

        tbody tr:nth-child(even) { background: #f0f5fb; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody td { padding: 5px; border: 1px solid #d0ddf0; vertical-align: middle; }
        tbody td.center { text-align: center; }
        tbody td.right  { text-align: right; }
        tbody td.mono   { font-family: 'Courier New', monospace; font-size: 8px; }

        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 7.5px; font-weight: bold; color: #fff; }
        .badge-aktif    { background: #198754; }
        .badge-dipinjam { background: #e6a800; color: #000; }
        .badge-rusak    { background: #dc3545; }

        tfoot td { background: #1e3a5f; color: #fff; padding: 7px 5px; font-weight: bold; font-size: 9px; border: 1px solid #162d4a; }
        tfoot td.right { text-align: right; }
        tfoot td.label { text-align: right; padding-right: 8px; }

        .page-footer { position: fixed; bottom: 10px; left: 20px; right: 20px; font-size: 8px; color: #aaa; border-top: 1px solid #ddd; padding-top: 4px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN ASET</h1>
        <p>Sistem Manajemen Aset &mdash; Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="info-bar">
        @if($filterKategori)<span><strong>Kategori:</strong> {{ $filterKategori }} &nbsp;|&nbsp;</span>@endif
        @if($filterLokasi)<span><strong>Lokasi:</strong> {{ $filterLokasi }} &nbsp;|&nbsp;</span>@endif
        @if($filterStatus)<span><strong>Status:</strong> {{ ucfirst($filterStatus) }} &nbsp;|&nbsp;</span>@endif
        @if(!$filterKategori && !$filterLokasi && !$filterStatus)<span>Menampilkan <strong>semua data aset</strong></span>@endif
        <span style="float:right;color:#999;">{{ $asets->count() }} aset ditemukan</span>
    </div>

    {{-- Summary cards --}}
    <table class="summary-table">
        <tr>
            <td style="background:#1e3a5f;color:#fff;width:25%;">
                <div style="font-size:7.5px;opacity:.75;text-transform:uppercase;">Total Aset</div>
                <div style="font-size:20px;font-weight:bold;">{{ $asets->count() }}</div>
            </td>
            <td style="background:#198754;color:#fff;width:25%;">
                <div style="font-size:7.5px;opacity:.75;text-transform:uppercase;">Aktif</div>
                <div style="font-size:20px;font-weight:bold;">{{ $asets->where('status','aktif')->count() }}</div>
            </td>
            <td style="background:#e6a800;color:#000;width:25%;">
                <div style="font-size:7.5px;opacity:.6;text-transform:uppercase;">Dipinjam</div>
                <div style="font-size:20px;font-weight:bold;">{{ $asets->where('status','dipinjam')->count() }}</div>
            </td>
            <td style="background:#dc3545;color:#fff;width:25%;">
                <div style="font-size:7.5px;opacity:.75;text-transform:uppercase;">Rusak</div>
                <div style="font-size:20px;font-weight:bold;">{{ $asets->where('status','rusak')->count() }}</div>
            </td>
        </tr>
    </table>

    {{-- Total nilai --}}
    <table class="total-table">
        <tr>
            <td style="font-size:9px;color:#555;">Total Nilai Aset</td>
            <td style="text-align:right;font-size:13px;font-weight:bold;color:#1e3a5f;">
                Rp {{ number_format($total_nilai, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- Tabel data --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="center" style="width:3%;">#</th>
                    <th style="width:11%;">Kode Aset</th>
                    <th style="width:20%;">Nama Aset</th>
                    <th style="width:12%;">Kategori</th>
                    <th style="width:12%;">Lokasi</th>
                    <th class="center" style="width:10%;">Tgl Pinjam</th>
                    <th class="center" style="width:10%;">Tgl Kembali</th>
                    <th class="right"  style="width:13%;">Nilai Aset (Rp)</th>
                    <th class="center" style="width:9%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asets as $i => $aset)
                    @php $t = $aset->transaksis->first(); @endphp
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td class="mono">{{ $aset->kode_aset }}</td>
                        <td><strong>{{ $aset->nama_aset }}</strong></td>
                        <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                        <td class="center">
                            {{ $t?->tanggal_pinjam
                                ? \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y')
                                : '-' }}
                        </td>
                        <td class="center">
                            {{ $t?->tanggal_kembali
                                ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y')
                                : '-' }}
                        </td>
                        <td class="right">
                            {{ $aset->nilai_aset ? number_format($aset->nilai_aset, 0, ',', '.') : '-' }}
                        </td>
                        <td class="center">
                            @if($aset->status === 'aktif')
                                <span class="badge badge-aktif">Aktif</span>
                            @elseif($aset->status === 'dipinjam')
                                <span class="badge badge-dipinjam">Dipinjam</span>
                            @else
                                <span class="badge badge-rusak">Rusak</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:20px;color:#aaa;">
                            Tidak ada data aset ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($asets->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="7" class="label">TOTAL NILAI ASET ({{ $asets->count() }} aset):</td>
                    <td class="right">{{ number_format($total_nilai, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="page-footer">
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td>Laporan Aset &mdash; Sistem Manajemen Aset</td>
                <td style="text-align:right;">Dicetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB</td>
            </tr>
        </table>
    </div>

</body>
</html>