<?php

namespace App\Controller;

use App\Entity\Movil;
use Doctrine\Persistence\ManagerRegistry;
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
    * @Route("/movil/insertar",  name="insertar_movil")
    */ 
    public function insertar(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        foreach ($this->moviles as $c) {
            $movil = new Movil();
            $movil->setNombre($c["nombre"]);
            $movil->setCapacidad($c["capacidad"]);
            $movil->setRam($c["ram"]);
            $movil->setPrecio($c["precio"]);
            $entityManager->persist($movil);
        }

        try
        {
            //Sólo se necesita realizar flush una vez y confirmará todas las operaciones pendientes
       
            $entityManager->flush();
            return new Response("Moviles insertados");
        } catch (\Exception $e) {
            return new Response("Error insertando objetos");
        }
    }
    /** 
    * @Route("/movil/{codigo}",  name="ficha_movil")
    */
    public function ficha(ManagerRegistry $doctrine, $codigo): Response{
        $repositorio = $doctrine->getRepository(Movil::class);
        $movil = $repositorio->find($codigo);

        return $this->render('ficha_movil.html.twig', [
            'movil' => $movil
        ]);
    }
    /** 
    * @Route("/movil/{codigo}",  name="ficha_movil")
    */
    public function fichaOld($codigo) : Response{
        //Si no existe el elemento con dicha clave devolvemos null
        $resultado = ($this->moviles[$codigo] ?? null);

        return $this->render('ficha_moviles.html.twig', [
            'movil' => $resultado
        ]);
    }
    
        /** 
    * @Route("/movil/buscar/{texto}",  name="buscar_movil")
    */
    public function buscar(ManagerRegistry $doctrine, $texto): Response{
        //Filtramos aquellos que contengan dicho texto en el nombre
        $repositorio = $doctrine->getRepository(Movil::class);

        $moviles = $repositorio->findByName($texto);

        return $this->render('lista_moviles.html.twig', [
            'moviles' => $moviles
        ]);
    }
    /** 
    * @Route("/movil/buscar/{texto}",  name="buscar_movil")
    */
    public function buscarOld($texto): Response{
        //Filtramos aquellos que contengan dicho texto en el nombre
        $resultados = array_filter($this->moviles,
        function ($movil) use ($texto){
            return strpos($movil["nombre"], $texto) !== FALSE;
        }
    );
            return $this->render('lista_moviles.html.twig', [
            'moviles' => $resultados
        ]);
    }
    /** 
    * @Route("/movil/update/{id}/{nombre}",  name="modificar_movil")
    */
    public function update(ManagerRegistry $doctrine, $id, $nombre): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Movil::class);
        $movil = $repositorio->find($id);
        if ($movil){
            $movil->setNombre($nombre);
            try
            {
                $entityManager->flush();
                return $this->render('ficha_movil.html.twig', [
                    'movil' => $movil
                ]);
            } catch (\Exception $e) {
                return new Response("Error insertando objetos");
            }
        }else
            return $this->render('ficha_movil.html.twig', [
                'movil' => null
            ]);
    }
     /** 
    * @Route("/movil/delete/{id}",  name="eliminar_movil")
    */
    public function delete(ManagerRegistry $doctrine, $id): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Movil::class);
        $movil = $repositorio->find($id);
        if ($movil) {
            try
            {
                $entityManager->remove($movil);
                $entityManager->flush();
                return new Response("Contacto eliminado");
            } catch (\Exception $e) {
                return new Response("Error eliminado objeto");
            }
        }else
            return $this->render('ficha_movil.html.twig', [
                'movil' => null
            ]);
    }
}