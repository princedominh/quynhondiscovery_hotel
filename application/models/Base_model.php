<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

abstract class Base_model extends CI_Model
{
    protected $tablename = "";
    
    public function __construct()
    {
            $this->load->database();
    }
    
    abstract function baseDb();


    function getAll($config = array())
    {
        $this->baseDb();
        if(array_key_exists('order', $config)){
            foreach ($config['order'] as $key => $value) {
                $this->db->order_by($key,$value);
            }
        }
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    public function getById($id) {
        $this->baseDb();
        $this->db->where('BaseTbl.id', $id);
        $query = $this->db->get();
        
        $result = $query->row();  
        return $result;
    }
 

    /**
     * This function is used to add new item to system
     * @return number $insert_id : This is last inserted id
     */
    function create($dataInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->tablename, $dataInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->refreshDestination();
        
        $this->db->trans_complete();

        return $insert_id;
    }

    public function update_id($id, $data){
        $this->db->where('id', $id);
        $this->db->update($this->tablename, $data);
        return $this->db->affected_rows();
    }
    
    public function delete($id){
        $result = $this->db->delete($this->tablename, array('id'=>$id));

        $this->refreshDestination();

        return $result;
    }
    

    /**
     * This function is used to get the destination listing count
     * @param string $config : This is optional config
     * @return number $count : This is row count
     */
    function listingCount($config)
    {
        $this->baseDb();
        if(array_key_exists('searchText',$config)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$config['searchText']."%'
                            OR  BaseTbl.description  LIKE '%".$config['searchText']."%' 
                            )";
            $this->db->where($likeCriteria);
        }
        if(array_key_exists('order', $config)){
            foreach ($config['order'] as $key => $value) {
                $this->db->order_by($key,$value);
            }
        }
        $query = $this->db->get();
        
        return count($query->result());
    }

    /**
     * This function is used to get the destination listing count
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @param string $config : This is optional search text
     * @return array $result : This is result
     */
    function listing($page, $segment, $config = array())
    {
        $this->baseDb();
        if(array_key_exists('searchText',$config)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$config['searchText']."%'
                            OR  BaseTbl.description  LIKE '%".$config['searchText']."%' 
                            )";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        if(array_key_exists('order', $config)){
            foreach ($config['order'] as $key => $value) {
                $this->db->order_by($key,$value);
            }
        }
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }

}