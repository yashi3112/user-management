<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Todo_model extends CI_Model {

  public function authenticateUser($username,$password)
  {
     $this->db->select('userId,username');
     $this->db->from('user');
     $this->db->where('username',$username);
     $this->db->where('password',md5($password));
     $this->db->where('status',1);
     $result = $this->db->get()->row_array();
     if($result->num_row() == 1 )
     {
        return $result;
     }
     return false;
  }

}
