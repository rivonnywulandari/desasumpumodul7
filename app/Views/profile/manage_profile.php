<?= $this->extend('profile/index'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">My Profile</h3>
                </div>
                <div class="col">
                    <a href="<?= base_url('web/profile/update'); ?>" class="btn btn-primary float-end">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12 order-md-first order-last">
                    <div class="mb-4">
                        <p class="mb-2">Fullname</p>
                        <?php if (empty(user()->fullname)) : ?>
                            <p class="fw-bold fs-6"><i>(Belum dilengkapi)</i></p>
                        <?php else : ?>
                            <p class="fw-bold fs-5"><?= user()->fullname; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2">Username</p>
                        <?php if (empty(user()->username)) : ?>
                            <p class="fw-bold fs-6"><i>(Belum dilengkapi)</i></p>
                        <?php else : ?>
                            <p class="fw-bold fs-5"><?= user()->username; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2">Email</p>
                        <?php if (empty(user()->email)) : ?>
                            <p class="fw-bold fs-6"><i>(Belum dilengkapi)</i></p>
                        <?php else : ?>
                            <p class="fw-bold fs-5"><?= user()->email; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2">Address</p>
                        <?php if (empty(user()->address)) : ?>
                            <p class="fw-bold fs-6"><i>(Belum dilengkapi)</i></p>
                        <?php else : ?>
                            <p class="fw-bold fs-5"><?= user()->address; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <p class="mb-2">Phone</p>
                        <?php if (empty(user()->phone)) : ?>
                            <p class="fw-bold fs-6"><i>(Belum dilengkapi)</i></p>
                        <?php else : ?>
                            <p class="fw-bold fs-5"><?= user()->phone; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-12 order-md-last order-first mb-5">
                    <p class="mb-2">Profile Picture</p>
                    <div class="text-md-start text-center" id="avatar-container">
                        <?php if (empty(user()->user_image)) : ?>
                            <img src="<?= base_url('media/photos/user/default.jpg'); ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle">
                        <?php else : ?>
                            <?php
                            $userImage = user()->user_image;
                            $imageSrc = (strpos($userImage, 'http') === 0) ? $userImage : base_url('media/photos/user') . '/' . $userImage;
                            ?>
                            <img src="<?= $imageSrc; ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle">
                            <!-- <img src="<?= base_url('media/photos/user/'); ?><?= user()->user_image; ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle"> -->
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>