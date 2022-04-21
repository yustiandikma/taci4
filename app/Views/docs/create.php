<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">

            <h2 my-3>Form Tambah Data</h2>
            <form action="/docs/save" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="author" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control is-invalid <?= ($validation->hasError('author')) ? 'is-invalid' : ''; ?>" id="author" name="author" autofocus value="<?= old('author'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('author'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="release_year" class="col-sm-2 col-form-label">Tahun</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control is-invalid <?= ($validation->hasError('release_year')) ? 'is-invalid' : ''; ?>" id="release_year" name="release_year" value="<?= old('release_year'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('release_year'); ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="row mb-3 form-group">
                    <label for="date" class="col-sm-1 col-form-label">Date</label>
                    <div class="col-sm-4">
                        <div class="input-group date" id="datepicker">
                            <input type="text" class="form-control">
                            <span class="input-group-append">
                                <span class="input-group-text bg-white d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                </div> -->
                <div class="row mb-3">
                    <label for="file_name" class="col-sm-2 col-form-label">File</label>
                    <input class="form-control is-invalid <?= ($validation->hasError('file_name')) ? 'is-invalid' : ''; ?>" type="file" id="file_name" name="file_name">
                    <div id="file_name" class="invalid-feedback">
                        <?= $validation->getError('file_name'); ?>.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>

        </div>
    </div>
</div>

<?= $this->endsection(); ?>