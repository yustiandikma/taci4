<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col">

            <h1 class="mt-2">Index Dokumen</h1>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Author</th>
                        <th scope="col">File</th>
                        <th scope="col">Release Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php $i = 1; ?>
                        <?php foreach ($docs as $d) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $d['author']; ?></td>
                        <td><?= $d['file_name']; ?></td>
                        <td><?= $d['release_year']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>


<?= $this->endsection(); ?>