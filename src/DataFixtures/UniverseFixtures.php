<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\{OnlineUser, Universe};


class UniverseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // The-Universe
        $universe = new Universe();
        $universe->setName('The-Universe');
        $universe->setDescription('Je suis une description qualitative !');
        $universe->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $universe->setCreator($this->getReference('Sloky'));
        $universe->addModerator($this->getReference('Sloky'));
        $universe->setLogoURL(null);
        $universe->setBannerURL(null);
        $manager->persist($universe);
        $this->addReference('The-Universe', $universe);


        // Lune-Noire
        $universe = new Universe();
        $universe->setName('Lune-Noire');
        $universe->setDescription('Univers de qualité et bien décrit, oui oui oui !');
        $universe->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $universe->setCreator($this->getReference('Landry'));
        $universe->addModerator($this->getReference('Eggoer'));
        $universe->setLogoURL(null);
        $universe->setBannerURL(null);
        $manager->persist($universe);
        
        $this->addReference('Lune-Noire', $universe);

        $universe = new Universe();
        $universe->setName('The-Universe2');
        $universe->setDescription('Je suis une description qualitative !');
        $universe->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $universe->setCreator($this->getReference('Sloky'));
        $universe->addModerator($this->getReference('Sloky'));
        $universe->setLogoURL(null);
        $universe->setBannerURL(null);

        $manager->persist($universe);


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(OnlineUserFixtures::class);
    }
}
