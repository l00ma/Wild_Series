<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
            'programs' => $programs,
        ]);
    }

    #[Route('/program/{id<^[0-9]+$>}', methods: ['GET'], name: 'program_show')]
    public function show(Program $program): Response
    {

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}', methods: ['GET'], name: 'season_show')]
    public function showSeason(Season $seasonId): Response
    {
        //$season = $seasonRepository->findOneBy(['id' => $seasonId]);
        $program = $seasonId->getProgram();
        $episodes = $seasonId->getEpisodes();

        return $this->render('program/season_show.html.twig', [
            'season' => $seasonId,
        ]);
    }

    #[Route('/program/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}/episode/{episodeId<^[0-9]+$>}', methods: ['GET'], name: 'program_episode_show')]
    public function showEpisode(Program $programId, Season $seasonId, Episode $episodeId)
    {
        $program = $episodeId->getSeason()->getProgram();
        return $this->render('program/episode_show.html.twig', [
            'episode' => $episodeId,
        ]);
    }
}
