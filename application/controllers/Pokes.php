<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
class Pokes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    

	public function login(){	
        $current_date  = date_create();
        // var_dump($current_date);
        // $format_date = date_format($current_date,"F dS, Y"); 
        // $format_time = date_format($current_date,"h:i:s a"); 
        // $data = array("current_date"=> $format_date, "current_time" => $format_time);
		$this->load->view('poke/login');
	}

    public function login_process(){
        $config = array(
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required'
			),
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE){
			$errors = validation_errors('<li>', '</li>');
            $this->session->set_flashdata('errors', $errors);
			$this->session->set_flashdata('error-type', 'Sigin Error');
            redirect(base_url());
            die();

        }

		$user = $this->user->get_user_by_email($this->input->post("email",TRUE)); //XSS clean
		if(!$user){
            $this->session->set_flashdata('errors', '<li>Incorrect Email</li>');
			$this->session->set_flashdata('error-type', 'Incorrect Credential');
			redirect(base_url());
            die();
		}else{
			$encrypted_password = md5($this->input->post("password",TRUE). '' . $user["salt"]);
			if($user["hashed_password"] == $encrypted_password){
				$user = array(
					'user_id' => $user['id'],
					// 'student_email' => $student['email'],
					// 'student_firstname' => $student['first_name'],
					// 'student_lastname' => $student['last_name'],
					// 'student_fullname' => $student['first_name'].' '.$student['last_name'],
					'is_logged_in' => true,
					'alias' =>$user['alias'],
					
				 );
				$this->session->set_userdata($user);
				redirect(base_url()."pokes");
				 
				 die();
				//  redirect(base_url()."profile");
			}else{
				$this->session->set_flashdata('errors', '<li>Incorrect Password</li>');
				$this->session->set_flashdata('error-type', 'Incorrect Credential');
				redirect(base_url());
				die();
			}
		}
    }


    public function register_process(){
        $current_date  = date_create();
        //2021-05-29
        $format_date = date_format($current_date,"Y-m-d"); 
		$config = array(
			array(
				'field' => 'email',
				'label' => 'email',
				'rules' => 'trim|required|valid_email'
			),
			
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required'
			),
            array(
				'field' => 'alias',
				'label' => 'Alias',
				'rules' => 'trim|required'
			),

            array(
				'field' => 'date',
				'label' => 'Date of Birth',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|min_length[8]'
			),
			array(
				'field' => 'confirm_password',
				'label' => 'Password Confirm',
				'rules' => 'trim|required|matches[password]|min_length[8]'
			),
		);

		$this->form_validation->set_rules($config);

		
		if($this->form_validation->run() === FALSE){
            $errors = validation_errors('<li>', '</li>');
            if($this->input->post("date") > $format_date){
                $errors .= "<li>Date of Birth should be today or in the past</li>";
            }
			
            $this->session->set_flashdata('errors', $errors);
			$this->session->set_flashdata('error-type', 'Registration Error');
            redirect(base_url());
			die();
		}else{

            if($this->input->post("date") > $format_date){
                $this->session->set_flashdata('errors', '<li>Date of Birth should be today or in the past</li>');
                $this->session->set_flashdata('error-type', 'Registration Error');
                redirect(base_url());
                die();
            }

            // var_dump($this->input->post());
			$salt = bin2hex(openssl_random_pseudo_bytes(22));
			$encrypted_password = md5($this->input->post("password",TRUE) . '' . $salt);

			$user_details = array(
				"email" => $this->input->post("email",TRUE),
				"name" => $this->input->post("name",TRUE),
				"alias" => $this->input->post("alias",TRUE),
				"hashed_password" => $encrypted_password,
				"salt" => $salt,
                'birth_date' =>  $this->input->post("date",TRUE),
			);

			$add_user = $this->user->add_user($user_details);
			if($add_user === TRUE) {
				// echo "Course is added!";
				$this->session->set_flashdata('add-user-success', '<div class="alert alert-success">User has been registered</div>');
				redirect(base_url());
			}
		}
		
	}


    public function poke_user_account(){	
        // $current_date  = date_create();
        // $format_date = date_format($current_date,"F dS, Y"); 
        // $format_time = date_format($current_date,"h:i:s a"); 
        // $data = array("current_date"=> $format_date, "current_time" => $format_time);
        $data['users_to_poke'] = $this->user->get_all_other_users($this->session->userdata("user_id")); 
        $data['number_of_people_who_poke_you'] = $this->poke->number_of_people_who_poke_you($this->session->userdata("user_id"));
        $data['get_all_user_who_poke_you'] = $this->poke->get_all_user_who_poke_you($this->session->userdata("user_id"));
		$this->load->view('poke/pokes',$data);
	}


    public function poke_process(){
        $poke_detail = array(
            "poke_from" => $this->input->post("poke_from",TRUE),
            "poke_to" => $this->input->post("poke_to",TRUE),
        );

        $this->poke->add_poke($poke_detail);

        redirect(base_url()."pokes");
        
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

}
