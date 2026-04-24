<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event • SEMARFIN</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    body { font-family: 'Inter', sans-serif; }
    .card { transition: transform .2s ease, box-shadow .2s ease; border-radius: 1rem; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15,23,42,.08); }
    .glass { background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.6); }
    .sidebar-gradient { background-image: linear-gradient(135deg, #0b163d, #2d0e4f); }
    .pill { border-radius: 9999px; padding: .3rem .75rem; font-size: .75rem; font-weight: 600; }
    .form-input { border:1px solid #e2e8f0; background-color: #f8fafc; border-radius:.5rem; padding:.6rem 1rem; width:100%; transition:all .3s ease; }
    .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.2); outline:none; background-color: white; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-slate-100 text-slate-800">

<div class="flex min-h-screen">
  <div id="overlay" class="fixed inset-0 bg-slate-900/40 z-30 hidden md:hidden"></div>

  <aside id="sidebar"
         class="fixed md:static z-40 inset-y-0 left-0 w-72 translate-x-[-100%] md:translate-x-0 transition-transform duration-200 sidebar-gradient text-white flex flex-col shadow-xl md:shadow-none">
    <div class="p-6 border-b border-white/10 text-center">
      <div class="mb-2">
        <img src="{{ asset('images/Logo Semar Arena.jpeg') }}"
             alt="Logo SEMARFIN"
             class="h-20 mx-auto object-contain rounded-full border-2 border-white/30 p-1">
      </div>
      <div class="text-2xl font-bold tracking-wide mt-2">SEMARFIN</div>
      <div class="text-xs text-white/70">Semar Arena Finance</div>
    </div>

<nav class="flex-1 p-4 space-y-2">
  {{-- Dashboard --}}
  <a href="{{ route('dashboard') }}"
     class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }}">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-7 9 7M4.5 10.5V21h15V10.5" />
    </svg>
    <span>Dashboard</span>
  </a>

  {{-- SEMARFIN Event --}}
  <a href="{{ route('events.index') }}"
     class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('events.index') ? 'bg-white/20' : 'hover:bg-white/10' }}">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8M8 15h8M4 5h16v14H4z" />
    </svg>
    <span>SEMARFIN Event</span>
  </a>

  {{-- Kelola Event --}}
  <a href="{{ route('events.manage_index') }}"
     class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('events.manage_index') || request()->routeIs('events.manage') ? 'bg-white/20' : 'hover:bg-white/10' }}">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h8" />
    </svg>
    <span>Kelola Event</span>
  </a>

  {{-- SEMARFIN Laporan (baru) --}}
  <a href="{{ route('reports.index') }}"
     class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('reports.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M8 8h10M8 12h10M8 16h10M3 20h18" />
    </svg>
    <span>SEMARFIN Laporan</span>
  </a>
</nav>



    <div class="p-6 border-t border-white/10">
      <div class="text-xs text-white/70 mb-2">Masuk sebagai</div>
      <div class="flex items-center justify-between">
        <div class="truncate font-medium">{{ auth()->user()->name ?? 'User' }}</div>
        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
          @csrf
          <button type="submit" class="text-sm px-3 py-1 rounded-md bg-white/15 hover:bg-white/25 transition">
            Logout
          </button>
        </form>
      </div>
    </div>
  </aside>

  <div class="flex-1 flex flex-col">
    <header class="glass sticky top-0 z-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <button id="btnMenu" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
            <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">Manajemen Event</h1>
            <span class="pill bg-slate-100 text-slate-700 hidden sm:inline-block">🗓️ {{ now()->format('d M Y') }}</span>
          </div>
          <a href="{{ route('events.index') }}"
             class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200 transition text-sm font-semibold">
            Refresh
          </a>
        </div>
      </div>
    </header>

    <main class="flex-1 pb-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Notifikasi --}}
        @if (session('ok'))
          <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-medium shadow-sm">
            {{ session('ok') }}
          </div>
        @endif
        @if ($errors->any())
          <div class="p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 shadow-sm">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
        @endif

        {{-- Form tambah event --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card">
          <div class="p-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Tambah Event Baru</h2>
          </div>
          <div class="p-6">
            <form action="{{ route('events.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-6">
              @csrf
              <div>
                <label class="text-sm font-medium mb-2 block text-slate-700">Tanggal</label>
                <input id="tgl" type="date" name="tanggal" class="form-input" required>
              </div>
              <div class="md:col-span-2">
                <label class="text-sm font-medium mb-2 block text-slate-700">Venue</label>
                <input type="text" name="venue" value="{{ old('venue') }}" class="form-input" placeholder="contoh: Masukkan lokasi">
              </div>

              <div class="md:col-span-3 flex justify-end mt-4">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition font-semibold">
                  + Simpan Event
                </button>
              </div>
            </form>
          </div>
        </div>

        {{-- Daftar event --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card">
          <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Daftar Event</h2>
            <span class="pill bg-white text-slate-600 ring-1 ring-slate-200">Total: {{ $events->count() }}</span>
          </div>
          <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr class="font-semibold text-left border-b border-slate-200">
                  <th class="px-6 py-4">Tanggal</th>
                  <th class="px-6 py-4">Venue</th>
                  <th class="px-6 py-4 text-right">Saldo Awal</th>
                  <th class="px-6 py-4 text-right">Saldo Akhir</th>
                  <th class="px-6 py-4 text-center">Aksi</th> </tr>
              </thead>
              <tbody class="divide-y divide-slate-200">
                @forelse ($events as $e)
                  <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="pill bg-slate-100 text-slate-700">
                        {{ \Illuminate\Support\Carbon::parse($e->tanggal)->format('d/m/Y') }}
                      </span>
                    </td>
                    <td class="px-6 py-4">{{ $e->venue ?: '—' }}</td>
                    <td class="px-6 py-4 text-right">
                      Rp {{ number_format((int)($e->saldo_awal ?? 0),0,',','.') }}
                    </td>
                    <td class="px-6 py-4 text-right font-bold {{ ($e->saldo_akhir ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                      Rp {{ number_format((int)($e->saldo_akhir ?? 0),0,',','.') }}
                    </td>
                    {{-- Kolom Aksi --}}
                    <td class="px-6 py-4">
                      <div class="flex items-center justify-center gap-2 flex-wrap">
                        {{-- Form Hapus Event --}}
                        <form action="{{ route('events.destroy', $e->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Aksi ini tidak dapat dibatalkan.');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-rose-600 hover:text-rose-900 transition flex items-center gap-1 text-sm bg-rose-50 px-3 py-1 rounded-md ring-1 ring-rose-200">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.166L18.16 2.339A2.25 2.25 0 0015.682 1.5H8.318a2.25 2.25 0 00-2.478.839L4.258 5.795m9.968-.166L8.318 5.795M5.636 5.636l1.24 10.375c.076.64.484 1.15 1.05 1.488L12 21.75l4.074-4.251c.566-.338.974-.848 1.05-1.488L18.364 5.636m-12.728 0c-.391 0-.693.302-.693.693v.001a.693.693 0 00.693.693h12.728a.693.693 0 00.693-.693v-.001a.693.693 0 00-.693-.693H5.636z" />
                            </svg>
                            <span>Hapus</span>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada event.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

{{-- Script untuk Offcanvas Mobile --}}
<script>
  const btnMenu = document.getElementById('btnMenu');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  btnMenu?.addEventListener('click', () => { sidebar.style.transform = 'translateX(0)'; overlay.classList.remove('hidden'); });
  overlay?.addEventListener('click', () => { sidebar.style.transform = 'translateX(-100%)'; overlay.classList.add('hidden'); });
</script>
</body>
</html>
