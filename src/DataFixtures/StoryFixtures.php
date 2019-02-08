<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Story;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $story = new Story();
        $story->setName('Super Story');
        $story->setDescription('je suis une super description qualitativbe !');
        $story->setCreationDate(new \DateTime());
        $story->setStartDate(new \DateTime());
        $story->setEndRegistrationDate(new \DateTime());
        $story->setAuthor($this->getReference('Sloky'));
        $story->setVisibility($this->getReference('STORY'));
        $story->setStatus($this->getReference('IN_PROGRESS'));
        $story->setUniverse($this->getReference('The-Universe'));
        $story->setSummary('Sommaire');
        $manager->persist($story);
        $this->addReference('SuperStory', $story);

        $story = new Story();
        $story->setName('Story Xarah');
        $story->setDescription('je suis une super description !');
        $story->setCreationDate(new \DateTime());
        $story->setStartDate(new \DateTime());
        $story->setEndRegistrationDate(new \DateTime());
        $story->setAuthor($this->getReference('Landry'));
        $story->setVisibility($this->getReference('STORY'));
        $story->setStatus($this->getReference('IN_PROGRESS'));
        $story->setUniverse($this->getReference('Lune-Noire'));
        $story->setSummary('Sommaire');
        $manager->persist($story);
        $this->addReference('Solitaire', $story);

        $story = new Story();
        $story->setName('Story Cröw');
        $story->setDescription('je suis qualitatif !');
        $story->setCreationDate(new \DateTime());
        $story->setStartDate(new \DateTime());
        $story->setEndRegistrationDate(new \DateTime());
        $story->setAuthor($this->getReference('Landry'));
        $story->setVisibility($this->getReference('STORY'));
        $story->setStatus($this->getReference('FINISHED'));
        $story->setUniverse($this->getReference('Lune-Noire'));
        $story->setSummary('Sommaire');
        $manager->persist($story);
        $this->addReference('VraimentOuf', $story);

        $story = new Story();
        $story->setName('Story Akan');
        $story->setDescription('je suis une super description qualitativbe !');
        $story->setCreationDate(new \DateTime());
        $story->setStartDate(new \DateTime());
        $story->setEndRegistrationDate(new \DateTime());
        $story->setAuthor($this->getReference('Landry'));
        $story->setVisibility($this->getReference('UNIVERSE'));
        $story->setStatus($this->getReference('FORSAKEN'));
        $story->setUniverse($this->getReference('Lune-Noire'));
        $story->setSummary('Sommaire');
        $manager->persist($story);
        $this->addReference('Piraterie', $story);

        $manager->flush(); 
    }

    public function getDependencies()
    {
        return array(
            OnlineUserFixtures::class, 
            VisibilityFixtures::class, 
            StatusFixtures::class, 
            UniverseFixtures::class
        );
    }
}
