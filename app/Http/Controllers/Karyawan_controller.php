<?php

namespace App\Http\Controllers;

use App\Models\M_karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class Karyawan_controller extends Controller
{
    public function index(){
        return view('karyawan');
    }

    public function yajra(Request $request){
        $columns = array( 
            0 => 'id', 
            1 => 'nama',
            2 => 'tmptlahir',
            3 => 'jabatan',
            4 => 'foto',
            5 => 'id',
        );

        $querycount = DB::table('karyawan_new')->select(DB::raw('count(id) as jumlah'))->get();

        $totalData = $querycount['0']->jumlah;
        
        $totalFiltered = strval($totalData);
        
        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request['order']['0']['column']];
        $dir = $request['order']['0']['dir'];
        if(empty($request['search']['value'])) {
            $query = DB::table('karyawan_new')->select(['*'])
                                                ->orderBy($order, $dir)
                                                ->limit($limit)
                                                ->offset($start)
                                                ->get();
        } 
        else {
            $search = $request['search']['value'];
            $query = DB::table('karyawan_new')->select(['*'])
                                                ->where('nama', 'like', "%{$search}%")
                                                ->orderBy($order, $dir)
                                                ->limit($limit)
                                                ->offset($start)->get();
            
                                              
            $querycount = DB::table('karyawan_new')->where('nama', 'LIKE', "%{$search}%")->count();
            
            $totalFiltered = $querycount;
        }

        $data = [];
        if (!empty($query)) {
            $no = $start +1;
            foreach ($query as $row){
                $nestedData['no'] = $no;
                $nestedData['nama'] = $row->nama;
                $nestedData['tmptlahir'] = $row->tmptlahir.', '.date('d F Y', strtotime($row->tgllahir));
                $nestedData['jabatan'] = $row->jabatan;
                $nestedData['foto'] = "<img src='img/".$row->foto."'>";
                $nestedData['action'] = "
                <a id='edit' type='button' data-bs-target='#tambahModal' data-bs-toogle='modal' data-action='edit' data-id='".$row->id."' class='btn btn-sm btn-outline-primary edit' data-placement='bottom'>
                        Edit
                    </a>
                <a id='hapus' type='button' data-bs-target='#hapusModal' data-bs-toogle='modal' data-action='hapus'  data-id='".$row->id."' class='btn btn-sm btn-outline-danger hapus' data-placement='bottom'>
                    Hapus
                </a>
                ";
                $data[] = $nestedData;
                $no++;
            }
        }

        $json_data = array(
            "draw"            => intval($request['draw']),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data  
            );
     
        echo json_encode($json_data);
    }

    public function getDataForEdit(Request $request)
    {
        if($request->ajax()){
            $karyawan = DB::table('karyawan_new')->where('id', $request->id)->get();
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
        
                $query = DB::table('karyawan_new')->insert([
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
                    $query = DB::table('karyawan_new')->where('id', $request->id)->update([
                        'nama' => $request->nama,
                        'tmptlahir' => $request->tmptlahir,
                        'tgllahir' => $request->tgllahir,
                        'jabatan' => $request->jabatan,
                        'foto' => $fotoNewName
                    ]);
                }
                else {
                    $query = DB::table('karyawan_new')->where('id', $request->id)->update([
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
            $selectdata = DB::table('karyawan_new')->where('id', $request->id)->first();
            $image_path = "img/$selectdata->foto";
            if (File::exists($image_path)) {
                File::delete($image_path);
                DB::table('karyawan_new')->where('id', $request->id)->delete();
                return json_encode(array("statusCode" => 200));
            }else {
                DB::table('karyawan_new')->where('id', $request->id)->delete();
                return json_encode(array("statusCode" => 201));
            }
        }
        else {
            return "Dont have token";
        }
    }
}
