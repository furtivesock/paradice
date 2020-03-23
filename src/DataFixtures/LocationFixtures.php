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
        $location1->setParentLocation(null);
        $location1->setImageURL(null);

        $manager->persist($location1);

        $location2 = new Location();
        $location2->setName('Le Néant');
        $location2->setDescription('Le point central de Fossilis');
        $location2->setUniverse($this->getReference('The-Universe'));
        $location2->setParentLocation($location1);
        $location2->setImageURL(null);
        
        $manager->persist($location2);
        $this->addReference('Fossilis', $location1);


        
        
        $location1 = new Location();
        $location1->setName('Rionto');
        $location1->setDescription('Terres des créatures mi-animales.');
        $location1->setUniverse($this->getReference('Lune-Noire'));
        $location1->setParentLocation(null);
        $location1->setImageURL(null);

        $manager->persist($location1);

        $location2 = new Location();
        $location2->setName('Perami');
        $location2->setDescription('Capitale de Rionto');
        $location2->setUniverse($this->getReference('Lune-Noire'));
        $location2->setParentLocation($location1);
        $location2->setImageURL(null);
        
        $manager->persist($location2);
        $this->addReference('Rionto', $location1);
        
        
        
        $manager->flush();


    }

    public function getDependencies()
    {
        return array(UniverseFixtures::class);
    }
}
