<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Buku;  
use App\Models\Gallery;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\FavoriteBook;

class ControllerBuku extends Controller
{


    
    public function index(){
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id','desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);
        $total_harga = Buku::sum('harga');
        return view('buku.index', compact('data_buku', 'no', 'total_harga','jumlah_buku'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $batas = 5;
        
        $data_buku = Buku::where('judul', 'like', '%' . $search . '%')
            ->orWhere('penulis', 'like', '%' . $search . '%')
            ->orWhere('harga', 'like', '%' . $search . '%')
            ->orWhere('tgl_terbit', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->paginate($batas);

        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = Buku::sum('harga');
        $jumlah_buku = $data_buku->count();

        return view('buku.index', compact('data_buku', 'no', 'total_harga', 'jumlah_buku'));
    }

    public function create() {
        $buku = new Buku; 
        return view('buku.create', compact('buku'));
    }

    public function store(Request $request) {
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);
    
        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
            'buku_seo' => Str::slug($request->judul, '-'),
        ]);
    
        if ($request->hasFile('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
    
            Image::make(storage_path().'/app/public/uploads/'.$fileName)
                ->fit(240,320)
                ->save();
    
            $buku->update([
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ]);
        }
    
        if ($request->file('gallery')) {
            foreach ($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
    
                $gallery = Gallery::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/' . $filePath,
                    'foto' => $fileName,
                    'buku_id' => $buku->id
                ]);
            }
        }
    
        return redirect('/buku')->with('pesan', 'Buku baru berhasil ditambahkan');
    }
    
    

    public function destroy($id) {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku');
    }

    public function edit($id) {
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id ) {
        $buku = Buku::find($id);
    
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);
    
        if ($request->hasFile('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
    
            Image::make(storage_path().'/app/public/uploads/'.$fileName)
                ->fit(240,320)
                ->save();
    
            $buku->update([
                'judul'     => $request->judul,
                'penulis'   => $request->penulis,
                'harga'     => $request->harga,
                'tgl_terbit'=> $request->tgl_terbit,
                'filename'  => $fileName,
                'filepath'  => '/storage/' . $filePath
            ]);
        }
    
        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
    
                $gallery = Gallery::create([
                    'nama_galeri'   => $fileName,
                    'path'          => '/storage/' . $filePath,
                    'foto'          => $fileName,
                    'buku_id'       => $id
                ]);
            }
        }
    
        return redirect('/buku')->with('pesan', 'Perubahan Data Buku Berhasil di Simpan');
    }

    public function deleteGallery($bukuId, $galleryId)
    {
        $buku = Buku::findOrFail($bukuId);
        $gallery = $buku->galleries()->findOrFail($galleryId);
        $gallery->delete();
    
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    public function galeri_buku($title)
    {
        $bukus = Buku::where('buku_seo', $title)->first();

        $galeries = $bukus->galleries()->orderBy('id', 'desc')->paginate(5);
        return view ('buku.detail_buku', compact('bukus', 'galeries'));
    }

    public function rateBuku(Request $request, $id) {
        $this->validate($request, [
            'rating' => 'required|integer|between:1,5',
        ]);
    
        $buku = Buku::find($id);
        $currentRating = $buku->rating ?? 0;
        $currentCount = $buku->rating_count ?? 0;
    
        // Calculate new average rating
        $newRating = ($currentRating * $currentCount + $request->rating) / ($currentCount + 1);
    
        // Update book's rating and rating_count
        $buku->update([
            'rating' => $newRating,
            'rating_count' => $currentCount + 1,
        ]);

        return redirect()->back()->with('success', 'Rating submitted successfully');
    
        // return redirect()->route('galeri.buku', ['buku_seo' => $buku->buku_seo])->with('pesan', 'Rating submitted successfully');


    }


    public function addToFavorites(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->favoriteBooks()->where('book_id', $id)->exists()) {
            $user->favoriteBooks()->create(['book_id' => $id]);
        }

        return redirect()->back()->with('success', 'Book added to favorites');
    }

    public function myFavorites()
    {
        $user = auth()->user();
        $favoriteBooks = $user->favoriteBooks()->with('book')->get();

        return view('buku.my_favorites', compact('favoriteBooks'));
    }

    
}
