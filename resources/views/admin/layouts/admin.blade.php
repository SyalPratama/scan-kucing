<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - AnabulID')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        catOrange: '#FF9F43',
                        catSoft: '#FFF4EB',
                        catDark: '#2D3748'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .custom-swal-popup {
            border-radius: 1.5rem !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-catSoft text-catDark antialiased min-h-screen flex">
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-orange-100 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between">
        <div class="p-6">
            <!-- Logo / Brand -->
            <div class="flex items-center gap-3 px-2 mb-8">
                <div
                    class="bg-orange-50 w-10 h-10 rounded-2xl flex items-center justify-center text-catOrange text-xl shadow-sm">
                    <i class="fa-solid fa-cat"></i>
                </div>
                <div>
                    <h2 class="font-bold text-lg leading-none">AnabulID</h2>
                    <span class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Admin Panel</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium {{ Route::is('admin.dashboard') ? 'text-catOrange bg-orange-50 font-bold' : 'text-gray-500 hover:text-catOrange hover:bg-orange-50' }} rounded-2xl transition">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
                </a>

                <a href="{{ route('admin.data-user') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium {{ Route::is('admin.data-user*') ? 'text-catOrange bg-orange-50 font-bold' : 'text-gray-500 hover:text-catOrange hover:bg-orange-50' }} rounded-2xl transition">
                    <i class="fa-solid fa-users w-5 text-center"></i> Data User
                </a>

                <a href="{{ route('admin.data-kucing') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium {{ Route::is('admin.data-kucing*') || Route::is('client.data-kucing*') ? 'text-catOrange bg-orange-50 font-bold' : 'text-gray-500 hover:text-catOrange hover:bg-orange-50' }} rounded-2xl transition">
                    <i class="fa-solid fa-paw w-5 text-center"></i> Data Kucing
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar / Info Akun -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50 m-4 rounded-2xl flex items-center justify-between">
            <div class="flex items-center gap-2 min-w-0">
                <div
                    class="w-8 h-8 bg-catOrange rounded-xl flex items-center justify-center text-white text-xs font-bold shadow-sm select-none">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold truncate">{{ auth()->user()->name }}</p>

                    <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-gray-400 hover:text-red-500 transition text-sm pl-2" title="Logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-catDark/20 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
        <header
            class="bg-white/80 backdrop-blur-md border-b border-orange-50 sticky top-0 z-20 px-6 py-4 flex items-center justify-between lg:justify-end">
            <button onclick="toggleSidebar()"
                class="lg:hidden w-10 h-10 bg-gray-50 hover:bg-orange-50 text-gray-600 hover:text-catOrange rounded-xl flex items-center justify-center transition">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <div class="text-xs text-gray-400 font-medium hidden sm:block">
                <i class="fa-solid fa-calendar-days mr-1"></i> {{ now()->translatedFormat('d F Y') }}
            </div>
        </header>

        <!-- 3. DYNAMIC CONTENT AREA -->
        <main class="p-6 sm:p-8 flex-1 max-w-6xl w-full mx-auto">
            @yield('content')
        </main>

        <!-- 4. GLOBAL FOOTER -->
        <footer
            class="mt-auto py-4 px-8 border-t border-orange-100 bg-white/50 text-center text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} AnabulID. All rights reserved. Dev Panel v1.0
        </footer>
    </div>

    <!-- GLOBAL JAVASCRIPT -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>

</html>
