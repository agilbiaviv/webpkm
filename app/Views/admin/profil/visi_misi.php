<?= $this->extend('admin/template') ?>

<?= $this->section('pageStyle') ?>
<meta name="csrf_token_name" content="<?= csrf_token() ?>">
<meta name="csrf_token" content="<?= csrf_hash() ?>">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

                <form action="<?= base_url('admin/visi-misi/save') ?>" method="POST">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Visi Misi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $data['id'] ?? '' ?>">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Visi</label>
                                        <textarea class="form-control" id="summernote-visi" name="visi" row="5" required><?= isset($data) ? $data['visi'] : '' ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Misi</label>
                                        <textarea class="form-control" id="summernote-misi" name="misi" row="5" required><?= isset($data) ? $data['misi'] : '' ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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

<!-- Summernote -->
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>

<script>
    $(document).ready(function() {

        $('#summernote-visi').summernote({
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        })

        $('#summernote-misi').summernote({
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        })


    })
</script>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>


<?= $this->endSection() ?>