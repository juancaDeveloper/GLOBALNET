<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorias extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->model('categorias_model');
	}
	
	public function index()
	{
      $this->load->view('templates/header_categoria');
     
	  $this->load->view('templates/navbar');
	  $this->load->view('templates/sidebar-menu');
      $this->load->view('paginas/prueba');
     
	  $this->load->view('templates/footer');
	  $this->load->view('templates/footer-src');
	}
	

	public function insert()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('nombre', 'Nombre', 'required|is_unique[categorias.nombre]');
			$this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$ajax_data = $this->input->post();
				if ($this->categorias_model->insert_entry($ajax_data)) {
					$data = array('responce' => 'success', 'message' => 'Datos ingresados Ok');
				} else {
					$data = array('responce' => 'error', 'message' => 'Fallo en ingresar datos');
				}
			}

			echo json_encode($data);
		} else {
			echo "No se permite el acceso directo al script :v";
		}
	}

	public function fetch()
	{
		if ($this->input->is_ajax_request()) {
			// if ($posts = $this->crud_model->get_entries()) {
			// 	$data = array('responce' => 'success', 'posts' => $posts);
			// }else{
			// 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
			// }
			$posts = $this->categorias_model->get_entries();
			$data = array('responce' => 'success', 'posts' => $posts);
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function delete()
	{
		if ($this->input->is_ajax_request()) {
			$del_id = $this->input->post('del_id');

			if ($this->categorias_model->delete_entry($del_id)) {
				$data = array('responce' => 'success');
			} else {
				$data = array('responce' => 'error');
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function edit()
	{
		if ($this->input->is_ajax_request()) {
			$edit_id = $this->input->post('edit_id');

			if ($post = $this->categorias_model->edit_entry($edit_id)) {
				$data = array('responce' => 'success', 'post' => $post);
			} else {
				$data = array('responce' => 'error', 'message' => 'failed to fetch record');
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function update()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('edit_nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('edit_descripcion', 'Descripcion', 'required');
			$this->form_validation->set_rules('edit_estado', 'Estado', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$data['id'] = $this->input->post('edit_record_id');
				$data['nombre'] = $this->input->post('edit_nombre');
				$data['descripcion'] = $this->input->post('edit_descripcion');
				$data['estado'] = $this->input->post('edit_estado');

				if ($this->categorias_model->update_entry($data)) {
					$data = array('responce' => 'success', 'message' => 'Datos modificados correctamente');
				} else {
					$data = array('responce' => 'error', 'message' => 'Failed to update record');
				}
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	

	public function login(){
		
		$this->load->view('paginas/login');
	

	}
}