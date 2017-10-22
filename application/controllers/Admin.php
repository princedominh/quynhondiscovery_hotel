<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Do Minh Duc
 * @version : 1.1
 * @since : 01 Sep 2017
 */
class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->helper('url_helper');
        $this->load->helper('cias_helper');
        

        $autoload['libraries'] = array('globals');


        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->load->model('user_model');
        $this->load->model('reference_model');
        $this->load->model('destination_model');

        $this->global['pageTitle'] = 'Dashboard';
        
        $this->global['users'] = $this->user_model->getAll();
        $this->global['references'] = $this->reference_model->getAll();
        $this->global['destinations'] = $this->destination_model->getAll();
        
        $this->loadViews("admin/dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 5 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'Kohimedia : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:sa'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:sa'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:sa'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:sa'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Kohimedia : Change Password';
        
        $this->loadViews("user/changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:sa'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function referenceListing()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->reference_model->referenceListingCount($searchText); 

            $returns = $this->paginationCompress ( "itemListing/", $count, 5 );
            
            $data['referenceRecords'] = $this->reference_model->referenceListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = APP_NAME.' : Reference Listing';
            
            $this->loadViews("admin/references", $this->global, $data, NULL);
        }
    }
   
    function referenceNew()
    {
        if($this->isAdmin() != TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('destination_model');
            
            $this->global['pageTitle'] = APP_NAME.' : Add New Reference';

            $this->loadViews("admin/reference_new", $this->global, NULL, NULL);
        }        
    }
    /**
     * This function is used to add new Item to the system
     */
    function addNewItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('type','Type','trim|required|numeric');
            $this->form_validation->set_rules('os','Os','trim|required|numeric');
            $this->form_validation->set_rules('version','Version','trim|required|max_length[10]|xss_clean');
            $this->form_validation->set_rules('download_link','Download Link','trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules('size','Size','trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('company','Os','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('description','Os','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->itemNew();
            }
            else
            {
                $upload_data = $this->do_upload();
                $name = ucwords(strtolower($this->input->post('name')));
                $typeId = $this->input->post('type');
                $osId = $this->input->post('os');
                $version = $this->input->post('version');
                $download_link = $this->input->post('download_link');
                $size = $this->input->post('size');
                $company = $this->input->post('company');
                $description = $this->input->post('description');
                $icon = (!is_null($upload_data['error']))? 'no-photo.gif':$upload_data['data']['file_name'];
                if(!is_null($upload_data['error'])) {
                    $this->session->set_flashdata('error', $upload_data['error']);
                }
                
                $itemInfo = array('name'=>$name, 'type_id'=>$typeId, 
                                    'os_id'=>$osId, 'version'=> $version,
                                    'icon'=>$icon, 'description'=> $description,
                                    'size'=>$size, 'company'=>$company,
                                    'download_link'=>$download_link, 'created_at'=>date('Y-m-d H:i:s'));
                
                $result = $this->item_model->addNewItem($itemInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Item created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('itemNew');
            }
        }
    }

    function itemEdit($itemId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('type_model');
            $this->load->model('os_model');
            $data['type_list'] = $this->type_model->getAllType();
            $data['os_list'] = $this->os_model->getAllOs();
            $item = $this->item_model->getById($itemId);
            if($item){
                $data['item'] = $item;
            } else {
                $this->session->set_flashdata('error', 'Item is not exist!');
                redirect('itemListing');
            }
            $this->global['pageTitle'] = 'Kohimedia : Edit Item';

            $this->loadViews("admin/item_edit", $this->global, $data, NULL);
        }        
    }
    /**
     * This function is used to edit old Item to the system
     */
    function editOldItem()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('itemId','Id','required|numeric');
            $this->form_validation->set_rules('name','Name','trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('type','Type','trim|required|numeric');
            $this->form_validation->set_rules('os','Os','trim|required|numeric');
            $this->form_validation->set_rules('version','Version','trim|required|max_length[10]|xss_clean');
            $this->form_validation->set_rules('download_link','Download Link','trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules('size','Size','trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('company','Os','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('description','Os','trim|required|xss_clean');

            $itemId = $this->input->post('itemId');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->itemEdit($itemId);
            }
            else
            {
                $item = $this->item_model->getById($itemId);
                if($item){ //check if item exist
                    $upload_data = array('error'=>null, 'data'=>null);
                    if (!empty($_FILES['icon']['name'])) {
                        $upload_data = $this->do_upload();
                    }
                    $name = ucwords(strtolower($this->input->post('name')));
                    $typeId = $this->input->post('type');
                    $osId = $this->input->post('os');
                    $version = $this->input->post('version');
                    $download_link = $this->input->post('download_link');
                    $size = $this->input->post('size');
                    $company = $this->input->post('company');
                    $description = $this->input->post('description');
                    $icon = (!is_null($upload_data['data']))? $upload_data['data']['file_name']:'';
                    if(!is_null($upload_data['error'])) {
                        $this->session->set_flashdata('error', $upload_data['error']);
                    }

                    $itemInfo = array('name'=>$name, 'type_id'=>$typeId, 
                                        'os_id'=>$osId, 'version'=> $version,
                                        'description'=> $description,
                                        'size'=>$size, 'company'=>$company,
                                        'download_link'=>$download_link, 'created_at'=>date('Y-m-d H:i:s'));
                    if($icon!=''){
                        $itemInfo['icon'] = $icon;
                    }

                    $this->item_model->update_id($itemId,$itemInfo);
                } else {
                    $this->session->set_flashdata('error', 'Item is not exist!');
                }
                redirect('itemListing');
            }
        }
    }
    
    /**
     * This function is used to delete the item using itemId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteItem()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $itemId = $this->input->post('itemId');
            
            $result = $this->item_model->deleteItem($itemId);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    public function do_upload($type = 'new') {
        $result = array('error'=>null, 'data'=>null);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100;
        $config['max_width'] = 768;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('icon')) {
            $error = array('error' => $this->upload->display_errors());

            $result['error'] = $error['error'];
        } else {
            $data = array('upload_data' => $this->upload->data());

            $result['data'] = $data['upload_data'];
        }
        
        return $result;
    }

}

