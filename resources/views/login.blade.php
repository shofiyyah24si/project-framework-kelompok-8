<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Bina Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 flex items-center justify-center h-screen">

    <form action="{{ route('login.process') }}" method="POST"
          class="bg-slate-800 p-8 rounded-xl shadow-xl shadow-black/40 space-y-4 w-80">
        @csrf

        <h2 class="text-xl font-bold text-white text-center mb-3">Login Sistem Bina Desa</h2>

        <input type="text" name="email" placeholder="Email"
               class="w-full px-4 py-2 bg-slate-700 rounded text-white outline-none placeholder-slate-400">

        <input type="password" name="password" placeholder="Password"
               class="w-full px-4 py-2 bg-slate-700 rounded text-white outline-none placeholder-slate-400">

        <button class="w-full bg-accent py-2 rounded text-white font-bold hover:bg-accentSoft transition">
            Login
        </button>

        @error('email')
            <p class="text-red-400 text-sm">{{ $message }}</p>
        @enderror
    </form>

</body>
</html>
