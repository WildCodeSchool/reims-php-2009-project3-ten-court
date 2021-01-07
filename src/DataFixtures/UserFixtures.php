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
        $contributor->setEmail('axel@gmail.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPseudo('Axel');
        $contributor->setSex('Homme');
        $contributor->setLevel('intermediaire');
        $contributor->setPhone('438-396-1459');
        $contributor->setBirthdate(new DateTime('1990/11/30'));
        $contributor->setCity('Montréal');
        $contributor->setDescription('Je souhaite commencer à jouer au tennis');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            'password'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('damien@gmail.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPseudo('Damien');
        $contributor->setSex('Homme');
        $contributor->setLevel('expert');
        $contributor->setPhone('06 30 20 10 90');
        $contributor->setBirthdate(new DateTime('1976/02/24'));
        $contributor->setCity('Rethel');
        $contributor->setDescription('Je voudrais rencontrer du monde afin de jouer et être plus experimenté');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            'password'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('alexandre@gmail.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPseudo('Alexandre');
        $contributor->setSex('Homme');
        $contributor->setLevel('débutant');
        $contributor->setPhone('202-555-0101');
        $contributor->setBirthdate(new DateTime('1970/04/10'));
        $contributor->setCity('California');
        $contributor->setDescription('J\'ai décidé de changer de sport et de me mettre au tennis');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            'password'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('olivier@gmail.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPseudo('Olivier');
        $contributor->setSex('Homme');
        $contributor->setLevel('professionnel');
        $contributor->setPhone('06 21 29 98 10');
        $contributor->setBirthdate(new DateTime('1970/07/03'));
        $contributor->setCity('Troyes');
        $contributor->setDescription('Je souhaite rencontrer des personnes pour jouer');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            'password'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPseudo('Administrator');
        $admin->setSex('Homme');
        $admin->setLevel('Expert');
        $admin->setPhone('06 98 98 98 99');
        $admin->setBirthdate(new DateTime('2000/02/24'));
        $admin->setCity('Nowhere');
        $admin->setDescription('Admin Account');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);
        $manager->flush();
    }
}
