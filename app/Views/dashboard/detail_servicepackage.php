<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-7 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title text-center">Service Package Information</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/servicepackage/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>                         
                                    <tr>
                                        <td class="fw-bold">Category</td>
                                        <?php if ($data['category'] == 1) : ?>
                                        <td>Group</td>
                                        <?php elseif ($data['category'] == 2) : ?>
                                        <td>Individu</td>
                                        <?php endif; ?>
                                    </tr>      
                                    <tr>
                                        <td class="fw-bold">Min Capacity</td>
                                        <td><?= esc($data['min_capacity']); ?></td>
                                    </tr>                               
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td><?= esc($data['price']); ?></td>
                                    </tr>                               
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="col-md-5 col-12">
            <!-- Object Location on Map -->


        </div>
    </div>
</section>

<?= $this->endSection() ?>