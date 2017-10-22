<div class="row">
    <div class="col-md-12">                                
        <div class="form-group">
             <label for="<?php echo $fieldname ?>"><?php echo $fieldlabel ?></label>
            <textarea class="form-control <?php if(array_key_exists('required', $option)) { if($option['required']=='required')echo 'required'; }?>" 
                      id="<?php echo $fieldname ?>" 
                      name="<?php echo $fieldname ?>"
                      <?php foreach($option as $key=>$value){
                       echo $key . '="' . $value . '"';
                      } ?>
                      >
                   <?php if(!empty($object)) echo $object->{$fieldname}; ?>
            </textarea>
        </div>

    </div>
</div>
