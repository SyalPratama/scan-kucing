<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AnabulID</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        catOrange: '#FF9F43',
                        catSoft: '#FFF4EB',
                        catDark: '#2D3748',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-catSoft min-h-screen flex items-center justify-center p-4 text-catDark antialiased">

    <!-- Container Utama (Pengganti x-guest-layout) -->
    <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-xl border border-orange-100 relative overflow-hidden">

        <!-- Dekorasi Jejak Kaki di Pojok -->
        <div class="absolute -top-6 -right-6 text-orange-100 transform rotate-12 pointer-events-none">
            <i class="fa-solid fa-paw text-9xl"></i>
        </div>

        <!-- Header Form -->
        <div class="text-center mb-8 relative z-10">
            <div
                class="bg-catOrange text-white w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md shadow-orange-500/20">
                <i class="fa-solid fa-cat text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-catDark">Selamat Datang Kembali!</h2>
            <p class="text-sm text-gray-500 mt-1">Masuk untuk mengakses data scan anabulmu</p>
        </div>

        <!-- Session Status (Laravel standard alert style) -->
        @if (session('status'))
            <div
                class="mb-4 bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-10">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-catOrange focus:bg-white focus:ring-4 focus:ring-orange-100 transition"
                        placeholder="contoh@kucing.com">
                </div>
                @if ($errors->get('email'))
                    <div class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-catOrange focus:bg-white focus:ring-4 focus:ring-orange-100 transition"
                        placeholder="********">

                    <!-- Tombol Mata Kucing (Hide/Show) -->
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-catOrange focus:outline-none hover:opacity-80 group"
                        title="Intip Password">
                        <!-- Default: Mata Kucing Terpejam (Hide) -->
                        <span id="eyeClosed" class="inline-block">
                            <i class="fa-solid fa-eye-slash text-base"></i>
                        </span>
                        <!-- Ketika di-klik: Mata Kucing Terbuka Lebar/Bulat (Show) -->
                        <span id="eyeOpen" class="hidden">
                            <i class="fa-solid fa-cat text-base animate-pulse"></i>
                        </span>
                    </button>
                </div>
                @if ($errors->get('password'))
                    <div class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first('password') }}</span>
                    </div>
                @endif
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded-md border-gray-300 text-catOrange focus:ring-catOrange accent-catOrange">
                    <span class="ms-2 text-xs font-medium text-gray-600 hover:text-gray-900">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-gray-500 hover:text-catOrange transition"
                        href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-catDark text-white font-bold text-sm py-3.5 px-4 rounded-2xl shadow-lg hover:bg-opacity-90 active:scale-[0.98] transition flex items-center justify-center gap-2">
                    <span>Masuk Ke Akun</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Script untuk Toggle Password Mata Kucing -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === 'password') {
                // Tampilkan Password
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                // Sembunyikan Password
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>
