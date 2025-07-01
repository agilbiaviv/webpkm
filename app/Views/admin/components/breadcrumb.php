<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= count($breadcrumbs) == 1 ? "Beranda" : $breadcrumbs[1]['name']; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php if (!empty($breadcrumbs)): ?>
                        <?php foreach ($breadcrumbs as $breadcrumb): ?>
                            <li class="breadcrumb-item <?= isset($breadcrumb['active']) && $breadcrumb['active'] ? 'active' : '' ?>">
                                <?php if (isset($breadcrumb['url'])): ?>
                                    <?php if($breadcrumb['url'] == "#") : ?>
                                        <?= esc($breadcrumb['name']) ?>
                                    <?php else : ?>
                                        <a href="<?= base_url($breadcrumb['url']) ?>"><?= esc($breadcrumb['name']) ?></a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?= esc($breadcrumb['name']) ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
