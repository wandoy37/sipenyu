<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\uptd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ResizeImage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Produk::latest()->get();
        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $uptd = uptd::find($id);
        return view('produk.create', compact('uptd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'harga' => 'required',
                'satuan' => 'required',
                'keterangan' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'title.required' => 'Produk wajib diisi.',
                'harga.required' => 'Harga wajib diisi.',
                'satuan.required' => 'Satuan wajib diisi.',
                'keterangan.required' => 'Keterangan wajib diisi.',
                'thumbnail.required' => 'Thumbnail wajib diisi.',
                'thumbnail.image' => 'Thumbnail berupa gambar.',
                'thumbnail.mimes' => 'Thumbnail harus berupa jpeg,png,jpg.',
                'thumbnail.max' => 'Thumbnail Maksimal 2mb',
            ],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            // Process Uploads
            $path = public_path('produk/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $name = time() . '.' . $request->thumbnail->extension();
            ResizeImage::make($request->file('thumbnail'))
                ->resize(1280, 720)
                ->save($path . $name);

            Produk::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
                'thumbnail' => $name,
                'uptd_id' => $request->uptd,
            ]);

            return redirect()->route('daftar.uptd.index')->with('success', 'Produk baru berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('daftar.uptd.index')->with('fails', 'Produk baru gagal ditambahkan.');
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Produk::find($id);
        return view('produk.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validator
        if ($request['thumbnail']) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'harga' => 'required',
                    'satuan' => 'required',
                    'keterangan' => 'required',
                    'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'title.required' => 'Produk wajib diisi.',
                    'harga.required' => 'Harga wajib diisi.',
                    'satuan.required' => 'Satuan wajib diisi.',
                    'keterangan.required' => 'Keterangan wajib diisi.',
                    'thumbnail.required' => 'Thumbnail wajib diisi.',
                    'thumbnail.image' => 'Thumbnail berupa gambar.',
                    'thumbnail.mimes' => 'Thumbnail harus berupa jpeg,png,jpg.',
                    'thumbnail.max' => 'Thumbnail Maksimal 2mb',
                ],
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'harga' => 'required',
                    'satuan' => 'required',
                    'keterangan' => 'required',
                ],
                [
                    'title.required' => 'Produk wajib diisi.',
                    'harga.required' => 'Harga wajib diisi.',
                    'satuan.required' => 'Satuan wajib diisi.',
                    'keterangan.required' => 'Keterangan wajib diisi.',
                ],
            );
        }

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            $product = Produk::find($id);
            // Process Uploads
            if ($request['thumbnail']) {
                $path = public_path('produk/');
                !is_dir($path) &&
                    mkdir($path, 0777, true);

                // delete old thumbnai
                $oldThumbnail = $product->thumbnail;
                File::delete($path . $oldThumbnail);

                $name = time() . '.' . $request->thumbnail->extension();
                ResizeImage::make($request->file('thumbnail'))
                    ->resize(1280, 720)
                    ->save($path . $name);
            }

            $product->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
                'thumbnail' => $name ?? $product->thumbnail,
            ]);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('produk.index')->with('fails', 'Produk gagal diupdate.');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Produk::find($id);
            $path = public_path('produk/');
            File::delete($path . $product->thumbnail);

            $product->delete($product);
            return redirect()->route('produk.index')->with('success', 'Produk ' . $product->title . ' telah dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('produk.index')->with('fails', 'Produk ' . $product->title . ' gagal dihapus.');
        } finally {
            DB::commit();
        }
    }
}
