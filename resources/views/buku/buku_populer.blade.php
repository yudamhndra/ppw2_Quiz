<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buku Populer') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($bukuPopuler as $buku)
                    <div class="bg-white overflow-hidden rounded-lg border border-gray-200 shadow-md">
                        <div class="relative h-44">
                            @if($buku->filepath)
                                <img
                                    class="h-full w-full object-cover object-center"
                                    src="{{ asset($buku->filepath) }}"
                                    alt="{{ $buku->judul }}"
                                />
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gray-300">
                                    <span class="text-gray-600">Gambar Tidak Tersedia</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ $buku->buku_seo ? route('galeri.buku', $buku->buku_seo) : '#' }}" class="text-xl font-medium text-gray-700 hover:underline">{{ $buku->judul }}</a>
                            <p class="text-gray-500">{{ $buku->penulis }}</p>
                            <p class="text-green-600 font-semibold mt-2">Rp. {{ number_format($buku->harga, 0, ',', '.') }}</p>
                            <p class="text-gray-500">{{ \Carbon\Carbon::parse($buku->tgl_terbit)->isoFormat('D MMMM YYYY') }}</p>
                            <div class="mt-4">
                                <span class="text-gray-600">Rating: {{ $buku->rating }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>