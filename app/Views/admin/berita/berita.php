<?= $this->extend('admin/template') ?>

<?= $this->section('pageStyle') ?>
<meta name="csrf-token" data-name="<?= csrf_token(); ?>" content="<?= csrf_hash(); ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6 d-flex justify-content-start align-items-center">
                <h3 class="card-title">Tabel Berita</h3>
              </div>
              <div class="col-sm-6 d-flex justify-content-end align-items-center">
                <a href="<?= base_url('admin/berita/create'); ?>" class="btn btn-primary">
                  <i class="fas fa-plus"></i> Tambah Berita
                </a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="beritaTable" class="table table-bordered table-hover" style="width: 100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Tags</th>
                    <th>View Count</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
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
</section>
<?= $this->endSection() ?>s

<?= $this->section('pageScript') ?>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';
    let baseUrl = "<?= base_url(); ?>";

    let beritaTable = $('#beritaTable').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "ajax": {
        "url": baseUrl + "admin/berita/fetch",
        "type": "POST",
        "data": function(d) {
          d[csrfName] = csrfHash; // ✅ Send CSRF Token with request
        },
        "dataSrc": function(json) {
          csrfHash = json.csrf_hash; // ✅ Update CSRF Token after request
          return json.data; // ✅ Ensure DataTables receives the correct data
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      },
      "columns": [{
          "data": null,
          "name": "no",
          "searchable": false,
          "render": function(data, type, row, meta) {
            return `<p class="text-center">${meta.row + meta.settings._iDisplayStart + 1}</p>`;
          }
        },
        {
          "data": "judul_berita"
        },
        {
          "data": "nama_kategori"
        },
        {
          "data": "author_name"
        },
        {
          "data": "status",
          "render": function(data, type, row) {
            let badge = data == 1 ?
              '<span class="badge badge-success">Published</span>' :
              '<span class="badge badge-secondary">Draft</span>';
            let button = `<button class="btn mt-2 btn-sm btn-toggle-status btn-${data==1 ? "secondary" : "success"}" 
                                  data-id="${row.id}" data-status="${data}">
                                  ${data == 1 ? 'Unpublish' : 'Publish'}
                                </button>`;
            return badge + '<br>' + button;
          }
        },
        {
          "data": "tags"
        },
        {
          "data": "view_count",
          "searchable": false
        },
        {
          "data": "foto",
          "render": function(data) {
            return `<img src="${baseUrl}uploads/berita/${data}" alt="Foto" width="80">`;
          }
        },
        {
          "data": "id",
          "render": function(data) {
            return `<a href="${baseUrl}admin/berita/edit/${data}" class="btn btn-warning btn-sm m-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm m-1 delete-btn" data-id="${data}">
                                <i class="fas fa-trash"></i>
                            </a>`;
          }
        }
      ],
      drawCallback: function() {
        $('#beritaTable').off('click', '.delete-btn').on('click', '.delete-btn', function() {
          let beritaId = $(this).data('id');

          Swal.fire({
            title: "Apakah anda yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Hapus",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "<?= base_url('admin/berita/delete/'); ?>" + beritaId,
                type: "DELETE",
                dataType: "json",
                data: {
                  [csrfName]: csrfHash
                },
                success: function(response) {
                  if (response.status === "success") {
                    Swal.fire("Deleted!", response.message, "success")
                      .then(() => {
                        csrfHash = response.csrf_hash;
                        beritaTable.ajax.reload();
                      });
                  } else {
                    Swal.fire("Error!", response.message, "error");
                  }
                },
                error: function() {
                  Swal.fire("Error!", "Failed to delete berita.", "error");
                }
              });
            }
          });
        });
      }
    });

    // ✅ Handle Status Change Button Click
    $('#beritaTable').on('click', '.btn-toggle-status', function() {
      let beritaId = $(this).data('id');
      let currentStatus = $(this).data('status');
      let newStatus = currentStatus == 1 ? 0 : 1;

      Swal.fire({
        title: "Apakah anda yakin mengubah status berita ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ffc107",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ubah",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: baseUrl + "admin/berita/updateStatus",
            type: "POST",
            data: {
              berita_id: beritaId,
              status: newStatus,
              [csrfName]: csrfHash // ✅ Use latest CSRF Token
            },
            dataType: "json",
            success: function(response) {
              if (response.status == "success") {
                Swal.fire("Berhasil!", response.message, "success")
                  .then(() => {
                    csrfHash = response.csrf_hash; // ✅ Update CSRF Token
                    beritaTable.ajax.reload(); // ✅ Reload DataTable
                  })
              } else {
                Swal.fire("Error!", response.message, "error")
              }

            },
            error: function(xhr) {
              Swal.fire("Error!", "Gagal mengubah status berita!", "error")
              console.log(xhr.responseText);
            }
          });
        }
      });

    });
  });
</script>

<?= $this->endSection() ?>