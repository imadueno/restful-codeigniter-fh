<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require( APPPATH.'/libraries/REST_Controller.php');

/*
* Es importante requerir el REST_Controller
* Es importante extender del REST_Controller
*/

class Clientes extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Cliente_model');
    }

    // ==================================
    // Paginar clientes mediante helper
    // METHOD: GET
    // ==================================
    public function paginar_get(){

        $this->load->helper('paginacion');

        $pagina     = $cliente_id = $this->uri->segment(3); // parametro #3
        $por_pagina = $cliente_id = $this->uri->segment(4); // parametro #4

        $campos = array('id','nombre','telefono1'); // campos de la tabla

        $respuesta = paginar_todo( 'clientes', $pagina, $por_pagina, $campos ); // helper
        $this->response( $respuesta );  // imprime el resultado de lo que se obtuvo
    }

    // ==================================
    // Registrar un cliente nuevo en la db
    // METHOD: PUT
    // ==================================
    public function cliente_put(){
        $data = $this->put();   // guarda los campos posteados
        $this->load->library('form_validation');    // ayuda para validar los campos
        $this->form_validation->set_data( $data );

        $this->form_validation->set_rules('correo','correo electronico','trim|required|valid_email');
        $this->form_validation->set_rules('nombre','nombre','trim|required');
        $this->form_validation->set_rules('zip','zip','trim|required|min_length[3]|max_length[5]');

        if( $this->form_validation->run() ){ // TRUE = TODO BIEN

            $query = $this->db->get_where( 'clientes', array( 'correo' => $data['correo'] ) );
            $cliente_correo = $query->row();    // guarda 1 fila del resultado
            
            if(isset( $cliente_correo ) ){  // si el correo está duplicado
                $respuesta = array(
                    'error' => TRUE,
                    'mensaje' => 'El correo ya está registrado'
                );

                $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST );
                return; // finaliza la ejecución del metodo
            }

            $cliente = $this->Cliente_model->set_datos( $data ); // objeto de cliente model

            if( $this->db->insert( 'clientes', $cliente ) ){    // INSERTADO

                $respuesta = array(
                    'error' => FALSE,
                    'mensaje' => 'Se ha insertado el registro correctamente',
                    'cliente_id' => $this->db->insert_id()  // CI Query builder function
                );

                $this->response( $respuesta );

            }else{  // NO INSERTADO

                $respuesta = array(
                    'error' => TRUE,
                    'mensaje' => 'Error en la base de datos',
                    'error_mensaje' => $this->db->_error_message(), // error en la db
                    'error_number' => $this->db->_error_number()    // num error db
                );

                $this->response( $respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR );  // error 500

            }


        }else{  // form validation FALSE

            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Hay errores en la información',
                'errores' => $this->form_validation->get_errores_arreglo()  // MY_Form_validation.php
            );

            $this->response( $respuesta, REST_Controller::HTTP_BAD_REQUEST ); // error

        }
    }


    public function cliente_get(){

        $cliente_id = $this->uri->segment(3);   // parametro #3 de la url

        if(!isset($cliente_id)){    // valida si existe el ID

            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'ID no proporcionado'
            );

            $this->response($respuesta , REST_Controller::HTTP_BAD_REQUEST );
            return; // finaliza la ejecución del metodo
        }

        $cliente = $this->Cliente_model->get_cliente( $cliente_id );

        if(isset($cliente)){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Cliente retornado',
                'cliente' => $cliente
            );
            $this->response( $respuesta );
        }else{
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'ID '.$cliente_id.' no existe.',
                'cliente' => $cliente
            );
            $this->response( $respuesta , REST_Controller::HTTP_NOT_FOUND );
        }
        $this->response( $cliente );
    }
}