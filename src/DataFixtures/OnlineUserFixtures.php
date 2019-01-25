<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\OnlineUser;

class OnlineUserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Sloky');
        $onlineUser->setPassword('jesuisunmdp');
        $onlineUser->setCreationDate(new \DateTime());
        $onlineUser->setEmail('email@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $manager->flush();

        $this->addReference('Sloky',$onlineUser);
    }
}
