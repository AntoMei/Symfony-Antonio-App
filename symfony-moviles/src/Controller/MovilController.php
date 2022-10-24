<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Entity\Movil;
use Doctrine\Persistence\ManagerRegistry;
use LDAP\Result;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MovilType;

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
    * @Route("/movil/nuevo",  name="movil_nuevo")
    */  
    public function nuevo(ManagerRegistry $doctrine, Request $request) {
        $movil = new Movil();

        $formulario = $this->createForm(MovilType::class, $movil);

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $movil = $formulario->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($movil);
            $entityManager->flush();
            return $this->redirectToRoute('ficha_moviles.html.twig', ["codigo" => $movil->getId()]);
        }
        return $this->render('nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }   
    /** 
    * @Route("/movil/editar/{codigo}",  name="editar_movil",requirements={"codigo"="\d+"})
    */  
    public function editar(ManagerRegistry $doctrine, Request $request, $codigo) {
        $repositorio = $doctrine->getRepository(Movil::class);

        $movil = $repositorio->find($codigo);
        if ($movil) {
            $formulario = $this->createForm(MovilType::class, $movil);
            
            $formulario->handleRequest($request);

            if ($formulario->isSubmitted() && $formulario->isValid()) {
                $movil = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($movil);
                $entityManager->flush();
            return $this->redirectToRoute('ficha_moviles', ["codigo" => $movil->getId()]);
        }
        return $this->render('nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }else{
        return $this->render('ficha_moviles.html.twig', [
            'contacto' => NULL
        ]);
    }
}
    /** 
    * @Route("/movil/insertarSinMarca",  name="insertar_sin_marca_movil")
    */  
    public function insertarSinMarca(ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Marca::class);

        $marca = $repositorio->findOneBy(["nombre" => "Samsung"]);

        $movil = new Movil();

        $movil->setNombre("Inserción de prueba sin marca");
        $movil->setCapacidad("128 GB");
        $movil->setRam("4 GB");
        $movil->setPrecio("800€");
        $movil->setMarca($marca);

        $entityManager->persist($movil);

        $entityManager->flush();
        return $this->render('ficha_moviles.html.twig', [
            'movil' => $movil
        ]);
    }
    /** 
    * @Route("/movil/insertarConMarca",  name="insertar_con_marca_movil")
    */ 
    public function insertarConMarca(ManagerRegistry $doctrine): Response{
        $entityManager = $doctrine->getManager();
        $marca = new Marca();

        $marca->setNombre("Samsung");
        $movil = new Movil();

        $movil->setNombre("Inserción de prueba con marca");
        $movil->setCapacidad("128 GB");
        $movil->setRam("6 GB");
        $movil->setPrecio("400€");
        $movil->setMarca($marca);

        $entityManager->persist($marca);
        $entityManager->persist($movil);

        $entityManager->flush();
        return $this->render('ficha_moviles.html.twig', [
            'movil' => $movil
        ]);
    }
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