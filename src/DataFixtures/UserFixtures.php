<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const USER_REFERENCE = 'user';

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Entreprise();
        $user->setEmail('admin@qsa.com');
        $user->setName('QSA');
        $user->setFirstConnection(false);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $this->addReference('admin', $user);
        $manager->persist($user);
        $manager->flush();

        for ($i = 0; $i <= 30; $i++) {
            $user = new Entreprise();
            $user->setName('user' . $i);
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setFirstConnection(true);
            $user->setPassword($this->passwordHasher->hashPassword($user, '123456789'));
            $this->addReference(self::USER_REFERENCE . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();

    }

}
