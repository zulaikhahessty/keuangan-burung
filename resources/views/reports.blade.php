<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SEMARFIN Laporan</title>
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-slate-100 text-slate-800">

<div class="flex min-h-screen">
  <div id="overlay" class="fixed inset-0 bg-slate-900/40 z-30 hidden md:hidden"></div>

  {{-- Sidebar (SAMA dengan halaman lain) --}}
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

      {{-- SEMARFIN Event (buat event + lihat daftar ringkas) --}}
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

      {{-- SEMARFIN Laporan (menu baru) --}}
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

  {{-- Konten --}}
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
            <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">SEMARFIN Laporan</h1>
            <span class="pill bg-slate-100 text-slate-700 hidden sm:inline-block">🗓️ {{ now()->format('d M Y') }}</span>
          </div>
        </div>
      </div>
    </header>

    <main class="flex-1 pb-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        {{-- Daftar Event + tombol export --}}
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200 card">
          <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Daftar Event (Laporan)</h2>
            <span class="pill bg-white text-slate-600 ring-1 ring-slate-200">Total: {{ $events->count() }}</span>
          </div>
          <div class="p-0 overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr class="font-semibold text-left border-b border-slate-200">
                  <th class="px-6 py-4">Tanggal</th>
                  <th class="px-6 py-4">Venue</th>
                  <th class="px-6 py-4 text-right">Saldo Akhir</th>
                  <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200">
                @forelse ($events as $e)
                  <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="pill bg-slate-100 text-slate-700">
                        {{ \Illuminate\Support\Carbon::parse($e->tanggal)->format('d/m/Y') }}
                      </span>
                    </td>
                    <td class="px-6 py-4">{{ $e->venue ?: '—' }}</td>
                    <td class="px-6 py-4 text-right font-bold {{ ($e->saldo_akhir ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                      Rp {{ number_format((int)($e->saldo_akhir ?? 0),0,',','.') }}
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center justify-center gap-2 flex-wrap">
                        <a href="{{ route('events.export', ['event' => $e->id, 'format' => 'xlsx']) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h10l6 6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 15l4 4m0-4l-4 4"/>
                          </svg>
                          XLSX
                        </a>
                        <a href="{{ route('events.export', ['event' => $e->id, 'format' => 'pdf']) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h10l6 6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h4"/>
                          </svg>
                          PDF
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">Belum ada event.</td>
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

<script>
  const btnMenu = document.getElementById('btnMenu');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  btnMenu?.addEventListener('click', () => { sidebar.style.transform = 'translateX(0)'; overlay.classList.remove('hidden'); });
  overlay?.addEventListener('click', () => { sidebar.style.transform = 'translateX(-100%)'; overlay.classList.add('hidden'); });
</script>
</body>
</html>
