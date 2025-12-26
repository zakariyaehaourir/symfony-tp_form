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
        return $this->render('cart/index.html.twig' , ['form'=>$this->createForm(AddToCartType::class)]);
    }
}
