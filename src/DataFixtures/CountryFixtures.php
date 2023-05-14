<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
  private $countries = [
    [
      'code' => 'DE',
      'name' => 'Germany',
      'taxInfo' => [
        'idLength' => 11,
        'percent' => 19,
      ],
    ],
    [
      'code' => 'IT',
      'name' => 'Italy',
      'taxInfo' => [
        'idLength' => 13,
        'percent' => 22,
      ],
    ],
    [
      'code' => 'GR',
      'name' => 'Greece',
      'taxInfo' => [
        'idLength' => 11,
        'percent' => 24,
      ],
    ],
  ];

  public function load(ObjectManager $manager): void
  {
    foreach ($this->countries as $countryItem) {
      $country = new Country();
      $country->setCode($countryItem['code']);
      $country->setName($countryItem['name']);
      $country->setTaxIdLength($countryItem['taxInfo']['idLength']);
      $country->setTaxPercent($countryItem['taxInfo']['percent']);

      $manager->persist($country);
    }

    $manager->flush();
  }
}
