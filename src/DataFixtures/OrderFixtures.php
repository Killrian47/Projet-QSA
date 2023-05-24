<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public const ORDER_REFERENCE = 'order';

    public function load(ObjectManager $manager): void
    {
        $index = 0;
        for ($i = 0; $i <= 180; $i++) {
            $order = new Order();
            $order->setEntreprise($this->getReference(UserFixtures::USER_REFERENCE . $index));
            $index++;
            if ($i == 30 || $i == 60 || $i == 90 || $i == 120 || $i == 150) {
                $index = 0;
            }
            $order->setCreatedAt(new \DateTimeImmutable('now'));
            $order->setIsExported(false);
            $this->addReference(self::ORDER_REFERENCE . $i, $order);
            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
