<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/store/new", name="new_prod")
     */
    public function editProduct(Product $product=null, Request $req, EntityManagerInterface $manager){
        if(!$product) {
            $product = new Product();
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setPrice(str_replace(',', '.', $product->getPrice()));
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('store');
        }

        return $this->render('store/edit_prod.html.twig', [
            'form' => $form->createView(),
            'mode' => $product->getId() != null, 
        ]);
    }
}
