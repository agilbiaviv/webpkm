<?= $this->extend('admin/template') ?>

<?= $this->section('pageStyle') ?>
<meta name="csrf_token_name" content="<?= csrf_token() ?>">
<meta name="csrf_token" content="<?= csrf_hash() ?>">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css'); ?>">

<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/footer-config/update') ?>" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Konfigurasi Footer</h3>
                        </div>
                        <div class="card-body">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Instansi <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_instansi" maxlength="100"
                                            class="form-control <?= session('errors.nama_instansi') ? 'is-invalid' : '' ?>"
                                            placeholder="Contoh: Puskesmas Bungatan"
                                            value="<?= esc($footer['nama_instansi'] ?? '') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" name="telepon" maxlength="20" class="form-control"
                                            placeholder="0355xxxxxx"
                                            value="<?= esc($footer['telepon'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Nomor WhatsApp</label>
                                        <input type="text" name="whatsapp" maxlength="20" class="form-control"
                                            placeholder="08xxxxxxxxxx"
                                            value="<?= esc($footer['whatsapp'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" maxlength="100" class="form-control"
                                            placeholder="email@domain.com"
                                            value="<?= esc($footer['email'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control summernote" name="alamat" rows="4"
                                            placeholder="Tulis alamat lengkap"><?= esc($footer['alamat'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="url" name="facebook" class="form-control"
                                            placeholder="https://facebook.com/nama"
                                            value="<?= esc($footer['facebook'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <input type="url" name="instagram" class="form-control"
                                            placeholder="https://instagram.com/nama"
                                            value="<?= esc($footer['instagram'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Tiktok</label>
                                        <input type="url" name="tiktok" class="form-control"
                                            placeholder="https://tiktok.com/nama"
                                            value="<?= esc($footer['tiktok'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>YouTube</label>
                                        <input type="url" name="youtube" class="form-control"
                                            placeholder="https://youtube.com/channel/..."
                                            value="<?= esc($footer['youtube'] ?? '') ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Embed URL Google Maps</label>
                                        <textarea name="maps_embed_url" rows="2" class="form-control"
                                            placeholder="https://www.google.com/maps/embed?..."><?= esc($footer['maps_embed_url'] ?? '') ?></textarea>

                                        <?php if (!empty($footer['maps_embed_url'])): ?>
                                            <div class="mt-2 rounded overflow-hidden shadow">
                                                <iframe src="<?= esc($footer['maps_embed_url']) ?>"
                                                    width="100%" height="180" style="border:0;" loading="lazy" allowfullscreen></iframe>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end align-items-center">
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
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['codeview']]
            ]
        });
    });
</script>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>