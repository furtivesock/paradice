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
        $onlineUser->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $onlineUser->setEmail('email@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);
        $this->addReference('Sloky', $onlineUser);
        
        // Cyrela
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Cyrela');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'bonjour'));
        $onlineUser->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $onlineUser->setEmail('cyrela@yahoo.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        // Eggoer
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Eggoer');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'EggoerMdp'));
        $onlineUser->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $onlineUser->setEmail('eggoer@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $this->addReference('Eggoer', $onlineUser);
        
        // Landry
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Landry');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'jesuisunmdp'));
        $onlineUser->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $onlineUser->setEmail('landry@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $this->addReference('Landry', $onlineUser);
        
        // Sequentia
        $onlineUser = new OnlineUser();
        $onlineUser->setUsername('Sequentia');
        $onlineUser->setPassword($this->encoder->encodePassword($onlineUser, 'jesuisunmdp'));
        $onlineUser->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $onlineUser->setEmail('sequentia@info.fr');
        $onlineUser->setAvatarURL(NULL);
        $manager->persist($onlineUser);

        $this->addReference('Sequentia', $onlineUser);
        


        $manager->flush();


        
    }
}
