<?= $this->extend('admin/template') ?>

<?= $this->section('pageStyle') ?>
<meta name="csrf-token" data-name="<?= csrf_token(); ?>" content="<?= csrf_hash(); ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>" />
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- OrgChart CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.9/css/jquery.orgchart.min.css">

<style>
    #chart-container {
        transition: transform 0.2s ease;
    }
</style>
<style>
    #chart-wrapper {
        overflow: hidden;
        width: 100%;
        height: 600px;
        position: relative;
        cursor: grab;
    }

    #chart-container {
        transform-origin: 0 0;
        transition: transform 0.1s ease-out;
        position: absolute;
        top: 0;
        left: 0;
    }

    .orgchart .node img {
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: block;
        margin: 0 auto 5px;
        object-fit: cover;
    }


    .orgchart .node .content {
        white-space: normal !important;
        /* allow line wraps */
        word-break: break-word;
        /* break long words if needed */
        height: auto !important;
        /* let height grow as needed */
        min-height: 20px;
        /* optional: define a minimum */
        max-width: 120px;
        /* optional: limit width */
        text-align: center;
        /* optional: center text */
        padding: 4px 6px;
        /* optional: better spacing */
    }

    .orgchart .node .title {
        white-space: normal !important;
        word-break: break-word;
        max-width: 120px;
        width: auto !important;
        height: auto !important;
        text-align: center;
    }

    .tooltip-inner {
        max-width: 200px;
        white-space: pre-wrap;
        /* allow line breaks if needed */
        font-size: 0.875rem;
        /* smaller font */
    }

    .group-root {
        background-color: #37474F !important;
        /* Blue Grey Dark */
    }

    .group-0 {
        background-color: #1E88E5 !important;
        /* Blue Dark */
    }

    .group-1 {
        background-color: #D81B60 !important;
        /* Pink Dark */
    }

    .group-2 {
        background-color: #8E24AA !important;
        /* Purple Dark */
    }

    .group-3 {
        background-color: #FB8C00 !important;
        /* Orange Dark */
    }

    .group-4 {
        background-color: #00897B !important;
        /* Teal Dark */
    }

    /* You can add more .group-x as needed */
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 d-flex justify-content-start align-items-center">
                                <h3 class="card-title">Tabel Struktur Organisasi</h3>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end align-items-center">
                                <a href="<?= base_url('admin/profil/struktur-organisasi/create'); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Struktur Organisasi
                                </a>
                                <a href="#" class="btn btn-success ml-2" data-toggle="modal" data-target="#chartModal" id="previewChartBtn">
                                    <i class="fas fa-eye"></i> Lihat Bagan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="strukturTable" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($struktur as $index => $anggota): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <?php if ($anggota['foto']): ?>
                                                    <img src="<?= base_url('uploads/struktur/' . $anggota['foto']) ?>" onerror="this.error=null; this.src='<?= base_url('uploads/struktur/default.png') ?>'" width="50" class="img-thumbnail">
                                                <?php else: ?>
                                                    <img src="<?= base_url('uploads/struktur/default.png') ?>" width="50" class="img-thumbnail">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($anggota['nama']) ?></td>
                                            <td><?= esc($anggota['jabatan']) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/profil/struktur-organisasi/edit/' . $anggota['id']) ?>" class="btn btn-warning btn-sm m-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn delete-btn btn-danger btn-sm" data-id="<?= $anggota['id'] ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Chart Preview -->
<div id="chartModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title">Bagan Struktur Organisasi</h5>
                <div>
                    <button id="zoomInBtn" class="btn btn-sm btn-outline-primary mr-1"><i class="fas fa-search-plus"></i></button>
                    <button id="zoomOutBtn" class="btn btn-sm btn-outline-primary mr-1"><i class="fas fa-search-minus"></i></button>
                    <button id="resetZoomBtn" class="btn btn-sm btn-outline-secondary"><i class="fas fa-compress"></i></button>
                    <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
            </div>
            <div class="modal-body">
                <div id="chart-wrapper">
                    <div id="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('pageScript') ?>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- OrgChart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.9/js/jquery.orgchart.min.js"></script>

