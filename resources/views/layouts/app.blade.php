<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SMK Wikrama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased overflow-hidden flex h-screen">

    <aside class="w-64 bg-[#253E8D] text-white flex flex-col flex-shrink-0 shadow-xl z-20">
        <div class="py-6 px-4">
            <p class="text-xs text-gray-300 font-semibold mb-4 uppercase tracking-wider">Menu</p>
            @php
                $dashboardRoute = Auth::user()->role === 'admin' ? 'admin.dashboard' : 'operator.lending.index';
            @endphp
            <a href="{{ route($dashboardRoute) }}"
                class="flex items-center gap-3 {{ request()->routeIs('*.dashboard') ? 'bg-blue-800 text-white' : 'text-gray-300 hover:text-white hover:bg-blue-800' }} px-4 py-3 rounded-lg font-medium transition">
                <i class="fa-solid fa-table-cells w-5 text-center"></i>
                Dashboard
            </a>
        </div>

        <div class="py-2 px-4">
            <p class="text-xs text-gray-300 font-semibold mb-4 uppercase tracking-wider">Items Data</p>

            {{-- Menu Categories: Hanya Admin --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.categories') }}"
                    class="flex items-center gap-3 {{ request()->is('admin/categories*') ? 'bg-blue-800 text-white' : 'text-gray-300 hover:text-white hover:bg-blue-800' }} px-4 py-3 rounded-lg font-medium transition mb-2">
                    <i class="fa-solid fa-list w-5 text-center"></i>
                    Categories
                </a>
            @endif

            {{-- Menu Items: Admin & Operator --}}
            @php
                $itemsRoute = Auth::user()->role === 'admin' ? 'admin.items' : 'operator.items';
            @endphp
            <a href="{{ route($itemsRoute) }}"
                class="flex items-center gap-3 {{ request()->is('*/items*') ? 'bg-blue-800 text-white' : 'text-gray-300 hover:text-white hover:bg-blue-800' }} px-4 py-3 rounded-lg font-medium transition mb-2">
                <i class="fa-solid fa-cube w-5 text-center"></i>
                Items
            </a>

            {{-- Menu Lending: Hanya Operator --}}
            @if(Auth::user()->role === 'operator')
                <a href="{{ route('operator.lending.index') }}"
                    class="flex items-center gap-3 {{ request()->is('*/lending*') ? 'bg-blue-800 text-white' : 'text-gray-300 hover:text-white hover:bg-blue-800' }} px-4 py-3 rounded-lg font-medium transition">
                    <i class="fa-solid fa-hand-holding-box w-5 text-center"></i>
                    Lending
                </a>
            @endif
        </div>

        {{-- Section Accounts: Hanya Admin --}}
        @if(Auth::user()->role === 'admin')
            <div class="py-6 px-4">
                <p class="text-xs text-gray-300 font-semibold mb-4 uppercase tracking-wider">Accounts</p>
                <div>
                    <button onclick="toggleUsersMenu()"
                        class="w-full flex items-center justify-between {{ request()->is('admin/users*') ? 'bg-blue-800 text-white' : 'text-gray-300 hover:text-white hover:bg-blue-800' }} px-4 py-3 rounded-lg font-medium transition focus:outline-none">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-user w-5 text-center"></i>
                            Users
                        </div>
                        <i id="usersMenuIcon"
                            class="fa-solid {{ request()->is('admin/users*') ? 'fa-chevron-down' : 'fa-chevron-right' }} text-xs transition-transform duration-200"></i>
                    </button>

                    <div id="usersSubMenu" class="{{ request()->is('admin/users*') ? '' : 'hidden' }} mt-2 space-y-1 pb-2">
                        <a href="{{ route('admin.users.admin') }}"
                            class="flex items-center gap-3 {{ request()->is('admin/users/admin*') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} px-4 py-2 rounded-lg transition pl-12">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            <span>Admin</span>
                        </a>
                        <a href="{{ route('admin.users.operator') }}"
                            class="flex items-center gap-3 {{ request()->is('admin/users/operator*') ? 'text-white font-bold' : 'text-gray-400 hover:text-white' }} px-4 py-2 rounded-lg transition pl-12">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            <span>Operator</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </aside>

    <div class="flex-1 flex flex-col relative h-screen overflow-hidden">

        <header class="h-64 bg-cover bg-center relative"
            style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="relative z-10 flex justify-between items-center px-8 py-6 text-white">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/logowk.png') }}" alt="Logo"
                            class="h-10 w-10 bg-white rounded-full p-1">
                        <h1 class="text-xl font-bold tracking-wide">Welcome Back, {{ Auth::user()->name }}</h1>
                    </div>
                </div>
                <div class="text-lg font-medium">{{ \Carbon\Carbon::now()->format('d F, Y') }}</div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto no-scrollbar relative z-20 px-8 pb-8 -mt-24">
            <div class="bg-white rounded-md shadow-lg p-4 flex justify-between items-center mb-6">
                <p class="text-gray-700 font-medium pl-4">Dashboard > @yield('breadcrumb', 'Home')</p>

                <div class="relative inline-block text-left">
                    <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none pr-4">
                        <div
                            class="w-10 h-10 rounded-full border-2 border-gray-800 flex items-center justify-center bg-gray-100 overflow-hidden">
                            <i class="fa-regular fa-user text-xl text-gray-800"></i>
                        </div>
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}
                            ({{ ucfirst(Auth::user()->role) }})</span>
                        <i class="fa-solid fa-chevron-down text-gray-500 text-sm ml-2"></i>
                    </button>

                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-3 w-48 bg-white rounded-md shadow-xl z-50 py-2 border border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 flex items-center gap-3 transition">
                                <i class="fa-solid fa-arrow-right-from-bracket text-blue-500"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }
        function toggleUsersMenu() {
            const sub = document.getElementById('usersSubMenu');
            const icon = document.getElementById('usersMenuIcon');
            sub.classList.toggle('hidden');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-right');
        }
        window.onclick = function (event) {
            if (!event.target.closest('.relative.inline-block')) {
                const d = document.getElementById('profileDropdown');
                if (d) d.classList.add('hidden');
            }
        }
    </script>
</body>

</html>