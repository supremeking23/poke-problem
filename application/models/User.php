  
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

  
    function get_all_users(){
        return $this->db->query("SELECT * FROM users")->result_array();
    }

    function get_user_by_id($id){
        return $this->db->query("SELECT * FROM users where id = ?", array($id))->row_array();
    }

    function get_user_by_email($email){
        return $this->db->query("SELECT * FROM users where email = ?", array($email))->row_array();
    }

    function add_user($user){
        $query = "INSERT INTO users(name,alias,email,hashed_password,salt,birth_date,created_at) VALUES (?,?,?,?,?,?,?)";
        $values = array($user['name'],$user['alias'],$user['email'],$user['hashed_password'],$user['salt'],$user['birth_date'],date("Y-m-d, H:i:s"));
        return $this->db->query($query, $values);
    }

    function get_all_other_users($user_id){
        $query = "SELECT count(pokes.poke_to) as poke_history,users.id,users.name,users.email,users.alias,pokes.poke_to FROM users LEFT JOIN pokes ON users.id = pokes.poke_to GROUP BY pokes.poke_to,users.id,users.name,users.email,users.alias HAVING users.id != ? ORDER BY users.id";
        $values = array($user_id);
        return $this->db->query($query, $values)->result_array();
    }
    // function get_all_other_users($user_id){
    //     $query = "SELECT id,name,email,alias FROM users WHERE id != ?";
    //     $values = array();
    //     return $this->db->query($query, $values)->result_array;
    // }


}

?>