<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (ProgramFixtures::PROGRAM as $program) {
            for ($i = 0; $i < 5; $i++) {
                $season = new Season();

                $season->setNumber($i + 1);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));

                $season->setProgram($this->getReference('program_' . $program[0]));
                $this->addReference('season' . $i . '_' .  $program[0], $season);

                $manager->persist($season);
            }
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
