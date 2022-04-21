<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h1>Hello, world!</h1>

            <?php if (session()->getFlashdata('pesan')) :  ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos magni nostrum ab laborum, ipsa placeat aut natus veniam odio aspernatur animi impedit, nisi minus, omnis vel corporis deserunt quae. Itaque.</p>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>