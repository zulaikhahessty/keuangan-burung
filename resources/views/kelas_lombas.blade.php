<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelas Lomba & Pengeluaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Optional: Add custom fonts or additional styling here if needed */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-700 h-screen flex antialiased">

<aside class="w-64 bg-slate-900 text-white flex flex-col shadow-lg">
    <div class="px-6 py-5 font-extrabold text-2xl border-b border-white/10 text-center">
        🐦 Keuangan Burung
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors duration-200">
            <span class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg> Dashboard</span>
        </a>
        <a href="{{ route('events.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition-colors duration-200">
            <span class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg> Event</span>
        </a>
        <span class="block px-4 py-3 rounded-lg bg-slate-800 text-slate-200 shadow-md">
            <span class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 5a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm6 9a2 2 0 11-4 0 2 2 0 014 0z"/><path d="M12.293 14.707a1 1 0 01.293-.293l5-5a1 1 0 011.414 1.414l-5 5a1 1 0 01-1.414 0zM16 17h1a1 1 0 010 2h-1a1 1 0 010-2z"/></svg> Kelas Lomba & Pengeluaran</span>
        </span>
    </nav>
    <div class="p-4 border-t border-slate-800">
        <div class="text-sm text-slate-400 mb-2">Masuk sebagai</div>
        <div class="flex items-center justify-between">
            <div class="font-medium truncate text-slate-200">{{ auth()->user()->name ?? 'User' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs px-3 py-1 rounded-full bg-slate-700 hover:bg-slate-600 transition-colors duration-200">Logout</button>
            </form>
        </div>
    </div>
</aside>

<div class="flex-1 flex flex-col">
    <header class="bg-white shadow-sm px-8 py-5 flex justify-between items-center z-10">
        <h1 class="text-2xl font-semibold text-slate-800">
            Kelas Lomba & Pengeluaran – Event {{ \Illuminate\Support\Carbon::parse($event->tanggal)->format('d/m/Y') }}
        </h1>
        <a href="{{ route('events.manage', $event) }}" class="px-5 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
            Kembali ke Kelola Event
        </a>
    </header>

    <main class="flex-1 p-8 space-y-8 overflow-y-auto">
        @if (session('ok'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <div>{{ session('ok') }}</div>
        </div>
        @endif
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
            <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="font-semibold text-xl text-slate-800 mb-6">Tambah Kelas / Sesi</h2>
            <form action="{{ route('kelas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                <div class="md:col-span-2">
                    <label class="text-sm font-medium mb-1 block text-slate-600">Nama Kelas</label>
                    <input name="nama_kelas" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" placeholder="Murai Batu / Cucak Hijau..." required>
                </div>
                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Sesi Ke</label>
                    <input type="number" name="sesi_ke" min="1" value="1" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" required>
                </div>

                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Harga Tiket</label>
                    <input type="number" name="harga_tiket" min="0" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" required>
                </div>
                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Jumlah Peserta</label>
                    <input type="number" name="jumlah_peserta" min="0" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" required>
                </div>

                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Hadiah Juara 1</label>
                    <input type="number" name="hadiah_1" min="0" value="0" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                </div>
                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Hadiah Juara 2</label>
                    <input type="number" name="hadiah_2" min="0" value="0" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                </div>
                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Hadiah Juara 3</label>
                    <input type="number" name="hadiah_3" min="0" value="0" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                </div>

                <div>
                    <label class="text-sm font-medium mb-1 block text-slate-600">Jumlah Piala</label>
                    <input type="number" name="jumlah_piala" min="0" value="3" class="w-full border-slate-300 rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                </div>

                <div class="lg:col-span-3 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 font-medium shadow-lg">
                        <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg> Tambah Kelas Lomba</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="font-semibold text-xl text-slate-800 mb-6">Daftar Kelas / Sesi</h2>

            @if($event->kelasLombas->isEmpty())
            <p class="text-slate-500 text-center py-8">Belum ada kelas lomba yang terdaftar.</p>
            @else
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-semibold sticky top-0">
                        <tr>
                            <th class="text-left px-4 py-3 border-b">Burung</th>
                            <th class="text-right px-4 py-3 border-b">Sesi</th>
                            <th class="text-right px-4 py-3 border-b">Harga Tiket</th>
                            <th class="text-right px-4 py-3 border-b">Jml. Peserta</th>
                            <th class="text-right px-4 py-3 border-b">Jml. Gantang</th>
                            <th class="text-right px-4 py-3 border-b">Total Tiket</th>
                            <th class="text-right px-4 py-3 border-b">Hadiah 1</th>
                            <th class="text-right px-4 py-3 border-b">Hadiah 2</th>
                            <th class="text-right px-4 py-3 border-b">Hadiah 3</th>
                            <th class="text-right px-4 py-3 border-b">Total Hadiah</th>
                            <th class="text-right px-4 py-3 border-b">Piala</th>
                            <th class="text-right px-4 py-3 border-b">Sisa Piala</th>
                            <th class="text-right px-4 py-3 border-b">Sisa Tiket</th>
                            <th class="text-right px-4 py-3 border-b">Laba</th>
                            <th class="text-center px-4 py-3 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($event->kelasLombas->sortBy('sesi_ke') as $row)
                        <tr class="hover:bg-slate-100 transition-colors duration-150 odd:bg-white even:bg-slate-50">
                            <td class="px-4 py-3">{{ $row->nama_kelas }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->sesi_ke }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->harga_tiket,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->jumlah_peserta }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->jumlah_gantang }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->total_tiket,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->hadiah_1,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->hadiah_2,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->hadiah_3,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->total_hadiah,0,',','.') }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->jumlah_piala }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->sisa_piala }}</td>
                            <td class="px-4 py-3 text-right">{{ $row->sisa_tiket }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($row->laba_bersih,0,',','.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('kelas.edit', $row->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">Edit</a>
                                <form action="{{ route('kelas.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')" class="inline-block ml-3">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 transition-colors duration-200">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 p-6 bg-indigo-600 text-white rounded-lg text-right font-medium text-lg">
                <div>Total Tiket: <span class="font-bold">Rp {{ number_format($totalTiket,0,',','.') }}</span></div>
                <div>Total Hadiah: <span class="font-bold">Rp {{ number_format($totalHadiah,0,',','.') }}</span></div>
                <div>Sisa Tiket: <span class="font-bold">{{ $sisaTiket }}</span></div>
            </div>
            @endif
        </div>

    </main>
</div>

</body>
</html>