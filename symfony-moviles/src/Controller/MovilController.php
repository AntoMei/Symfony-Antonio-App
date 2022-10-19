<?php

namespace App\Controller;

use LDAP\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovilController extends AbstractController
{

    private $moviles = [

        1 => ["nombre" => "Samsung Galaxy Z Flip4", "capacidad" => " 128 GB", "ram" => "8 GB", "precio" => "1099€"],

        2 => ["nombre" => "Xiaomi 12 Pro", "capacidad" => "256 GB", "ram" => "8 GB", "precio" => "899,99€"],

        5 => ["nombre" => "iPhone 14 Pro", "capacidad" => "256 GB", "ram" => "8 GB", "precio" => "1319€"],

        7 => ["nombre" => "Xiaomi Mi 11 Pro", "capacidad" => "128 GB", "ram" => "8 GB", "precio" => "647€"],

        9 => ["nombre" => "Samsung Galaxy S22", "capacidad" => "256 GB", "ram" => "8 GB", "precio" => "909€"],

    ];     
    /** 
    * @Route("/movil/{codigo}",  name="ficha_movil")
    */
    public function ficha($codigo) : Response{
        //Si no existe el elemento con dicha clave devolvemos null
        $resultado = ($this->moviles[$codigo] ?? null);

        if ($resultado) {
            $html = "<ul>";
                $html .= "<li>" . $codigo . "</li>";
                $html .= "<li>" . $resultado['nombre'] . "</li>";
                $html .= "<li>" . $resultado['capacidad'] . "</li>";
                $html .= "<li>" . $resultado['ram'] . "</li>";
                $html .= "<li>" . $resultado['precio'] . "</li>";
            $html .= "</ul>";
        return new Response("<html><body>$html</body>");
    }else
        return new Response("<html><body>Movil $codigo no encontrado</body>");
}
}