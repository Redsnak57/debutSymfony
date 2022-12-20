<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    #[Route('/panier', name: 'app_card')]
    public function index(Cart $cart): Response
    {
        return $this->render('card/index.html.twig', [
            "cart" => $cart->getFull(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute("app_products");
    }

    #[Route('/cart/addPanier/{id}', name: 'addPanier')]
    public function addPanier(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute("app_card");
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute("app_products");
    }

    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, int $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute("app_card");
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_to_cart')]
    public function decrase(Cart $cart, int $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute("app_card");
    }
}
