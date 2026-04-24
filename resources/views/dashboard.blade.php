<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard • SEMARFIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card { transition: transform .2s ease, box-shadow .2s ease; border-radius: 1rem; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(15,23,42,.08); }
        .glass { background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.6); }
        .sidebar-gradient { background-image: linear-gradient(135deg, #0b163d, #2d0e4f); }
        .pill { border-radius: 9999px; padding: .3rem .75rem; font-size: .75rem; font-weight: 600; }
        .bg-custom-blue { background-color: #2156a5; }
        .text-custom-blue { color: #2156a5; }
        .bg-custom-green { background-color: #0b9356; }
        .text-custom-green { color: #0b9356; }
        .bg-custom-red { background-color: #a52136; }
        .text-custom-red { color: #a52136; }
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

    <div class="flex-1 flex flex-col">
        <header class="glass sticky top-0 z-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4"> <button id="btnMenu" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">Dashboard</h1>
                        <span class="pill bg-slate-100 text-slate-700 hidden sm:inline-block">🗓️ {{ now()->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="card glass p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Event</div>
                                <div class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalEvents }}</div>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-indigo-50 grid place-items-center text-indigo-600">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 12h14M5 16h14" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card glass p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Pemasukan</div>
                                <div class="mt-1 text-3xl font-extrabold text-slate-900">Rp {{ number_format($totalTicket,0,',','.') }}</div>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-emerald-50 grid place-items-center text-emerald-600">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8M3 12a9 9 0 1018 0A9 9 0 003 12z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card glass p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Pengeluaran</div>
                                <div class="mt-1 text-3xl font-extrabold text-slate-900">Rp {{ number_format($totalOut,0,',','.') }}</div>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-rose-50 grid place-items-center text-rose-600">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6m12 0a6 6 0 10-12 0 6 6 0 0012 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card glass p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Saldo Terkini</div>
                                <div class="mt-1 text-3xl font-extrabold {{ ($saldoAkhir ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    Rp {{ number_format($saldoAkhir,0,',','.') }}
                                </div>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-emerald-50 grid place-items-center text-emerald-600">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card glass p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Grafik Pemasukan vs Pengeluaran</h3>
                        <div class="text-xs text-slate-500">Tergrup: {{ request('group','month')==='week'?'Mingguan':'Bulanan' }}</div>
                    </div>
                    <canvas id="financeChart" class="!h-72"></canvas>
                </div>

                @isset($latestEvents)
                <div class="card glass p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Arena Event Terbaru</h3>
                        <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto -mx-6 sm:mx-0">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                                <tr class="text-left">
                                    <th class="px-6 py-4 rounded-tl-xl rounded-bl-xl">Tanggal</th>
                                    <th class="px-6 py-4">Venue</th>
                                    <th class="px-6 py-4 text-right">Tiket</th>
                                    <th class="px-6 py-4 text-right">Pengeluaran</th>
                                    <th class="px-6 py-4 text-right rounded-tr-xl rounded-br-xl">Saldo Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($latestEvents as $ev)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <span class="pill bg-slate-100 text-slate-700">
                                                {{ \Illuminate\Support\Carbon::parse($ev->tanggal)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $ev->venue ?: '—' }}</td>
                                        <td class="px-6 py-4 text-right">Rp {{ number_format($ev->total_tiket ?? 0,0,',','.') }}</td>
                                        <td class="px-6 py-4 text-right">Rp {{ number_format($ev->total_out ?? 0,0,',','.') }}</td>
                                        <td class="px-6 py-4 text-right font-semibold {{ ($ev->saldo_akhir ?? 0) >= 0 ? 'text-emerald-600':'text-rose-600' }}">
                                            Rp {{ number_format($ev->saldo_akhir ?? 0,0,',','.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada data event terbaru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endisset
            </div>
        </main>
    </div>
</div>

<script>
    // Offcanvas
    const btnMenu = document.getElementById('btnMenu');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    btnMenu?.addEventListener('click', () => { sidebar.style.transform = 'translateX(0)'; overlay.classList.remove('hidden'); });
    overlay?.addEventListener('click', () => { sidebar.style.transform = 'translateX(-100%)'; overlay.classList.add('hidden'); });

    // Chart
    const ctx = document.getElementById('financeChart');
    if (ctx) {
        const gIn = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
        gIn.addColorStop(0, 'rgba(33, 86, 165, 0.9)');
        gIn.addColorStop(1, 'rgba(33, 86, 165, 0.35)');
        const gOut = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
        gOut.addColorStop(0, 'rgba(165, 33, 54, 0.9)');
        gOut.addColorStop(1, 'rgba(165, 33, 54, 0.35)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartMonths ?? []),
                datasets: [
                    { label: 'Pemasukan (Tiket)', data: @json($chartIn ?? []), backgroundColor: gIn, borderRadius: 8, maxBarThickness: 40 },
                    { label: 'Pengeluaran', data: @json($chartOut ?? []), backgroundColor: gOut, borderRadius: 8, maxBarThickness: 40 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true, color: '#64748b' } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.dataset.label}: Rp ${new Intl.NumberFormat('id-ID').format(ctx.parsed.y ?? 0)}`,
                            title: (items) => items[0].label
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(100,116,139,.15)' },
                        ticks: {
                            callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v),
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    }
</script>
</body>
</html>