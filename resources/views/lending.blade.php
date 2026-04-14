<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - SMK Wikrama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        wikrama: '#253E8D',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-gray-800">

    <nav class="bg-white py-4 px-10 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center">
            <img src="{{ asset('assets/images/logowk.png') }}" alt="Wikrama Logo" class="h-12">
        </div>
        <button onclick="toggleModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-md font-semibold transition">
            Login
        </button>
    </nav>

    <header class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
            Inventaris Management of <br> SMK Wikrama
        </h1>
        <p class="text-gray-500 text-lg mb-10">
            Management of incoming and outgoing items at SMK Wikrama Bogor.
        </p>

        <div class="flex justify-center">
            <img src="{{ asset('assets/images/lending1.png') }}" alt="Inventory Illustration"
                class="w-full max-w-2xl drop-shadow-xl">
        </div>
    </header>

    <section class="bg-white py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Our system flow</h2>
                <p class="text-gray-400 mt-2">Our inventory system workflow</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group cursor-pointer">
                    <div
                        class="bg-[#000830] h-64 rounded-xl flex items-center justify-center mb-4 transition group-hover:scale-105 shadow-lg">
                        <i class="fas fa-database text-white text-6xl"></i>
                    </div>
                    <h3 class="text-center font-bold text-lg">Items Data</h3>
                </div>

                <div class="group cursor-pointer">
                    <div
                        class="bg-orange-400 h-64 rounded-xl flex items-center justify-center mb-4 transition group-hover:scale-105 shadow-lg">
                        <i class="fas fa-tools text-white text-6xl"></i>
                    </div>
                    <h3 class="text-center font-bold text-lg">Management Technician</h3>
                </div>

                <div class="group cursor-pointer">
                    <div
                        class="bg-blue-200 h-64 rounded-xl flex items-center justify-center mb-4 transition group-hover:scale-105 shadow-lg">
                        <i class="fas fa-hand-holding-heart text-blue-700 text-6xl"></i>
                    </div>
                    <h3 class="text-center font-bold text-lg">Managed Lending</h3>
                </div>

                <div class="group cursor-pointer">
                    <div
                        class="bg-emerald-400 h-64 rounded-xl flex items-center justify-center mb-4 transition group-hover:scale-105 shadow-lg">
                        <i class="fas fa-users text-white text-6xl"></i>
                    </div>
                    <h3 class="text-center font-bold text-lg">All Can Borrow</h3>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-50 pt-20 pb-10 border-t border-gray-200">
        <div class="container mx-auto px-10 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <img src="{{ asset('assets/images/logowk.png') }}" alt="Logo" class="h-12 mb-4">
                <p class="text-gray-500">smkwikrama.sch.id</p>
                <p class="text-gray-500">021-7878-2875</p>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4 text-slate-900">Our Guidelines</h4>
                <ul class="text-gray-500 space-y-2">
                    <li><a href="#" class="hover:text-blue-500">Terms</a></li>
                    <li><a href="#" class="text-red-400 hover:text-red-600 font-medium">Privacy policy</a></li>
                    <li><a href="#" class="hover:text-blue-500">Cookie Policy</a></li>
                    <li><a href="#" class="hover:text-blue-500">Discover</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4 text-slate-900">Our address</h4>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    Jalan Wangun Tengah, Sindangsari,<br>
                    Bogor Timur, Kota Bogor,<br>
                    Jawa Barat
                </p>
                <div class="flex gap-4 text-gray-400 text-xl">
                    <a href="#" class="hover:text-blue-600 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-pink-500 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-blue-700 transition"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center mt-16 text-gray-400 text-sm">
            &copy; 2026 SMK Wikrama Bogor. All rights reserved.
        </div>
    </footer>
    <div id="loginModal"
        class="fixed inset-0 z-[99] {{ $errors->any() ? 'flex' : 'hidden' }} items-center justify-center bg-black bg-opacity-50 overflow-y-auto px-4">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-8 transform transition-all relative">

            @if ($errors->has('loginError'))
                <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('loginError') }}
                </div>
            @endif

            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Login</h2>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-6 relative">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-100' }} bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8 relative">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" id="passwordField" placeholder="Password"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-100' }} bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="toggleModal()"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-md transition">
                        Close
                    </button>
                    <button type="submit"
                        class="flex-1 bg-emerald-400 hover:bg-emerald-500 text-white font-bold py-3 rounded-md transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('loginModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.replace('hidden', 'flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.replace('flex', 'hidden');
                document.body.style.overflow = 'auto';

                // Opsional: Hapus pesan error saat modal ditutup manual
                window.location.href = "{{ route('landing') }}";
            }
        }

        // Auto-show jika ada error (Server Side Check)
        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->any())
                // Modal sudah terbuka via class PHP di atas, 
                // kita hanya pastikan body overflow terkunci.
                document.body.style.overflow = 'hidden';
            @endif
        });
    </script>
</body>

</html>
