<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Management
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
                        <h3 class="box-title">Enter Item Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                    
                    <?php echo form_open_multipart(base_url().'editOldItem');?>
                        <input type="hidden" name="itemId" value="<?php echo $item->id ?>"/>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" maxlength="200" value="<?php echo $item->name ?>"/>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon">Icon (Keep empty if do not change)</label>
                                        <input type="file" class="form-control required filename" id="icon"  name="icon" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select id="type" name="type" class="form-control required" >
                                            <optgroup label="--Select Type--">
                                                <?php foreach ($type_list as $type):?>
                                                <option value="<?php echo $type['id'] ?>" <?php echo ($type['id']==$item->type_id)? 'selected':'' ?>><?php echo $type['code'] ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="os">OS</label>
                                        <select id="os" name="os" class="form-control required" >
                                            <optgroup label="--Select OS--">
                                                <?php foreach ($os_list as $os):?>
                                                <option value="<?php echo $os['id'] ?>" <?php echo ($os['id']==$item->os_id)? 'selected':'' ?>><?php echo $os['code'] ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        <input type="text" class="form-control required" id="company"  name="company" maxlength="255" value="<?php echo $item->company ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="version">Version</label>
                                        <input type="text" class="form-control required" id="version" name="version" maxlength="10" value="<?php echo $item->version ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="size">Size</label>
                                        <input type="text" class="form-control required" id="size" name="size" maxlength="50" value="<?php echo $item->size ?>"/>
                                    </div>                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="download_link">Download Link</label>
                                        <input type="text" class="form-control required" id="download_link"  name="download_link" maxlength="255" value="<?php echo $item->download_link ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control required" id="description" name="description" ><?php echo $item->description ?></textarea>
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