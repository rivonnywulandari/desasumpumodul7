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
                            <h4 class="card-title text-center">Package Information</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/package/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
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
                                        <td class="fw-bold">Type</td>
                                        <td><?= esc($data['type_name']); ?></td>
                                    </tr>                                   
                                    <tr>
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($data['contact_person']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Minimal Capacity </td>
                                        <td><?= esc($data['min_capacity']); ?> people</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td><?= 'Rp ' . number_format(esc($data['price']), 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Description </p>
                            <p><?= esc($data['description']);?></p>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Service Include <br>
                            <?php foreach ($serviceinclude as $ls) : ?>
                                <li><?= esc($ls['name']);?></li>
                            <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Service Exclude</p>
                            <?php foreach ($serviceexclude as $ls) : ?>
                                <li><?= esc($ls['name']);?></li>
                            <?php endforeach; ?>
                            <br> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Activity</p>
                            <?php foreach ($day as $d) : ?>
                                <b>Day <?= esc($d['day']);?></b><br> 
                                <?php foreach ($activity as $ac) : ?>
                                    <?php if($d['day']==$ac['day']): ?>
                                        <?= esc($ac['activity']);?>. <?= esc($ac['name']);?> : <?= esc($ac['description']);?> <br>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <br> 
                        </div>
                    </div>
                    <button type="button" id="video-play" class="btn-play btn btn-outline-primary" data-bs-toggle="modal" data-src="<?= base_url('media/videos/' . esc($data['video_url']) . ''); ?>" data-bs-target="#videoModal" <?= ($data['video_url'] == '') ? 'disabled' : ''; ?>>
                        <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">play_circle</span> Play Video
                    </button>

                    <div class="modal fade text-left" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel17">Video</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="ratio ratio-16x9">
                                        <video src="" class="embed-responsive-item" id="video" controls>Sorry, your browser doesn't support embedded videos</video>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/our_gallery'); ?>

        </div>

        <div class="col-md-5 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                    <?= $this->include('web/layouts/map-head'); ?>
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
                <div class="card-body">
                    <div class="col-auto ">
                        <br>
                        <div class="btn-group float-right" role="group">
                            <?php foreach ($day as $d) : ?>
                                <?php  $loop = 0; ?>
                                <script>
                                    function add<?= $d['day'], $d['package_id']; ?>() 
                                    {

                                        initMap();
                                        map.setZoom(15);
                                        <?php 
                                            $activitiesForDay = array_filter($activity, function($activity) use ($d) {
                                                return $activity['day'] === $d['day'];
                                            });
                                            foreach ($activitiesForDay as $object) {
                                            $loop++;                                    

                                            $lat_now = isset($object['lat'])?esc($object['lat']):'';
                                            $lng_now = isset($object['lng'])?esc($object['lng']):'';
                                            $objectid = isset($object['object_id'])?esc($object['object_id']):'';
                                            ?>
                                                objectMarkerRoute("<?= $objectid; ?>", <?= $lat_now; ?>, <?= $lng_now; ?>, true, <?= $loop; ?>);
                                            
                                            <?php 
                                                if (1 < $loop) { ?>
                                               
                                                    // new01(<?= $lat_bef; ?>, <?= $lng_bef; ?>, <?= $lat_now; ?>, <?= $lng_now; ?>);
                                                    pointA<?= $loop; ?> = new google.maps.LatLng(<?= $lat_bef; ?>, <?= $lng_bef; ?>);
                                                    pointB<?= $loop; ?> = new google.maps.LatLng(<?= $lat_now; ?>, <?= $lng_now; ?>);
                                                    directionsService<?= $loop; ?> = new google.maps.DirectionsService;
                                                    directionsDisplay<?= $loop; ?> = new google.maps.DirectionsRenderer({
                                                    suppressMarkers: true,
                                                    map: map
                                                    });
                                                    directionsService<?= $loop; ?>.route({
                                                    origin: pointA<?= $loop; ?>,
                                                    destination: pointB<?= $loop; ?>,
                                                    avoidTolls: true,
                                                    avoidHighways: false,
                                                    travelMode: google.maps.TravelMode.DRIVING
                                                    }, function(response, status) {
                                                    if (status == google.maps.DirectionsStatus.OK) {
                                                        directionsDisplay<?= $loop; ?>.setDirections(response);
                                                    } else {
                                                        window.alert('Directions request failed due to ' + status);
                                                    }
                                                    });
                                                
                                            <?php 
                                                } 
                                            ?>
                                            <?php 
                                            $lat_bef = $lat_now;
                                            $lng_bef = $lng_now; 
                                            ?>
                                            <?php 
                                            }
                                            ?>
                                    }
                                    </script>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm" type="button" aria-expanded="false" onclick="add<?= $d['day'], $d['package_id']; ?>();">Day <?= $d['day']; ?> Route</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php if (!empty($activitiesForDay)):  ?>
                                                <?php foreach ($activitiesForDay as $index => $currentActivity) :?>
                                                    <?php  $loop++; ?>
                                                    <?php if ($currentActivity['day'] === $d['day']) : ?>

                                                            <?php if (isset($activitiesForDay[$index + 1])): 
                                                                $nextActivity = $activitiesForDay[$index + 1];
                                                            ?>    
                                                                <li><button type="button" onclick="routeBetweenObjects( <?= $currentActivity['lat'] ?>, <?= $currentActivity['lng'] ?>, <?= $nextActivity['lat']?>, <?= $nextActivity['lng'] ?>)" class="btn btn-outline-primary"><i class="fa fa-road"></i>  Activity <?= esc($currentActivity['activity']);?> ke <?= esc($nextActivity['activity']);?></button></a></li>

                                                            <?php endif; ?>    

                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <script>
                    initMap(-0.54145013, 100.48094882)
                </script>
                <?php foreach($day as $d) : ?>
                    <?php foreach($activity as $ac) : ?>
                    <script>
                    </script>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <!-- Direction section -->
            <?= $this->include('web/layouts/direction'); ?>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    const myModal = document.getElementById('videoModal');
    const videoSrc = document.getElementById('video-play').getAttribute('data-src');

    myModal.addEventListener('shown.bs.modal', () => {
        // console.log(videoSrc);
        document.getElementById('video').setAttribute('src', videoSrc);
    });
    myModal.addEventListener('hide.bs.modal', () => {
        document.getElementById('video').setAttribute('src', '');
    });

    $('#direction-row').hide();

</script>
<?= $this->endSection() ?>
