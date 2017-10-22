<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/models/Base_model.php';

class User_model extends Base_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        $this->tablename = "qnd_user";
    }    

    public function baseDb(){
        $this->db->select('BaseTbl.id, BaseTbl.username, BaseTbl.password, BaseTbl.salt, '
                . 'BaseTbl.type, BaseTbl.created_at, BaseTbl.updated_at, BaseTbl.deleted_at, '
                . 'BaseTbl.email, BaseTbl.fullname, BaseTbl.last_login, BaseTbl.date_of_birth,  '
                . 'BaseTbl.confimation_token, BaseTbl.password_requested_at, BaseTbl.roles ');
        $this->db->from($this->tablename.' as BaseTbl');
        $this->db->where('BaseTbl.deleted_at IS NULL',NULL, false);
    }

    /**
     * This function is used to add new item to system
     * @return number $insert_id : This is last inserted id
     */
    function create($data)
    {
        $this->db->trans_start();
        
        $salt = $this->_create_salt();
        $data['salt'] = $salt;
        $data['password'] = $this->encryption->encrypt($salt.$data['password']);
        $data['created_at'] = date("Y-m-d H:m:s");
        $data['updated_at'] = $data['created_at'];
        
        $this->db->insert($this->tablename, $data);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();

        return $insert_id;
    }

    public function update_id($id, $data){
        $this->db->where('id', $id);
        if (array_key_exists('password', $data)) {
            $salt = $this->_create_salt();
            $data['salt'] = $salt;
            $data['password'] = $this->encryption->encrypt($salt.$data['password']);
        }
        $data['updated_at'] = date("Y-m-d H:m:s");
        $this->db->update($this->tablename, $data);
        return $this->db->affected_rows();
    }
    
    public function delete($id){
//        $result = $this->db->delete($this->tablename, array('id'=>$id));
        return $this->update_id($id, array('deleted_at'=>date("Y-m-d H:m:s")));
    }
    
    
    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', null);
        $query = $this->db->get($this->tablename);
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    private function _create_salt()
    {
        $this->load->helper('string');
        return sha1(random_string('alnum', 20));
    } 
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */

    function loginMe($email, $password)
    {
        $this->db->select('BaseTbl.id, BaseTbl.password, BaseTbl.username, BaseTbl.roles');
        $this->db->from($this->tablename .' as BaseTbl');
        $this->db->where('BaseTbl.email', $email);
        $this->db->where('BaseTbl.deleted_at', null);
        $query = $this->db->get();
        
        $user = $query->result();
        
        return $user; //remove later
    }


    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('userId, email, name');
        $this->db->from($this->tablename);
        $this->db->where('deleted_at', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows;
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('deleted_at', 0);
        $this->db->update('user', array('password'=>getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email'=>$email));
    }
}

  