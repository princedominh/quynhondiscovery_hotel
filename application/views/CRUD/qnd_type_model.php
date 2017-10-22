<div class="row">
    <div class="col-md-12">                                
        <div class="form-group">
            <label for="<?php echo $fieldname ?>"><?php echo $fieldlabel ?></label>
            <select class="form-control <?php if(array_key_exists('required', $option)) { if($option['required']=='required')echo 'required'; }?>" 
                   id="<?php echo $fieldname ?>" 
                   name="<?php echo $fieldname ?>"
                   <?php foreach($option as $key=>$value){
                       echo $key . '="' . $value . '"';
                   } ?>
            >
                <?php if(!empty($object)) $default = $object->{$fieldname}; ?>
                <?php foreach ($list as $item):?>
                <option value="<?php echo $item->{$id_field} ?>" <?php if($item->{$id_field}==$default) echo 'selected="selected"'; ?>>
                    <?php if(isset($pre_func)) call_user_func($pre_func, $item) ?><?php echo $item->{$represent_field} ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
