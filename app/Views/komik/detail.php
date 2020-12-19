<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Detail Komik</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= base_url('img/' . $komik['sampul']) ?>" alt="<?= $komik['judul'] ?>" title="<?= $komik['judul'] ?>" class="w-100">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul'] ?></h5>
                            <p class="card-text">
                                <b>Penulis <?= ' : ' . $komik['penulis'] ?></b><br />
                                Penerbit <?= ' : ' . $komik['penerbit'] ?>
                            </p>
                            <p class="card-text mb-4"><small class="text-muted">Last updated 3 mins ago</small></p>


                            <a href="<?= base_url('komik/edit/' . $komik['slugh']) ?>" class="btn btn-warning">Edit</a>

                            <!-- membuat html spoofing -->
                            <form action="<?= base_url('komik/' . $komik['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin hapus data ini?')">Delete</button>
                            </form>

                            <a href="<?= base_url('komik') ?>" class="btn btn-dark">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>