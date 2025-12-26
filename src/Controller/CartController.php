<?php

namespace App\Controller;

use App\Form\Type\AddToCartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class CartController extends AbstractController
{
    #[Route('/cart')]
    public function index():Response{
        $form = $this->createForm(AddToCartType::class);
        if($form->isSubmitted()){
            dd($form->getData());
        }
        return $this->render('cart/index.html.twig' , ['form'=>$form]);
    }
}
