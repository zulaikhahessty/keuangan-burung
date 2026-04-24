<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kelola Event • SEMARFIN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    /* ====== Theme: senada dengan halaman SEMARFIN ====== */
    body { font-family: 'Inter', sans-serif; }
    .sidebar-gradient { background-image: linear-gradient(135deg, #0b163d, #2d0e4f); }
    .glass { background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226,232,240,.7); }
    .card { transition: transform .2s ease, box-shadow .2s ease; border-radius: 1rem; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15,23,42,.08); }
    .pill { border-radius: 9999px; padding:.3rem .75rem; font-size:.75rem; font-weight:600; }
    .form-input { border:1px solid #e2e8f0; background-color:#f8fafc; border-radius:.5rem; padding:.6rem 1rem; width:100%; transition:all .3s ease; }
    .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.2); outline:none; background:white; }
    .table-row-hover:hover { background-color:#f8fafc; }

    /* ====== Modal (dipertahankan, dirapikan) ====== */
    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.6); display:flex; justify-content:center; align-items:center; z-index:9999; opacity:0; visibility:hidden; transition:opacity .3s ease, visibility .3s ease; }
    .modal-overlay.open { opacity:1; visibility:visible; }
    .modal-content { background:#fff; border-radius:1rem; max-width:900px; width:95%; box-shadow:0 15px 30px rgba(0,0,0,.25); transform:translateY(-20px); opacity:0; transition:transform .3s cubic-bezier(.175,.885,.32,1.275), opacity .3s ease; max-height:90vh; overflow-y:auto; position:relative; }
    .modal-overlay.open .modal-content { transform:translateY(0); opacity:1; }
    .modal-header { padding:1.25rem 2rem; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; }
    .modal-body { padding:2rem; }
    .modal-footer { padding:1.25rem 2rem; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:1rem; }

    /* Number input custom */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }
    input[type="number"] { -moz-appearance:textfield; }
    .number-input-wrapper { position:relative; }
    .number-input-wrapper input { padding-right:2.5rem; }
    .number-input-buttons { position:absolute; right:0; top:0; height:100%; display:flex; flex-direction:column; justify-content:center; align-items:center; border-left:1px solid #cbd5e1; }
    .number-input-buttons button { width:2.5rem; height:50%; background:transparent; border:none; cursor:pointer; color:#64748b; transition:background-color .2s ease; font-size:.875rem; line-height:1; }
    .number-input-buttons button:hover { background:#f1f5f9; }
    .number-input-buttons button:first-child { border-bottom:1px solid #cbd5e1; }

    /* Toast & pulse */
    .row-pulse { animation: pulseRow 1.2s ease-out 1; }
    @keyframes pulseRow { 0% { background-color:#ecfeff; } 100% { background-color:transparent; } }

    /* Modal detail: read-only */
    .modal-overlay.locked { cursor:default; }
    .modal-overlay.locked .modal-content { pointer-events:auto; }
    .modal-body-readonly p, .modal-body-readonly li, .modal-body-readonly span { user-select:text; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-slate-100 text-slate-800">

<div class="flex min-h-screen">
  <!-- Overlay untuk offcanvas (jika perlu diaktifkan mobile) -->
  <div id="overlay" class="fixed inset-0 bg-slate-900/40 z-30 hidden md:hidden"></div>

  <!-- Sidebar: diseragamkan dengan halaman SEMARFIN -->
<!-- Sidebar: versi final seragam dengan SEMARFIN -->
<aside id="sidebar"
       class="fixed md:static z-40 inset-y-0 left-0 w-72 translate-x-[-100%] md:translate-x-0 
              transition-transform duration-200 sidebar-gradient text-white flex flex-col shadow-xl md:shadow-none">

  <!-- Header Logo -->
  <div class="p-6 border-b border-white/10 text-center">
    <img src="{{ asset('images/Logo Semar Arena.jpeg') }}"
         alt="Logo SEMARFIN"
         class="h-20 mx-auto rounded-full border-2 border-white/30 p-1 shadow-md">
    <div class="mt-3">
      <h1 class="text-2xl font-bold tracking-wide">SEMARFIN</h1>
      <p class="text-xs text-white/70">Semar Arena Finance</p>
    </div>
  </div>

  <!-- Menu Navigasi -->
  <nav class="flex-1 p-5 space-y-2">
    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
              {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }}">
      <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-7 9 7M4.5 10.5V21h15V10.5" />
      </svg>
      <span class="truncate">Dashboard</span>
    </a>

    {{-- SEMARFIN Event --}}
    <a href="{{ route('events.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
              {{ request()->routeIs('events.index') ? 'bg-white/20' : 'hover:bg-white/10' }}">
      <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8M8 15h8M4 5h16v14H4z" />
      </svg>
      <span class="truncate">SEMARFIN Event</span>
    </a>

    {{-- Kelola Event --}}
    <a href="{{ route('events.manage_index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
              {{ request()->routeIs('events.manage_index') || request()->routeIs('events.manage') ? 'bg-white/20' : 'hover:bg-white/10' }}">
      <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h8" />
      </svg>
      <span class="truncate">Kelola Event</span>
    </a>

    {{-- SEMARFIN Laporan --}}
    <a href="{{ route('reports.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
              {{ request()->routeIs('reports.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
      <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M8 8h10M8 12h10M8 16h10M3 20h18" />
      </svg>
      <span class="truncate">SEMARFIN Laporan</span>
    </a>
  </nav>

  <!-- Bagian bawah -->
  <div class="p-6 border-t border-white/10 mt-auto">
    <div class="text-xs text-white/70 mb-2">Masuk sebagai</div>
    <div class="flex items-center justify-between">
      <div class="truncate font-medium">{{ auth()->user()->name ?? 'User' }}</div>
      <form method="POST" action="{{ route('logout') }}"
            onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
        @csrf
        <button type="submit"
                class="text-sm px-3 py-1 rounded-md bg-white/15 hover:bg-white/25 transition">
          Logout
        </button>
      </form>
    </div>
  </div>
</aside>


  <!-- Konten -->
  <div class="flex-1 flex flex-col">
    <!-- Header glass senada -->
    <header class="glass sticky top-0 z-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <button id="btnMenu" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
            <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">Kelola Event</h1>
            <div class="hidden sm:flex items-center gap-2">
              <span class="pill bg-slate-100 text-slate-700">
                {{ \Illuminate\Support\Carbon::parse($event->tanggal)->format('d/m/Y') }}
              </span>
              @if($event->venue)
                <span class="pill bg-indigo-100 text-indigo-700">{{ $event->venue }}</span>
              @endif
            </div>
          </div>
          <a href="{{ route('events.index') }}" class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200 transition text-sm font-semibold">
            ← Kembali
          </a>
        </div>
      </div>
    </header>

    <main class="flex-1 overflow-y-auto pb-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 space-y-8">

        {{-- Notifikasi --}}
        @if (session('ok'))
          <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-medium shadow-sm">
            {{ session('ok') }}
          </div>
        @endif
        @if ($errors->any())
          <div class="p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 shadow-sm">
            <ul class="list-disc list-inside">
              @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
        @endif

        @php
  // ====== Perhitungan Ringkasan Global (Saldo Awal = 0) ======

  // Pemasukan hanya dari penjualan tiket
  $sumKelasTiket  = $event->kelasLombas->sum('total_tiket');

  // Pengeluaran terdiri dari: hadiah, operasional, dan piala
  $sumKelasHadiah = $event->kelasLombas->sum('total_hadiah');
  $sumOps         = $event->pengeluarans->sum('jumlah');
  $sumPiala       = $event->kelasLombas->sum('jumlah_piala'); // jika tiap piala dianggap bernilai uang

  // Saldo awal tetap 0 (aturan baru)
  $saldoAwal = 0;

  // Hitung total pengeluaran dan saldo akhir
  $totalPengeluaran = ($sumKelasHadiah ?? 0) + ($sumOps ?? 0) + ($sumPiala ?? 0);
  $saldoHitung = $saldoAwal + ($sumKelasTiket ?? 0) - $totalPengeluaran;
@endphp

<!-- Ringkasan Global -->
<div class="rounded-2xl bg-white shadow-lg border border-slate-200 card p-6">
  <h3 class="text-xl font-bold text-slate-900 mb-4">LAPORAN OPERASIONAL GANTANGAN SEMAR</h3>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

    <!-- Saldo Awal -->
    <div class="flex flex-col items-start p-4 bg-slate-50 rounded-lg">
      <div class="text-sm text-slate-500 font-medium">Saldo Awal</div>
      <div id="global-saldo-awal" class="text-2xl font-bold text-slate-800 mt-1">
        Rp {{ number_format($saldoAwal, 0, ',', '.') }}
      </div>
    </div>

    <!-- Total Pemasukan -->
    <div class="flex flex-col items-start p-4 bg-indigo-50 rounded-lg">
      <div class="text-sm text-indigo-700 font-medium">Total Pemasukan</div>
      <div id="global-total-tiket" class="text-2xl font-bold text-indigo-900 mt-1">
        Rp {{ number_format($sumKelasTiket ?? 0, 0, ',', '.') }}
      </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="flex flex-col items-start p-4 bg-rose-50 rounded-lg">
      <div class="text-sm text-rose-700 font-medium">Total Pengeluaran</div>
      <div id="global-total-pengeluaran" class="text-2xl font-bold text-rose-900 mt-1">
        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
      </div>
    </div>

    <!-- Saldo Akhir -->
    <div id="global-saldo-akhir-card"
         class="flex flex-col items-start p-4 rounded-lg {{ $saldoHitung >= 0 ? 'bg-emerald-50' : 'bg-rose-50' }}">
      <div id="global-saldo-akhir-label"
           class="text-sm font-medium {{ $saldoHitung >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
        Saldo Akhir
      </div>
      <div id="global-saldo-akhir"
           class="text-2xl font-bold {{ $saldoHitung >= 0 ? 'text-emerald-900' : 'text-rose-900' }} mt-1">
        Rp {{ number_format($saldoHitung, 0, ',', '.') }}
      </div>
    </div>

  </div>
</div>


        <!-- Form tambah kelas -->
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card p-8">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Tambah Kelas Lomba</h2>
          </div>
          <form action="{{ route('kelas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 p-6 bg-slate-50 rounded-lg border border-slate-200">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="lg:col-span-2">
              <label class="text-sm font-medium mb-1 block text-slate-700">Nama Kelas</label>
              <input name="nama_kelas" class="form-input" placeholder="Masukkan Nama Kelas Perlombaan" required>
            </div>
            <div>
              <label class="text-sm font-medium mb-1 block text-slate-700">Harga Tiket</label>
              <input type="number" name="harga_tiket" min="0" class="form-input" required>
            </div>
            <div>
              <label class="text-sm font-medium mb-1 block text-slate-700">Jumlah Peserta</label>
              <input type="number" name="jumlah_peserta" min="0" class="form-input" required>
            </div>
            @for ($i=1;$i<=10;$i++)
              <div>
                <label class="text-sm font-medium mb-1 block text-slate-700">Hadiah Juara {{ $i }}</label>
                <input type="number" name="hadiah_{{ $i }}" min="0" class="form-input">
              </div>
            @endfor
            <div>
              <label class="text-sm font-medium mb-1 block text-slate-700">Total Pengeluaran Piala</label>
              <input type="number" name="jumlah_piala" min="0" class="form-input">
            </div>
            <div class="lg:col-span-3 col-span-2 flex justify-end">
              <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition font-semibold">
                + Tambah Kelas
              </button>
            </div>
          </form>
        </div>

        {{-- Daftar Kelas Global (tanpa sesi) --}}
        @php
          $kelasAll   = $event->kelasLombas->sortBy('created_at'); // paling awal diinput = paling atas
          $sumPeserta = $kelasAll->sum('jumlah_peserta');
          $sumTiket   = $kelasAll->sum('total_tiket');
          $sumHadiah  = $kelasAll->sum('total_hadiah');
          $sumPiala   = $kelasAll->sum('jumlah_piala');
          $sumLaba    = $kelasAll->sum('laba_bersih');
        @endphp

        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card p-8">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Daftar Kelas Lomba</h2>
          </div>
          @if($kelasAll->isEmpty())
            <div class="rounded-2xl bg-white border border-slate-200 card p-8 text-center text-slate-500">
              Belum ada kelas lomba yang ditambahkan.
            </div>
          @else
            <div class="overflow-x-auto rounded-lg border border-slate-200 shadow-sm">
              <table class="w-full text-sm table-auto">
                <thead class="bg-slate-50 text-slate-600 sticky top-0">
                  <tr class="font-semibold text-left">
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3 text-right">Peserta</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-right">Total Tiket</th>
                    <th class="px-4 py-3 text-right">Total Hadiah</th>
                    <th class="px-6 py-4 text-right">Total Piala</th>
                    <th class="px-4 py-3 text-right">Laba</th>
                    <th class="px-4 py-3 text-center w-28">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                  @foreach($kelasAll as $row)
                  <tr class="table-row-hover transition cursor-pointer" data-row-id="kelas-{{ $row->id }}">
                    <td class="px-4 py-3 whitespace-nowrap">{{ $row->nama_kelas }}</td>
                    <td class="px-4 py-3 text-right">{{ $row->jumlah_peserta }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($row->harga_tiket,0,',','.') }}</td>
                    <td class="px-4 py-3 text-right font-medium text-indigo-700">Rp {{ number_format($row->total_tiket,0,',','.') }}</td>
                    <td class="px-4 py-3 text-right font-medium text-rose-600">Rp {{ number_format($row->total_hadiah,0,',','.') }}</td>

            {{-- Total Piala --}}
            <td class="px-4 py-3 text-right">
              <span class="pill bg-amber-50 text-amber-700 border border-amber-200">
                {{ number_format($row->jumlah_piala ?? 0, 0, ',', '.') }}
              </span>
            </td>

                    <td class="px-4 py-3 text-right font-bold {{ ($row->laba_bersih ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                      Rp {{ number_format($row->laba_bersih,0,',','.') }}
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                      <div class="flex items-center justify-center gap-2">
                        <button type="button"
                                class="text-indigo-700 hover:text-indigo-900 transition"
                                data-update-url="{{ route('kelas.update', $row->id) }}"
                                data-json='@json($row)'
                                onclick="openEditKelasModal(this)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>
                        </button>
                        <form action="{{ route('kelas.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                          @csrf @method('DELETE')
                          <button type="submit" class="text-rose-600 hover:text-rose-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" /></svg>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr class="bg-slate-100 font-bold border-t border-slate-200">
                    <td class="px-4 py-3 text-right">TOTAL</td>
                    <td class="px-4 py-3 text-right">{{ $sumPeserta }}</td>
                    <td class="px-4 py-3"></td>
                    <td class="px-4 py-3 text-right text-indigo-700">Rp {{ number_format($sumTiket,0,',','.') }}</td>
                    <td class="px-4 py-3 text-right text-rose-600">Rp {{ number_format($sumHadiah,0,',','.') }}</td>
                    <td class="px-4 py-3 text-right text-amber-700">Rp {{ number_format($sumPiala, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right {{ $sumLaba >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format($sumLaba,0,',','.') }}</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          @endif
        </div>

        <!-- Pengeluaran Operasional -->
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card p-8">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Pengeluaran Operasional</h2>
            <span class="text-sm text-slate-500">Biaya di luar hadiah</span>
          </div>

          <form action="{{ route('pengeluaran.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8 p-6 bg-slate-50 rounded-lg border border-slate-200">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div>
              <label class="text-sm font-medium mb-1 block text-slate-700">Uraian</label>
              <input name="uraian" class="form-input" placeholder="Juri / Admin / Konsumsi..." required>
            </div>
            <div>
              <label class="text-sm font-medium mb-1 block text-slate-700">Jumlah (Rp)</label>
              <input type="number" name="jumlah" min="0" class="form-input" required>
            </div>
            <div class="md:col-span-2 flex justify-end">
              <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg shadow-md hover:bg-emerald-700 transition font-semibold">
                + Tambah Pengeluaran
              </button>
            </div>
          </form>

          @if($event->pengeluarans->isEmpty())
            <p class="text-slate-500 text-center py-6">Belum ada pengeluaran operasional.</p>
          @else
            <div class="overflow-x-auto rounded-lg border border-slate-200 shadow-sm">
              <table class="w-full text-sm table-auto">
                <thead class="bg-slate-50 text-slate-600 sticky top-0">
                  <tr class="font-semibold text-left">
                    <th class="px-4 py-3">Uraian</th>
                    <th class="px-4 py-3 text-right">Jumlah</th>
                    <th class="px-4 py-3 text-center w-24">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                  @foreach($event->pengeluarans->sortByDesc('created_at') as $row)
                  <tr class="table-row-hover transition" data-row-id="pengeluaran-{{ $row->id }}">
                    <td class="px-4 py-3">{{ $row->uraian }}</td>
                    <td class="px-4 py-3 text-right text-rose-600">Rp {{ number_format($row->jumlah,0,',','.') }}</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                      <div class="flex items-center justify-center gap-2">
                        <button type="button"
                                class="text-indigo-700 hover:text-indigo-900 transition"
                                data-update-url="{{ route('pengeluaran.update', $row->id) }}"
                                data-json='@json($row)'
                                onclick="openEditPengeluaranModal(this)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>
                        </button>
                        <form action="{{ route('pengeluaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus pengeluaran ini?')">
                          @csrf @method('DELETE')
                          <button type="submit" class="text-rose-600 hover:text-rose-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" /></svg>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr class="bg-slate-100 font-bold border-t border-slate-200">
                    <td class="px-4 py-3 text-right">TOTAL</td>
                    <td class="px-4 py-3 text-right text-rose-600">Rp {{ number_format($sumOps,0,',','.') }}</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          @endif
        </div>

      </div>
    </main>
  </div>
</div>

<!-- ====== Modals ====== -->
{{-- Modal Edit Kelas Lomba --}}
<div id="editKelasModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="text-2xl font-bold text-slate-900">Edit Kelas Lomba</h3>
      <button type="button" onclick="closeEditKelasModal()" class="text-slate-500 hover:text-slate-700 transition">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <form id="formEditKelas" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-5">
        @csrf @method('PUT')
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <div class="md:col-span-2">
          <label class="text-sm font-medium mb-1 block text-slate-700">Nama Kelas</label>
          <input id="edit_nama_kelas" name="nama_kelas" class="form-input" placeholder="Murai Batu / Cucak Hijau..." required>
        </div>

        <div>
          <label class="text-sm font-medium mb-1 block text-slate-700">Harga Tiket</label>
          <div class="number-input-wrapper">
            <input id="edit_harga_tiket" type="number" name="harga_tiket" min="0" class="form-input" required>
            <div class="number-input-buttons">
              <button type="button" onclick="this.previousElementSibling.stepUp()">▲</button>
              <button type="button" onclick="this.previousElementSibling.stepDown()">▼</button>
            </div>
          </div>
        </div>
        <div>
          <label class="text-sm font-medium mb-1 block text-slate-700">Jumlah Peserta</label>
          <div class="number-input-wrapper">
            <input id="edit_jumlah_peserta" type="number" name="jumlah_peserta" min="0" class="form-input" required>
            <div class="number-input-buttons">
              <button type="button" onclick="this.previousElementSibling.stepUp()">▲</button>
              <button type="button" onclick="this.previousElementSibling.stepDown()">▼</button>
            </div>
          </div>
        </div>

        {{-- Hadiah 1..10 --}}
        @for ($i=1;$i<=10;$i++)
        <div>
          <label class="text-sm font-medium mb-1 block text-slate-700">Hadiah Juara {{ $i }}</label>
          <div class="number-input-wrapper">
            <input id="edit_hadiah_{{ $i }}" type="number" name="hadiah_{{ $i }}" min="0" value="0" class="form-input">
            <div class="number-input-buttons">
              <button type="button" onclick="this.previousElementSibling.stepUp()">▲</button>
              <button type="button" onclick="this.previousElementSibling.stepDown()">▼</button>
            </div>
          </div>
        </div>
        @endfor

        <div class="md:col-span-1">
          <label class="text-sm font-medium mb-1 block text-slate-700">Jumlah Piala</label>
          <div class="number-input-wrapper">
            <input id="edit_jumlah_piala" type="number" name="jumlah_piala" min="0" value="3" class="form-input">
            <div class="number-input-buttons">
              <button type="button" onclick="this.previousElementSibling.stepUp()">▲</button>
              <button type="button" onclick="this.previousElementSibling.stepDown()">▼</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" onclick="closeEditKelasModal()" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition font-semibold">Batal</button>
      <button type="submit" form="formEditKelas" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition font-semibold">Simpan Perubahan</button>
    </div>
  </div>
</div>

{{-- Modal Edit Pengeluaran --}}
<div id="editPengeluaranModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="text-2xl font-bold text-slate-900">Edit Pengeluaran Operasional</h3>
      <button type="button" onclick="closeEditPengeluaranModal()" class="text-slate-500 hover:text-slate-700 transition">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <form id="formEditPengeluaran" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
        @csrf @method('PUT')
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <div>
          <label class="text-sm font-medium mb-1 block text-slate-700">Uraian</label>
          <input id="edit_uraian_pengeluaran" name="uraian" class="form-input" placeholder="Juri / Admin / Konsumsi..." required>
        </div>
        <div>
          <label class="text-sm font-medium mb-1 block text-slate-700">Jumlah (Rp)</label>
          <div class="number-input-wrapper">
            <input id="edit_jumlah_pengeluaran" type="number" name="jumlah" min="0" class="form-input" required>
            <div class="number-input-buttons">
              <button type="button" onclick="this.previousElementSibling.stepUp()">▲</button>
              <button type="button" onclick="this.previousElementSibling.stepDown()">▼</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" onclick="closeEditPengeluaranModal()" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition font-semibold">Batal</button>
      <button type="submit" form="formEditPengeluaran" class="px-6 py-2 bg-emerald-600 text-white rounded-lg shadow-md hover:bg-emerald-700 transition font-semibold">Simpan Perubahan</button>
    </div>
  </div>
</div>

{{-- Modal Detail Kelas (read-only) --}}
<div id="detailKelasModal" class="modal-overlay locked">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="text-2xl font-bold text-slate-900">Detail Kelas Lomba</h3>
      <div class="text-xs text-slate-500">Hanya baca</div>
    </div>
    <div class="modal-body modal-body-readonly">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Nama Kelas</div>
          <div id="dk-nama" class="text-lg font-semibold text-slate-900">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Harga Tiket</div>
          <div id="dk-harga" class="text-lg font-semibold text-slate-900">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Jumlah Peserta</div>
          <div id="dk-peserta" class="text-lg font-semibold text-slate-900">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Total Tiket</div>
          <div id="dk-total-tiket" class="text-lg font-semibold text-indigo-700">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Total Hadiah</div>
          <div id="dk-total-hadiah" class="text-lg font-semibold text-rose-600">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Jumlah Piala</div>
          <div id="dk-piala" class="text-lg font-semibold text-slate-900">—</div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-slate-500">Laba Bersih</div>
          <div id="dk-laba" class="text-lg font-extrabold">—</div>
        </div>
      </div>

      <div id="dk-rincian-wrapper" class="mt-8">
        <div class="text-sm text-slate-500 mb-2">Rincian Hadiah</div>
        <ul id="dk-rincian-hadiah" class="list-disc list-inside space-y-1 text-slate-800"></ul>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" onclick="closeDetailKelasModal()" class="px-6 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition font-semibold">Tutup</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="fixed top-4 right-4 z-[10000] hidden">
  <div class="flex items-start gap-3 rounded-xl bg-white shadow-lg border border-slate-200 p-4 min-w-[280px]">
    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 grid place-items-center">✔</div>
    <div class="text-sm">
      <div id="toast-title" class="font-semibold text-slate-900">Tersimpan</div>
      <div id="toast-msg" class="text-slate-600">Perubahan berhasil disimpan.</div>
    </div>
    <button onclick="hideToast()" class="text-slate-400 hover:text-slate-600">✕</button>
  </div>
</div>

<!-- ====== Script ====== -->
<script>
  // Offcanvas (opsional jika ingin aktifkan di mobile)
  const btnMenu = document.getElementById('btnMenu');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  btnMenu?.addEventListener('click', () => { sidebar.style.transform = 'translateX(0)'; overlay.classList.remove('hidden'); });
  overlay?.addEventListener('click', () => { sidebar.style.transform = 'translateX(-100%)'; overlay.classList.add('hidden'); });

  // === Kelas Modal ===
  function openEditKelasModal(btn){
    const payload = JSON.parse(btn.getAttribute('data-json'));
    const url = btn.getAttribute('data-update-url');
    const modal = document.getElementById('editKelasModal');
    const form  = document.getElementById('formEditKelas');
    form.action = url;
    document.getElementById('edit_nama_kelas').value = payload.nama_kelas;
    document.getElementById('edit_harga_tiket').value = payload.harga_tiket;
    document.getElementById('edit_jumlah_peserta').value = payload.jumlah_peserta;
    document.getElementById('edit_jumlah_piala').value = payload.jumlah_piala ?? 0;
    for(let i=1;i<=10;i++){ document.getElementById(`edit_hadiah_${i}`).value = payload[`hadiah_${i}`] ?? 0; }
    openEditKelasModal._triggerBtn = btn;
    modal.classList.add('open');
  }
  function closeEditKelasModal(){ document.getElementById('editKelasModal').classList.remove('open'); }

  // === Pengeluaran Modal ===
  function openEditPengeluaranModal(btn){
    const payload = JSON.parse(btn.getAttribute('data-json'));
    const url = btn.getAttribute('data-update-url');
    const modal = document.getElementById('editPengeluaranModal');
    const form  = document.getElementById('formEditPengeluaran');
    form.action = url;
    document.getElementById('edit_uraian_pengeluaran').value = payload.uraian;
    document.getElementById('edit_jumlah_pengeluaran').value = payload.jumlah;
    modal.classList.add('open');
  }
  function closeEditPengeluaranModal(){ document.getElementById('editPengeluaranModal').classList.remove('open'); }

  // Tutup modal ketika klik overlay (kecuali modal detail yang locked)
  document.getElementById('editKelasModal').addEventListener('click', e => { if (e.target.id === 'editKelasModal') closeEditKelasModal(); });
  document.getElementById('editPengeluaranModal').addEventListener('click', e => { if (e.target.id === 'editPengeluaranModal') closeEditPengeluaranModal(); });

  // Helpers
  const rupiah = n => new Intl.NumberFormat('id-ID').format(n || 0);
  const asNumber = (text) => typeof text === 'number' ? text : (Number(String(text).replace(/[^\d-]/g, '')) || 0);

  function showToast(title='Tersimpan', msg='Perubahan berhasil disimpan.'){
    const el = document.getElementById('toast');
    document.getElementById('toast-title').textContent = title;
    document.getElementById('toast-msg').textContent = msg;
    el.classList.remove('hidden');
    clearTimeout(showToast._t);
    showToast._t = setTimeout(hideToast, 2600);
  }
  function hideToast(){ document.getElementById('toast').classList.add('hidden'); }

  // Detail (read-only)
  function openDetailKelasModal(payload){
    const safe = (k,d=0)=> (payload[k] ?? d);
    document.getElementById('dk-nama').textContent = payload.nama_kelas ?? '—';
    document.getElementById('dk-harga').textContent = 'Rp ' + rupiah(safe('harga_tiket'));
    document.getElementById('dk-peserta').textContent = String(safe('jumlah_peserta'));
    document.getElementById('dk-total-tiket').textContent = 'Rp ' + rupiah(safe('total_tiket'));
    document.getElementById('dk-total-hadiah').textContent = 'Rp ' + rupiah(safe('total_hadiah'));
    document.getElementById('dk-piala').textContent = String(safe('jumlah_piala'));
    const laba = Number(safe('laba_bersih'));
    const elLaba = document.getElementById('dk-laba');
    elLaba.textContent = 'Rp ' + rupiah(laba);
    elLaba.classList.toggle('text-emerald-700', laba >= 0);
    elLaba.classList.toggle('text-rose-700', laba < 0);

    const wrapper = document.getElementById('dk-rincian-wrapper');
    const ul = document.getElementById('dk-rincian-hadiah');
    ul.innerHTML = '';
    let ada = false;
    for(let i=1;i<=10;i++){
      const val = Number(payload[`hadiah_${i}`] ?? 0);
      if (val > 0){ const li = document.createElement('li'); li.textContent = `Juara ${i}: Rp ${rupiah(val)}`; ul.appendChild(li); ada = true; }
    }
    wrapper.style.display = ada ? '' : 'none';
    document.getElementById('detailKelasModal').classList.add('open');
  }
  function closeDetailKelasModal(){ document.getElementById('detailKelasModal').classList.remove('open'); }
  document.addEventListener('keydown', function(e){
    const open = document.getElementById('detailKelasModal')?.classList.contains('open');
    if (open && e.key === 'Escape'){ e.preventDefault(); e.stopPropagation(); }
  }, true);

  // Delegasi klik baris -> buka detail (kecuali kolom Aksi)
  document.addEventListener('click', function(e){
    const tr = e.target.closest('tr[data-row-id^="kelas-"]');
    if (!tr) return;
    const aksiCell = tr.querySelector('td:nth-child(7)');
    if (aksiCell && aksiCell.contains(e.target)) return;
    const editBtn = tr.querySelector('button[onclick^="openEditKelasModal"]');
    if (!editBtn) return;
    try { const payload = JSON.parse(editBtn.getAttribute('data-json') || '{}'); openDetailKelasModal(payload); }
    catch(err){ console.error('Gagal parse data-json untuk detail:', err); }
  });

  // Submit AJAX Edit Kelas
  document.getElementById('formEditKelas').addEventListener('submit', async function(e){
    e.preventDefault();
    const form = e.currentTarget;
    const btn  = form.closest('.modal-content').querySelector('button[form="formEditKelas"][type="submit"]');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try {
      const res = await fetch(form.action, {
        method:'POST',
        headers:{ 'X-Requested-With':'XMLHttpRequest','Accept':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '' },
        body:new FormData(form)
      });
      if (!res.ok){
        if (res.status === 401 || res.status === 419) showToast('Sesi berakhir','Silakan muat ulang halaman lalu coba lagi.');
        else showToast('Gagal', `Terjadi masalah (HTTP ${res.status}).`);
        return;
      }
      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')){
        showToast('Gagal','Server mengirim HTML/redirect. Pastikan controller mengembalikan JSON.');
        return;
      }
      const data = await res.json();
      if (!data.ok) throw new Error('Gagal menyimpan');

      const r = data.row;
      let tr = document.querySelector(`tr[data-row-id="kelas-${r.id}"]`);

      if (tr){
        tr.querySelector('td:nth-child(1)').textContent = r.nama_kelas;
        tr.querySelector('td:nth-child(2)').textContent = r.jumlah_peserta;
        tr.querySelector('td:nth-child(3)').innerHTML = 'Rp ' + rupiah(r.harga_tiket);
        tr.querySelector('td:nth-child(4)').innerHTML = 'Rp ' + rupiah(r.total_tiket);
        tr.querySelector('td:nth-child(5)').innerHTML = 'Rp ' + rupiah(r.total_hadiah);
        const labaCell = tr.querySelector('td:nth-child(6)');
        labaCell.innerHTML = 'Rp ' + rupiah(r.laba_bersih);
        labaCell.classList.toggle('text-emerald-600', (r.laba_bersih||0) >= 0);
        labaCell.classList.toggle('text-rose-600', (r.laba_bersih||0) < 0);
        const editBtn = tr.querySelector('button[onclick^="openEditKelasModal"]');
        if (editBtn) editBtn.setAttribute('data-json', JSON.stringify(r));
        tr.classList.remove('row-pulse'); void tr.offsetWidth; tr.classList.add('row-pulse');
      }

      recalcGlobal();
      closeEditKelasModal();
      showToast('Tersimpan','Kelas berhasil diperbarui.');
    } catch(err){
      console.error(err);
      showToast('Gagal','Tidak dapat menyimpan perubahan.');
    } finally {
      btn.disabled = false; btn.textContent = 'Simpan Perubahan';
    }
  });

  // Submit AJAX Edit Pengeluaran
  document.getElementById('formEditPengeluaran').addEventListener('submit', async function(e){
    e.preventDefault();
    const form = e.currentTarget;
    const btn  = form.closest('.modal-content').querySelector('button[form="formEditPengeluaran"][type="submit"]');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try{
      const res = await fetch(form.action,{
        method:'POST',
        headers:{ 'X-Requested-With':'XMLHttpRequest','Accept':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '' },
        body:new FormData(form)
      });
      if(!res.ok){
        if (res.status === 401 || res.status === 419) showToast('Sesi berakhir','Silakan muat ulang halaman lalu coba lagi.');
        else showToast('Gagal', `Terjadi masalah (HTTP ${res.status}).`);
        return;
      }
      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')){
        showToast('Gagal','Server mengirim HTML/redirect. Pastikan controller mengembalikan JSON untuk AJAX.');
        return;
      }
      const data = await res.json();
      if(!data.ok) throw new Error('Gagal menyimpan');

      const r = data.row;
      const tr = document.querySelector(`tr[data-row-id="pengeluaran-${r.id}"]`);
      if (tr){
        tr.querySelector('td:nth-child(1)').textContent = r.uraian;
        tr.querySelector('td:nth-child(2)').innerHTML  = 'Rp ' + rupiah(r.jumlah);
        const editBtn = tr.querySelector('button[onclick^="openEditPengeluaranModal"]');
        if (editBtn) editBtn.setAttribute('data-json', JSON.stringify(r));
        tr.classList.remove('row-pulse'); void tr.offsetWidth; tr.classList.add('row-pulse');
      }

      recalcPengeluaranTotal();
      recalcGlobal();

      closeEditPengeluaranModal();
      showToast('Tersimpan','Pengeluaran berhasil diperbarui.');
    }catch(err){
      console.error(err);
      showToast('Gagal','Tidak dapat menyimpan perubahan.');
    }finally{
      btn.disabled = false; btn.textContent = 'Simpan Perubahan';
    }
  });

  // Recalc Total Pengeluaran
  function recalcPengeluaranTotal(){
    const section = Array.from(document.querySelectorAll('.rounded-2xl.bg-white.shadow-lg.border.card.p-8'))
      .find(sec => sec.querySelector('h2')?.textContent?.includes('Pengeluaran Operasional'));
    if (!section) return;
    const tableEl = section.querySelector('table'); if (!tableEl) return;
    let total=0;
    tableEl.querySelectorAll('tbody tr').forEach(tr=>{
      total += asNumber(tr.querySelector('td:nth-child(2)')?.textContent || '0');
    });
    const totalCell = tableEl.querySelector('tfoot td:nth-child(2)');
    if (totalCell) totalCell.innerHTML = 'Rp ' + rupiah(total);
  }

  // Recalc Ringkasan Global
  function recalcGlobal(){
    let totalTiket=0,totalHadiah=0,totalOps=0;
    document.querySelectorAll('.rounded-2xl.bg-white.shadow-lg.border.card.p-8').forEach(section=>{
      const h2 = section.querySelector('h2')?.textContent || '';
      if (h2.includes('Kelas Lomba') || h2.includes('Daftar Kelas Lomba')){
        section.querySelectorAll('tbody tr').forEach(tr=>{
          totalTiket += asNumber(tr.querySelector('td:nth-child(4)')?.textContent || '0');
          totalHadiah+= asNumber(tr.querySelector('td:nth-child(5)')?.textContent || '0');
        });
      }
    });
    const sectionOps = Array.from(document.querySelectorAll('.rounded-2xl.bg-white.shadow-lg.border.card.p-8'))
      .find(sec => sec.querySelector('h2')?.textContent?.includes('Pengeluaran Operasional'));
    if (sectionOps){
      sectionOps.querySelectorAll('tbody tr').forEach(tr=>{
        totalOps += asNumber(tr.querySelector('td:nth-child(2)')?.textContent || '0');
      });
    }

    // Aturan baru: saldo awal selalu 0 (tidak ambil dari DOM)
    const saldoAwal = 0;
    const saldoAkhir = saldoAwal + totalTiket - (totalHadiah + totalOps);

    const elTiket = document.getElementById('global-total-tiket');
    const elPengeluaran = document.getElementById('global-total-pengeluaran');
    const elSaldoAkhir = document.getElementById('global-saldo-akhir');
    const cardSaldoAkhir = document.getElementById('global-saldo-akhir-card');
    const labelSaldoAkhir = document.getElementById('global-saldo-akhir-label');

    if (elTiket) elTiket.innerHTML = 'Rp ' + rupiah(totalTiket);
    if (elPengeluaran) elPengeluaran.innerHTML = 'Rp ' + rupiah(totalHadiah + totalOps);
    if (elSaldoAkhir) elSaldoAkhir.innerHTML = 'Rp ' + rupiah(saldoAkhir);

    if (cardSaldoAkhir && labelSaldoAkhir){
      cardSaldoAkhir.classList.toggle('bg-emerald-50', saldoAkhir >= 0);
      cardSaldoAkhir.classList.toggle('bg-rose-50',   saldoAkhir < 0);
      elSaldoAkhir.classList.toggle('text-emerald-900', saldoAkhir >= 0);
      elSaldoAkhir.classList.toggle('text-rose-900',    saldoAkhir < 0);
      labelSaldoAkhir.classList.toggle('text-emerald-700', saldoAkhir >= 0);
      labelSaldoAkhir.classList.toggle('text-rose-700',    saldoAkhir < 0);
    }
  }
</script>
</body>
</html>
