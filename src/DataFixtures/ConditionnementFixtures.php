<?php

namespace App\DataFixtures;

use App\Entity\Conditionnement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConditionnementFixtures extends Fixture
{
    public const REFERENCE_CONDITIONNEMENT = 'conditionnement';

    public const CONDITIONNEMENT = [
        'Barquette',
        'Barquette operculée',
        'Sous vide',
        'Sous gaz',
        'Flacon',
        'Pot',
        'Sachet',
        'Poche',
        'Bocal',
        'Verrine',
        'Boîte métal',
        'Vrac'
    ];

    public function load(ObjectManager $manager): void
    {
        $index = 0;
        foreach (self::CONDITIONNEMENT as $item) {
            $conditionnement = new Conditionnement();
            $conditionnement->setName($item);
            $this->addReference(self::REFERENCE_CONDITIONNEMENT . $index);
            $index++;
            $manager->persist($conditionnement);
        }
        $manager->flush();
    }
}
