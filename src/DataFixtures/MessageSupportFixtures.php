<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\UniverseFixtures;
use App\Entity\MessageSupport;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageSupportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $messageSupport = new MessageSupport();
        $messageSupport->setContents('Je suis un contenu de message au support, oui. Ouiii, oui.');
        $messageSupport->setCreationDate(new \DateTime());
        $messageSupport->setUniverse($this->getReference('The-Universe'));
        $messageSupport->setSender($this->getReference('Sloky'));

        $manager->persist($messageSupport);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(OnlineUserFixtures::class, UniverseFixtures::class);
    }
}
