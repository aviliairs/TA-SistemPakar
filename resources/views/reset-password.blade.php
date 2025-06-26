<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Reset Password</title>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Bootstrap CSS via CDN as fallback -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS for Material Design look -->
  <style>
    .bg-gray-200 {
      background-color: #f8f9fa !important;
    }

    .bg-gradient-dark {
      background: linear-gradient(310deg, #141727 0%, #3A416F 100%);
    }

    .shadow-dark {
      box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(64, 64, 64, 0.4);
    }

    .border-radius-lg {
      border-radius: 0.75rem;
    }

    .card {
      box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
      border: 0;
    }

    .card-header {
      border-bottom: none;
    }

    .input-group-outline {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .input-group-outline .form-control {
      background: transparent;
      border: 1px solid #d2d6da;
      border-radius: 0.375rem;
      padding: 0.75rem;
      font-size: 0.875rem;
    }

    .input-group-outline .form-control:focus {
      border-color: #e91e63;
      box-shadow: 0 0 0 0.2rem rgba(233, 30, 99, 0.25);
    }

    .form-label {
      position: absolute;
      top: 0.75rem;
      left: 0.75rem;
      color: #7b809a;
      pointer-events: none;
      transition: all 0.2s ease;
      background: white;
      padding: 0 0.25rem;
    }

    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label {
      top: -0.5rem;
      left: 0.5rem;
      font-size: 0.75rem;
      color: #e91e63;
    }

    .btn-primary {
      background: linear-gradient(310deg, #e91e63 0%, #ad1457 100%);
      border: none;
      border-radius: 0.375rem;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    .page-header {
      background-image: url('{{ asset("images/fotoo.jpg") }}');
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .fadeIn3 {
      animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .alert {
      border-radius: 0.375rem;
      border: none;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .footer {
      color: white;
    }

    .footer a {
      color: white;
      text-decoration: none;
    }

    .footer a:hover {
      color: #e91e63;
    }
  </style>
</head>

<body class="bg-gray-200">
  <main class="main-content mt-0">
    <div class="page-header align-items-start">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Reset Password</h4>
                </div>
              </div>

              <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                  @csrf

                  @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                  @endif

                  <input type="hidden" name="token" value="{{ $token }}">
                  <input type="hidden" name="email" value="{{ old('email', $email) }}">

                  <div class="input-group-outline my-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder=" " required>
                    <label for="password" class="form-label">Password Baru</label>
                  </div>

                  <div class="input-group-outline my-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                  </div>

                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit">Reset Password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="footer position-absolute bottom-0 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>document.write(new Date().getFullYear())</script>,
                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold text-white" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
