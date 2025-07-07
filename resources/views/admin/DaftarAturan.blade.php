@extends('admin.admin')

<!DOCTYPE html>
<html lang="en">

@section('content')
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">

   <!--     Fonts and icons     -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
   <!-- Nucleo Icons -->
   <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
   <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
   <!-- Font Awesome Icons -->
   <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- Material Icons -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
   <!-- CSS Files -->
   <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css') }}" rel="stylesheet" />

   <style>
     /* Fix untuk modal overlay dan sidebar */
     .modal-backdrop {
       z-index: 1050 !important;
     }

     .modal {
       z-index: 1055 !important;
     }

     /* Pastikan sidebar tidak melampaui modal */
     .sidenav {
       z-index: 1000 !important;
     }

     /* Fix untuk body ketika modal terbuka */
     body.modal-open {
       padding-right: 0 !important;
       overflow: hidden;
     }

     /* Mencegah sidebar berinteraksi ketika modal terbuka */
     body.modal-open .sidenav {
       pointer-events: none;
     }

     /* Pastikan modal content bisa diklik */
     .modal-dialog {
       pointer-events: auto;
     }


   </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        @yield('content')
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tables</li>
          </ol>
        </nav>
         {{-- <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
        </div> --}}
    </div>
    </nav>
    <!-- End Navbar -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end me-4 mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
          <i class="fas fa-plus me-1"></i> Tambah Data
        </button>
    </div>

    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Daftar Aturan</h6>
              </div>
            </div>

            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0" style="width: 75vw">
                <table class="table w-100 align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kode Rule</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Gejala</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kondisi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kesimpulan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($aturans as $aturan)
                      <tr>
                        <td class="text-sm">{{ $aturan->id_rule}}</td>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $aturan->kode_rule }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="text-sm" style="white-space: normal; word-break: break-word;">{{ $aturan->kode_gejala }}</td>
                        <td class="text-sm">{{ $aturan->kategori }}</td>
                        <td class="text-sm">{{ $aturan->kondisi }}</td>
                        <td class="text-sm text-center">
                          <a href="#" class="btn btn-info btn-sm"
                             data-bs-toggle="modal"
                             data-bs-target="#detailModal"
                             data-kode_rule="{{ $aturan->kode_rule }}"
                             data-kesimpulan="{{ $aturan->kesimpulan }}"
                             data-kategori="{{ $aturan->kategori }}"
                             data-kondisi="{{ $aturan->kondisi }}"
                             data-kode_gejala="{{ $aturan->kode_gejala }}"
                             title="Lihat Detail Kesimpulan">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                          </a>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="{{ $aturan->id_rule }}"
                                    data-kode_rule="{{ $aturan->kode_rule }}"
                                    data-kode_gejala="{{ $aturan->kode_gejala }}"
                                    data-kategori="{{ $aturan->kategori }}"
                                    data-kondisi="{{ $aturan->kondisi }}"
                                    data-kesimpulan="{{ $aturan->kesimpulan }}"
                                    title="Edit Aturan">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Tombol Delete yang membuka modal -->
                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $aturan->id_rule }}"
                                    data-kode_rule="{{ $aturan->kode_rule }}"
                                    title="Hapus Pakar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
          <h5 class="modal-title text-white" id="detailModalLabel">
            <i class="fas fa-info-circle me-2"></i>
            Detail Aturan: <span id="detailKodeRule"></span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div>
                <label class="form-label fw-bold text-secondary">Kode Rule: <label class="text-dark" id="detailKodeRuleText"></label></label>
              </div>
              <div>
                <label class="form-label fw-bold text-secondary">Kategori: <label class="text-dark" id="detailKategori"></label></label>
              </div>
              <div>
                <label class="form-label fw-bold text-secondary">Kondisi: <label class="text-dark" id="detailKondisi"></label></label>
              </div>
            </div>
            {{-- <div class="col-md-6"> --}}
              <div>
                <label class="form-label fw-bold text-secondary">Kode Gejala: <label class="text-dark" id="detailKodeGejala" style="word-break: break-word;"></label></label>
              </div>
            {{-- </div> --}}
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label fw-bold text-secondary">Kesimpulan Lengkap:</label>
                <div class="p-3 bg-light rounded">
                  <p class="text-dark mb-0" id="detailKesimpulan" style="white-space: pre-wrap; word-break: break-word;"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Tambah Aturan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('aturan.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="kode_rule" class="form-label">Kode Rule</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kode_rule" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="kode_gejala" class="form-label">Kode Gejala</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kode_gejala" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <div class="input-group input-group-outline">
                <select name="kategori" class="form-control" required>
                  <option value="">Pilih Kategori</option>
                  <option value="reproduksi">Reproduksi</option>
                  <option value="gizi">Gizi</option>
                  <option value="mental">Mental</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="kondisi" class="form-label">Kondisi</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kondisi" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="kesimpulan" class="form-label">Kesimpulan</label>
              <div class="input-group input-group-outline">
                <textarea name="kesimpulan" class="form-control" rows="3" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Aturan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_kode_rule" class="form-label">Kode Rule</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kode_rule" id="edit_kode_rule" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="edit_kode_gejala" class="form-label">Kode Gejala</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kode_gejala" id="edit_kode_gejala" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="edit_kategori" class="form-label">Kategori</label>
              <div class="input-group input-group-outline">
                <select name="kategori" id="edit_kategori" class="form-control" required>
                  <option value="reproduksi">Reproduksi</option>
                  <option value="gizi">Gizi</option>
                  <option value="mental">Mental</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="kondisi" class="form-label">Kondisi</label>
              <div class="input-group input-group-outline">
                <input type="text" name="kondisi" id="edit_kondisi" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="kesimpulan" class="form-label">Kesimpulan</label>
              <div class="input-group input-group-outline">
                <textarea name="kesimpulan" id="edit_kesimpulan" class="form-control w-100" rows="5" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">
            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
            Konfirmasi Penghapusan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">Apakah Anda yakin ingin menghapus Aturan <span id="kodeRule"></span>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Hidden form untuk delete -->
  <form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>

  @endsection

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk modal detail
        const detailButtons = document.querySelectorAll('[data-bs-target="#detailModal"]');
        detailButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const kodeRule = this.getAttribute('data-kode_rule');
                const kesimpulan = this.getAttribute('data-kesimpulan');
                const kategori = this.getAttribute('data-kategori');
                const kondisi = this.getAttribute('data-kondisi');
                const kodeGejala = this.getAttribute('data-kode_gejala');

                // Fill modal detail
                document.getElementById('detailKodeRule').textContent = kodeRule;
                document.getElementById('detailKodeRuleText').textContent = kodeRule;
                document.getElementById('detailKategori').textContent = kategori;
                document.getElementById('detailKondisi').textContent = kondisi;
                document.getElementById('detailKodeGejala').textContent = kodeGejala;
                document.getElementById('detailKesimpulan').textContent = kesimpulan;
            });
        });

        // Script untuk modal edit
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const kodeRule = this.getAttribute('data-kode_rule');
                const kodeGejala = this.getAttribute('data-kode_gejala');
                const kategori = this.getAttribute('data-kategori');
                const kondisi = this.getAttribute('data-kondisi');
                const kesimpulan = this.getAttribute('data-kesimpulan');

                // Set action URL
                document.getElementById('editForm').action = `/admin/aturan/${id}`;

                // Fill form fields
                document.getElementById('edit_kode_rule').value = kodeRule;
                document.getElementById('edit_kode_gejala').value = kodeGejala;
                document.getElementById('edit_kategori').value = kategori;
                document.getElementById('edit_kondisi').value = kondisi;
                document.getElementById('edit_kesimpulan').value = kesimpulan;
            });
        });

        // Script untuk modal delete
        const deleteButtons = document.querySelectorAll('.delete-btn');
        let currentDeleteId = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentDeleteId = this.getAttribute('data-id');
                const kodeRule = this.getAttribute('data-kode_rule');

                // Update nama pakar di modal
                document.getElementById('kodeRule').textContent = kodeRule;
            });
        });

        // Handle konfirmasi delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentDeleteId) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/admin/aturan/${currentDeleteId}`;
                deleteForm.submit();
            }
        });

        // Handle modal events untuk sidebar
        const modals = document.querySelectorAll('.modal');
        const sidebar = document.querySelector('.sidenav');

        modals.forEach(modal => {
            // Ketika modal dibuka
            modal.addEventListener('show.bs.modal', function() {
                // Nonaktifkan sidebar interactions
                if (sidebar) {
                    sidebar.style.pointerEvents = 'none';
                    sidebar.style.zIndex = '1000';
                }

                // Pastikan body tidak bisa scroll
                document.body.style.overflow = 'hidden';
            });

            // Ketika modal ditutup
            modal.addEventListener('hidden.bs.modal', function() {
                // Aktifkan kembali sidebar interactions
                if (sidebar) {
                    sidebar.style.pointerEvents = 'auto';
                    sidebar.style.zIndex = '1000';
                }

                // Kembalikan scroll body
                document.body.style.overflow = 'auto';
            });
        });
    });

    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
