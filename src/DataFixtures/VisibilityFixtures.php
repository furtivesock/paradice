<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Visibility;

class VisibilityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $visibility = new Visibility();
        $visibility->setName('ALL');
        $manager->persist($visibility);
        
        $visibility = new Visibility();
        $visibility->setName('UNIVERSE');
        $manager->persist($visibility);
        
        $visibility = new Visibility();
        $visibility->setName('STORY');
        $manager->persist($visibility);

        $manager->flush();

        $this->addReference('STORY', $visibility);
    }
}
