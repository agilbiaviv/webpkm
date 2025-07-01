<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= count($breadcrumbs) == 1 ? "Beranda" : $breadcrumbs[1]['name']; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
  <style>
    body {
      transition: background-color .3s, color .3s;
    }

    body.dark-mode .main-header.navbar {
      background-color: #343a40 !important;
      border-bottom: 1px solid #4b545c;
      /* dark gray */
      color: #f8f9fa !important;
    }

    body.dark-mode .main-header.navbar .nav-link,
    body.dark-mode .main-header.navbar .navbar-nav .nav-item .nav-link {
      color: #f8f9fa !important;
    }

    body.dark-mode .navbar-light .navbar-nav .nav-link {
      color: #f8f9fa !important;
    }
  </style>
  <!-- css spesific page -->
  <?= $this->renderSection('pageStyle'); ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="hold-transition sidebar-mini">
  <script>
    if (localStorage.getItem('dark-mode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

  <!--begin::App Wrapper-->
  <div class="wrapper">
    <?= $this->include('admin/components/navbar') ?>
    <?= $this->include('admin/components/sidebar') ?>
    <!--begin::App Main-->
    <div class="content-wrapper">
      <?= $this->include('admin/components/breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
      <div class="content">
        <!-- content disini  -->
        <?= $this->renderSection('content') ?>
      </div>
    </div>
    <?= $this->include('admin/components/footer') ?>
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <!-- jQuery -->
  <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- AdminLTE -->
  <script src="<?= base_url('assets/dist/js/adminlte.js'); ?>"></script>
  <script>
    $(document).ready(function() {
      const darkModeEnabled = localStorage.getItem('dark-mode') === 'true';

      if (darkModeEnabled) {
        $('body').addClass('dark-mode');
        $('#darkModeSwitch').prop('checked', true);
      }

      $('#darkModeSwitch').change(function() {
        if (this.checked) {
          $('body').addClass('dark-mode');
          localStorage.setItem('dark-mode', 'true');
        } else {
          $('body').removeClass('dark-mode');
          localStorage.setItem('dark-mode', 'false');
        }
      });
    });
  </script>



  <?= $this->renderSection('pageScript'); ?>
</body>

</html>