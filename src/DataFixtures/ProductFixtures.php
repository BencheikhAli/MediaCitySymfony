<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <= 10 ; $i++) { 
            $product = new Product();
            $product->setNom("Produit" . $i);
            $product->setPrix($i*3);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
