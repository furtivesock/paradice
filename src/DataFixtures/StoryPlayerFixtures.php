<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\StoryPlayer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StoryPlayerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $storyPlayer = new StoryPlayer();
        $storyPlayer->setPlayer($this->getReference('Xeyh'));
        $storyPlayer->setStory($this->getReference('SuperStory'));
        $storyPlayer->setAcceptationDate(new \DateTime());

        $manager->persist($storyPlayer);

        $manager->flush();
    }

    public function getDependencies() 
    {
        return array(
            PersonaFixtures::class,
            StoryFixtures::class
        );
    }
}
