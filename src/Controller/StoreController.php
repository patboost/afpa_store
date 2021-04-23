<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/store/delete/{id}", name="delete_prod")
     */
    public function deleteProduct(Product $prod, EntityManagerInterface $manager) {
        $manager->remove($prod);
        $manager->flush();
        return $this->redirectToRoute('store');
    }

    /**
     * @Route ("/store/edit/{id}", name="edit_prod")
     */
    public function editProduct(Product $product){
        return $this->render('store/edit_prod.html.twig');
    }
}
