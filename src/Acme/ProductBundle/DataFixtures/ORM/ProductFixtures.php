<?php

namespace Acme\ProductBundle\DataFixtures\ORM\Load;

use Doctrine\Common\Persistence\ObjectManager;
use Acme\ProductBundle\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setPrice(rand(50, 200));
            $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In erat mauris, faucibus quis pharetra sit amet, pretium ac libero. Etiam vehicula eleifend bibendum. Morbi gravida metus ut sapien condimentum sodales mollis augue sodales. Vestibulum quis quam at sem placerat aliquet. Curabitur a felis at sapien ullamcorper fermentum. Mauris molestie arcu et lectus iaculis sit amet eleifend eros posuere. Fusce nec porta orci.');

        }


    }
}