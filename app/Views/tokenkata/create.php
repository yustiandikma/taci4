<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Tambah Data</h2>
            <form action="/tokenkata/save" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <!-- Cross-site Resouece Forgery menghindari pemasulsuan data dari halaman lain -->
                <!-- <div class="row mb-3">
                    <label for="dokumen" class="col-sm-2 col-form-label ">Dokumen</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('dokumen')) ? 'is-invalid' : ''; ?>" id="dokumen" name="dokumen" autofocus>
                        <div id="dokumen" class="invalid-feedback">
                            <?= $validation->getError('dokumen'); ?>.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="dokumen" class="col-sm-2 col-form-label ">Dokumen</label>
                    <div class="col-sm-10">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                    </div>
                </div> -->

                <div class="mb-3">
                    <label for="dokumen" class="col-sm-2 form-label">Pilih Dokumen</label>
                    <div>
                        <input class="form-control is-invalid <?= ($validation->hasError('dokumen')) ? 'is-invalid' : ''; ?>" type="file" id="dokumen" name="dokumen">
                        <div id="dokumen" class="invalid-feedback">
                            <?= $validation->getError('dokumen'); ?>.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>

        </div>
    </div>
</div>


<?= $this->endsection(); ?>