<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Halaman Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="<?= base_url() ?>"><b>Data</b>Person</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="" class="mb-3" id="formRegister">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="nama" placeholder="Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control pw" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control pw" name="password2" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="<?= base_url('login') ?>" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
  <script>
    $(document).ready(function() {
      // console.log($('#formRegister'));
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      })

      $("#formRegister").submit(function(e) {
        e.preventDefault();
        console.log($(this).serializeArray());

        let nama = $("#formRegister input[name='nama']")
        let username = $("#formRegister input[name='username']")
        let password = $("#formRegister input[name='password']")
        let password2 = $("#formRegister input[name='password2']")

        if (nama.val() == '') {
          Toast.fire({
            icon: 'warning',
            title: 'Nama harus diisi'
          })
          nama.focus();
          return false;
        } else if (username.val() == '') {
          Toast.fire({
            icon: 'warning',
            title: 'Username harus diisi'
          })
          username.focus();
          return false;
        } else if (password.val() == '') {
          Toast.fire({
            icon: 'warning',
            title: 'Password harus diisi'
          })
          password.focus();
          return false;
        } else if (password2.val() == '') {
          Toast.fire({
            icon: 'warning',
            title: 'Silahkan isi kembali password'
          })
          password2.focus();
          return false;
        } else {
          $.ajax({
            type: "POST",
            url: "<?= base_url('auth/doregister') ?>",
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(data) {
              console.log(data);

              if (data.error == 1) {
                Toast.fire({
                  icon: 'warning',
                  title: data.pesan
                })
              } else if (data.error == 0) {
                Toast.fire({
                  icon: 'success',
                  title: data.pesan
                }).then(function() {
                  window.location.href = data.lokasi;
                })
              }
            }
          })
        }

      })

    })
  </script>
</body>

</html>