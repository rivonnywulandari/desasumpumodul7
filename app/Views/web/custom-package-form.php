<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
$users = in_array('users', $uri);
?>

<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('styles') ?>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/form-element-select.css'); ?>">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap Table with Add and Delete Row Feature</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


<style>
    .filepond--root {
        width: 100%;
    }

    body {
        color: #000 !important;
        background: #F5F7FA;
        /* font-family: 'Open Sans', sans-serif; */
    }

    .table-wrapper {
        margin: 10px auto;
        background: #fff;
        padding: 5px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }

    .table-title {
        padding-bottom: 0px;
        margin: 0 0 0px;
    }

    .table-title h2 {
        margin: 3px 0 0;
        font-size: 16px;
    }

    .table-title .add-new {
        float: right;
        height: 25px;
        font-weight: bold;
        font-size: 10px;
        text-shadow: none;
        min-width: 80px;
        border-radius: 50px;
        line-height: 11px;
    }

    .table-title .add-new i {
        margin-right: 2px;
    }

    table.table {

        width: 100%;
    }

    table.table tr th,
    table.table tr td {
        border-color: #e9e9e9;
        padding: 5px;
    }

    table.table tr {
        margin-bottom: 0px;
        height: 20px;
    }

    table.table th i {
        font-size: 11px;
        margin: 0 3px;
        cursor: pointer;
    }

    table.table th:last-child {
        width: 80px;
    }

    table.table td a {
        cursor: pointer;
        display: inline-block;
        margin: 0 3px;
        min-width: 20px;
    }

    table.table td a.add {
        color: #27C46B;
    }

    table.table td a.edit {
        color: #FFC107;
    }

    table.table td a.delete {
        color: #E34724;
    }

    table.table td i {
        font-size: 14px;
    }

    table.table td a.add i {
        font-size: 18px;
        margin-right: -1px;
        position: relative;
        top: 1px;
    }

    table.table .form-control {
        height: 25px;
        line-height: 25px;
        box-shadow: none;
        border-radius: 2px;
        font-size: 12px;
    }

    table.table .form-control.error {
        border-color: #f50000;
    }

    table.table td .add {
        display: none;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>
        <?php if (session()->has('warning')) : ?>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Wait!',
                    text: '<?= session('warning') ?>',
                });
            </script>
        <?php endif; ?>
        <?php if (session()->has('success')) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session('success') ?>',
                });
            </script>
        <?php endif; ?>
        <?php if (session()->has('failed')) : ?>
            <script>
                Swal.fire({
                    icon: 'danger',
                    title: 'Failed!',
                    text: '<?= session('failed') ?>',
                });
            </script>
        <?php endif; ?>

        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Custom Your Package</h4>
                </div>
                <div col="auto">
                    <div class="btn-group float-end" role="group">
                        <a href="<?= base_url('web/reservation/custombooking/') . $data['id']; ?>" class="btn btn-success"><i class="fa fa-cart-plus"></i> Booking This Package</a>
                        <form action="<?= base_url('web/package/deletepackage') . '/' . $data['id']; ?>" method="post" id="formcancel" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= esc($data['id']); ?>">
                            <input type="hidden" name="name" value="<?= esc($data['name']); ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-danger" onclick="return showconfirmcancelbooking();"><i class="fa fa-times"></i>Cancel Custom This Package</button>
                        </form>
                    </div>
                </div>

                <script>
                    function showconfirmcancelbooking() {
                        Swal.fire({
                            title: 'Cancel Custom?',
                            text: 'You want to cancel customizing this package?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, cancel it!',
                            cancelButtonText: 'No, keep customizing'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Continue with form submission
                                document.querySelector('#formcancel').submit();
                            }
                        });

                        // Prevent form submission
                        return false;
                    }
                </script>
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
                                        <td class="fw-bold">Package Type</td>
                                        <td><?= esc($data['type_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Minimal Capacity</td>
                                        <td><?= esc($data['min_capacity']); ?> orang</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td><?= 'Rp ' . number_format(esc($data['price']), 0, ',', '.'); ?> <i class="small"><i style="color: red;">*</i>The admin will adjust the price of this package based on the activities and services added</i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Activity Your Package</h4>
                </div>
                <br>
                <div class="card-body">
                    <!-- Menambahkan hari paket -->

                    <div class="col-auto ">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#dayModal" data-bs-whatever="@getbootstrap"><i class="fa fa-plus"></i> Day</button>
                            <button type="button" class="btn btn-outline-info " data-bs-toggle="modal" data-bs-target="#activityModal" data-bs-whatever="@getbootstrap"><i class="fa fa-plus"></i> Activity</button>
                        </div>
                        <i class="small"><i style="color: red;">*</i>Add activity what you want</i>
                    </div>
                    <div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="dayModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="dayModalLabel">Package Day</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form class="row g-3" action="<?= base_url('web/detailreservation/createday') . '/' . $data['id']; ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="card-header">
                                            <?php @csrf_field(); ?>
                                            <h5 class="card-title"><?= esc($data['name']) ?></h5>
                                            <div class="row g-4">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="package">Package</label>
                                                        <input type="text" class="form-control" id="package" name="package" placeholder="Pxxxxx" readonly value="<?= esc($data['id']) ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="day">Day</label>
                                                        <input type="number" class="form-control" id="day" name="day" min="1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <input type="text" class="form-control" id="description" name="description" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                        <button type="submit" class="btn btn-outline-primary me-1 mb-1"><i class="fa-solid fa-add"></i></button>
                                        <button type="reset" class="btn btn-outline-danger me-1 mb-1"><i class="fa-solid fa-trash-can"></i> </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end menambahkan hari paket -->

                    <!-- Menambahkan Aktivitas -->
                    <div class="col-sm-2 float-end">
                        <!-- <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Activity</button> -->
                        <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="activityModalLabel">Activity Package Day </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form class="row g-3" action="<?= base_url('web/detailreservation/createactivity') . '/' . $data['id']; ?>" method="post">
                                        <div class="modal-body">
                                            <div class="card-header">
                                                <?php @csrf_field(); ?>
                                                <div class="row g-4">
                                                    <div class="col-md-12">
                                                        <input hidden type="text" class="form-control" id="package" name="package" placeholder="Pxxxxx" disabled value="<?= esc($data['id']) ?>">
                                                        <label for="day">Activity Day</label>
                                                        <select class="form-select" name="day" required>
                                                            <option value="" selected>Select the day</option>
                                                            <?php foreach ($day as $item => $keyy) : ?>
                                                                <option value="<?= esc($keyy['day']); ?>">Activity Day <?= esc($keyy['day']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div><br>
                                                <div class="row g-4">
                                                    <div class="col-md-3">
                                                        <label for="activity">Activity</label>
                                                        <input type="number" min='1' required class="form-control" id="activity" name="activity">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="activity_type">Activity Type</label>
                                                        <select class="form-select" name="activity_type" id="activity_type" required onchange="objectOptions()">
                                                            <option value="" selected>Select Type</option>
                                                            <option value="A">Attraction</option>
                                                            <option value="TH">Traditional House</option>
                                                            <!-- <option value="HO">Homestay</option> -->
                                                            <!-- <option value="EV">Event</option> -->
                                                            <option value="CP">Culinary Place</option>
                                                            <option value="SP">Souvenir Place</option>
                                                            <option value="WO">Worship Place</option>
                                                            <option value="FC">Facility</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="object1">Object</label>
                                                        <script>
                                                            objectOptions();
                                                        </script>
                                                        <fieldset class="form-group">
                                                            <select class="form-select" name="object" id="object" required>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div><br>
                                                <div class="row g-4">
                                                    <div class="col-md-12">
                                                        <label for="description_activity">Description</label>
                                                        <input type="text" class="form-control" id="description_activity" name="description_activity" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" class="btn btn-outline-primary me-1 mb-1"><i class="fa-solid fa-add"></i></button>
                                            <button type="reset" class="btn btn-outline-danger me-1 mb-1"><i class="fa-solid fa-trash-can"></i> </button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end Menambahkan Aktivitas -->

                    <?php if (isset($day)) : ?>
                        <?php foreach ($day as $item => $key) : ?>
                            <div class="table-responsive">
                                <div class="table-wrapper">

                                    <div class="table-title">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h2><b>Day <?= esc($key['day']); ?></b></h2>
                                                <p><?= esc($key['description']); ?></p>
                                            </div>
                                            <div class="col-sm-2 ">
                                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                                    <!-- <button type="button" class="btn btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i class="material-icons">&#xE254;</i></button>                                                             -->
                                                    <form action="<?= base_url('web/detailreservation/deleteday') . '/' . $key['package_id']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="package_id" value="<?= esc($key['package_id']); ?>">
                                                        <input type="hidden" name="day" value="<?= esc($key['day']); ?>">
                                                        <input type="hidden" name="description" value="<?= esc($key['description']); ?>">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('apakah anda yakin?');"><i class="material-icons">&#xE872;</i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activity Type</th>
                                                <th>Object</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($data_package)) : ?>
                                                <?php foreach ($data_package as $item => $value) : ?>
                                                    <?php if ($value['day'] == $key['day']) : ?>
                                                        <tr>
                                                        <td><?= esc($value['activity']); ?></td>
                                                            <td><?= esc($value['name']); ?></td>
                                                            <?php if (isset($value['attraction_price'])) : ?>
                                                                <td><?= esc($value['attraction_price']); ?></td>
                                                            <?php elseif (isset($value['traditional_house_price'])) : ?>
                                                                <td><?= esc($value['traditional_house_price']); ?></td>
                                                            <?php else : ?>
                                                                <td> 0 </td>
                                                            <?php endif; ?> 
                                                            <td><?= esc($value['description']); ?></td>
                                                            <td>
                                                                <!-- <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a> -->
                                                                <!-- <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a> -->

                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <form action="<?= base_url('web/detailreservation/delete') . '/' . $value['package_id']; ?>" method="post" class="d-inline">
                                                                        <?= csrf_field(); ?>
                                                                        <input type="hidden" name="package_id" value="<?= esc($value['package_id']); ?>">
                                                                        <input type="hidden" name="day" value="<?= esc($value['day']); ?>">
                                                                        <input type="hidden" name="activity" value="<?= esc($value['activity']); ?>">
                                                                        <input type="hidden" name="description" value="<?= esc($value['description']); ?>">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('apakah anda yakin?');"><i class="material-icons">&#xE872;</i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <!-- Menambahkan Service -->
            <!-- <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Activity</button> -->
            <div class="modal fade" id="detailServicesPackageModal" tabindex="-1" aria-labelledby="detailServicesPackageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="detailServicesPackageModalLabel">Service Package</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form class="row g-3" action="<?= base_url('web/servicepackage/createservicepackage/') . $id; ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="card-header">
                                    <?php @csrf_field(); ?>
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label for="id_service">Service </label>
                                            <select class="form-select" name="id_service" required>
                                                <option value="" selected>Select the service</option>
                                                <?php foreach ($servicelist as $item) : ?>
                                                    <option value="<?= esc($item['id']); ?>"><?= esc($item['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div><br>
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="radio" name="status_service" value="1" required>
                                                Service
                                            </label>
                                            <label>
                                                <input type="radio" name="status_service" value="0" required>
                                                Non-service
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-outline-primary me-1 mb-1"><i class="fa-solid fa-add"></i></button>
                                    <button type="reset" class="btn btn-outline-danger me-1 mb-1"><i class="fa-solid fa-trash-can"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Menambahkan Service -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Services Package</h4>
                </div>
                <br>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="form-group mb-4">
                            <div class="col-auto ">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-info " data-bs-toggle="modal" data-bs-target="#detailServicesPackageModal" data-bs-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Services Package</button>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <label for="facility" class="mb-2">Services</label>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($detailservice)) : ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($detailservice as $item => $value) : ?>
                                                    <?php if ($value['status'] == "1") : ?>
                                                        <tr>
                                                            <td><?= esc($i++); ?></td>
                                                            <td><?= esc($value['name']); ?></td>
                                                            <td>
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <!-- <button type="button" class="btn btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i class="material-icons">&#xE254;</i></button>                                                             -->
                                                                    <form action="<?= base_url('web/servicepackage/delete/') . $value['package_id']; ?>" method="post" class="d-inline">
                                                                        <?= csrf_field(); ?>
                                                                        <input type="hidden" name="package_id" value="<?= esc($value['package_id']); ?>">
                                                                        <input type="hidden" name="service_package_id" value="<?= esc($value['service_package_id']); ?>">
                                                                        <input type="hidden" name="name" value="<?= esc($value['name']); ?>">
                                                                        <input type="hidden" name="status" value="<?= esc($value['status']); ?>">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('apakah anda yakin akan menghapus?');"><i class="material-icons">&#xE872;</i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <label for="facility" class="mb-2">Non-Services</label>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($detailservice)) : ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($detailservice as $item => $value) : ?>
                                                    <?php if ($value['status'] == "0") : ?>
                                                        <tr>
                                                            <td><?= esc($i++); ?></td>
                                                            <td><?= esc($value['name']); ?></td>
                                                            <td>
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <!-- <button type="button" class="btn btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i class="material-icons">&#xE254;</i></button>                                                             -->
                                                                    <form action="<?= base_url('web/servicepackage/delete/') . $value['package_id']; ?>" method="post" class="d-inline">
                                                                        <?= csrf_field(); ?>
                                                                        <input type="hidden" name="package_id" value="<?= esc($value['package_id']); ?>">
                                                                        <input type="hidden" name="service_package_id" value="<?= esc($value['service_package_id']); ?>">
                                                                        <input type="hidden" name="name" value="<?= esc($value['name']); ?>">
                                                                        <input type="hidden" name="status" value="<?= esc($value['status']); ?>">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('apakah anda yakin akan menghapus?');"><i class="material-icons">&#xE872;</i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>


    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>

<!-- <script>
    $('#datepicker_start').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });
    $('#datepicker_end').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });
