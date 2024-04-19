<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiTokens = ApiToken::latest()->get();
        return view('api-token.index', compact('apiTokens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api_token = Str::random(60);
        ApiToken::create([
            'client_code' => Str::random(10),
            'api_token' => $api_token,
        ]);
        return redirect()->back()->with('success','Berhasil menambahkan api token baru, token: '.$api_token);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiToken  $apiToken
     * @return \Illuminate\Http\Response
     */
    public function show(ApiToken $apiToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApiToken  $apiToken
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiToken $apiToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiToken  $apiToken
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api_token = Str::random(60);
        ApiToken::find($id)->update([
            'api_token' => $api_token,
        ]);
        return redirect()->back()->with('success','Berhasil mereset api token baru, token: '.$api_token);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiToken  $apiToken
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $apiToken = ApiToken::find($id);
        $apiToken->delete();
        return redirect()->back()->with('success','Berhasil menghapus api token : '.$apiToken->api_token);
    }
}
