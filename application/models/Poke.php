  
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poke extends CI_Model {

  
    // function get_all_users(){
    //     return $this->db->query("SELECT * FROM users")->result_array();
    // }

    // function get_user_by_id($id){
    //     return $this->db->query("SELECT * FROM users where id = ?", array($id))->row_array();
    // }

    // function get_user_by_email($email){
    //     return $this->db->query("SELECT * FROM users where email = ?", array($email))->row_array();
    // }

    function add_poke($poke){
        $query = "INSERT INTO pokes(poke_from,poke_to,created_at) VALUES (?,?,?)";
        $values = array($poke['poke_from'],$poke['poke_to'],date("Y-m-d, H:i:s"));
        return $this->db->query($query, $values);
    }

    function number_of_people_who_poke_you($user_id){
        return $this->db->query("SELECT count(*) as number_of_people_who_poke_you FROM pokes where poke_to = ?", array($user_id))->row_array();
    }

    function get_all_user_who_poke_you($user_id){
        $query = "SELECT count(pokes.poke_from) as poke_count,users.id,users.name FROM users LEFT JOIN pokes ON users.id = pokes.poke_from GROUP BY pokes.poke_to,users.id,users.name HAVING users.id != ? ORDER BY users.id";
        $values = array($user_id);
        return $this->db->query($query, $values)->result_array();
    }


}

?>