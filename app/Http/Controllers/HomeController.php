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

    public function getDataForEdit(Request $request)
    {
        if($request->ajax()){
            $karyawan = DB::table('karyawan')->where('id', $request->id)->get();
            return $karyawan;
        } 
        else{
            return "Don't have token";
        }
    }

    public function manipulasiData(Request $request)
    {
        if ($request->ajax()) {

            if($request->aksi === "tambah"){

                if($foto = $request->file('foto')){
                    $fotoNewName = time().'.'.$foto->getClientOriginalExtension();
                    $request->foto->move(public_path('img'), $fotoNewName);
                }
        
                $query = DB::table('karyawan')->insert([
                    'id' => $request->id,
                    'nama' => $request->nama,
                    'tmptlahir' => $request->tmptlahir,
                    'tgllahir' => $request->tgllahir,
                    'jabatan' => $request->jabatan,
                    'foto' => $fotoNewName
                ]);
        
                if($query){
                    return json_encode(array("statusCode" => 200));
                } else {
                    return json_encode(array("statusCode" => 201));
                }
            }

            elseif($request->aksi === "edit"){

                if ($request->file('foto') != null) {
                    $image_path = "img/$request->fotolama";
                    File::delete($image_path);
                    $fotoNewName = time().'.'.$request->file('foto')->getClientOriginalExtension();
                    $request->foto->move(public_path('img'), $fotoNewName);
                    $query = DB::table('karyawan')->where('id', $request->id)->update([
                        'nama' => $request->nama,
                        'tmptlahir' => $request->tmptlahir,
                        'tgllahir' => $request->tgllahir,
                        'jabatan' => $request->jabatan,
                        'foto' => $fotoNewName
                    ]);
                }
                else {
                    $query = DB::table('karyawan')->where('id', $request->id)->update([
                        'nama' => $request->nama,
                        'tmptlahir' => $request->tmptlahir,
                        'tgllahir' => $request->tgllahir,
                        'jabatan' => $request->jabatan,
                        'foto' => $request->fotolama
                    ]);
                }

                if($query){
                    return json_encode(array("statusCode" => 200));
                } else {
                    return json_encode(array("statusCode" => 201));
                }

            }

        } else {
            return "Dont have token";
        }
        
    }

    public function hapusData(Request $request)
    {
        if($request->ajax()){
            $selectdata = DB::table('karyawan')->where('id', $request->id)->first();
            $image_path = "img/$selectdata->foto";
            if (File::exists($image_path)) {
                File::delete($image_path);
                DB::table('karyawan')->where('id', $request->id)->delete();
                return json_encode(array("statusCode" => 200));
            }else {
                DB::table('karyawan')->where('id', $request->id)->delete();
                return json_encode(array("statusCode" => 201));
            }
        }
        else {
            return "Dont have token";
        }
    }
}
