<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODE = [

        ['season1_FBI', 'Welcome to FBI S01E01', '1', 'a synopsis for ep 1'],
        ['season1_FBI', 'Welcome to FBI S01E02', '2', 'a synopsis for ep 2'],
        ['season1_FBI', 'Welcome to FBI S01E03', '3', 'a synopsis for ep 3'],

    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::EPISODE as $detail) {
            $episode = new Episode();
            $episode->setTitle($detail[1]);
            $episode->setNumber($detail[2]);
            $episode->setSeason($this->getReference($detail[0]));
            $episode->setSynopsis($detail[3]);
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            SeasonFixtures::class,
        ];
    }
}
