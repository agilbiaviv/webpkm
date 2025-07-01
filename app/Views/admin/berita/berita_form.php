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

        <form action="<?= isset($berita) ? base_url('admin/berita/update/' . $berita['id']) : base_url('admin/berita/save') ?>" method="POST" enctype="multipart/form-data">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Form Berita</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">

                    <?= csrf_field() ?>
                    <?php if (isset($berita)) : ?>
                      <input type="hidden" name="id" value="<?= $berita['id'] ?>">
                    <?php endif; ?>
                    <label>Kategori Berita</label>
                    <div class="input-group">
                      <select class="form-control select2" name="kategori_id" <?= empty($kategori) ? ' disabled' : ''; ?> required>
                        <?php if (empty($kategori)) : ?>
                          <option>-- Silahkan tambahkan kategori terlebih dahulu --</option>
                        <?php endif; ?>
                        <?php foreach ($kategori as $k) : ?>
                          <option value="<?= $k['id'] ?>" <?= isset($berita) && $berita['kategori_id'] == $k['id'] ? 'selected' : ''  ?>><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahKategori">
                        + Tambah Kategori
                      </button>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" class="form-control" value="<?= isset($berita) ? $berita['judul_berita'] : '' ?>" name="judul_berita" placeholder="Masukkan judul berita" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tanggal Berita</label>
                    <input type="date" class="form-control" value="<?= isset($berita) ? $berita['tanggal_berita'] : '' ?>" name="tanggal_berita" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Foto</label>
                    <input type="file"
                      class="filepond"
                      name="foto"
                      data-max-file-size="2MB"
                      required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Deskripsi Foto</label>
                    <input type="text" class="form-control" value="<?= isset($berita) ? $berita['caption_foto'] : ''  ?>" name="caption_foto" required>
                  </div>
                </div>



                <div class="col-md-12">
                  <div class="form-group">
                    <label>Uraian Berita</label>
                    <textarea class="form-control" id="summernote" name="deskripsi" row="5" required><?= isset($berita) ? $berita['deskripsi'] : ''  ?></textarea>
                  </div>
                </div>

                <div class="col-md-12 d-flex justify-content-end align-items-center">
                  <a class="btn btn-outline-secondary m-1" href="<?= base_url('admin/berita') ?>">Kembali</a>
                  <button type="submit" class="btn btn-<?= isset($berita) ? 'warning' : 'primary'  ?>"><?= isset($berita) ? 'Update' : 'Simpan'  ?></button>
                </div>

              </div><!-- ROW -->


            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kategori Berita</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Kategori</label>
          <input type="text" class="form-control" id="namaKategori" placeholder="Masukkan kategori baru">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnTambahKategori">Tambah</button>
      </div>
    </div>
  </div>
</div>

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
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
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
    <?php if (!empty($berita['foto'])): ?>
      pond.addFile("<?= base_url('uploads/berita/' . $berita['foto']) ?>");
    <?php endif; ?>

    $('.select2').select2({
      theme: "bootstrap4",
      placeholder: "Pilih Kategori",
      allowClear: true
    });

    $('#namaKategori').keypress(function(event) {
      if (event.which === 13) { // 13 = Enter key
        event.preventDefault(); // Prevent default form submission
        $('#btnTambahKategori').click(); // Trigger button click
      }
    });
    $('#btnTambahKategori').click(function() {
      var namaKategori = $('#namaKategori').val();

      if (namaKategori.trim() === '') {
        alert('Nama kategori tidak boleh kosong!');
        return;
      }

      $.ajax({
        url: "<?= base_url('admin/kategori/add') ?>",
        type: "POST",
        data: {
          nama_kategori: namaKategori,
          [csrfName]: csrfHash
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
          console.log("Server Response:", response);

          if (response && response.success) {
            // SweetAlert2 Success
            csrfHash = response.csrfHash //refresh CSRF token
            $('input[name="csrf_test_name"]').val(response.csrf_hash)

            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: 'Kategori berhasil ditambahkan!',
              showConfirmButton: false,
              timer: 2000
            });

            // Refresh dropdown options
            refreshKategoriDropdown();

            // Close modal and clear input
            $('#modalTambahKategori').modal('hide');
            $('#namaKategori').val('');
          } else {
            // SweetAlert2 Warning/Error
            Swal.fire({
              icon: 'warning',
              title: 'Gagal!',
              text: response.message || 'Kategori sudah ada!',
            });
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: ", xhr.responseText);

          // SweetAlert2 Error
          Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Terjadi kesalahan, coba lagi nanti.'
          });
        }
      });

    });

    function refreshKategoriDropdown() {
      $.ajax({
        url: "<?= base_url('admin/kategori/fetch') ?>", // Adjust this endpoint to fetch updated categories
        type: "GET",
        dataType: "json",
        success: function(response) {
          let dropdown = $('select[name="kategori_id"]');
          dropdown.removeAttr('disabled');
          dropdown.empty(); // Clear existing options

          $.each(response, function(index, kategori) {
            dropdown.append(`<option value="${kategori.id}">${kategori.nama_kategori}</option>`);
          });

          dropdown.val(response[response.length - 1]?.id); // Select the newly added category
        },
        error: function() {
          console.error("Failed to refresh dropdown.");
        }
      });
    }

  })
</script>

<?= $this->endSection() ?>