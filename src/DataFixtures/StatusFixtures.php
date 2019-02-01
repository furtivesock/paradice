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
        $this->addReference('FINISHED', $status);
        
        $status = new Status();
        $status->setName('IN_PROGRESS');
        $manager->persist($status);
        $this->addReference('IN_PROGRESS', $status);

        $status = new Status();
        $status->setName('FORSAKEN');
        $manager->persist($status);
        $this->addReference('FORSAKEN', $status);

        $status = new Status();
        $status->setName('INSCRIPTION');
        $manager->persist($status);
        $this->addReference('INSCRIPTION', $status);



        $manager->flush();

        
    }
}
