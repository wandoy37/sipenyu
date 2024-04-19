<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('admin')->only('index', 'create', 'store', 'destroy');
    }


    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
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
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|unique:users',
                'role' => 'required',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ],
            [],
        );

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'remember_token' => Str::random(10),
            ]);
            return redirect()->route('pengguna.index')->with('success', $request->username . ' berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('pengguna.index')->with('fails', $request->username . ' gagal ditambahkan.');
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
        $user = User::find($id);
        return view('user.edit', compact('user'));
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
        $user = User::find($id);
        // Validator
        if ($request->password) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'username' => 'required|unique:users,username,' . $user->id,
                    'email' => 'required|unique:users,email,' . $user->id,
                    'password' => 'required|confirmed|min:6',
                    'password_confirmation' => 'required',
                ],
                [],
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'username' => 'required|unique:users,username,' . $user->id,
                    'email' => 'required|unique:users,email,' . $user->id,
                ],
                [],
            );
        }

        // If validator fails.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If validator success
        DB::beginTransaction();
        try {
            $dataPengguna = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $dataPengguna['password'] = Hash::make($request->password);
            } else {
                $dataPengguna['password'] = $user->password;
            }

            if (Auth::user()->role == 'admin') {
                $dataPengguna['role'] = $request->role;
            } else {
                $dataPengguna['role'] = $user->role;
            }


            $user->update($dataPengguna);

            if (Auth::user()->role == 'admin') {
                return redirect()->route('pengguna.index')->with('success', $request->username . ' berhasil diupdate.');
            } else {
                return redirect()->route('pengguna.edit', $user->id)->with('success', $request->username . ' berhasil diupdate.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if (Auth::user()->role == 'admin') {
                return redirect()->route('pengguna.index')->with('fails', $request->username . ' gagal diupdate.');
            } else {
                return redirect()->route('pengguna.edit', $user->id)->with('fails', $user->username . ' gagal diupdate.');
            }
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
        $user = User::find($id);
        DB::beginTransaction();
        try {
            $user->delete($user);
            return redirect()->route('pengguna.index')->with('success', $user->username . ' telah dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('pengguna.index')->with('fails', $user->username . ' gagal dihapus');
        } finally {
            DB::commit();
        }
    }
}
