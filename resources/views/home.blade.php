@extends('layouts.app')

@section('content')

<section class="bg-white dark:bg-gray-900 rounded-3xl p-10 shadow-xl">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            Sistem Bina Desa
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">
            Sistem Monitoring Kebencanaan & Tanggap Darurat Desa
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">

        <!-- WARGA -->
        <a href="{{ route('warga.index') }}"
           class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-xl transition dark:bg-gray-800 dark:border-gray-700">
           
            <!-- ICON -->
            <div class="mb-4">
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M17 8a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Data Warga
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                Kelola informasi warga desa: identitas, alamat, kontak, dan keperluan darurat.
            </p>
        </a>

        <!-- KEJADIAN -->
        <a href="{{ route('kejadian.index') }}"
           class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-xl transition dark:bg-gray-800 dark:border-gray-700">

            <div class="mb-4">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                </svg>
            </div>

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Kejadian Bencana
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                Pencatatan berbagai kejadian bencana seperti banjir, tanah longsor, dan lainnya.
            </p>
        </a>

        <!-- POSKO -->
        <a href="{{ route('posko.index') }}"
           class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-xl transition dark:bg-gray-800 dark:border-gray-700">

            <div class="mb-4">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10l9-7 9 7v11a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2z" />
                </svg>
            </div>

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Posko Bencana
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                Informasi posko siaga untuk kebutuhan tanggap darurat dan bantuan logistik.
            </p>
        </a>

    </div>
</section>

@endsection
