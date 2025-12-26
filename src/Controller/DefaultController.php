<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(Request $request): Response
    {

       // dd($request->query->all()); //pour query string EX :/default?name=shedhedababe&age=77 ,ne CAPTE PAS les paramètres de route
        /**
         *  pour post/put/delete/patch au les donées sont passer dans le body
         *  Equivalant à $_POST['email']
         */
        //dd($request->request->get('username'));
        //dd($request->attributes->get('id')); //route params quelque soit le methode
        dump($request->toArray()); //lance un excpetion si pas du body
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
