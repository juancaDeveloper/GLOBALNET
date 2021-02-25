<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->load->model('cliente_model');
	}
	
	public function index()
	{


		$data =array('clientes' => $this->cliente_model->get_tipocliente(),
	);
	$data2 =array('documentos' => $this->cliente_model->get_tipodocumento(),
);
	

      $this->load->view('templates/header_clientes',$data);
     
	  $this->load->view('templates/navbar');
	  $this->load->view('templates/sidebar-menu');
      $this->load->view('paginas/clientes',$data2);
     
	  $this->load->view('templates/footer');
	  $this->load->view('templates/footer-src');
	}
	

	public function insert()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('tipo_cliente_id', 'Tipo_Cliente', 'required');
			$this->form_validation->set_rules('tipo_documento_id', 'Tipo_Documento', 'required');
			$this->form_validation->set_rules('num_documento', 'Num_Documento', 'required');
			$this->form_validation->set_rules('telefono', 'Telefono', 'required');
			$this->form_validation->set_rules('direccion', 'Direccion', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$ajax_data = $this->input->post();
				if ($this->cliente_model->insert_entry($ajax_data)) {
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

	public function mostrar()
	{
		if ($this->input->is_ajax_request()) {
			// if ($posts = $this->crud_model->get_entries()) {
			// 	$data = array('responce' => 'success', 'posts' => $posts);
			// }else{
			// 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
			// }
			$posts = $this->cliente_model->get_entries();
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

			if ($this->cliente_model->delete_entry($del_id)) {
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

			if ($post = $this->cliente_model->edit_entry($edit_id)) {
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
			$this->form_validation->set_rules('edit_tipo_cliente_id', 'Tipo_Cliente', 'required');
			$this->form_validation->set_rules('edit_tipo_documento_id', 'Tipo_Documento', 'required');
			$this->form_validation->set_rules('edit_num_documento', 'Num_documento', 'required');
			$this->form_validation->set_rules('edit_telefono', 'Telefono', 'required');
			$this->form_validation->set_rules('edit_direccion', 'Direccion', 'required');
			$this->form_validation->set_rules('edit_estado', 'Estado', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('responce' => 'error', 'message' => validation_errors());
			} else {
				$data['id'] = $this->input->post('edit_record_id');
				$data['nombre'] = $this->input->post('edit_nombre');
				$data['telefono'] = $this->input->post('edit_telefono');
				$data['direccion'] = $this->input->post('edit_direccion');
				$data['tipo_cliente_id'] = $this->input->post('edit_tipo_cliente_id');
				$data['tipo_documento_id'] = $this->input->post('edit_tipo_documento_id');
				$data['num_documento'] = $this->input->post('edit_num_documento');
				$data['estado'] = $this->input->post('edit_estado');
				

				if ($this->cliente_model->update_entry($data)) {
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