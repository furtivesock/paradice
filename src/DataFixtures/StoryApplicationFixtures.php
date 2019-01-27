<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\StoryApplication;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StoryApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $storyApplication = new StoryApplication();
        $storyApplication->setApplicant($this->getReference('Xeyh'));
        $storyApplication->setStory($this->getReference('SuperStory'));
        $storyApplication->setApplicationDate(new \DateTime());
        $storyApplication->setMotivation('Je suis motivée de chez mo-ti-vée');
        $storyApplication->setAccepted(true);

        $manager->persist($storyApplication);

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
