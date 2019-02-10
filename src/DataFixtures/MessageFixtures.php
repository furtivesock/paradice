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
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));;
        $message->setSender($this->getReference('Sloky'));
        $message->setChapter($this->getReference('ChapterOne'));

        $manager->persist($message);


        $message = new Message();
        $message->setContents('Salam les Kheys');
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $message->setSender($this->getReference('Eggoer'));
        $message->setChapter($this->getReference('ChapterDeux'));

        $manager->persist($message);

        $message = new Message();
        $message->setContents('Salam frr');
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $message->setSender($this->getReference('Sequentia'));
        $message->setChapter($this->getReference('ChapterDeux'));

        $manager->persist($message);

        $message = new Message();
        $message->setContents('Wesh groooo');
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $message->setSender($this->getReference('Eggoer'));
        $message->setChapter($this->getReference('ChapterDeux'));

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
