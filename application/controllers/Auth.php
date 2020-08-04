<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{

    public function __construct()
    {
      parent::__construct();
      $this->load->library('form_validation');
    }


    public function index()
    {
       $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
       $this->form_validation->set_rules('password', 'Password', 'trim|required');
      
       if($this->form_validation->run == false){
          $data['title']= 'Login Page';
          $this->load->view('temp/a_header', $data);
          $this->load->view('auth/login');
          $this->load->view('temp/a_footer');
       }
      }

    public function registration()
    {
      
      $this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
      'is_unique' => 'this email has alredy registered!'
      ]); //user itu nama tabel nya
      $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
         'matches'=> 'password not matches!',
         'min_length' => 'password too short!'
      ]);
      $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]'); //didalam siku name nya
       
      
      if ($this->form_validation->run() == false){
          $data['title'] = 'user registration';
          $this->load->view('temp/a_header', $data);
          $this->load->view('auth/registration');
          $this->load->view('temp/a_footer'); 
       }
       else {
         $data=[
            // htmlspecialchars($this->input->post('name', true)),
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'image' => 'default.jpg' ,
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1,
            'date_created' => time()
 
         ];

         $this->db->insert('user', $data);
         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> success registered, please login</div>');
         redirect('Auth'); 

       }
      }
   }
?>
