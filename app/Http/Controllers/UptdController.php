<?php

namespace App\Http\Controllers;

use App\Models\uptd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ResizeImage;

class UptdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uptds = uptd::latest()->get();
        return view('uptd.index', compact('uptds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('uptd.create');
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
                'alamat' => 'required',
                'no_hp' => 'required',
                'keterangan' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'title.required' => 'Unit Pelayanan / UPTD wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'no_hp.required' => 'No HP wajib diisi.',
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
            $path = public_path('uptd/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $name = time() . '.' . $request->thumbnail->extension();
            ResizeImage::make($request->file('thumbnail'))
                ->resize(1920, 1080)
                ->save($path . $name);

            uptd::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'keterangan' => $request->keterangan,
                'thumbnail' => $name,
            ]);

            return redirect()->route('daftar.uptd.index')->with('success', 'Daftar UPTD baru berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('daftar.uptd.index')->with('fails', 'Daftar UPTD baru gagal ditambahkan.');
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
    public function edit($slug)
    {
        $uptd = uptd::where('slug', $slug)->first();
        return view('uptd.edit', compact('uptd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $uptd = uptd::where('slug', $slug)->first();
        // Validator
        if ($request['thumbnail']) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'alamat' => 'required',
                    'no_hp' => 'required',
                    'keterangan' => 'required',
                    'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'title.required' => 'Unit Pelayanan / UPTD wajib diisi.',
                    'alamat.required' => 'Alamat wajib diisi.',
                    'no_hp.required' => 'No HP wajib diisi.',
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
                    'alamat' => 'required',
                    'no_hp' => 'required',
                    'keterangan' => 'required',
                ],
                [
                    'title.required' => 'Unit Pelayanan / UPTD wajib diisi.',
                    'alamat.required' => 'Alamat wajib diisi.',
                    'no_hp.required' => 'No HP wajib diisi.',
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
            if ($request['thumbnail']) {
                // Process Uploads
                $path = public_path('uptd/');
                !is_dir($path) &&
                    mkdir($path, 0777, true);

                // delete old thumbnai
                $oldThumbnail = $uptd->thumbnail;
                File::delete($path . $oldThumbnail);

                $name = time() . '.' . $request->thumbnail->extension();
                ResizeImage::make($request->file('thumbnail'))
                    ->resize(1920, 1080)
                    ->save($path . $name);
            }

            $uptd->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'keterangan' => $request->keterangan,
                'thumbnail' => $name ?? $uptd->thumbnail,
            ]);

            return redirect()->route('daftar.uptd.index')->with('success', 'Daftar UPTD berhasil di uptade.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('daftar.uptd.index')->with('fails', 'Daftar UPTD gagal di uptade.');
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
    public function destroy($slug)
    {

        DB::beginTransaction();
        try {
            $uptd = uptd::where('slug', $slug)->first();
            $path = public_path('uptd/');
            File::delete($path . $uptd->thumbnail);

            $uptd->delete($uptd);
            return redirect()->route('daftar.uptd.index')->with('success', 'Daftar ' . $uptd->title . ' telah dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('daftar.uptd.index')->with('fails', 'Daftar ' . $uptd->title . ' gagal dihapus.');
        } finally {
            DB::commit();
        }
    }
}
