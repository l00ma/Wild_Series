<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        foreach (ProgramFixtures::PROGRAM as $program) {
            for ($j = 0; $j < 5; $j++) {
                for ($i = 0; $i < 10; $i++) {
                    $episode = new Episode();

                    $episode->setTitle($faker->text(20));
                    $episode->setNumber($i + 1);
                    $episode->setSeason($this->getReference('season' . $j . '_' .  $program[0]));
                    $episode->setSynopsis($faker->text(100));
                    $manager->persist($episode);
                }
            }
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
