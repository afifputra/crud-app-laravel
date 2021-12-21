    $(document).ready(function() {
        $('#dataKaryawan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "./yajra",
        columns: [
            {data: 'no', name: 'no'},
            {data: 'nama', name: 'nama'},
            {data: 'tmptlahir', name: 'tmptlahir'},
            // {data: 'tgllahir', name: 'tgllahir'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'foto', name: 'foto'},
            {data: 'action', name: 'action'}
        ]
        });
    
    let myModal = new bootstrap.Modal($('#tambahModal'));
    let hapusModal = new bootstrap.Modal($('#hapusModal'));

    // Menampilkan Modal Tambah
    $("#tambah").click(function () {
        $('#textTambah').text('Tambah Data');
        $('#formTambah')[0].reset();
        $('button#btn-tambah').text('Tambah Data');
        $('#aksi').val("tambah");
    })

    // Menampilkan Modal Edit
    $("#dataKaryawan").on("click", '.edit' ,function() {
        myModal.show();
        $('#textTambah').text('Edit Data');
        $('button#btn-tambah').text('Edit Data');
        $('#aksi').val("edit");
        let id = $(this).data("id");
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/getdata",
            type: "POST",
            data: {
                id: id,
                _token: token
            },
            dataType: "json",
            success: function(dataResult) {
                $('#id').val(dataResult[0].id);
                $('#nama').val(dataResult[0].nama);
                $('#tmptlahir').val(dataResult[0].tmptlahir);
                $('#tgllahir').val(dataResult[0].tgllahir);
                $('#jabatan').val(dataResult[0].jabatan);
                $('#foto-lama').val(dataResult[0].foto);
            }
        })
    });

    // Menampilkan Modal Hapus   
    $("#dataKaryawan").on("click", ".hapus" ,function () {
        hapusModal.show();
        let id = $(this).data("id");
        id = $("#id").val(id);
    })

    // Submit Form Tambah & Edit
    $('#formTambah').on('submit', function (e) {

        e.preventDefault();
        let form = new FormData(this);

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

        $.ajax({
            type: 'post',
            url: '/manipulasidata',
            data: form,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (dataResult) {
                if(dataResult.statusCode==200){
                    alert('Sukses');
                    $('#dataKaryawan').DataTable().ajax.reload();
                    myModal.hide();
                }
                else if(dataResult.statusCode==201){
                    alert('Error');
                }
            }
        });

    });


    // Submit Form Hapus
    $('#btn-hapus').click(function () {
        let id = $('#id').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: '/hapus',
            data: {
                id: id,
                _token: token
            },
            dataType: 'json',
            success: function (dataResult) {
                console.log(dataResult[0]);
                if(dataResult.statusCode==200){
                    alert('Sukses');
                    $('#dataKaryawan').DataTable().ajax.reload();
                    hapusModal.hide();
                }
                else if(dataResult.statusCode==201){
                    alert('Error');
                }
            }
        });

    })

});