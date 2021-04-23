<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/store", name="store")
     */
    public function index(ProductRepository $repo): Response
    {
        $prods = $repo->findAll();
        return $this->render('store/index.html.twig', [
            'prods' => $prods,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('store/home.html.twig');
    }
}
