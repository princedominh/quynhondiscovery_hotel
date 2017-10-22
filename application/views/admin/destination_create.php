<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Destination Management
        <small>Add / Edit Item</small>
      </h1>
    </section>
    
    <section class="content">
    
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
                        <h3 class="box-title">Enter Destination Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                    
                    <?php echo form_open_multipart(base_url().'admin/destination/save_create');?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control required" required="required" id="name" name="name" maxlength="200"/>
                                    </div>
                                    
                                </div>
<!--                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon">Icon</label>
                                        <input type="file" class="form-control required filename" id="icon"  name="icon" />
                                    </div>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Parent</label>
                                        <select id="type" name="parent" class="form-control required" required="required">
                                            <optgroup label="--Select Parent--">
                                                <?php foreach ($destinations as $destination):?>
                                                <option value="<?php echo $destination->id; ?>">
                                                    <?php $i=0;
                                                        while ($i<$destination->level){
                                                            echo "--";
                                                            $i++;
                                                        }
                                                    ?>
                                                    <?php echo $destination->name ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select id="type" name="type" class="form-control required" required="required">
                                            <optgroup label="--Select Type--">
                                                <?php foreach ($types as $type):?>
                                                <option value="<?php echo $type ?>" <?php if($type=="destination") echo 'selected="selected"'; ?>><?php echo $type ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control required" id="description" name="description" ></textarea>
                                    </div>
                                    
                                </div>
                            </div>
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
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>