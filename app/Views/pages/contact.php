<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Contact</h1>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, maiores excepturi impedit corporis esse. Eaque iste, tempore esse eos laborum, qui velit perspiciatis sed voluptates, aspernatur numquam. Suscipit, officiis!
            </p>
            <?php foreach ($alamat as $d) : ?>
                <ul>
                    <li><?= $d['tipe'] ?></li>
                    <li><?= $d['jalan'] ?></li>
                    <li><?= $d['kota'] ?></li>
                </ul>
            <?php endforeach ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>