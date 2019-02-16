<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\UniverseApplication;

class UniverseApplicationFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $universeApplication = new UniverseApplication();
        $universeApplication->setApplicant($this->getReference('Eggoer'));
        $universeApplication->setUniverse($this->getReference('The-Universe'));
        $universeApplication->setAccepted(null);
        $universeApplication->setMotivation('Je suis très motivé');
        $universeApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
        $manager->persist($universeApplication);

        $universeApplication = new UniverseApplication();
        $universeApplication->setApplicant($this->getReference('Landry'));
        $universeApplication->setUniverse($this->getReference('The-Universe'));
        $universeApplication->setAccepted(false);
        $universeApplication->setMotivation('Motibations');
        $universeApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
        $manager->persist($universeApplication);

        $manager->flush();
    }
    
    public function getDependencies() 
    {
        return array(
            OnlineUserFixtures::class,
            UniverseFixtures::class
        );
    }
}
