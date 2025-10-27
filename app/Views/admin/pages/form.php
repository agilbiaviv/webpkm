<?= $this->extend('admin/template') ?>

<?= $this->section('pageStyle') ?>
<meta name="csrf_token_name" content="<?= csrf_token() ?>">
<meta name="csrf_token" content="<?= csrf_hash() ?>">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<!-- filepond CSS -->
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet" />

<!-- summernote -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css'); ?>">

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= isset($page) ? base_url('admin/page-manager/update/' . $page['id']) : base_url('admin/page-manager/save') ?>" method="POST" enctype="multipart/form-data">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Manajemen Halaman</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?= csrf_field() ?>
                                <?php if (isset($page)) : ?>
                                    <input type="hidden" name="id" value="<?= $page['id'] ?>">
                                <?php endif; ?>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Judul Halaman <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" autocomplete="off" value="<?= isset($page) ? $page['title'] : '' ?>" name="title" placeholder="Masukkan judul halaman" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gambar (Opsional)</label>
                                        <input type="file"
                                            class="filepond"
                                            name="image"
                                            data-max-file-size="2MB">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Konten <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="summernote" name="content" row="5" required><?= isset($page) ? $page['content'] : ''  ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end align-items-center">
                                    <a class="btn btn-outline-secondary m-1" href="<?= base_url('admin/page-manager') ?>">Kembali</a>
                                    <button type="submit" class="btn btn-<?= isset($page) ? 'warning' : 'primary'  ?>"><?= isset($page) ? 'Update' : 'Simpan'  ?></button>
                                </div>

                            </div><!-- ROW -->


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('pageScript') ?>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- filepond JS -->

<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

<!-- Summernote -->
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>

<script>
    $(document).ready(function() {

        let csrfName = '<?= csrf_token() ?>'
        let csrfHash = '<?= csrf_hash() ?>'

        $('#summernote').summernote({
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36'] // 👈 daftar ukuran

        })

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );

        const pond = FilePond.create(document.querySelector('.filepond'), {
            allowMultiple: false,
            acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxFileSize: '2MB',
            storeAsFile: true,
        });

        // Preload image if available
        <?php if (!empty($page['image'])): ?>
            pond.addFile("<?= base_url('uploads/pages/' . $page['image']) ?>");
        <?php endif; ?>

        $('.select2').select2({
            theme: "bootstrap4",
            placeholder: "Pilih Kategori",
            allowClear: true
        });

    })
</script>

<?= $this->endSection() ?>