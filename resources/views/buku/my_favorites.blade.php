<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            MY Favorites
        </h2>
        <a href="{{ route('buku.index') }}" class="text-blue-500 hover:underline">Back to Books</a>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4">
       

        @if ($favoriteBooks->isEmpty())
            <p class="text-gray-600">You haven't added any books to your favorites yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($favoriteBooks as $favoriteBook)
                    <div class="bg-white shadow-md p-4 rounded-md">
                        @if ($favoriteBook->book->filepath)
                            <img src="{{ asset($favoriteBook->book->filepath) }}" alt="{{ $favoriteBook->book->judul }}" class="w-full h-40 object-cover mb-4 rounded-md">
                        @endif
                        <h3 class="text-xl font-semibold">{{ $favoriteBook->book->judul }}</h3>
                        <p class="text-gray-600">{{ $favoriteBook->book->penulis }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
