<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- Content Header (Page header) -->
                <section class="content-header header">
                  <h1>
                    New 
                    <small>Application</small>
                  </h1>
                </section>
                <div class="row">
                    <?php foreach ($items as $item): ?>
                    <div class="col-sm-6 col-lg-3 col-md-3 col-xlg-2">
                        <div class="thumbnail">
                            <div class="picCard">
                                <a href="<?php echo base_url().'itemDetail/'.$item->id; ?>"><img class="lazy" alt="" src="<?php echo base_url() . 'uploads/' . ($item->icon == '' ? 'no-photo.gif' : $item->icon); ?>"></a>
                            </div>
                            <div class="caption">
                                <h5 class="titleCard"><a href="<?php echo base_url().'itemDetail/'.$item->id; ?>"><?php echo $item->name ?></a>
                                </h5>
                                <p class="subCard"><a href="<?php echo base_url().'itemDetail/'.$item->id; ?>"><?php echo $item->company ?></a></p>
                                <p class="btnCard">
                                    <a class="btn btn-default" href="<?php echo base_url().'itemDetail/'.$item->id; ?>">Download</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- ./col -->
<!--            <div class="col-lg-3">
                Cột đang làm
            </div> ./col -->
          </div>
    </section>
</div>