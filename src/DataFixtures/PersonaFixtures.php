<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\UniverseFixtures;
use App\Entity\Persona;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PersonaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $persona = new Persona();
        $persona->setFirstName('Xeyh');
        $persona->setLastName('Silver-Scale');
        $persona->setPhysicalDescription('Xeyh a perdu son corps il y a quelques années, 
        il est actuellement dans le corps d\'Astra Asleyn. Astra est une jeune adolescente de 14 ans. 
        Elle possède des cheveux d\'un blanc immaculé, sa taille est de 1m42 et elle pèse 40kg. 
        Ses yeux varient selon la personnalité contrôlant le corps, sombre lorsque Xeyh le contrôle et bien 
        plus clair lorsque Astra prend le dessus.');
        $persona->setPersonality('Xeyh est une personne agressive et égoïste, il ne pense qu\'à sa propre suvie
        bien qu\'il soit désormais obligé de penser à la survie d\'Astra qui est désormais lié à lui. Il est confiant
        en ses capacités et se bat agilement, alliant magie et armes sans problèmes. Le combat ne l\'effrai pas
        bien au contraire il préfère même abattre ceux lui barrant la route plutôt que de discuter pour faire des compromis.
        Astra quant à elle est bien plus calme et posée, elle est plutôt amicale, peureuse et déteste se 
        battre.');
        $persona->setBackground('Xeyh était un humain né à Herméa, royaume dirigé par le Dragon d\Or Mengkare.
        Il en fut exclut après son refut de soumettre sa volonté à ce dragon. Fort des connaissances acquises là-bas
        il sait se battre et réfléchir avec un talent non négligeable. Lors de son exil il fut attaqué et capturé par
        un mage noir, mais réussit à l\'abattre et continua les recherches de ce dernier. Voyant les découvertes sur la capture
        et l\'assimilation d\'âmes, il s\'en inspira et fit ses propres recherches, devenant alors capable de les manipuler.
        Par la suite, après avoir perdu beaucoup de force, il rencontra une fillette du nom d\'Astra qui avait besoin de quelqu\'un
        pour sauver son village. Ils passèrent un marché et Xeyh prit possession de son corps. Il tua les bandits qui détruisaient
        le village de la petite fille et remarqua que son âme était toujours présente. Il comprit alors que son sort n\'avait que partiellement
        fonctionné, liant les âmes de ces deux entités à jamais. Désormais, l\'entité contrôlant le corps de la fillette
        alterne entre Xeyh et Astra, changeant radicalement leur manière d\'être selon celui qui le contrôle.');
        $persona->setAge(14);
        $persona->setUniverse($this->getReference('The-Universe'));
        $persona->setUser($this->getReference('Sloky'));

        // $product = new Product();
        // $manager->persist($product);

        $manager->persist($persona);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            OnlineUserFixtures::class, 
            UniverseFixtures::class,
        );
    }
}
