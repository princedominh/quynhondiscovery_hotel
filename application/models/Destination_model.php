<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/models/Base_model.php';

class Destination_model extends Base_model
{
    public $TYPES = ['continental','country', 'capital, city', 'city', 'province', 'district, city', 'district', 'destination'];
    
    public function __construct()
    {
        parent::__construct();
        $this->tablename = "destination";
    }
    
    public function baseDb(){
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.level, '
                . 'BaseTbl.parent_id, BaseTbl.root, '
                . 'BaseTbl.description, BaseTbl.lft, BaseTbl.rgt, BaseTbl.type,  '
                . 'BaseTbl.description');
        $this->db->from($this->tablename.' as BaseTbl');
//        $this->db->join('type as Type', 'Type.id = BaseTbl.type_id','left');
//        $this->db->join('os as Os', 'Os.id = BaseTbl.os_id','left');
    }

    
    public function getAllChild($id) {
        $this->baseDb();
        $this->db->where('BaseTbl.parent_id', $id);
        $this->db->order_by("lft", "asc");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to add new item to system
     * @return number $insert_id : This is last inserted id
     */
    function create($dataInfo)
    {
        $this->db->trans_start();
        $parent = $this->getById($dataInfo['parent_id']);
        $dataInfo['level'] = $parent->level + 1;
        $this->db->insert($this->tablename, $dataInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->refreshDestination();
        
        $this->db->trans_complete();

        return $insert_id;
    }

    public function update_id($id, $data){
        $this->db->where('id', $id);
        $this->db->update($this->tablename, $data);
        $result = $this->db->affected_rows();
        $this->refreshDestination();
        
        return $result;
    }

    public function delete($id){
        $result = $this->db->delete($this->tablename, array('id'=>$id));

        $this->refreshDestination();

        return $result;
    }
    
    private function refreshDestination()
    {
        //getroot
        $this->baseDb();
        $this->db->where('BaseTbl.root', null);
        $query = $this->db->get();
        
        $root = $query->row();
        $this->visit($root, 0);
    }
    
    private function visit($node, $val)
    {
        $level = $node->level;
        $lft = $val + 1;
        //get all child
        $children = $this->getAllChild($node->id);
//        var_dump($children); die;
        $x = $lft;
        if(count($children)>0) {
            foreach($children as $child){
//                var_dump($child);
                $child->level = $level+1;
                $next = $this->visit($child, $x);
                $x = $next;
            }
        }
        $next_val = $x+1;
        $data['lft'] = $lft;
        $data['rgt'] = $next_val;
        $data['level'] = $level;
        $this->update_lftrgt($node->id, $data);
        return $next_val;
    }
    private function update_lftrgt($id, $data){
        $this->db->where('id', $id);
        $this->db->update($this->tablename, $data);
        $result = $this->db->affected_rows();
        
        return $result;
    }    

    function nameWithPre(){
        $str = "";
        for($i=0; $i<$this->level; $i++) {
            $str .= "--";
        }
        return $str . $this->name;
    }
}

  