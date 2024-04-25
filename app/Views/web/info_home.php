<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <!--map-->
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-auto">
                            <h5 class="card-title">Google Maps with Location</h5>
                        </div>
                        <!-- <script>
                            ramalancuaca();
                        </script>
                        <div class="col-md-auto" id="weather-info"></div> -->
                        <?= $this->include('web/layouts/map-head'); ?>
                    </div>
                </div>
                <?= $this->include('web/layouts/map-body-5'); ?>
            </div>
        </div>


        <div class="col-md-4 col-12">
            <div class="row">
                <!--popular-->
                <div class="col-12" id="list-rec-col">
                    <div class="card">
                        <div class="card-header">
                            <script>
                                getTourismVillageInfo();
                            </script>
                            <?php foreach ($data as $item) : endforeach; ?>

                            <h5 class="card-title text-center"><?= esc($item['name']); ?></h5>

                        </div>
                        <div class="card-body table-responsive" style="max-height: 550px;">
                            <?php $i = 0; ?>
                            <script>
                                clearMarker();
                                clearRadius();
                                clearRoute();
                            </script>

                            <script>
                                objectMarker("<?= esc($item['id']); ?>", <?= esc($item['lat']); ?>, <?= esc($item['lng']); ?>);
                            </script>
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php foreach ($item['gallery'] as $x) : ?>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= esc($i); ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></li>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php $i = 0; ?>
                                    <?php foreach ($item['gallery'] as $g) : ?>
                                        <div class="carousel-item<?= ($i == 0) ? ' active' : ''; ?>">
                                            <a>
                                                <img src="<?= base_url('media/photos/sumpu/' . esc($g)); ?>" class="d-block w-100">
                                            </a>
                                        </div>
                                    <?php $i++;
                                    endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                            <?php if (isset($data)) : ?>
                                <?php foreach ($data as $item) : ?>
                                    <div class="row">
                                        <div class="col table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold">Name</td>
                                                        <td><?= esc($item['name']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Type of Tourism</td>
                                                        <td><?= esc($item['type_of_tourism']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Address</td>
                                                        <td><?= esc($item['address']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Open</td>
                                                        <td><?= esc($item['open']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Close</td>
                                                        <td><?= esc($item['close']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Contact Person</td>
                                                        <td><?= esc($item['contact_person']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Nearby section -->
            <?= $this->include('web/layouts/nearby'); ?>
        </div>
    </div>
    <!-- Direction section -->
    <?= $this->include('web/layouts/direction'); ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $('#direction-row').hide();
    $('#check-nearby-col').hide();
    $('#result-nearby-col').hide();
</script>
<?= $this->endSection() ?>