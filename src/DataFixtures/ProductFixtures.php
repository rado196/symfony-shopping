<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
  private $products = [
    [
      'title' => 'Apple AirPods (2nd gen)',
      'price' => 129,
    ],
    [
      'title' => 'Apple AirPods Pro (2nd gen)',
      'price' => 249,
    ],
    [
      'title' => 'Apple AirPods (3rd gen)',
      'price' => 169,
    ],
    [
      'title' => 'Apple AirPods Max',
      'price' => 549,
    ],
    [
      'title' => 'Apple EarPods',
      'price' => 19,
    ],

    [
      'title' => 'Beats Fit Pro',
      'price' => 199.99,
    ],
    [
      'title' => 'Beats Studio Buds',
      'price' => 149.99,
    ],
    [
      'title' => 'Beats Flex',
      'price' => 69.99,
    ],
    [
      'title' => 'Beats Studio3',
      'price' => 349.95,
    ],
    [
      'title' => 'Powerbeats Studio3',
      'price' => 249.95,
    ],

    [
      'title' => 'Samsung Galaxy Buds2',
      'price' => 69.99,
    ],
    [
      'title' => 'Samsung Galaxy Buds2 Pro',
      'price' => 124.99,
    ],
    [
      'title' => 'Samsung Galaxy Buds Live',
      'price' => 59.99,
    ],
    [
      'title' => 'Samsung Type-C Headphones',
      'price' => 29.99,
    ],
  ];

  public function load(ObjectManager $manager): void
  {
    foreach ($this->products as $productInfo) {
      $product = new Product();
      $product->setTitle($productInfo['title']);
      $product->setPrice($productInfo['price']);

      $manager->persist($product);
    }

    $manager->flush();
  }
}
