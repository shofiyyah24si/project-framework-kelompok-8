<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Sistem Bina Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- WAJIB: Load Tailwind + Flowbite via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-navy text-slate-100 antialiased">

    {{-- NAVBAR --}}
    <nav class="border-b border-slate-800 bg-[#020617]/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-accent to-fuchsia-500 
                            flex items-center justify-center shadow-lg shadow-blue-500/40">
                    <span class="text-lg font-bold">BD</span>
                </div>

                <div>
                    <p class="text-lg font-semibold leading-5">Sistem Bina Desa</p>
                    <p class="text-[10px] text-slate-400 -mt-1">Kebencanaan & Tanggap Darurat</p>
                </div>
            </a>

            {{-- MENU --}}
            <div class="hidden md:flex items-center gap-10 text-sm font-medium">

                <a href="/warga"
                   class="px-2 py-1 border-b-2 transition
                   {{ request()->is('warga*') 
                        ? 'border-accent text-white' 
                        : 'border-transparent text-slate-300 hover:text-white hover:border-slate-600' }}">
                    Warga
                </a>

                <a href="/kejadian"
                   class="px-2 py-1 border-b-2 transition
                   {{ request()->is('kejadian*') 
                        ? 'border-accent text-white' 
                        : 'border-transparent text-slate-300 hover:text-white hover:border-slate-600' }}">
                    Kejadian
                </a>

                <a href="/posko"
                   class="px-2 py-1 border-b-2 transition
                   {{ request()->is('posko*') 
                        ? 'border-accent text-white' 
                        : 'border-transparent text-slate-300 hover:text-white hover:border-slate-600' }}">
                    Posko
                </a>

                <button onclick="openLogoutModal()"
                        class="text-red-400 hover:text-red-300 font-semibold transition">
                    Logout
                </button>
            </div>

        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
        © {{ date('Y') }} Sistem Bina Desa — Kebencanaan & Tanggap Darurat
    </footer>

    {{-- LOGOUT MODAL --}}
    <div id="logoutModal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm 
                flex items-center justify-center z-[999]">

        <div class="bg-navySoft border border-slate-700 rounded-2xl p-6 w-80 shadow-xl">

            <h2 class="text-lg font-semibold">Keluar dari Sistem?</h2>
            <p class="text-slate-300 text-sm mt-2 mb-6">Anda yakin ingin logout?</p>

            <div class="flex gap-3">
                <button onclick="closeLogoutModal()"
                        class="flex-1 py-2 rounded-xl bg-slate-700 text-slate-200 hover:bg-slate-600 transition">
                    Batal
                </button>

                <a href="{{ route('logout') }}"
                   class="flex-1 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition">
                    Logout
                </a>
            </div>

        </div>
    </div>

    {{-- MODAL SCRIPT --}}
    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>

</body>
</html>
