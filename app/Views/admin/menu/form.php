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

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= isset($menu) ? base_url('admin/menu-manager/update/' . $menu['id']) : base_url('admin/menu-manager/save') ?>" method="POST">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Manajemen Menu</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?= csrf_field() ?>
                                <?php if (isset($menu)) : ?>
                                    <input type="hidden" name="id" value="<?= $menu['id'] ?>">
                                <?php endif; ?>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Menu <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" autocomplete="off"
                                            value="<?= isset($menu) ? $menu['name'] : '' ?>"
                                            name="name"
                                            placeholder="Masukkan nama menu"
                                            required>
                                    </div>
                                </div>

                                <!-- Tipe -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipe Menu <span class="text-danger">*</span></label>
                                        <select name="type" id="menuType" class="form-control select2" required>
                                            <option value="">Pilih Tipe Menu</option>
                                            <option value="page" <?= (isset($menu) && $menu['type'] == 'page') ? 'selected' : '' ?>>Page (layout tampilan seragam)</option>
                                            <option value="custom" <?= (isset($menu) && $menu['type'] == 'custom') ? 'selected' : '' ?>>Custom (link eksternal)</option>
                                            <option value="special" <?= (isset($menu) && $menu['type'] == 'special') ? 'selected' : '' ?>>Special (layout tampilan berbeda / hardcode)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>URL</label>
                                        <input type="text" class="form-control" autocomplete="off"
                                            value="<?= isset($menu) ? $menu['url'] : '' ?>"
                                            name="url"
                                            placeholder="contoh : /visi-misi">
                                        <small class="text-muted">Jika menu adalah parent (punya submenu), isi url dengan <strong class="text-danger">"#"</strong></small>
                                    </div>
                                </div>


                                <!-- Page select (muncul kalau type=page) -->
                                <div class="col-md-6 type-field type-page d-none">
                                    <div class="form-group">
                                        <label>Pilih Halaman</label>
                                        <select name="page_id" class="form-control select2">
                                            <option value="">-- Pilih Halaman --</option>
                                            <?php foreach ($pages as $p): ?>
                                                <option value="<?= $p['id'] ?>" <?= (isset($menu) && $menu['page_id'] == $p['id']) ? 'selected' : '' ?>>
                                                    <?= $p['title'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- menu special -->
                                <div class="col-md-6 type-field type-special d-none">
                                    <div class="form-group">
                                        <label>Menu Khusus</label>
                                        <input type="text" name="special_key" class="form-control" value="<?= $menu['special_key'] ?? '' ?>" placeholder="ex: berita, inovasi, pengaduan ...">
                                        <small class="text-muted">
                                            Gunakan lowercase tanpa spasi. Contoh: <code>berita</code> → akan diarahkan ke <code>BeritaController</code>.
                                        </small>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Parent Menu</label>
                                        <select name="parent_id" class="form-control select2" style="width:100%">
                                            <option value="">-- Tidak Ada --</option>
                                            <?php foreach ($menus as $m): ?>
                                                <option value="<?= $m['id'] ?>"
                                                    <?= isset($menu) && $menu['parent_id'] == $m['id'] ? 'selected' : '' ?>>
                                                    <?= $m['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Pilih parent jika menu ini submenu.</small>
                                    </div>
                                </div>

                                <!-- Posisi -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Posisi (Urutan) <span class="text-danger">*</span></label>
                                        <input type="number" name="position" class="form-control" value="<?= $menu['position'] ?? 1 ?>" min="1" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="active" <?= isset($menu) && $menu['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="inactive" <?= isset($menu) && $menu['status'] == 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end align-items-center">
                                    <a class="btn btn-outline-secondary m-1" href="<?= base_url('admin/menu-manager') ?>">Kembali</a>
                                    <button type="submit" class="btn btn-<?= isset($menu) ? 'warning' : 'primary'  ?>">
                                        <?= isset($menu) ? 'Update' : 'Simpan'  ?>
                                    </button>
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

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap4",
            placeholder: "Pilih opsi",
            allowClear: true
        });
    })
</script>
<script>
    function toggleFields(type) {
        document.querySelectorAll('.type-field').forEach(el => el.classList.add('d-none'));
        if (type && type != "custom") {
            document.querySelector('.type-' + type).classList.remove('d-none');
        }
    }

    $('#menuType').on('change', function() {
        toggleFields(this.value);
    });

    // trigger saat edit
    toggleFields($('#menuType').val());
</script>
<?= $this->endSection() ?>