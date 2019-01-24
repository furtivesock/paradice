<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VisibilityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $visibility = new Visibility();
        $manager->setName('ALL');
        $manager->persist($visisbility);
        
        $visibility = new Visibility();
        $manager->setName('UNIVERSE');
        $manager->persist($visisbility);
        
        $visibility = new Visibility();
        $manager->setName('STORY');
        $manager->persist($visisbility);

        $manager->flush();
    }
}
