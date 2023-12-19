<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Buku') }}
            </h2>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('buku.create') }}" class="btn-primary">
                    {{ __('Tambah Buku Baru') }}
                </a>
            @endif

            @auth
                <a href="{{ route('buku.myfavorites') }}" class="btn-secondary">
                    {{ __('Buku Favoritku') }}
                </a>
            @endauth

            <a href="{{ route('buku.populer') }}" class="btn-secondary">
                {{ __('Buku Populer') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($data_buku as $buku)
                    <div class="bg-white overflow-hidden rounded-lg border border-gray-200 shadow-md">
                        <div class="relative h-44">
                            @if($buku->filepath)
                                <img
                                    class="h-full w-full object-cover object-center"
                                    src="{{ asset($buku->filepath) }}"
                                    alt="{{ $buku->judul }}"
                                />
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ $buku->buku_seo ? route('galeri.buku', $buku->buku_seo) : '#' }}" class="text-xl font-medium text-gray-700">{{ $buku->judul }}</a>
                            <p class="text-gray-500">{{ $buku->penulis }}</p>
                            <p class="text-green-600 font-semibold mt-2">Rp. {{ number_format($buku->harga, 0, ',', '.') }}</p>
                            <p class="text-gray-500">{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('j F Y') }}</p>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <div class="flex justify-end mt-4">
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="post" id="delete-buku">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin mau dihapus?')" class="btn-delete mr-2">Hapus</button>
                                    </form>
                                    <a x-data="{ tooltip: 'Edit' }}" href="{{ route('buku.edit', $buku->id) }}" class="btn-primary">
                                        Edit
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $data_buku->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
