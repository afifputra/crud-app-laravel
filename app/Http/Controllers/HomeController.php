<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

    public function getDataForEdit(Request $request)
    {
        if($request->ajax()){
            $karyawan = DB::table('karyawan')->where('id', $request->id)->get();
            return json_encode($karyawan);
        } 
        else{
            return "Don't have token";
        }
    }

    public function hapusData(Request $request)
    {
        if($request->ajax()){
            $image_path = asset("img/$request->foto");
            // return var_dump($image_path);
            $result = $request;
            // $result = DB::table('karyawan')->where('id', $request->id)->delete();
            // if (File::exists($image_path)) {
            //     File::delete($image_path);
            // }
            return json_encode($result);
        }
        else {
            return "Don't have token";
        }
    }
}
