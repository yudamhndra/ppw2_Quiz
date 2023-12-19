<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden rounded-lg shadow-md m-5">
                <section id="album" class="py-4 text-center bg-light">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold mb-4">{{ $bukus->judul }}</h2>
                        <hr class="my-2">

                        @auth
                            <form method="post" action="{{ route('buku.favorite', ['id' => $bukus->id]) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save to Favorites</button>
                            </form>
                        @endauth

                        <!-- Rating Section -->
                        <div class="flex items-center mb-4">
                            <p class="text-xl font-semibold mr-2">Rating:</p>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $bukus->rating)
                                        <svg fill="gold" class="w-5 h-5 text-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 2a1 1 0 0 1 .773.37l1.94 2.497 4.81.556a1 1 0 0 1 .554 1.705l-3.53 3.428.83 4.874a1 1 0 0 1-1.451 1.054L10 14.666l-4.315 2.26a1 1 0 0 1-1.45-1.055l.83-4.874-3.53-3.428a1 1 0 0 1 .554-1.705l4.81-.556L9.227 2.37A1 1 0 0 1 10 2z"/>
                                        </svg>
                                    @else
                                        <svg fill="gray" class="w-5 h-5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 2a1 1 0 0 1 .773.37l1.94 2.497 4.81.556a1 1 0 0 1 .554 1.705l-3.53 3.428.83 4.874a1 1 0 0 1-1.451 1.054L10 14.666l-4.315 2.26a1 1 0 0 1-1.45-1.055l.83-4.874-3.53-3.428a1 1 0 0 1 .554-1.705l4.81-.556L9.227 2.37A1 1 0 0 1 10 2z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-lg font-semibold ml-2">{{ number_format($bukus->rating, 1) }}</p>
                        </div>

                        <!-- Image Gallery Section -->
                        <div class="flex flex-wrap gap-4 overflow-x-auto">
                            @foreach($bukus->galleries as $gallery)
                                <div class="flex-shrink-0 flex flex-col items-center rounded-md bg-white m-2 p-4">
                                    <a href="{{ asset($gallery->path) }}" data-lightbox="image-1" data-title="{{ $gallery->keterangan }}">
                                        <img src="{{ asset($gallery->path) }}" class="w-48 h-32 object-cover rounded-md" alt="{{ $gallery->nama_galeri }}">
                                    </a>
                                    <p class="mt-2 text-sm">{{ $gallery->nama_galeri }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Rating Form -->
                        <form method="post" action="{{ route('buku.rate', ['id' => $bukus->id]) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700">Submit Rating:</label>
                                <select name="rating" id="rating" class="mt-1 block w-1/4">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit Rating</button>
                        </form>

                    </div>
                </section>

                <form action="{{ route('buku.submitReview', ['bukuId' => $buku->id]) }}" method="post">
                    @csrf
                    <label for="review">Review:</label>
                    <textarea name="review" id="review" rows="4" cols="50"></textarea>
                    <button type="submit">Submit Review</button>
                </form>

                <h2>Review</h2>
                @foreach($reviews as $review)
                    <p>{{ $review->review }}</p>
                @endforeach


                <a href="{{ route('buku.index') }}" class="inline-block px-4 py-2 border border-blue-500 text-blue-500 bg-blue-100 rounded mt-4">
                    {{ __('Kembali ke Daftar Buku') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
