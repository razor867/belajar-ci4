<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="<?= base_url('komik/create') ?>" class="btn btn-primary mb-2">Tambah Komik</a>
            <h1>Daftar Komik</h1>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($komik as $k) {
                        $i++; ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><img src="<?= base_url('img/' . $k['sampul']) ?>" alt="" class="sampul"></td>
                            <td><?= $k['judul'] ?></td>
                            <td>
                                <a href="<?= base_url('komik/' . $k['slugh']) ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>