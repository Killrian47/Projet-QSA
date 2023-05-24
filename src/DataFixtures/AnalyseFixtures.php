<?php

namespace App\DataFixtures;

use App\Entity\Analyse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnalyseFixtures extends Fixture implements DependentFixtureInterface
{

    public const ANALYSE_REFERENCE = 'analyse';

    public function load(ObjectManager $manager): void
    {
        $index = 0;
        for ($i = 0; $i <= 180; $i++) {
            $analyse = new Analyse();
            $analyse->setEntreprise($this->getReference(UserFixtures::USER_REFERENCE . $index));
            $index++;
            if ($i == 30 || $i == 60 || $i == 90 || $i == 120 || $i == 150) {
                $index = 0;
            }
            $analyse->setName('analyse_n°_' . $i);
            $this->addReference(self::ANALYSE_REFERENCE . $i, $analyse);
            $manager->persist($analyse);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [
          UserFixtures::class,
        ];
    }
}
