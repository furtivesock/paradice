<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Message;


class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $message = new Message();
        $message->setContents('Coucou les copinous');
        $message->setCreationDate(new \DateTime());;
        $message->setSender($this->getReference('Xeyh'));
        $message->setChapter($this->getReference('ChapterOne'));

        $manager->persist($message);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            OnlineUserFixtures::class,
            ChapterFixtures::class
        );
    }
}
