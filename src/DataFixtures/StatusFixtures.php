<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Status;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $status = new Status();
        $status->setName('FINISHED');
        $manager->persist($status);
        
        $status = new Status();
        $status->setName('IN_PROGRESS');
        $manager->persist($status);
        
        $status = new Status();
        $status->setName('FORSAKEN');
        $manager->persist($status);
        
        $status = new Status();
        $status->setName('INSCRIPTION');
        $manager->persist($status);

        $manager->flush();
    }
}
