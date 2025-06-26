@extends('admin.admin')

@section('content')
<div class="container-fluid py-4">
  <div class="row">

    <!-- User -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah User</p>
              <h5 class="font-weight-bolder">{{ $jumlahUser }}</h5>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center rounded-circle">
                <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Gejala -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Gejala</p>
              <h5 class="font-weight-bolder">{{ $jumlahGejala }}</h5>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center rounded-circle">
                <i class="fa fa-notes-medical text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pakar -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Pakar</p>
              <h5 class="font-weight-bolder">{{ $jumlahPakar }}</h5>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle">
                <i class="fa fa-user-tie text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Diagnosa -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Diagnosa</p>
              <h5 class="font-weight-bolder">{{ $jumlahDiagnosa }}</h5>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow text-center rounded-circle">
                <i class="fa fa-stethoscope text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
