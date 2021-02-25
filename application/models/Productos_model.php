<?php 

	class Productos_model extends CI_Model {

        public function get_entries()
        {
            $this->db->select('p.*,c.nombre as categoria');
            $this->db->from('productos p');
            $this->db->join('categorias c','p.categoria_id = c.id');

                $query = $this->db->get();
                // if (count( $query->result() ) > 0) {
                	return $query->result();
                // }
        }

        public function insert_entry($data)
        {
            return $this->db->insert('productos', $data);
        }

        public function delete_entry($id){
        	return $this->db->delete('productos', array('id' => $id));
        }

        public function edit_entry($id){
        	$this->db->select("*");
        	$this->db->from("productos");
        	$this->db->where("id", $id);
        	$query = $this->db->get();
        	if (count($query->result()) > 0) {
        		return $query->row();
        	}
        }

        public function update_entry($data)
        {
            return $this->db->update('productos', $data, array('id' => $data['id']));
        }

}