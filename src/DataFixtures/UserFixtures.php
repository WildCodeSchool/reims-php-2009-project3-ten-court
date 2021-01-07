<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Generate Women Users
        for ($i = 0; $i < 20; $i++) {
            // Création d’un utilisateur de type “contributeur” (= auteur)
            $contributor = new User();
            $contributor->setEmail($faker->email);
            $contributor->setRoles(['ROLE_CONTRIBUTOR']);
            $contributor->setPseudo($faker->firstNameFemale);
            $contributor->setSex('Femme');
            $contributor->setLevel($faker->randomElement(array (
                'Débutant', 'Intermediaire', 'Expert', 'Professionnel'
            )));
            $contributor->setPhone($faker->phoneNumber);
            $contributor->setBirthdate(new DateTime($faker->date(
                'Y-m-d', //format
                '2005-12-12'/* 'now' */ //date max
            )));
            $contributor->setCity($faker->city);
            $contributor->setPostalcode($faker->postcode);
            $contributor->setAddress($faker->streetAddress);
            $contributor->setDescription($faker->sentence(20));
            $contributor->setPassword($this->passwordEncoder->encodePassword(
                $contributor,
                'password'
            ));

            $manager->persist($contributor);
        }

        //Generate Men Users
        for ($i = 0; $i < 20; $i++) {
            // Création d’un utilisateur de type “contributeur” (= auteur)
            $contributor = new User();
            $contributor->setEmail($faker->email);
            $contributor->setRoles(['ROLE_CONTRIBUTOR']);
            $contributor->setPseudo($faker->firstNameMale);
            $contributor->setSex('Homme');
            $contributor->setLevel($faker->randomElement(array(
                'Débutant', 'Intermediaire', 'Expert', 'Professionnel'
            )));
            $contributor->setPhone($faker->phoneNumber);
            $contributor->setBirthdate(new DateTime($faker->date(
                'Y-m-d', //format
                '2005-12-12'/* 'now' */ //date max
            )));
            $contributor->setCity($faker->city);
            $contributor->setPostalcode($faker->postcode);
            $contributor->setAddress($faker->streetAddress);
            $contributor->setDescription($faker->sentence(20));
            $contributor->setPassword($this->passwordEncoder->encodePassword(
                $contributor,
                'password'
            ));

            $manager->persist($contributor);
        }

        // Create an admin User
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPseudo('Administrator');
        $admin->setSex('Homme');
        $admin->setLevel('Expert');
        $admin->setPhone('06 10 20 30 40');
        $admin->setBirthdate(new DateTime('1990/12/24'));
        $admin->setCity('Bakersfield');
        $admin->setDescription('Je suis l\'administrateur de cette application');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);
        $manager->flush();
    }
}
