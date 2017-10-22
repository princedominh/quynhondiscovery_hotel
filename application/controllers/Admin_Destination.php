<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseCRUDController.php';

/**
 * Class : Admin_Destination
 * User Class to control all destination operations.
 * @author : Do Minh Duc
 * @version : 1.1
 * @since : 01 Sep 2017
 */
class Admin_Destination extends BaseCRUDController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        $config = array(
            'page' => 'admin/destination',
            'modelname' => 'destination_model',
            'pageName' => APP_NAME.' : Destionation Listing',
            'objectName' => 'Destination',
        );
        $listing = array(
            'name' => array('label'=>'Name','type'=>'preName'),
            'parent_id' => array('label'=>'Parent','type'=>'qnd_type_model','modelname'=>'destination_model','toString'=>'name'),
            'type' => array('label'=>'Type'),
            'description' => array('label'=>'Description'),
        );
        $listing_config = array('order'=> array('lft'=>'asc'));
        $create_edit = $this->configFormField();
        parent::__construct($config, $listing, $create_edit, $listing_config);
    }
    
    private function configFormField()
    {
        return array(
            'name' => array('type'=>null,'data'=> array(
                'fieldname'=> 'name',
                'fieldlabel'=> 'Name',
                'option'=> array('required'=>'required'),
            )),
            'type' => array('type'=>'select', 'data'=>array(
                'fieldname'=> 'type',
                'fieldlabel'=> 'Type',
                'option'=> array('required'=>'required'),
                'list'=>array(
                    'continental' => 'continental',
                    'country' => 'country',
                    'capital, city' => 'capital, city',
                    'province' => 'province',
                    'district, city' => 'district, city',
                    'district' => 'district',
                    'destination' => 'destination',
                    ),
                'default' => 'destination',
                )),
            'parent_id' => array('type'=>'qnd_type_model','data'=>array(
                'fieldname'=> 'parent_id',
                'fieldlabel'=> 'Parent',
                'option'=> array('required'=>'required'),
                'modelname'=>'destination_model',
                'id_field'=>'id',
                'represent_field'=>'name',
                'pre_func'=>'preName',
                'default' => 1,
                'sql_option'=>array('order'=>array('lft'=>'asc')),
            )),
            'description' => array('type'=>'textarea','data'=> array(
                'fieldname'=> 'description',
                'fieldlabel'=> 'Description',
                'option'=> array(),
            )),
        );
    }

    public function setFormValidation(){
        $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('parent_id','Parent','required|numeric');
        $this->form_validation->set_rules('type','Type','required');
    }


//    public function do_upload($type = 'new') {
//        $result = array('error'=>null, 'data'=>null);
//        $config['upload_path'] = './uploads/';
//        $config['allowed_types'] = 'gif|png|jpg|jpeg';
//        $config['max_size'] = 100;
//        $config['max_width'] = 768;
//        $config['max_height'] = 768;
//
//        $this->load->library('upload', $config);
//
//        if (!$this->upload->do_upload('icon')) {
//            $error = array('error' => $this->upload->display_errors());
//
//            $result['error'] = $error['error'];
//        } else {
//            $data = array('upload_data' => $this->upload->data());
//
//            $result['data'] = $data['upload_data'];
//        }
//        
//        return $result;
//    }

}

