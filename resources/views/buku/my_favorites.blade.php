<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Buku Favorit
        </h2>
        <a href="{{ route('buku.index') }}" class="text-blue-500 hover:underline">Kembali ke Daftar Buku</a>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">

        @if ($favoriteBooks->isEmpty())
            <p class="text-gray-600">You haven't added any books to your favorites yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Judul</th>
                            <th class="py-2 px-4 border-b">Penulis</th>
                            <!-- Add more table headers as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($favoriteBooks as $favoriteBook)
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    @if ($favoriteBook->book->filepath)
                                        <img src="{{ asset($favoriteBook->book->filepath) }}" alt="{{ $favoriteBook->book->judul }}" class="w-20 h-12 object-cover rounded-md">
                                    @endif
                                    <span class="ml-2">{{ $favoriteBook->book->judul }}</span>
                                </td>
                                <td class="py-2 px-4 border-b">{{ $favoriteBook->book->penulis }}</td>
                                <!-- Add more table data cells as needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
