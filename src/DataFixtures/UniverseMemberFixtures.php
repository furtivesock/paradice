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
        // The Universe
        $universeMember = new UniverseMember();
        $universeMember->setMember($this->getReference('Sloky'));
        $universeMember->setUniverse($this->getReference('The-Universe'));
        $universeMember->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
        $manager->persist($universeMember);

        // Lune-Noire
        $universeMember = new UniverseMember();
        $universeMember->setMember($this->getReference('Landry'));
        $universeMember->setUniverse($this->getReference('Lune-Noire'));
        $universeMember->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
        $manager->persist($universeMember);

        $universeMember = new UniverseMember();
        $universeMember->setMember($this->getReference('Eggoer'));
        $universeMember->setUniverse($this->getReference('Lune-Noire'));
        $universeMember->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
        $manager->persist($universeMember);

        $universeMember = new UniverseMember();
        $universeMember->setMember($this->getReference('Sequentia'));
        $universeMember->setUniverse($this->getReference('Lune-Noire'));
        $universeMember->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        
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
