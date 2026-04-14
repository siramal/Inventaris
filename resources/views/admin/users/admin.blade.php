@extends('layouts.app')

@section('title', 'Admin Accounts Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm transition-all">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Admin Accounts Table</h2>
                <p class="text-gray-500 text-sm mt-1">Add, delete, update <span class="text-pink-500">.admin-accounts</span>
                </p>
                <p class="text-gray-400 text-xs mt-1"><span class="text-pink-400">p.s password</span> 4 character of email and
                    nomor.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.users.admin.export') }}"
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-medium py-2 px-6 rounded transition">
                    Export Excel
                </a>

                <a href="{{ route('admin.users.admin.create') }}"
                    class="bg-[#20c997] hover:bg-[#1ba87e] text-white font-medium py-2 px-6 rounded transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Add
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-4 px-6 text-[#050A30] font-medium">#</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Name</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Email</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 bg-[#f8f9fa] hover:bg-gray-100 transition">
                            <td class="py-5 px-6 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="py-5 px-6 text-gray-700 capitalize">{{ $user->name }}</td>
                            <td class="py-5 px-6 text-gray-700">{{ $user->email }}</td>
                            <td class="py-5 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.users.admin.edit', $user->id) }}"
                                        class="bg-[#6f42c1] hover:bg-[#59339e] text-white py-1 px-5 rounded text-sm transition shadow-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.admin.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this account?')">
                                        @csrf
                                        @method('DELETE') <button type="submit"
                                            class="bg-[#f56565] hover:bg-[#e53e3e] text-white py-1 px-5 rounded text-sm transition shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 italic">
                                No admin accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
