<?php

namespace App\Class;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class Cart {

    private RequestStack $stack;
    private EntityManagerInterface $manager;

    public function __construct(RequestStack $stack, EntityManagerInterface $manager){
        $this->stack = $stack;
        $this->manager = $manager;
    }

    public function add(int $id){
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);
 
        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
 
        $session->set('cart', $cart);
    }

    public function get(){
        $method = $this->stack->getSession();
        return $method->get("cart");
    }

    public function remove(){
        $method = $this->stack->getSession();
        return $method->remove("cart"); 
    }

    public function delete($id){
        $session = $this->stack->getSession();
        $cart = $session->get("cart", []);
        unset($cart[$id]);

        return $session->set("cart", $cart);
    }

    public function decrease($id){
        $session = $this->stack->getSession();
        $cart = $session->get('cart', []);
        if($cart[$id] > 1){
            $cart[$id] --;
        } else {
            unset($cart[$id]);
        }

        return $session->set("cart", $cart);
    }

    public function getFull(){
        $cartComplete = [];
        if($this->get()){
            foreach($this->get() as $id => $quantity){
                $productObject = $this->manager->getRepository(Product::class)->findOneById($id);
                if(!$productObject){
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    "product" => $productObject,
                    "quantity" => $quantity,
                ];
            }
        }
        return $cartComplete;
    }

}