<?php

namespace App\DataFixtures;

use App\Entity\EtatPhysique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatPhysiqueFixtures extends Fixture
{

    public const REFERENCE_ETAT_PHYSIQUE = 'etat_physique';

    public const ETAT_PHYSIQUE = [
        'Frais',
        'Surgelés',
        'Conserve',
        'Semi-conserve',
        'Sec',
        'Liquide'
    ];

    public function load(ObjectManager $manager): void
    {
        $index = 0;
        foreach (self::ETAT_PHYSIQUE as $key) {
            $etatPhysique = new EtatPhysique();
            $etatPhysique->setName($key);
            $this->addReference(self::REFERENCE_ETAT_PHYSIQUE . $index, $etatPhysique);
            $manager->persist($etatPhysique);
            $index++;
        }

        $manager->flush();
    }
}
