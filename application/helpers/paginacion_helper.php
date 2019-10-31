<?php
    
    /*
    * Helper paginacion
    * Ayuda a realizar paginación para mostrar
    * resultados segmentados.
    */

    function paginar_todo( $tabla, $pagina = 1, $por_pagina = 20, $campos = array() ){
        /*
        * $CI   = First, assign the CodeIgniter object to a variable:
        * =&    = Hace referencia a lo que sea que contenga el objeto o instancia
        * get_instance();   = Instancia que funciona solo con clases,modelos y vistas
        * 
        * Referencia: https://codeigniter.com/user_guide/general/ancillary_classes.html
        */

        $CI =& get_instance();
        $CI->load->database();

        if( !isset( $pagina ) ){
            $pagina = 1;
        }

        if( !isset( $por_pagina ) ){
            $por_pagina = 20;
        }

        $cuantos = $CI->db->count_all( $tabla );
        $total_paginas = ceil($cuantos / $por_pagina);

        if( $pagina > $total_paginas ){
            $pagina = $total_paginas;
        }

        $pagina -= 1;
        $desde = $pagina * $por_pagina;

        if( $pagina >= $total_paginas - 1 ){
            $pag_siguiente = 1;
        }else{
            $pag_siguiente = $pagina + 2;
        }

        if( $pagina < 1 ){
            $pagina_anterior = $total_paginas;
        }else{
            $pagina_anterior = $pagina;
        }

        $CI->db->select( $campos );
        $query = $CI->db->get( $tabla, $por_pagina, $desde );


        $respuesta = array(
            'error' => FALSE,
            'cuantos' => $cuantos,
            'total_paginas' => $total_paginas,
            'pag_actual' => ( $pagina + 1 ),
            'pag_siguiente' => $pag_siguiente,
            'pag_anterior' => $pagina_anterior,
            $tabla => $query->result()
        );
        return $respuesta;
    }

?>