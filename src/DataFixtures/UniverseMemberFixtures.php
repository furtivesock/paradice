<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\UniverseMember;

class UniverseMemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $universeMember = new UniverseMember();
        $universeMember->setMember($this->getReference('Sloky'));
        $universeMember->setUniverse($this->getReference('The-Universe'));
        $universeMember->setAcceptationDate(new \DateTime());
        
        $manager->persist($universeMember);

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
