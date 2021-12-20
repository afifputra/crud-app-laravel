$(document).ready(function() {


    // Menampilkan Modal Tambah
    $("#tambah").click(function () {
        $('#textTambah').text('Tambah Data');
        $('#formTambah')[0].reset();
        $('button#btn-tambah').text('Tambah Data');
        $('#aksi').val("tambah");
    })

    // Menampilkan Modal Edit
    $("#dataKaryawan").on("click", '.edit' ,function() {
        let myModal = new bootstrap.Modal($('#tambahModal'));
        myModal.show();
        $('#textTambah').text('Edit Data');
        $('button#btn-tambah').text('Edit Data');
        $('#aksi').val("edit");
        let id = $(this).data("id");
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/home/getdata",
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
        let hapusModal = new bootstrap.Modal($('#hapusModal'));
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
            url: '/home/manipulasidata',
            data: form,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (dataResult) {
                if(dataResult.statusCode==200){
                    alert('Sukses');
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
            url: '/home/hapus',
            data: {
                id: id,
                _token: token
            },
            dataType: 'json',
            success: function (dataResult) {
                console.log(dataResult[0]);
                if(dataResult.statusCode==200){
                    alert('Sukses');
                }
                else if(dataResult.statusCode==201){
                    alert('Error');
                }
            }
        });

    })


    // $('#btn-tambah').on('click', function() {
    // $("#btn-tambah").attr("disabled", "disabled");
    // let id = $("#id").val();
    // let nama = $("#nama").val();
    // let tmptlahir = $("#tmptlahir").val();
    // let tgllahir = $("#tgllahir").val();
    // let jabatan = $("#jabatan").val();
    // let foto = $("#foto").val();
    // let aksi = $("#aksi").val();
    // if(nama!="" && tmptlahir!="" && tgllahir!="" && jabatan!="" && foto!="" && aksi!=""){
    //     $.ajax({
    //         url: "functions.php",
    //         type: "POST",
    //         data: {
    //             id: id,
    //             nama: nama,
    //             tmptlahir: tmptlahir,
    //             tgllahir: tgllahir,
    //             jabatan: jabatan,
    //             foto: foto,
    //             aksi: aksi				
    //         },
    //         dataType: "json",
    //         cache: false,
    //         success: function(dataResult){
    //             if(dataResult.statusCode==200){
    //                 $("#btn-tambah").removeAttr("disabled");
    //                 $('#formTambah').find('input:text').val('');
    //                 $("#success").show();
    //                 $('#success').html('Data added successfully !'); 						
    //             }
    //             else if(dataResult.statusCode==201){
    //                 alert("Error occured !");
    //             }
                
    //         }
    //     });
    // }
    // else{
    //     alert('Please fill all the field !');
    // }
    // });

});