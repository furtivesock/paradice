<?php

namespace App\DataFixtures;

use App\Entity\Chapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

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

        $this->addReference('ChapterOne', $chapter);

        $chapter = new Chapter();
        $chapter->setName('Le début de la fin');
        $chapter->setNumero(1);
        $chapter->setLocation($this->getReference('Rionto'));
        $chapter->setStory($this->getReference('Piraterie'));
        $chapter->setEnd(false);
        $manager->persist($chapter);

        $this->addReference('ChapterDeux', $chapter);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LocationFixtures::class,
            StoryFixtures::class,
        ];
    }
}
