<?php

namespace App\DataFixtures;

use App\Entity\Characteristic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CharacteristicFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $characteristic = new Characteristic();
        $characteristic->setName('Humain');
        $characteristic->setDescription('Race humaine');
        $characteristic->setType($this->getReference('Race'));
        $characteristic->setImageURL(null);

        $manager->persist($characteristic);

        $characteristic = new Characteristic();
        $characteristic->setName('Sorcier Vert');
        $characteristic->setDescription('Un sorcier reconvertit dans l\'écologie et qui se sert '.
        'de ses nombreux pouvoirs afin de lutter contre le réchauffement climatique actuel.'.
        'Un sorcier vert à par ailleurs de nombreux avantages dans le domaine de la politique '.
        'grâce à son expérience acquise dans ses nombreuses campagnes politiques dans le monde entier.');
        $characteristic->setType($this->getReference('Classe'));
        $characteristic->setImageURL(null);

        $manager->persist($characteristic);

        $characteristic = new Characteristic();
        $characteristic->setName('Ecriver à l\'ARC');
        $characteristic->setDescription('Une arme redoutable qui permettait, d\'après la légende,'.
        'de soigner des personnes en phase terminale du cancer.');
        $characteristic->setType($this->getReference('Arc'));
        $characteristic->setImageURL(null);

        $manager->persist($characteristic);

        $characteristic = new Characteristic();
        $characteristic->setName('Magie noire');
        $characteristic->setDescription('Magie noire, très très noire');
        $characteristic->setType($this->getReference('Magie'));
        $characteristic->setImageURL(null);

        $manager->persist($characteristic);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TypeFixtures::class,
        ];
    }
}
