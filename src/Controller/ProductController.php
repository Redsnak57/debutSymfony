<?php

namespace App\Controller;

use App\Class\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    #[Route('/nos-produits', name: 'app_products')]
    public function index(Request $request): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $products = $this->manager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->manager->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            "products" => $products,
            "form" => $form->createView(),
        ]);
    }

    #[Route('/produit/{slug}', name: 'app_product')]
    public function show($slug)
    {

        $product = $this->manager->getRepository(Product::class)->findOneBySlug($slug);

        if(!$product){
            return $this->redirectToRoute("app_products");
        }

        return $this->render('product/show.html.twig', [
            "product" => $product,
        ]);
    }
}
