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

        $manager->flush(); 

        $this->addReference('SuperStory', $story);
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
