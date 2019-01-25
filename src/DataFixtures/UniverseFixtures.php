<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Universe;
use App\Entity\OnlineUser;

class UniverseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $universe = new Universe();
        $universe->setName('The-Universe');
        $universe->setDescription('Je suis une description qualitative !');
        $universe->setCreationDate(new \DateTime());
        $universe->setCreator($this->getReference('Sloky'));
        $universe->addModerator($this->getReference('Sloky'));
        $universe->setLogoURL(NULL);
        $universe->setBannerURL(NULL);

        $manager->persist($universe);

        $manager->flush();
    }

    public function getDependences()
    {
        return array(OnlineUserFixtures::class);
    }
}
