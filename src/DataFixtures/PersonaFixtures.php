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
        // Xeyh Silver-Scale
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
        $manager->persist($persona);
        $this->addReference('Xeyh', $persona);

        // Xarah Jinkein
        $persona = new Persona();
        $persona->setFirstName('Xarah');
        $persona->setLastName('Jinkein');
        $persona->setPhysicalDescription('Xarah possède deux formes. Une première forme humaine sous laquelle 
        il a les yeux bleus, des cheveux blancs assez court sur le crâne et une longue tresse dans le dos 
        descendant jusqu\'a ses pieds. Des marques orangées sont visibles sur ses joues. Sous forme de kitsune, 
        il possède un pelage roux ainsi une grande queue de la même couleur avec le bout noir.');
        $persona->setPersonality('Xarah est une personne agressive et égoïste, il ne pense qu\'à sa propre 
        suvie et à celle de ceux qu\'il aime. Rares sont ces dernières, on peut compter la Déesse Arnavä à qui il 
        a déjà sauvé la vie une fois ainsi que sa fille Visryn, qu\'il a eu avec elle. On peut également compter
        Kloaris, sa deuxième femme. Il est extrèmement attentionnée envers celles qu\'il aime et est prêt à 
        égorger quiconque atteindrait à leurs vies.');
        $persona->setBackground('Xarah a toujours vécut seul, dans des lieux dangereux. Il est habitué à se battre 
        et est passionné d\'histoire. Il s\'est tourné récemment vers la magie lié aux âmes et est capable de voler
        celle des morts.');
        $persona->setAge(21);
        $persona->setUniverse($this->getReference('Lune-Noire'));
        $persona->setUser($this->getReference('Eggoer'));
        $manager->persist($persona);
        $this->addReference('Xarah', $persona);


        // Cröw
        $persona = new Persona();
        $persona->setFirstName('Cröw');
        $persona->setLastName(NULL);
        $persona->setPhysicalDescription('Cröw est une fée du néant, elle fait 20 cm. Elle porte un large 
        chapeau de sorcière semblant trop grand pour elle qui cache ses yeux en permanence. Lorsqu\'ils sont 
        visibles, on peut voir des yeux vairons. L\'oeil gauche est de couleur violacée tandis que le droit est 
        de couleur dorée rappelant son ancienne nature.');
        $persona->setPersonality('Cröw est une personne très tournée vers les Dieux. Elle a été trahit à plusieurs 
        reprises par ceux en qui elle avait confiance et est devenu malfaisante.');
        $persona->setBackground('Très tournée vers les Dieux, elle servait le Dieu des Astres avant qu\'il ne meurt. 
        Lorsqu\'il est mrot elle a été accusé de ne pas avoir joué son rôle et a été exclu des plans divins.
        Elle développa ses propres capacité et fut corrompu par une énergie destructrice. Une nouvelle divinité 
        s\'approcha d\'elle et elle décida de la servir contre sa survie.');
        $persona->setAge(1200);
        $persona->setUniverse($this->getReference('Lune-Noire'));
        $persona->setUser($this->getReference('Eggoer'));
        $manager->persist($persona);
        $this->addReference('Cröw', $persona);
        
        // Akan
        $persona = new Persona();
        $persona->setFirstName('Akan');
        $persona->setLastName(NULL);
        $persona->setPhysicalDescription('Akan est un ange déchu ayant une apparence de diable.');
        $persona->setPersonality('C\'est un pirate, piller, tuer, voler, s\'alcooliser. Voilà ce qui le décrit le mieux.');
        $persona->setBackground('L\'ennui l\'a poussé à se détourner de sa divinité, préférant la piraterie à la bonté.');
        $persona->setAge(1200);
        $persona->setUniverse($this->getReference('Lune-Noire'));
        $persona->setUser($this->getReference('Sequentia'));
        $manager->persist($persona);
        $this->addReference('Akan', $persona);

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
