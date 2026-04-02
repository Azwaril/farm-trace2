<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - Farm Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .left-side {
            width: 50%;
            background: linear-gradient(135deg, #127A02 35%, #48C735 69%, #3E8933 100%);
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: 50px;
            right: 80px;
        }

        .left-side::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: 60px;
            left: 40px;
        }

        .left-feature {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .left-icon {
            background: rgba(255, 255, 255, 0.15);
            padding: 12px;
            border-radius: 12px;
        }

        @media(max-width:768px) {
            .left-side {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex">

        <!-- LEFT SIDE -->
        <div class="left-side hidden md:flex">

            <img src="{{ asset('images/logo.register.png') }}" class="w-36 mb-6">

            <h1 class="text-3xl font-bold">
                Lacak Perjalanan Produk Pertanian Anda
            </h1>

            <p class="mt-4 text-lg">
                Bergabunglah dengan ribuan petani yang telah mempercayai sistem pelacakan kami
                untuk transparansi dan kualitas produk.
            </p>

            <div class="left-feature">
                <div class="left-icon">
                    <i class="bi bi-shield-check text-xl"></i>
                </div>
                <div>
                    <b>Keamanan Terjamin</b>
                    <p class="text-sm">Data Anda terenkripsi dan tersimpan dengan aman</p>
                </div>
            </div>

            <div class="left-feature">
                <div class="left-icon">
                    <i class="bi bi-graph-up text-xl"></i>
                </div>
                <div>
                    <b>Pelacakan Real-time</b>
                    <p class="text-sm">Monitor produk dari ladang hingga konsumen</p>
                </div>
            </div>

            <div class="left-feature">
                <div class="left-icon">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <div>
                    <b>Komunitas Terpercaya</b>
                    <p class="text-sm">Jaringan petani terverifikasi</p>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full md:w-1/2 flex justify-center items-center bg-white">

            <div class="w-full max-w-md px-8 py-10">

                <h2 class="text-3xl font-bold text-gray-900">
                    Buat Akun Baru
                </h2>

                <p class="text-gray-500 mt-2 mb-8">
                    Mulai perjalanan digital pertanian Anda
                </p>

                <!-- SUCCESS -->
                @if(session('success'))
                    <div class="mb-5 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ERROR -->
                @if(session('error'))
                    <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- VALIDATION -->
                @if ($errors->any())
                    <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300">
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="/register" class="space-y-5">

                    @csrf

                    <!-- USERNAME -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Username</label>

                        <div class="relative mt-2">
                            <i data-feather="user"
                                class="absolute left-4 top-4 w-4 text-gray-400"></i>

                            <input type="text"
                                name="name"
                                placeholder="John"
                                class="w-full h-14 border-2 border-gray-200 rounded-xl pl-12 focus:border-green-500 outline-none">
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Email</label>

                        <div class="relative mt-2">
                            <i data-feather="mail"
                                class="absolute left-4 top-4 w-4 text-gray-400"></i>

                            <input type="email"
                                name="email"
                                placeholder="john@example.com"
                                class="w-full h-14 border-2 border-gray-200 rounded-xl pl-12 focus:border-green-500 outline-none">
                        </div>
                    </div>

                    <!-- NOMOR -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nomor Telepon</label>

                        <div class="relative mt-2">
                            <i data-feather="phone"
                                class="absolute left-4 top-4 w-4 text-gray-400"></i>

                            <input type="text"
                                name="no_hp"
                                placeholder="+62 812 3456 7890"
                                class="w-full h-14 border-2 border-gray-200 rounded-xl pl-12 focus:border-green-500 outline-none">
                        </div>
                    </div>

                    <!-- ALAMAT -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Alamat</label>

                        <div class="relative mt-2">
                            <i data-feather="map-pin"
                                class="absolute left-4 top-4 w-4 text-gray-400"></i>

                            <input type="text"
                                name="alamat"
                                placeholder="Sidayu, Gresik"
                                class="w-full h-14 border-2 border-gray-200 rounded-xl pl-12 focus:border-green-500 outline-none">
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Password</label>

                        <div class="relative mt-2">

                            <i data-feather="lock"
                                class="absolute left-4 top-4 w-4 text-gray-400"></i>

                            <input type="password"
                                name="password"
                                id="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full h-14 border-2 border-gray-200 rounded-xl pl-12 pr-12 focus:border-green-500 outline-none">

                            <i data-feather="eye"
                                onclick="togglePassword()"
                                class="absolute right-4 top-4 w-4 text-gray-400 cursor-pointer"></i>

                        </div>
                    </div>

                    <!-- TERMS -->
                    <div class="flex items-start gap-2 text-sm">
                        <input type="checkbox" required class="mt-1">

                        <p class="text-gray-600">
                            Saya setuju dengan
                            <span class="text-green-600 font-semibold">Syarat & Ketentuan</span>
                            dan
                            <span class="text-green-600 font-semibold">Kebijakan Privasi</span>
                        </p>
                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="w-full h-14 rounded-xl text-white font-semibold
                               bg-gradient-to-r from-green-400 to-green-700
                               hover:opacity-90 transition">

                        Daftar Sekarang
                    </button>

                    <!-- DIVIDER -->
                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-gray-500 text-sm">Atau daftar dengan</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- SOCIAL -->
                    <div class="flex gap-4">

                        <button type="button"
                            class="w-1/2 h-14 border-2 border-gray-200 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50">

                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                                class="w-5">
                            Google
                        </button>

                        <button type="button"
                            class="w-1/2 h-14 border-2 border-gray-200 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50">

                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/facebook/facebook-original.svg"
                                class="w-5">
                            Facebook
                        </button>

                    </div>

                    <!-- LOGIN -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Sudah punya akun?
                        <a href="/login" class="text-green-600 font-semibold">
                            Masuk di sini
                        </a>
                    </p>

                </form>

            </div>

        </div>

    </div>

    <script>
        feather.replace()

        function togglePassword() {
            const pass = document.getElementById("password")
            pass.type = pass.type === "password" ? "text" : "password"
        }
    </script>

</body>

</html>