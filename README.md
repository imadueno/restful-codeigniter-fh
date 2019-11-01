# Creando servicios RESTful PHP-MySQL utilizando CodeIgniter 3
## Introducción
Este proyecto ayudará a realizar servicios RESTful utilizando el framework de PHP [CodeIgniter 3](https://codeigniter.com/en/download). 

## Proposito
Poder crear una API que nos permita poder ofrecer información de utilidad a una entidad ajena nuestro servidor. Nuestro servidor contendrá la información ( base de datos ) la cual será manejada de forma condicionada para permitir que una entidad ( usuario ) externa, pueda hacer uso de ella, o bien cualquiera de las acciones que un CRUD tradicional nos permite hacer, pero mediante peticiones HTTP ( Utilizando URL's).

>CRUD: Create, Read, Update y Delete

#### Ejemplo de una petición

```
[GET] http://api.dominio.com/clientes/cliente/23
[PUT] http://api.dominio.com/clientes/registro?nombre=pepe&password=123&email=pepe@gmail.com
```

## Definición de conceptos
- **REST** (Representational State Transfer) es una arquitectura que se ejecuta sobre HTTP.
- **RESTful** hace referencia a un servicio web que implementa la arquitectura REST.

## Contenido
El contenido de este repositorio, es la estructura general de un proyecto nuevo de CodeIgniter 3. Los archivos que nos ayudarán a poder hacer un uso adecuado de los servicios RESTful, se encuentran en la carpeta [assets](/assets/) de este proyecto. Así mismo, se encuentran correctamente ubicados como se muestra a continuación:
```
form_validation.php      -->	/application/config/form_validation.php
MY_Form_validation.php	 -->	/application/libraries/MY_Form_validation.php
Format.php               -->	/application/libraries/Format.php
rest.php                 -->	/application/config/rest.php
REST_Controller.php      -->	/application/libraries/REST_Controller.php
rest_controller_lang.php -->	/application/language/english/rest_controller_lang.php
```
De manera de ejemplo, se incluye una base de datos para realizar pruebas con los servicios, ubicada en la carpeta [database](/database/) de este proyecto, llamada:
> clientes.sql

## Configuración
### Configuración de la base de datos
Una vez importada nuestra base de datos **clientes.sql** tenemos que hacer la debida configuración dentro de nuestro framework para poder hacer uso de ella. Para ello, tenemos que abrir el siguiente archivo:
> /application/config/database.php

Modificamos el array **db['default']** en los siguientes campos:
```
'hostname' => 'localhost',
'username' => 'root',
'password' => '12345',
'database' => 'clientes'
```
## Cómo funciona
En este caso, el framework nos ofrece muchas posibilidades para poder realizar diversos proyectos utilizando la tecnología MVC ( Modelo Vista Controlador ). En este proyecto en particular. Sólo haremos uso del controlador, para simplificar el código por hacer.

#### Controlador
El controlador es un archivo PHP que se debe crear dentro de la ruta:
- /application/controllers/**Controllername.php**
> Es importante que el nombre comience con mayuscula.

Los controladores nos permitirán manipular las peticiones hechas por el usuario y hacer las validaciones o instrucciones necesarias para poder regresar la información que se necesite.

#### Estructura de un controlador para utilizar RESTful
```
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require( APPPATH.'/libraries/REST_Controller.php');

class Controllername extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
		
		//Servicios aquí
}
```
Es importante mantener esta estructura para poder hacer uso de la clase padre **REST_Controller** que nos facilitará en cierta forma la manera de poder manejar las peticiones hechas.

#### Ejemplo de servicio
