<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public const CATEGORY = CarCategoryFixtures::CATEGORIES;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
    foreach (self::CATEGORY as $key => $category){
        for ($i = 0; $i <= 25; $i++) {
            $car = new Car();
            $car->setName($faker->word());
            $car->setNbDoors($faker->randomElement([3, 5]));
            $car->setNbSeats($faker->numberBetween(4, 5));
            $car->setCost($faker->numberBetween(10000, 50000));
            $car->setCarCategory($this->getReference('category_' . $category));
            $manager->persist($car);
        }
        }

        $manager->flush();
    }
}
