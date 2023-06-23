<?php

namespace App\DataFixtures;

use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarCategoryFixtures extends Fixture
{
   public const CATEGORIES = ['Citadine', 'Break', 'SUV', 'Berline', 'Monospace'];

    public function load(ObjectManager $manager): void
    {

        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new CarCategory();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
    }

}
