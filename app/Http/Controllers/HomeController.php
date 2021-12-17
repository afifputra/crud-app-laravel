<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function tampilkanData()
    {
        // ambil data dari db
        $employee = DB::table('karyawan')->get();
        // mengirim data ke view
        return view('karyawan',['karyawan' => $employee]);
    }

    public function tambahData(Request $request)
    {

        if($foto = $request->file('foto')){
            $fotoExt = time().'.'.$foto->getClientOriginalExtension();
            $request->foto->move(public_path('img'), $fotoExt);
        }

        DB::table('karyawan')->insert([
            'id' => $request->id,
            'nama' => $request->nama,
            'tmptlahir' => $request->tmptlahir,
            'tgllahir' => $request->tgllahir,
            'jabatan' => $request->jabatan,
            'foto' => $fotoExt
        ]);
        return redirect('/home');
    }

    public function getDataForEdit($id)
    {
        $employee = DB::table('karyawan')->where('id', $id)->get();
        return view('edit',['karyawan' => $employee]);
    }
}
