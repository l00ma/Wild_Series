<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        ['FBI', 'Suivez le quotidien des agents spéciaux de la branche new-yorkaise du F.B.I.', 'https://artworks.thetvdb.com/banners/posters/5b7dd59bd6c65.jpg', 'category_Policier'],
        ['Barry', 'Un ex-Marine devenu tueur à gages au rabais se rend à Los Angeles pour exécuter un contrat. Il rencontre des théâtreux résolument optimistes et se découvre une vocation d\'acteur.', 'https://artworks.thetvdb.com/banners/posters/333072-3.jpg', 'category_Drame'],
        ['Good Girls', 'Trois mères de famille bien comme il faut orchestrent le casse d\'un supermarché pour échapper à la ruine et accéder à l\'indépendance. Toutes pour une, et une pour toutes.', 'https://artworks.thetvdb.com/banners/posters/328577-4.jpg', 'category_Drame'],
        ['Or de lui', 'Joseph est VRP dans une petite PME de banlieue. Sa vie se résume à : voiture - boulot - voiture - dîner avec une femme qui ne l’aime plus - dodo. Et rien ne présage que les choses évoluent pour lui. Jusqu’au jour où, par miracle, il commence à pondre… de l’or.', 'https://artworks.thetvdb.com/banners/v4/series/383785/posters/618d0614063ff.jpg', 'category_Humour'],
        ['Outer Banks', 'Sur une île où les inégalités sont accentuées, John B recrute ses trois meilleurs amis pour partir à la recherche d\'un trésor légendaire lié à la disparition de son père.', 'https://artworks.thetvdb.com/banners/series/379169/posters/5f3f6b28c81ce.jpg', 'category_Aventure'],

    ];


    public function load(ObjectManager $manager)
    {

        foreach (self::PROGRAM as $detail) {
            $program = new Program();
            $program->setTitle($detail[0]);
            $program->setSynopsis($detail[1]);
            $program->setPoster($detail[2]);
            $program->setCategory($this->getReference($detail[3]));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
