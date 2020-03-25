<?php

namespace App\DataFixtures;

use App\Entity\StoryApplication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StoryApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $storyApplication = new StoryApplication();
        $storyApplication->setApplicant($this->getReference('Xeyh'));
        $storyApplication->setStory($this->getReference('SuperStory'));
        $storyApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $storyApplication->setMotivation('Je suis motivée de chez mo-ti-vée');
        $storyApplication->setAccepted(true);

        $manager->persist($storyApplication);

        $storyApplication = new StoryApplication();
        $storyApplication->setApplicant($this->getReference('Xarah'));
        $storyApplication->setStory($this->getReference('Solitaire'));
        $storyApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $storyApplication->setMotivation('Je suis motivée de chez mo-ti-vée');
        $storyApplication->setAccepted(true);

        $manager->persist($storyApplication);

        $storyApplication = new StoryApplication();
        $storyApplication->setApplicant($this->getReference('Cröw'));
        $storyApplication->setStory($this->getReference('VraimentOuf'));
        $storyApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $storyApplication->setMotivation('SVP J VEUX JOUER');
        $storyApplication->setAccepted(false);

        $manager->persist($storyApplication);

        $storyApplication = new StoryApplication();
        $storyApplication->setApplicant($this->getReference('Akan'));
        $storyApplication->setStory($this->getReference('Piraterie'));
        $storyApplication->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $storyApplication->setMotivation('Je suis motivée de chez mo-ti-vée');
        $storyApplication->setAccepted(true);

        $manager->persist($storyApplication);

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
