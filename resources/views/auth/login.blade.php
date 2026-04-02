<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Inter', sans-serif;
}

/* warna utama dari figma */
.bg-primary {
    background: #127A02;
}

/* shadow button figma */
.shadow-btn {
    box-shadow: 0px 4px 6px rgba(0,0,0,0.1),
                0px 10px 15px rgba(0,0,0,0.1);
}
</style>

</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="w-[1152px] h-[768px] bg-white border border-gray-300 rounded-lg flex overflow-hidden">

    {{-- LEFT --}}
    <div class="w-1/2 p-8 flex flex-col justify-between">

        {{-- LOGO --}}
        <div class="flex items-center justify-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="w-10">
            <h1 class="text-[30px] font-bold text-gray-800">FarmTrace</h1>
        </div>

        {{-- IMAGE --}}
        <img src="{{ asset('images/login.png') }}"
             class="rounded-2xl w-full h-[320px] object-cover">

        {{-- TEXT --}}
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                Lacak Perjalanan Produk Pertanian
            </h2>

            <p class="text-gray-500 mt-3 text-[18px] leading-[30px]">
                Dari Ladang hingga sampai Pembeli, pantau setiap langkah produk pertanian
                dengan platform yang transparan dan terpercaya.
            </p>
        </div>

        {{-- ICON FEATURE --}}
        <div class="flex justify-center gap-16">

            {{-- item --}}
            {{-- KEAMANAN --}}
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow">
                    <img src="{{ asset('icons/security.svg') }}" class="w-5 h-5">
                </div>
                <p class="text-sm mt-3 text-gray-700 font-medium">Keamanan</p>
            </div>

            {{-- TRANSPARANSI --}}
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow">
                    <img src="{{ asset('icons/transparansi.svg') }}" class="w-5 h-5">
                </div>
                <p class="text-sm mt-3 text-gray-700 font-medium">Transparansi</p>
            </div>

                    {{-- PELACAKAN --}}
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow">
                    <img src="{{ asset('icons/pelacakkan.svg') }}" class="w-5 h-5">
                </div>
                <p class="text-sm mt-3 text-gray-700 font-medium">Pelacakan</p>
            </div>

        </div>
    </div>

    {{-- RIGHT --}}
    <div class="w-1/2 flex items-center justify-center bg-primary">

        <div class="w-[464px]">

            {{-- TITLE --}}
            <div class="text-center mb-8">
                <h2 class="text-white text-[30px] font-bold">Selamat Datang</h2>
                <p class="text-white text-sm mt-2">Masuk ke akun FarmTrace Anda</p>
            </div>

            {{-- FORM --}}
            <form action="/login" method="POST" class="space-y-5">
                @csrf

                {{-- EMAIL --}}
                <div class="relative mt-2">
                    <input type="email" name="email"
                        class="w-full h-[50px] rounded-xl pl-12 border border-gray-300"
                        placeholder="Email">

                    <img src="{{ asset('icons/email.svg') }}"
                        class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2">
                </div>

                {{-- PASSWORD --}}
                <div class="relative mt-2">
                    <input type="password" name="password"
                        class="w-full h-[50px] rounded-xl pl-12 pr-10 border border-gray-300"
                        placeholder="Password">

                    <img src="{{ asset('icons/lock.svg') }}"
                        class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2">

                    <img src="{{ asset('icons/eye.svg') }}"
                        class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer">
                </div>

                {{-- REMEMBER --}}
                <div class="flex justify-between text-white text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox"> Ingat saya
                    </label>
                    <a href="#">Lupa password?</a>
                </div>

                {{-- BUTTON --}}
                <button class="w-full h-[48px] bg-white text-green-700 rounded-xl font-semibold shadow-btn">
                    Masuk
                </button>

                {{-- DIVIDER --}}
                <div class="flex items-center text-white text-sm">
                    <div class="flex-1 h-px bg-white/50"></div>
                    <span class="px-3">atau masuk dengan</span>
                    <div class="flex-1 h-px bg-white/50"></div>
                </div>

                {{-- SOCIAL --}}
                <div class="flex gap-4">
                    <button class="w-1/2 h-[50px] bg-white rounded-xl flex justify-center items-center gap-2">
                        <span class="text-red-500 font-bold">G</span> Google
                    </button>

                    <button class="w-1/2 h-[50px] bg-white rounded-xl flex justify-center items-center gap-2">
                        <span class="text-blue-600 font-bold">f</span> Facebook
                    </button>
                </div>

                {{-- REGISTER --}}
                <div class="text-center text-white mt-6">
                    <p>Belum punya akun?</p>
                    <a href="/register" class="underline font-semibold">Daftar sekarang</a>
                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>