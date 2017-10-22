<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageVar['objectName'] ?> Management
        <small>Add / Edit Item</small>
      </h1>
    </section>
    
    <section class="content">
        <?php // var_dump($create_edit); ?>
    
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter <?php echo $pageVar['objectName'] ?> Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                    
                    <?php echo form_open_multipart(base_url() . $pageVar['page'].'/save_create');?>
                        <div class="box-body">
                            <?php foreach($create_edit as $field ){
                                createfield($field);
                            }?>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
    
</div>
<!--<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>