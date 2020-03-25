<?php

namespace App\DataFixtures;

use App\Entity\MessageSupport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MessageSupportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $messageSupport = new MessageSupport();
        $messageSupport->setContents('Je suis un contenu de message au support, oui. Ouiii, oui.');
        $messageSupport->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $messageSupport->setUniverse($this->getReference('The-Universe'));
        $messageSupport->setSender($this->getReference('Sloky'));

        $manager->persist($messageSupport);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [OnlineUserFixtures::class, UniverseFixtures::class];
    }
}
