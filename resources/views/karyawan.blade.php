<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
        <title>CRUD App</title>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col">
                    <h4>
                        CRUD APP
                    </h4>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row mb-3 justify-content-center">
                    <div class="col">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal" id="tambah">Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <table id="dataKaryawan" class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tempat, Tanggal Lahir</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modal Tambah Edit Data -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div id="success" class="alert alert-success alert-dismissible" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                    </div>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="textTambah">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/home/manipulasidata" method="post" enctype="multipart/form-data" id="formTambah">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <label for="nama">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="tmptlahir">Tempat Lahir</label>
                                <input id="tmptlahir" name="tmptlahir" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"> 
                                <label for="tgllahir">Tanggal Lahir</label>
                                <input id="tgllahir" name="tgllahir" type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="jabatan">Jabatan</label>
                                <input id="jabatan" name="jabatan" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                <label for="foto">Foto</label>
                                <input id="foto" name="foto" type="file" class="form-control">
                                <input type="hidden" name="aksi" id="aksi" value="">
                                <input type="hidden" name="fotolama" id="foto-lama">
                            </div>
                            <div class="modal-footer">
                                <button type="close" name="close" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="submit" id="btn-tambah" value="Save to database" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Modal Hapus -->
            <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda Yakin untuk Menghapus Data ?</p>
                            <input type="hidden" name="id" id="id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" name="submit" id="btn-hapus" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{asset('js/script.js')}}"></script> 
    {{-- <script src="{{asset('js/datatables.js')}}"></script>  --}}
</html>