</script> -->
<script>
    // const myModal = document.getElementById('videoModal');
    // const videoSrc = document.getElementById('video-play').getAttribute('data-src');

    // myModal.addEventListener('shown.bs.modal', () => {
    //     // console.log(videoSrc);
    //     document.getElementById('video').setAttribute('src', videoSrc);
    // });
    // myModal.addEventListener('hide.bs.modal', () => {
    //     document.getElementById('video').setAttribute('src', '');
    // });

    function checkRequired(event) {
        if (!$('#geo-json').val()) {
            event.preventDefault();
            Swal.fire('Please select location for the New Package');
        }
    }
</script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageResize,
        FilePondPluginMediaPreview,
    );

    // Get a reference to the file input element
    const photo = document.querySelector('input[id="gallery"]');
    const video = document.querySelector('input[id="video"]');

    // Create a FilePond instance
    const pond = FilePond.create(photo, {
        imageResizeTargetHeight: 720,
        imageResizeUpscale: false,
        credits: false,
    });
    const vidPond = FilePond.create(video, {
        credits: false,
    })

    <?php if ($edit && count($data['gallery']) > 0) : ?>
        pond.addFiles(
            <?php foreach ($data['gallery'] as $g) : ?> `<?= base_url('media/photos/package/' . $g); ?>`,
            <?php endforeach; ?>
        );
    <?php endif; ?>
    pond.setOptions({
        server: '/upload/photo'
    });

    <?php if ($edit && $data['video_url'] != null) : ?>
        vidPond.addFile(`<?= base_url('media/videos/' . $data['video_url']); ?>`)
    <?php endif; ?>
    vidPond.setOptions({
        server: '/upload/video'
    });
</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function() {
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="text" class="form-control" name="activity" id="activity"></td>' +
                '<td><input type="text" class="form-control" name="activity_type" id="activity_type"></td>' +
                '<td><input type="text" class="form-control" name="object" id="object"></td>' +
                '<td><input type="text" class="form-control" name="description" id="description"></td>' +
                '<td>' + actions + '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function() {
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            input.each(function() {
                if (!$(this).val()) {
                    $(this).addClass("error");
                    empty = true;
                } else {
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            if (!empty) {
                input.each(function() {
                    $(this).parent("td").html($(this).val());
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }
        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function() {
            $(this).parents("tr").find("td:not(:last-child)").each(function() {
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function() {
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });
    });
</script>


<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-3.3.1.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#activity_type').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo site_url('Web/DetailPackage/get_object'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {

                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                    }
                    $('#object').html(html);

                }
            });
            return false;
        });

    });
</script>


<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('detail-package-form.php/detailPackage/ambil_data') ?>",
            cache: false,
        });

        $("#activity_type").change(function() {

            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'attraction',
                        id: value
                    },
                    success: function(respond) {
                        $("#object").html(respond);
                    }
                })
            }

        });

    })
</script>

<?= $this->endSection() ?>