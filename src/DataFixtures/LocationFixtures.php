<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Location;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $location1 = new Location();
        $location1->setName('Fossilis');
        $location1->setDescription('Terres de fossile écartées de toute vie. La civilisation la plus proche se trouve à plus de 300km.');
        $location1->setUniverse($this->getReference('The-Universe'));
        $location1->setParentLocation(NULL);
        $location1->setImageURL(NULL);

        $manager->persist($location1);

        $location2 = new Location();
        $location2->setName('Le Néant');
        $location2->setDescription('Le point central de Fossilis');
        $location2->setUniverse($this->getReference('The-Universe'));
        $location2->setParentLocation($location1);
        $location2->setImageURL(NULL);
        
        $manager->persist($location2);

        $manager->flush();


        $this->addReference('Fossilis', $location1);
    }

    public function getDependencies()
    {
        return array(UniverseFixtures::class);
    }
}
