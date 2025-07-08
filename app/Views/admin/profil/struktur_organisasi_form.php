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

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <script>
                        setTimeout(() => {
                            $('.alert-danger').fadeOut('slow');
                        }, 5000);
                    </script>
                <?php endif; ?>
                <form action="<?= isset($struktur) ? site_url('admin/profil/struktur-organisasi/update/' . $struktur['id']) : site_url('admin/profil/struktur-organisasi/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if (isset($struktur['id'])): ?>
                        <input type="hidden" name="id" value="<?= $struktur['id'] ?>">
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Struktur Organisasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $struktur['nama'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="<?= old('jabatan', $struktur['jabatan'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_id">Atasan</label>
                                        <select name="parent_id" class="form-control select2" <?= empty($strukturList) ? "readonly" : ""  ?>>
                                            <option value="" selected>Tidak Ada (Otomatis Menjadi Pemimpin)</option>
                                            <?php foreach ($strukturList as $item): ?>
                                                <option value="<?= $item['id'] ?>" <?= (isset($struktur['parent_id']) && $struktur['parent_id'] == $item['id']) ? 'selected' : '' ?>>
                                                    <?= $item['nama'] ?> - <?= $item['jabatan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto <?= isset($struktur['foto']) ? '(Kosongkan jika tidak ingin diganti)' : '' ?></label>
                                        <input type="file"
                                            name="foto"
                                            class="filepond"
                                            data-max-file-size="2MB">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Urutan</label>
                                        <input type="number" name="urutan" title="Urutan Tampilan Dalam Struktur Organisasi" class="form-control" value="<?= old('urutan', $struktur['urutan'] ?? 0) ?>" required>
                                        <small class="form-text text-muted">urutan terkecil berada di paling kiri pada struktur organisasi.</small>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end align-items-center">
                                    <a class="btn btn-outline-secondary m-1" href="<?= base_url('admin/profil/struktur-organisasi') ?>">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('pageScript') ?>
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

<script>
    $(document).ready(function() {

        let csrfName = '<?= csrf_token() ?>'
        let csrfHash = '<?= csrf_hash() ?>'

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
        <?php if (!empty($struktur['foto'])): ?>
            pond.addFile("<?= base_url('uploads/struktur/' . $struktur['foto']) ?>");
        <?php endif; ?>

        $('.select2').select2({
            theme: "bootstrap4",
        });

    })
</script>

<?= $this->endSection() ?>