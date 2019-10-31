<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cliente_model extends CI_Model {

    // Campos de la tabla clientes
    public $id;
    public $nombre;
    public $correo;
    public $zip;
    public $activo;
    public $telefono1;
    public $telefono2;
    public $pais;
    public $direccion;

    public function get_cliente( $id ){
        $this->db->where(array('id' => $id,'activo' => 1));
        $query = $this->db->get('clientes');
        $row = $query->custom_row_object(0,'Cliente_model');
        return $row;
    }

    public function set_datos( $data_cruda ){
        foreach( $data_cruda as $nombre_campo => $valor_campo ){
            if( property_exists( 'Cliente_model', $nombre_campo  ) ){
                $this->$nombre_campo = $valor_campo;
            }
        }

        if( $this->activo == NULL){
            $this->activo = 1;
        }

        $this->nombre = strtoupper( $this->nombre );

        return $this;
    }

}