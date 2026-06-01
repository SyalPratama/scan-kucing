<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AnabulID')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        // Mendaftarkan Poppins sebagai font utama (sans-serif) di Tailwind
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        catOrange: '#FF9F43',
                        catSoft: '#FFF4EB',
                        catDark: '#2D3748'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        body,
        .custom-swal-popup {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

    @yield('styles')
</head>

<body class="font-sans bg-catSoft text-catDark antialiased min-h-screen flex flex-col md:flex-row">

    <header
        class="md:hidden bg-white px-4 py-4 border-b border-orange-100 flex justify-between items-center sticky top-0 z-40 shadow-sm">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-cat text-2xl text-catOrange"></i>
            <span class="text-lg font-bold tracking-wide">Anabul<span class="text-catOrange">ID</span></span>
        </div>
        <span class="bg-orange-50 text-catOrange text-xs font-bold px-3 py-1.5 rounded-xl border border-orange-100">
            <i class="fa-solid fa-paw mr-1"></i> Client Panel
        </span>
    </header>

    <aside
        class="fixed bottom-0 left-0 right-0 md:sticky md:top-0 md:h-screen w-full md:w-64 bg-white border-t md:border-t-0 md:border-r border-orange-100 flex flex-row md:flex-col p-2 md:p-5 justify-between shadow-lg md:shadow-sm z-50">

        <div class="w-full md:w-auto flex md:flex-col justify-around md:justify-start gap-1 md:space-y-6">

            <div class="hidden md:flex items-center gap-2 px-2 py-3">
                <i class="fa-solid fa-cat text-3xl text-catOrange"></i>
                <span class="text-xl font-bold tracking-wide">Anabul<span class="text-catOrange">ID</span></span>
            </div>

            <nav class="flex flex-row md:flex-col justify-around md:justify-start w-full gap-1 md:gap-2">
                <a href="{{ route('client.data-kucing.index') }}"
                    class="flex flex-col md:flex-row items-center gap-1 md:gap-3 px-3 py-2 md:px-4 md:py-3 rounded-2xl font-semibold text-xs md:text-sm transition min-w-[70px] text-center md:text-left
                    {{ request()->routeIs('client.data-kucing.index') ? 'text-white bg-catOrange shadow-sm' : 'text-gray-400 md:text-gray-500 hover:text-catOrange hover:bg-orange-50' }}">
                    <i class="fa-solid fa-chart-pie text-lg md:text-xl"></i>
                    <span class="mt-0.5 md:mt-0">Dashboard</span>
                </a>

                <a href="{{ route('client.payment.index') }}"
                    class="flex flex-col md:flex-row items-center gap-1 md:gap-3 px-3 py-2 md:px-4 md:py-3 rounded-2xl font-semibold text-xs md:text-sm transition min-w-[70px] text-center md:text-left
                    {{ request()->routeIs('client.payment.*') ? 'text-white bg-catOrange shadow-sm' : 'text-gray-400 md:text-gray-500 hover:text-catOrange hover:bg-orange-50' }}">
                    <i class="fa-solid fa-receipt text-lg md:text-xl"></i>
                    <span class="mt-0.5 md:mt-0">Transaksi</span>
                </a>

                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="md:hidden flex flex-col items-center gap-1 px-3 py-2 rounded-2xl font-semibold text-xs text-red-400 hover:text-red-500 transition min-w-[70px] text-center">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span class="mt-0.5">Keluar</span>
                </button>
            </nav>
        </div>

        <div class="hidden md:block pt-5 border-t border-gray-100 w-full">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="w-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white font-semibold text-sm px-4 py-3 rounded-2xl border border-red-100 transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </button>
        </div>
    </aside>

    <main class="flex-1 overflow-x-hidden pb-24 md:pb-0">
        <div class="container mx-auto px-4 py-6 md:py-8 max-w-6xl">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html>
