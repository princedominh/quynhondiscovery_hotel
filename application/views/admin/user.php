<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/user/create">Create User</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?php
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>referenceListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Username</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            <?php
                            if (!empty($users)) {
                                foreach ($users as $record) {
                                    ?>
                                    <tr>
                                        <td><?php echo $record->username ?></td>
                                        <td><?php echo $record->type ?></td>
                                        <td><?php echo $record->created_at  ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'admin/user/edit/' . $record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                            <a href="#" data-itemid="<?php echo $record->id; ?>" class="deleteItem" ><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>-->
<script type="text/javascript">
    jQuery(document).ready(function () {
//        jQuery('ul.pagination li a').click(function (e) {
//            e.preventDefault();
//            var link = jQuery(this).get(0).href;
//            var value = link.substring(link.lastIndexOf('/') + 1);
//            jQuery("#searchList").attr("action", baseURL + "admin/destination/" + value);
//            jQuery("#searchList").submit();
	jQuery(document).on("click", ".deleteItem", function(){
		var itemId = $(this).data("itemid"),
                    hitURL = baseURL + "admin/user/delete",
                    currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this User?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { itemId : itemId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Item successfully deleted"); }
				else if(data.status = false) { alert("Item deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
    });
</script>
