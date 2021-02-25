<?php 

	class Cliente_model extends CI_Model {

        public function get_entries()
        {
            $this->db->select('c.*,tc.nombre as tipocliente, td.nombre as tipodocumento');
            $this->db->from('clientes c');
            $this->db->join('tipo_cliente tc','c.tipo_cliente_id = tc.id');
            $this->db->join('tipo_documento td','c.tipo_documento_id = td.id');

                $query = $this->db->get();
                // if (count( $query->result() ) > 0) {
                	return $query->result();
                // }
        }

        public function insert_entry($data)
        {
            return $this->db->insert('clientes', $data);
        }

        public function delete_entry($id){
        	return $this->db->delete('clientes', array('id' => $id));
        }

        public function edit_entry($id){
        	$this->db->select("*");
        	$this->db->from("clientes");
        	$this->db->where("id", $id);
        	$query = $this->db->get();
        	if (count($query->result()) > 0) {
        		return $query->row();
        	}
        }

        public function update_entry($data)
        {
            return $this->db->update('clientes', $data, array('id' => $data['id']));
        }


        public function get_tipocliente()
        {
                $query = $this->db->get('tipo_cliente');
                // if (count( $query->result() ) > 0) {
                	return $query->result();
                // }
        }

        
        public function get_tipodocumento()
        {
                $query = $this->db->get('tipo_documento');
                // if (count( $query->result() ) > 0) {
                	return $query->result();
                // }
        }

}