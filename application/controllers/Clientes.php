<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require( APPPATH.'/libraries/REST_Controller.php');

class Clientes extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Cliente_model');
    }

    public function cliente_get(){
        $cliente_id = $this->uri->segment(3);

        // validar cliente id
        if(!isset($cliente_id)){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'ID no proporcionado'
                );
            $this->response($respuesta , REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $cliente = $this->Cliente_model->get_cliente($cliente_id);
        if(isset($cliente)){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'ID no proporcionado',
                'cliente' => $cliente
            );
            $this->response($respuesta);
        }else{
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'ID '.$cliente_id.' no existe.',
                'cliente' => $cliente
            );
            $this->response($respuesta , REST_Controller::HTTP_NOT_FOUND);
        }
        $this->response($cliente);
    }
}