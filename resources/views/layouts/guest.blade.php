<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'SEMARFIN') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])

  {{-- Tipografi & tema halus --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --accent: #4f46e5; }
    body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
    /* Latar sangat soft, tidak mengganggu */
    .soft-bg {
      background:
        radial-gradient(1200px 500px at 10% -10%, rgba(79,70,229,.06), transparent 60%),
        radial-gradient(900px 400px at 110% 0%, rgba(15,23,42,.05), transparent 55%),
        #f7f8fb;
    }
    @media (prefers-color-scheme: dark){
      .soft-bg { background:#0b1220; }
      .card { background: rgba(18, 24, 40, 0.9) !important; border-color: rgba(148,163,184,.15) !important; }
      .muted { color: #cbd5e1 !important; }
    }
  </style>
</head>
<body class="min-h-screen soft-bg text-slate-800 antialiased">
  {{ $slot }}
</body>
</html>
