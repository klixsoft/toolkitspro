<style>
.myipaddress p {
    font-size: 16px;
}

.myipaddress .ipaddress {
    font-size: 40px;
    line-height: 54px;
    font-weight: 600;
    letter-spacing: -.25px;
    margin-bottom: 24px;
}
</style>

<div class="myipaddress p-3">
    <div class="row">
        <div class="col-md-6">
            <strong>What is my IP Address?</strong>
            <div class="fw-bold ipaddress"><?php echo $response->ip; ?></div>
            <strong class="location_label mb-0 fw-bold">My IP address location:</strong>
            <p class="location"><?php echo $response->country; ?>, <?php echo $response->region; ?>, <?php echo $response->city; ?></p>
            <strong class="mb-0 fw-bold">Internet service provider:</strong>
            <p class="internet"><?php echo $response->isp; ?></p>
        </div>

        <div class="col-md-6">
            <div id="map" style="width: 100%; height: 280px; float: right">
                <iframe style="border:none; outline:none; width: 100%; height: 280px" id="gmap_canvas"
                    src="https://maps.google.com/maps?ll=<?php echo $response->lat; ?>,<?php echo $response->lon; ?>&z=13&output=embed"></iframe>
            </div>
        </div>
    </div>
</div>