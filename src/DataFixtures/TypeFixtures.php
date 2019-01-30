<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Entity\Type;

class TypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type1 = new Type();
        $type1->setName('RACE');
        $type1->setParentType(NULL);
        $type1->setUniverse($this->getReference('The-Universe'));
        $manager->persist($type1);

        $type2 = new Type();
        $type2->setName('CLASSE');
        $type2->setParentType($type2);
        $type2->setUniverse($this->getReference('The-Universe'));
        $manager->persist($type2);

        $type3 = new Type();
        $type3->setName('ARME');
        $type3->setParentType(NULL);
        $type3->setUniverse($this->getReference('The-Universe'));
        $manager->persist($type3);

        $type4 = new Type();
        $type4->setName('ARC');
        $type4->setParentType($type3);
        $type4->setUniverse($this->getReference('The-Universe'));
        $manager->persist($type4);

        $manager->flush();

        $this->addReference('Race', $type1);
        $this->addReference('Classe', $type2);
        $this->addReference('Arc', $type3);
    }

    public function getDependencies()
    {
        return array(UniverseFixtures::class);
    }
}