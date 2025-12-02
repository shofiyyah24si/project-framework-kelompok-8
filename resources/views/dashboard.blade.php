@extends('layouts.app')

@section('content')
<div class="text-center mb-10">
    <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2">
        Sistem Bina Desa
    </h1>
    <p class="text-slate-400 text-sm">
        Pilih modul untuk melanjutkan pengelolaan data kebencanaan & tanggap darurat
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- CARD WARGA --}}
    <a href="{{ route('warga.index') }}"
       class="group rounded-2xl bg-navySoft/80 border border-slate-700/60 p-6 shadow-lg 
              hover:-translate-y-1 hover:border-accent/70 hover:shadow-blue-500/30 transition">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500
                        flex items-center justify-center text-3xl shadow-lg shadow-amber-500/30">
                👥
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-1 group-hover:text-white">Data Warga</h2>
                <p class="text-xs text-slate-400">
                    Pendataan warga terdampak dan potensi risiko di desa.
                </p>
            </div>
        </div>
    </a>

    {{-- CARD KEJADIAN --}}
    <a href="{{ route('kejadian.index') }}"
       class="group rounded-2xl bg-navySoft/80 border border-slate-700/60 p-6 shadow-lg 
              hover:-translate-y-1 hover:border-accent/70 hover:shadow-blue-500/30 transition">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600
                        flex items-center justify-center text-3xl shadow-lg shadow-red-500/40">
                🚨
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-1 group-hover:text-white">Kejadian Bencana</h2>
                <p class="text-xs text-slate-400">
                    Catatan kronologi, lokasi, dan dampak kejadian bencana.
                </p>
            </div>
        </div>
    </a>

    {{-- CARD POSKO --}}
    <a href="{{ route('posko.index') }}"
       class="group rounded-2xl bg-navySoft/80 border border-slate-700/60 p-6 shadow-lg 
              hover:-translate-y-1 hover:border-accent/70 hover:shadow-blue-500/30 transition">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-cyan-500
                        flex items-center justify-center text-3xl shadow-lg shadow-emerald-500/40">
                🏥
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-1 group-hover:text-white">Posko Bencana</h2>
                <p class="text-xs text-slate-400">
                    Manajemen posko, kontak penanggung jawab, dan distribusi bantuan.
                </p>
            </div>
        </div>
    </a>
</div>
@endsection
