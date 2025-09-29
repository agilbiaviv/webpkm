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
                                <h3 class="card-title">Tabel Menu</h3>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end align-items-center">
                                <a href="<?= base_url('admin/menu-manager/create'); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Menu
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="menusTable" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Menu</th>
                                        <th>Slug</th>
                                        <th>Parent</th>
                                        <th>Posisi</th>
                                        <th>Status</th>
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
<?= $this->endSection() ?>

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

        let menusTable = $('#menusTable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": baseUrl + "admin/menu-manager/fetch",
                "type": "POST",
                "data": function(d) {
                    d[csrfName] = csrfHash;
                },
                "dataSrc": function(json) {
                    csrfHash = json.csrf_hash;
                    return json.data;
                }
            },
            "columns": [{
                    "data": null,
                    "searchable": false,
                    "render": function(data, type, row, meta) {
                        return `<p class="text-center">${meta.row + meta.settings._iDisplayStart + 1}</p>`;
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "slug"
                },
                {
                    "data": "parent_name",
                    "render": function(data) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    "data": "position"
                },
                {
                    "data": "status",
                    "render": function(data) {
                        return data === 'active' ?
                            '<span class="badge badge-success">Aktif</span>' :
                            '<span class="badge badge-secondary">Nonaktif</span>';
                    }
                },
                {
                    "data": "id",
                    "render": function(data) {
                        return `
                            <a href="${baseUrl}admin/menu-manager/edit/${data}" class="btn btn-warning btn-sm m-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm m-1 delete-btn" data-id="${data}">
                                <i class="fas fa-trash"></i>
                            </a>`;
                    }
                }
            ],
            drawCallback: function() {
                $('#menusTable').off('click', '.delete-btn').on('click', '.delete-btn', function() {
                    let menuId = $(this).data('id');

                    Swal.fire({
                        title: "Apakah anda yakin akan menghapus menu ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Hapus",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: baseUrl + "admin/menu-manager/delete/" + menuId,
                                type: "DELETE",
                                dataType: "json",
                                data: {
                                    [csrfName]: csrfHash
                                },
                                success: function(response) {
                                    if (response.status === "success") {
                                        Swal.fire("Terhapus!", response.message, "success").then(() => {
                                            csrfHash = response.csrf_hash;
                                            menusTable.ajax.reload();
                                        });
                                    } else {
                                        Swal.fire("Error!", response.message, "error");
                                    }
                                },
                                error: function() {
                                    Swal.fire("Error!", "Failed to delete menu.", "error");
                                }
                            });
                        }
                    });
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>