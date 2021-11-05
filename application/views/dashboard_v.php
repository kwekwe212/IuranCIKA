<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Data Person</title>
    <?php $this->load->view('_partials/head') ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view('_partials/topbar') ?>
        <?php $this->load->view('_partials/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Data Orang</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-primary m-0" data-toggle="modal" data-target="#modalTambahData">
                                Tambah
                            </button>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('_partials/footer') ?>
    </div>
    <!-- ./wrapper -->



    <div class="modal fade" id="modalTambahData" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" name="tambahData" id="tambahData">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" id="inputNama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat" class="form-control" id="inputAlamat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNoTelepon" class="col-sm-2 col-form-label">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" name="notelp" class="form-control" id="inputNoTelepon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputKeterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="keterangan" id="inputKeterangan" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbahData" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" name="ubahData" id="ubahData">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="d-none" name="id">
                        <div class="form-group row">
                            <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" id="inputNama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat" class="form-control" id="inputAlamat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNoTelepon" class="col-sm-2 col-form-label">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" name="notelp" class="form-control" id="inputNoTelepon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputKeterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="keterangan" id="inputKeterangan" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('_partials/js') ?>

    <script>
        $(document).ready(function() {
            // console.log($("#content"))

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            })

            const ambilData = () => {
                $('#dataTable').DataTable().clear().destroy();
                $('#dataTable').DataTable({
                    "scrollX": true,
                    paging: false,
                    info: false,
                    buttons: [
                        'pdfHtml5'
                    ],
                    ajax: {
                        url: "<?= base_url('dashboard/ambilData') ?>",
                        type: "POST",
                        dataSrc: ""
                    },
                    columns: [{
                            "data": "name"
                        },
                        {
                            "data": "address"
                        },
                        {
                            "data": "telp"
                        },
                        {
                            "data": "keterangan"
                        },
                        {
                            "data": "action"
                        },
                    ]
                });
            }

            $("#tambahData").submit(function(e) {
                e.preventDefault();
                // console.log($(this).serializeArray());

                let nama = $("#tambahData input[name='nama']")
                let alamat = $("#tambahData input[name='alamat']")
                let notelp = $("#tambahData input[name='notelp']")
                let keterangan = $("#tambahData textarea[name='keterangan']")

                if (nama.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nama harus diisi'
                    })
                    nama.focus();
                    return false;
                } else if (alamat.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Alamat harus diisi'
                    })
                    alamat.focus();
                    return false;
                } else if (notelp.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nomor Telepon harus diisi'
                    })
                    notelp.focus();
                    return false;
                } else if (keterangan.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Keterangan harus diisi'
                    })
                    keterangan.focus();
                    return false;
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('dashboard/tambahdata') ?>",
                        data: $(this).serializeArray(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            ambilData();

                            $("#modalTambahData").modal('hide');
                            $("#modalTambahData input, #modalTambahData textarea").val("");

                            Toast.fire({
                                icon: 'success',
                                title: response.pesan
                            })
                        }
                    })
                }

            })

            $("#ubahData").submit(function(e) {
                e.preventDefault();

                let nama = $("#ubahData input[name='nama']")
                let alamat = $("#ubahData input[name='alamat']")
                let notelp = $("#ubahData input[name='notelp']")
                let keterangan = $("#ubahData textarea[name='keterangan']")

                if (nama.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nama harus diisi'
                    })
                    nama.focus();
                    return false;
                } else if (alamat.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Alamat harus diisi'
                    })
                    alamat.focus();
                    return false;
                } else if (notelp.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nomor Telepon harus diisi'
                    })
                    notelp.focus();
                    return false;
                } else if (keterangan.val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Keterangan harus diisi'
                    })
                    keterangan.focus();
                    return false;
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('dashboard/ubahdata') ?>",
                        data: $(this).serializeArray(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            ambilData();

                            $("#modalUbahData").modal('hide');
                            $("#modalUbahData input, #modalUbahData textarea").val("");

                            Toast.fire({
                                icon: 'success',
                                title: response.pesan
                            })
                        }
                    })
                }

            })

            $("#dataTable").on('click', '.hapus', function() {
                console.log($(this).data('id'))

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah anda yakin ingin menghapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // console.log(result)
                    if (result.isConfirmed || result.value) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('dashboard/hapusData') ?>",
                            data: {
                                id: $(this).data('id')
                            },
                            success: function() {
                                Swal.fire(
                                    'Terhapus!', 'Data berhasil dihapus.', 'success'
                                )
                                ambilData();
                            },
                            error: function() {
                                Swal.fire(
                                    'Gagal!', 'Silahkan coba lagi', 'error'
                                )
                            }
                        })

                    }
                })
            })

            $("#dataTable").on('click', '.ubah', function() {
                console.log($(this).data('id'))

                let id = $("#modalUbahData input[name='id']")
                let nama = $("#modalUbahData input[name='nama']")
                let alamat = $("#modalUbahData input[name='alamat']")
                let notelp = $("#modalUbahData input[name='notelp']")
                let keterangan = $("#modalUbahData textarea[name='keterangan']")

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('dashboard/ambilDataId') ?>",
                    async: true,
                    dataType: 'json',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(response) {
                        id.val(response['id'])
                        nama.val(response['name'])
                        alamat.val(response['address'])
                        notelp.val(response['telp'])
                        keterangan.val(response['keterangan'])
                        $('#modalUbahData').modal('show')
                    }
                })

            })

            ambilData();
        })
    </script>
</body>

</html>