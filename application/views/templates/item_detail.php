<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-4 col-lg-3 col-md-3 col-xlg-2">
                        <div><img src="<?php echo base_url(). 'uploads/'. $item->icon; ?>" width="100%" /></div>
                    </div>
                    <div class="col-sm-8 col-lg-9 col-md-9 col-xlg-10">
                        <div><h1><?php echo $item->name; ?></h1></div>
                        <div><h3><?php echo $item->company; ?></h3></div>
                        <div><a class="btn btn-primary" href="<?php echo $item->download_link; ?>">Download</a></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div><?php echo $item->description; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div><h3>Info application</h3></div>
                        <table style="width: 100%;">
                            <tr>
                                <th>Update</th>
                                <th>Version</th>
                                <th>Size</th>
                                <th>View</th>
                            </tr>
                            <tr>
                                <td><?php 
                                    $date = date_create($item->created_at);
                                    echo date_format($date, "Y-m-d"); ?></td>
                                <td><?php echo $item->version; ?></td>
                                <td><?php echo $item->size; ?></td>
                                <td><?php echo $item->view; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!-- ./col -->
<!--            <div class="col-lg-3">
                Cột đang làm
            </div> ./col -->
          </div>
    </section>
</div>