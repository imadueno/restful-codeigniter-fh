<?php 
if( ! defined('BASEPATH') ) exit('No direct script access allowed');


$config = array(

	'cliente_put' => array(
			array( 'field'=>'correo', 'label'=>'correo electronico','rules'=>'trim|required|valid_email' ),
			array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required|min_length[2]|max_length[255]' ),
			array( 'field'=>'zip', 'label'=>'zip','rules'=>'trim|required|min_length[2]|max_length[5]' )
		)


);




?>