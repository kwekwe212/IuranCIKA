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
                        <div class="col-lg-8 col-md-12">
                            <div class="card" id="filterByDate">
                                <div class="card-body">
                                    <h5>Filter Date</h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group date" id="inputTanggal" data-target-input="nearest">
                                                    <input type="text" name="tanggal" class="form-control datetimepicker-input" data-target="#inputTanggal" />
                                                    <div class="input-group-append" data-target="#inputTanggal" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-none">
                                                <div class="input-group date" id="inputTanggalEnd" data-target-input="nearest">
                                                    <input type="text" name="tanggalend" class="form-control datetimepicker-input" data-target="#inputTanggalEnd" />
                                                    <div class="input-group-append" data-target="#inputTanggalEnd" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" id="excFilter">Terapkan</button>
                                            <button class="btn btn-warning" id="resetFilter">Reset</button>
                                            <button class="btn btn-danger" id="exportPDF"><i class="fas fa-file-pdf"></i></button>
                                            <button class="btn btn-success" id="exportExcel"><i class="fas fa-file-excel"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="filterHari">
                                        <label class="form-check-label" for="filterHari">
                                            Filter beberapa hari
                                        </label>
                                    </div>

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
            $('#inputTanggalEnd').datetimepicker({
                format: 'L'
            });

            const ambilData = (url, data) => {
                $('#dataTable').DataTable().clear().destroy();
                $('#dataTable').DataTable({
                    "scrollX": true,
                    paging: false,
                    info: false,
                    ajax: {
                        url: url,
                        type: "POST",
                        data: data,
                        dataSrc: "",
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

            // checkbox filter beberapa hari
            $('input.form-check-input').change(function() {
                $('#inputTanggalEnd').parent().toggleClass('d-none')

                if ($('#inputTanggalEnd').parent().hasClass('d-none')) {
                    $('#inputTanggalEnd input').val('')
                }
            });

            // excecute filter
            $('#excFilter').click(function(e) {
                e.preventDefault();

                let data = {
                    tanggal: $('#inputTanggal input').val(),
                    tanggalEnd: $('#inputTanggalEnd input').val()
                }

                ambilData('<?= base_url('iuran/filterTanggal') ?>', data)
            })

            // reset filter
            $('#resetFilter').click(function(e) {
                e.preventDefault();

                $('#inputTanggal input').val('')
                $('#inputTanggalEnd input').val('')
                $('#inputTanggalEnd').parent().addClass('d-none');
                $("#filterHari").prop('checked', false)

                ambilData('<?= base_url('iuran/ambilData') ?>', '');
            })

            // export pdf
            $('#exportPDF').click(function(e) {
                e.preventDefault();

                let tanggal = ($('#inputTanggal input').val()).split('/').join('-')
                let tanggalEnd = $('#inputTanggalEnd input').val()

                if (!tanggal && !tanggalEnd) {
                    window.open("<?= base_url('iuran/printPdf') ?>");
                } else if (tanggal && !tanggalEnd) {
                    window.open(`<?= base_url('iuran/printPdf/') ?>${tanggal}`)
                } else if (tanggal && tanggalEnd) {
                    window.open(`<?= base_url('iuran/printPdf/') ?>${tanggal}/${tanggalEnd}`)
                }
            })

            $('#exportExcel').click(function(e) {
                e.preventDefault();

                window.open('<?= base_url('iuran/printExcel') ?>');
            })

            ambilData('<?= base_url('iuran/ambilData') ?>', '');
            totalIuran();
        })
    </script>
</body>

</html>