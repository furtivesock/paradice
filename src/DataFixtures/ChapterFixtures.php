<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Chapter;

class ChapterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $chapter = new Chapter();
        $chapter->setName('Le début de la fin');
        $chapter->setNumero(0);
        $chapter->setLocation($this->getReference('Fossilis'));
        $chapter->setStory($this->getReference('SuperStory'));
        $chapter->setEnd(false);

        $manager->persist($chapter);

        $manager->flush();

        $this->addReference('ChapterOne', $chapter);
    }

    public function getDependencies()
    {
        return array(
            LocationFixtures::class,
            StoryFixtures::class
        );
    }
}
