<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		
		
    }

    public function index()

	{

	 
      $this->load->view('templates/header_ventas');
     
	  $this->load->view('templates/navbar');
	  $this->load->view('templates/sidebar-menu');
      $this->load->view('paginas/ventas/ventas');
     
	  $this->load->view('templates/footer');
	  $this->load->view('templates/footer-src');
	}

	public function add()

	{

	 
      $this->load->view('templates/header_ventas');
     
	  $this->load->view('templates/navbar');
	  $this->load->view('templates/sidebar-menu');
      $this->load->view('paginas/ventas/add');
     
	  $this->load->view('templates/footer');
	  $this->load->view('templates/footer-src');
	}
}