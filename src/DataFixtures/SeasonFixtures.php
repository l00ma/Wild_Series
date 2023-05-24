<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    const SEASON = [
        ['FBI', '1', '2005', 'a text to describe season 1 of FBI'],
        ['FBI', '2', '2006', 'a text to describe season 2 of FBI'],
        ['FBI', '3', '2007', 'a text to describe season 3 of FBI'],
        ['FBI', '4', '2008', 'a text to describe season 4 of FBI'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASON as $detail) {
            $season = new Season();
            $season->setNumber($detail[1]);
            $season->setProgram($this->getReference('program_' . $detail[0]));
            $season->setYear($detail[2]);
            $season->setDescription($detail[3]);
            $manager->persist($season);
            $this->addReference('season' . $detail[1] . '_' . $detail[0], $season);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
