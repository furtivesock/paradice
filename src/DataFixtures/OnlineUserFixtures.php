<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\OnlineUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class OnlineUserFixtures extends Fixture 
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Sloky');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'jesuisunmdp'));
        $onlineUser->setCreationDate(new \DateTime());
        $onlineUser->setEmail('email@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $this->addReference('Sloky', $onlineUser);

        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Cyrela');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'bonjour'));
        $onlineUser->setCreationDate(new \DateTime());
        $onlineUser->setEmail('cyrela@yahoo.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $manager->flush();

    }
}
