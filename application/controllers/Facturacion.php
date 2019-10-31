<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require( APPPATH.'/libraries/REST_Controller.php');

/*
* Es importante requerir el REST_Controller
* Es importante extender del REST_Controller
*/

class Facturacion extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        //$this->load->model('Cliente_model');
    }

    //TODO

    public function factura_get(){

        $id_factura = $cliente_id = $this->uri->segment(3); // parametro #3

        if( !isset( $id_factura ) ){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'No se ha proporcionado ningun ID',
                'factura' => null,
                'detalle' => null
            );
            $this->response( $respuesta );
            return;
        }


        $factura = $this->db->get_where( 'facturacion' , array( 'factura_id' => $id_factura ) );
        $this->db->reset_query();
        $detalle = $this->db->get_where( 'facturacion_detalle', array( 'factura_id' => $id_factura ) );



        $respuesta = array(
            'error' => TRUE,
            'mensaje' => 'ID recibido',
            'factura' => $factura->row(),   // 1 solo registro
            'detalle' => $detalle->result_array()   // multiples registros
        );

        $this->response( $respuesta );
    }
}