<script>
    let OrgChartRendred = false

    $(document).ready(function() {
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';
        let baseUrl = "<?= base_url(); ?>";
        const strukturData = <?= json_encode($struktur); ?>;

        let strukturTable = $('#strukturTable').DataTable({
            "responsive": true,
            drawCallback: function() {
                $('#strukturTable').off('click', '.delete-btn').on('click', '.delete-btn', function() {
                    let strukturId = $(this).data('id');

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
                                url: "<?= base_url('admin/profil/struktur-organisasi/delete/'); ?>" + strukturId,
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
                                                location.reload();
                                            });
                                    } else {
                                        Swal.fire("Error!", response.message, "error");
                                    }
                                },
                                error: function() {
                                    Swal.fire("Error!", "Failed to delete struktur.", "error");
                                }
                            });
                        }
                    });
                });
            }
        });

        let colorGroups = {};
        let colorIndex = 0;
        const colors = ['group-0', 'group-1', 'group-2', 'group-3', 'group-4'];

        function assignColorGroup(parentId) {
            if (!parentId) return 'group-root';
            if (!colorGroups[parentId]) {
                colorGroups[parentId] = colors[colorIndex++ % colors.length];
            }
            return colorGroups[parentId];
        }


        $('#previewChartBtn').on('click', function() {

            $.getJSON("<?= base_url('admin/profil/struktur-organisasi/chart-data') ?>", function(response) {
                $('#chart-container').empty();

                $('#chart-container').orgchart({
                    'data': Array.isArray(response) ? response[0] : response,
                    'nodeContent': 'nama',
                    'nodeTitle': 'jabatan',
                    'parentNodeSymbol': 'fa-users',
                    'createNode': function($node, data) {
                        const groupClass = assignColorGroup(data.parent_id);
                        $node.find('.title').addClass(groupClass); // 👈 apply class only to title area

                        if (data.foto) {
                            $node.prepend(`<img src="<?= base_url('uploads/struktur/') ?>${data.foto}" onerror="this.onerror=null; this.src='<?= base_url('uploads/struktur/default.png') ?>';" class="rounded-circle" width="40">`);
                        }
                        $node.attr({
                            'data-toggle': 'tooltip',
                            'data-placement': 'top',
                            'title': data.nama
                        });
                    }
                });

                // Activate Bootstrap tooltips
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        $('#chartModal').on('shown.bs.modal', function() {
            // Wait a moment for the chart to render
            setTimeout(() => {
                const wrapper = $('#chart-wrapper');
                const container = $('#chart-container');

                const wrapperWidth = wrapper.width();
                const wrapperHeight = wrapper.height();
                const containerWidth = container.outerWidth();
                const containerHeight = container.outerHeight();

                // Center calculation
                position.x = (wrapperWidth - containerWidth * scale) / 2;
                position.y = (wrapperHeight - containerHeight * scale) / 2;

                updateTransform();
            }, 100); // Delay to ensure chart is rendered
        });

    });
</script>

<script>
    let scale = 1;
    let position = {
        x: 0,
        y: 0
    };
    let isDragging = false;
    let startX, startY;

    const $chartWrapper = $('#chart-wrapper');
    const $chartContainer = $('#chart-container');

    function updateTransform() {
        $chartContainer.css('transform', `translate(${position.x}px, ${position.y}px) scale(${scale})`);
    }

    // Zoom Buttons
    $('#zoomInBtn').on('click', () => {
        scale += 0.1;
        updateTransform();
    });

    $('#zoomOutBtn').on('click', () => {
        if (scale > 0.2) {
            scale -= 0.1;
            updateTransform();
        }
    });

    $('#resetZoomBtn').on('click', () => {
        scale = 1;

        const wrapper = $('#chart-wrapper');
        const container = $('#chart-container');

        const wrapperWidth = wrapper.width();
        const wrapperHeight = wrapper.height();
        const containerWidth = container.outerWidth();
        const containerHeight = container.outerHeight();

        position.x = (wrapperWidth - containerWidth * scale) / 2;
        position.y = (wrapperHeight - containerHeight * scale) / 2;

        updateTransform();
    });


    // Mouse Wheel Zoom
    $chartWrapper.on('wheel', (e) => {
        e.preventDefault();
        const delta = e.originalEvent.deltaY;
        if (delta > 0 && scale > 0.2) {
            scale -= 0.05;
        } else if (delta < 0) {
            scale += 0.05;
        }
        updateTransform();
    });

    // Drag to Pan
    $chartWrapper.on('mousedown', (e) => {
        e.preventDefault();
        isDragging = true;
        startX = e.pageX - position.x;
        startY = e.pageY - position.y;
        $chartWrapper.css('cursor', 'grabbing');
    });

    $(document).on('mouseup', () => {
        isDragging = false;
        $chartWrapper.css('cursor', 'grab');
    });

    $(document).on('mousemove', (e) => {
        if (isDragging) {
            position.x = e.pageX - startX;
            position.y = e.pageY - startY;
            updateTransform();
        }
    });
</script>

<?= $this->endSection() ?>