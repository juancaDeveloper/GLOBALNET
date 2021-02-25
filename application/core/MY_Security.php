<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Security extends CI_Security
{
    public function csrf_show_error()
    {
        $heading = "ERROR en CSRF: Ocurrio un error al enviar datos.";
        $message = "Intente de nuevo por favor.";

        $_error = &load_class('Exceptions', 'core');
        echo $_error->show_error($heading, $message, 'csrf_error', 403);
        exit;
    }
}
