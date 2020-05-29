<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Todo_model extends CI_Model {

  public function get_all_notes()
    {
    
      $this->db->select('notes');
      $this->db->from('notes');
      $query = $this->db->get()->row_array();
     // echo "<pre>";print_r($query);die;
      return $query['notes'];
      
    }

    public function update_notes($update_data)
    {
        $result = $this->db->update('notes',$update_data);  
        return $result;
    }
    public function delete_holiday($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tblholidays');
        return true;

    }
 

   
}
