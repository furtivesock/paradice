<?php

namespace App\DataFixtures;

use App\Entity\StoryPlayer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StoryPlayerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Xeyh
        $storyPlayer = new StoryPlayer();
        $storyPlayer->setPlayer($this->getReference('Xeyh'));
        $storyPlayer->setStory($this->getReference('SuperStory'));
        $storyPlayer->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));

        $manager->persist($storyPlayer);

        // Xarah
        $storyPlayer = new StoryPlayer();
        $storyPlayer->setPlayer($this->getReference('Xarah'));
        $storyPlayer->setStory($this->getReference('Solitaire'));
        $storyPlayer->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));

        $manager->persist($storyPlayer);

        // Cröw
        $storyPlayer = new StoryPlayer();
        $storyPlayer->setPlayer($this->getReference('Cröw'));
        $storyPlayer->setStory($this->getReference('VraimentOuf'));
        $storyPlayer->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));

        $manager->persist($storyPlayer);

        // Akan
        $storyPlayer = new StoryPlayer();
        $storyPlayer->setPlayer($this->getReference('Akan'));
        $storyPlayer->setStory($this->getReference('Piraterie'));
        $storyPlayer->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));

        $manager->persist($storyPlayer);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PersonaFixtures::class,
            StoryFixtures::class,
        ];
    }
}
