<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Iuran | Data Person</title>
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
                            <h1 class="m-0 text-dark">Data Iuran</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <p class="my-0">Filter by :</p>
                                </div>
                                <div class="card-body">
                                    <!-- checkbox -->
                                    <div class="form-group input-radio">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="inputradio1" value="id" name="filter" />
                                            <label for="inputradio1">ID</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="inputradio2" value="name" name="filter" />
                                            <label for="inputradio2">Nama</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="inputradio3" value="address" name="filter" />
                                            <label for="inputradio3">Alamat</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="inputradio4" value="telp" name="filter" />
                                            <label for="inputradio4">No Telepon</label>
                                        </div>
                                    </div>

                                    <!-- select2 -->
                                    <div class="form-group">
                                        <!-- <label>Minimal</label> -->
                                        <select class="form-control select2bs4" disabled style="width: 100%;"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" name="inputIuran" id="inputIuran">
                                        <div class="form-group">
                                            <label for="inputNama" class="col-form-label">Nama</label>
                                            <input type="text" disabled name="nama" class="form-control" id="inputNama">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputNominalWajib" class="col-form-label">Nominal Wajib</label>
                                            <input type="number" min="1000" name="nominal_wajib" class="form-control" id="inputNominalWajib">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputNominalSampingan" class="col-form-label">Nominal Sampingan</label>
                                            <input type="number" min="1000" name="nominal_sampingan" class="form-control" id="inputNominalSampingan">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTanggal" class="col-form-label">Tanggal</label>
                                            <div class="input-group date" id="inputTanggal" data-target-input="nearest">
                                                <input type="text" name="tanggal" class="form-control datetimepicker-input" data-target="#inputTanggal" />
                                                <div class="input-group-append" data-target="#inputTanggal" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Tambah Iuran</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Iuran Wajib</th>
                                            <th>Iuran Sampingan</th>
                                            <th>Total Iuran</th>
                                            <th>Tanggal</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p class="m-0">Jumlah iuran : <span id="totalIuran"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('_partials/footer') ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <?php $this->load->view('_partials/js') ?>

    <script>
        $(document).ready(function() {
            // console.log($("#content"))

            $('#inputTanggal').datetimepicker({
                format: 'L'
            });

            const ambilData = () => {
                $('#dataTable').DataTable().clear().destroy();
                $('#dataTable').DataTable({
                    "scrollX": true,
                    paging: false,
                    info: false,
                    ajax: {
                        url: "<?= base_url('iuran/ambilData') ?>",
                        type: "POST",
                        dataSrc: ""
                    },
                    columns: [{
                            "data": "nama"
                        },
                        {
                            "data": "iuranWajib"
                        },
                        {
                            "data": "iuranSampingan"
                        },
                        {
                            "data": "totalIuran"
                        },
                        {
                            "data": "tanggal"
                        },
                        {
                            "data": "action"
                        },
                    ]
                });
            }

            const totalIuran = () => {
                $.ajax({
                    url: '<?= base_url('iuran/totalIuran') ?>',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        $('#totalIuran').html(response)
                    }
                })
            }

            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: 'Ketik sesuatu'
            })

            $('input[type=radio][name=filter]').change(function() {
                // console.log(this.value)
                let cat = this.value;

                $('#inputNama').val('')
                $('.select2bs4').val(null).trigger('change');

                $('.select2bs4').select2('destroy').prop('disabled', false);
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    minimumInputLength: 3,
                    placeholder: 'Ketik sesuatu',
                    ajax: {
                        url: '<?= base_url('iuran/ambilDataKolom') ?>',
                        dataType: 'json',
                        type: 'POST',
                        delay: 250,
                        data: function(term) {
                            return {
                                term: term,
                                cat
                            }
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                })
            });

            $('.select2bs4').on('select2:select', function(e) {
                $('#inputNama').val(e.params.data.text)
            });

            $("#inputIuran").submit(function(e) {
                e.preventDefault();
                // console.log($(this).serializeArray());

                let nama = $("#inputIuran input[name='nama']")
                let nominalwajib = $("#inputIuran input[name='nominal-wajib']")
                let nominalsampingan = $("#inputIuran input[name='nominal-sampingan']")
                let tanggal = $("#inputIuran input[name='tanggal']")

                nama.prop('disabled', false);

                if (nama.val() == '') {
                    alert("Nama harus diisi");
                    nama.focus();
                    return false;
                } else if (nominalwajib.val() == '') {
                    alert("Nominal Wajib harus diisi");
                    nominalwajib.focus();
                    return false;
                } else if (tanggal.val() == '') {
                    alert("Tanggal harus diisi");
                    tanggal.focus();
                    return false;
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('iuran/tambahIuran') ?>",
                        data: $(this).serializeArray(),
                        success: function(response) {
                            console.log(response);
                            ambilData();
                            totalIuran();

                            nama.val('')
                            nominalwajib.val('')
                            nominalsampingan.val('')
                            tanggal.val('')
                            // nominals.val("");
                        }
                    })
                }

                nama.prop('disabled', true);
            })

            $("#dataTable").on('click', '.hapus', function() {
                // console.log($(this).data('id'))

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
                            url: "<?= base_url('iuran/hapusData') ?>",
                            data: {
                                id: $(this).data('id')
                            },
                            success: function() {
                                Swal.fire(
                                    'Terhapus!', 'Data berhasil dihapus.', 'success'
                                )
                                ambilData();
                                totalIuran();
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

            ambilData();
            totalIuran();
        })
    </script>
</body>

</html>