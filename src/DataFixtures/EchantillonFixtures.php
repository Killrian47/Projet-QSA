<?php

namespace App\DataFixtures;

use App\Entity\Echantillon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EchantillonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $userId = 0;
        $orderId = 0;
        for ($i = 0; $i < 1080; $i++) {
            $echantillon = new Echantillon();
            $echantillon->setEntreprise($this->getReference(UserFixtures::USER_REFERENCE . $userId));
            $userId++;
            if ($i == 30 || $i == 60 || $i == 90 || $i == 120 || $i == 150 || $i == 180 || $i == 210 || $i == 240 ||
                $i == 270 || $i == 300 || $i == 330 || $i == 360 || $i == 390 || $i == 420 || $i == 450 || $i == 480 ||
                $i == 510 || $i == 540 || $i == 570 || $i == 600 || $i == 630 || $i == 660 || $i == 690 || $i == 720 ||
                $i == 750 || $i == 780 || $i == 810 || $i == 840 || $i == 870 || $i == 900 || $i == 930 || $i == 960 ||
                $i == 990 || $i == 1020 || $i == 1050) {
                $userId = 0;
            }
            $echantillon->setNumberOfOrder($this->getReference(OrderFixtures::ORDER_REFERENCE . $orderId));
            $echantillon->setAnalyse($this->getReference(AnalyseFixtures::ANALYSE_REFERENCE . $orderId));
            $orderId++;
            if ($i == 180 || $i == 360 || $i == 540 || $i == 720 || $i == 900) {
                $orderId = 0;
            }
            $echantillon->setProductName('produit_n°_' . $i);
            $echantillon->setDateAnalyse(new \DateTimeImmutable('now + 1 day'));
            $randomString = str_replace(['+', '/', '=', '\\'], '', base64_encode(random_bytes(10)));
            $echantillon->setNumberOfBatch($randomString);
            $echantillon->setSamplingBy($this->getReference('admin'));
            $echantillon->setStockage(null);
            $echantillon->setLieu(null);
            $echantillon->setEtatPhysique($this->getReference(EtatPhysiqueFixtures::REFERENCE_ETAT_PHYSIQUE . $faker->numberBetween(0, 5)));
            $echantillon->setConditioning(null);
            $echantillon->setValidationDlc(false);
            $echantillon->setAnalyseDlc(true);
            $echantillon->setDateOfSampling(new \DateTimeImmutable('now'));
            $echantillon->setDlcOrDluo(new \DateTimeImmutable('now + 30 days'));
            $echantillon->setDateOfManufacturing(new \DateTimeImmutable('now -20 days'));
            $echantillon->setTemperatureOfEnceinte(random_int(-10, 20));
            $echantillon->setTemperatureOfProduct(random_int(-10, 20));
            $echantillon->setSupplier('Je ne sais pas');
            $manager->persist($echantillon);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        // TODO: Implement getDependencies() method.
        return [
            UserFixtures::class,
            OrderFixtures::class,
            AnalyseFixtures::class,
            EtatPhysiqueFixtures::class
        ];
    }
}
