<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPseudo('Contributor');
        $contributor->setSex('Homme');
        $contributor->setLevel('Expert');
        $contributor->setBirthdate(new DateTime('1955/02/24'));
        $contributor->setCity('California');
        $contributor->setDescription('Contributor Account');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            'contributorpassword'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPseudo('Administrator');
        $admin->setSex('Homme');
        $admin->setLevel('Expert');
        $admin->setBirthdate(new DateTime('2000/02/24'));
        $admin->setCity('California');
        $admin->setDescription('Admin Account');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);
        $manager->flush();
    }
}
