<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $status = new Visibility();
        $manager->setName('FINISHED');
        $manager->persist($status);
        
        $status = new Visibility();
        $manager->setName('IN_PROGRESS');
        $manager->persist($status);
        
        $status = new Visibility();
        $manager->setName('FORSAKEN');
        $manager->persist($status);
        
        $status = new Visibility();
        $manager->setName('INSCRIPTION');
        $manager->persist($status);

        $manager->flush();
    }
}
