<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batik;

class BatikController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $batik = Batik::find($id);
        return view('batik.show', compact('batik'));
    }

    public function edit($id)
    {
        $batik = Batik::find($id);
        return view('batik.edit', compact('batik'));
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $batik = Batik::find($id);
        $batik->delete();
        return redirect()->route('batik.index');
    }
}
