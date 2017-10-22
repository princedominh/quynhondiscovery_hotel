<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 
require APPPATH . '/libraries/BaseController.php';

/**
 * Class : BaseCRUDController
 * Base Class to control over all the classes
 * @author : Do Minh Duc
 * @version : 1.1
 * @since : 14 September 2017
 */
abstract class BaseCRUDController extends BaseController {
    
    private $model;
    private $config;
    private $listing;
    private $listing_config;
    private $create_edit;
    /**
     * This is default constructor of the class
     */
    public function __construct($config = array('page'=>'','model'=>null), $listing = array(), $create_edit = array(), $listing_config = array())
    {
        parent::__construct();
        $this->config = $config;
        $this->listing = $listing;
        $this->create_edit = $create_edit;
        
        //listing_config = array(
        //                  'searchText'=> 'value',
        //                  'order' => array('field'=>'asc|desc')
        //              );
        $this->listing_config = $listing_config;
        
        $this->load->model($config['modelname']);
        $this->model = $this->{$config['modelname']};
        
        $this->load->library('session');
        $this->load->helper('qnd_crud');
        $this->load->helper('security');
        $this->load->helper('url_helper');
        $this->load->helper('cias_helper');
        
//        $autoload['libraries'] = array('globals');

        $this->isLoggedIn();   
    }
    
    /**
     * This function load the list
     */
    public function index()
    {
        $this->load->library('pagination');

        $count = $this->model->listingCount($this->listing_config);

        $returns = $this->paginationCompress( $this->config['page']."/", $count, 15 );

        $data['objects'] = $this->model->listing($returns["per_page"], $returns["segment"],$this->listing_config);
        $data['pageVar'] = $this->config;
        $data['columns'] = $this->listing;
        $data['config'] = $this->listing_config;

        $this->global['pageTitle'] = $this->config['pageName'] ;

        $this->loadViews("admin/CRUD_R", $this->global, $data, NULL);
    }
    
    /**
     * This function is used to load the add new form
     */
    function create()
    {
        $data['pageVar'] = $this->config;
        $data['create_edit'] = $this->create_edit;
        $this->global['pageTitle'] = APP_NAME.' : Create '.$this->config['objectName'];

        $this->loadViews("admin/CRUD_C", $this->global, $data, NULL);
    }

    function saveCreate() {
        $this->load->library('form_validation');
        $this->setFormValidation();
        if($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $dataInfo = array();
            foreach($this->create_edit as $key=>$value){
                $dataInfo[$key] =  $this->input->post($key);
            }

            $result = $this->destination_model->create($dataInfo);
            if($result > 0) {
                $this->session->set_flashdata('success', $this->config['objectName'].' created successfully');
            } else {
                $this->session->set_flashdata('error', $this->config['objectName'].' creation failed');
            }
            redirect($this->config['page']);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function edit($id = 0)
    {
        $data['pageVar'] = $this->config;
        $data['create_edit'] = $this->create_edit;
        $this->global['pageTitle'] = APP_NAME.' : Edit '.$this->config['objectName'];
        
        $object = $this->{$this->config['modelname']}->getById($id);
        if ($object) {
            $data['object'] = $object;
            $this->loadViews("admin/CRUD_U", $this->global, $data, NULL);
        } else {
            redirect($this->config['page']);
        }

    }
    function saveEdit() {
        $this->load->library('form_validation');
        $this->setFormValidation();
        $id = $this->input->post('item_id');
        
        if($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $dataInfo = array();
            foreach($this->create_edit as $key=>$value){
                $dataInfo[$key] =  $this->input->post($key);
            }
            
            $result = $this->model->update_id($id, $dataInfo);
            if($result > 0) {
                $this->session->set_flashdata('success', $this->config['objectName'].' saved successfully');
            } else {
                $this->session->set_flashdata('error', $this->config['objectName'].' saved failed. ID'.$id . '. json='. json_encode($destinationInfo));
            }
            redirect('admin/destination');
        }
    }
    abstract function setFormValidation();
    
    function getPostValue($key,$value){
        switch ($key){
            case 'qnd_type_model':
                break;
            default :
                return $this->input->post($key);
                break;
        }
    }
            
    
    function delete()
    {
        $id = $this->input->post('itemId');

        $result = $this->model->delete($id);

        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }
}