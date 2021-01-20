<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\TennisMatch;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TennisMatchFixtures extends Fixture implements DependentFixtureInterface
{
    private $cities = [
        'Paris',
        'Reims',
        'Epernay',
        'Bordeaux',
        'Lyon',
        'Toulouse',
        'Marseille',
        'Brest',
        'Lille',
    ];

    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Generate Women Users
        for ($i = 0; $i < 50; $i++) {
            // Création d’un utilisateur de type “contributeur” (= auteur)
            $match = new TennisMatch();
            $match->setEventDate($faker->dateTimeBetween('now', '2 years'));
            $match->setStartHour($faker->dateTimeBetween('now', '2 years'));
            $match->setEndHour($faker->dateTimeBetween('now', '2 years'));
            $match->setName('match amical');
            $match->setDescription($faker->paragraph());
            $randKey = array_rand($this->cities, 1);
            $match->setAdress($this->cities[$randKey]);
            $match->setOrganizer($this->getReference('admin'));
            $manager->persist($match);
        }
        $manager->flush();
    }
}
