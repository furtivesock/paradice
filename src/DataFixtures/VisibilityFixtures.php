<?php

namespace App\DataFixtures;

use App\Entity\Visibility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VisibilityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $visibility = new Visibility();
        $visibility->setName('ALL');
        $manager->persist($visibility);

        $this->addReference('ALL', $visibility);

        $visibility = new Visibility();
        $visibility->setName('UNIVERSE');
        $manager->persist($visibility);

        $this->addReference('UNIVERSE', $visibility);

        $visibility = new Visibility();
        $visibility->setName('STORY');
        $manager->persist($visibility);

        $this->addReference('STORY', $visibility);

        $manager->flush();
    }
}
