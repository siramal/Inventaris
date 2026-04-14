@extends('layouts.app   ')

@section('title', 'Operator Accounts Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{!! session('success') !!}</span>
            </div>
        @endif

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Operator Accounts Table</h2>
                <p class="text-gray-500 text-sm mt-1">Add, delete, update <span
                        class="text-pink-500">.operator-accounts</span></p>
                <p class="text-gray-400 text-xs mt-1">
                    <span class="text-pink-400">p.s password</span> 4 character of email and nomor.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.operator.create') }}"
                    class="bg-[#20c997] hover:bg-[#1ba87e] text-white font-medium py-2 px-6 rounded transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-[#050A30]">
                        <th class="py-4 px-6 font-medium">#</th>
                        <th class="py-4 px-6 font-medium">Name</th>
                        <th class="py-4 px-6 font-medium">Email</th>
                        <th class="py-4 px-6 font-medium text-center">Action</th>
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

                                    <form action="{{ route('admin.users.operator.reset', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Reset password operator ini ke default?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="column_number" value="{{ $loop->iteration }}">

                                        <button type="submit"
                                            class="bg-[#ffb848] hover:bg-[#e6a641] text-[#050A30] py-2 px-4 rounded text-sm font-medium transition shadow-sm">
                                            Reset Password
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.operator.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus operator ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-[#f56565] hover:bg-[#e53e3e] text-white py-2 px-5 rounded text-sm font-medium transition shadow-sm">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 italic">No operator accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
