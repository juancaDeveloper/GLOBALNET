<?php

defined('BASEPATH') OR exit('No direct access allowed');

class Auth extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->load->model("Usuarios_model");
    }


    public function index(){


        if($this->session->userdata("login")){

            redirect(base_url()."panel");
        } else{

            
            $this->load->view('paginas/login2');


        }

        


    }

    public function login(){
        $username =$this->input->post("username");
        $password=$this->input->post("password");
    
        $res = $this->Usuarios_model->login($username,sha1($password));

        if(!$res){

            $this->session->set_flashdata("error","El usuario  y/o Contraseña no validos");

            redirect(base_url());
        }
        else{
            $data = array(
                'id' => $res->id,
                'nombre' => $res->nombres,
                'rol'=> $res->rol_id,
                'login' => TRUE
            );
            $this->session->set_userdata($data);
            redirect(base_url()."panel");

        }

    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
}