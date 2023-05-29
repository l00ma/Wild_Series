<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('program/season_show.html.twig', [
            'season' => $seasonId,
        ]);
    }

    #[Route('/program/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}/episode/{episodeId<^[0-9]+$>}', methods: ['GET'], name: 'program_episode_show')]
    public function showEpisode(Episode $episodeId): Response
    {

        return $this->render('program/episode_show.html.twig', [
            'episode' => $episodeId,
        ]);
    }

    #[Route('program/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($program, true);
            $this->addFlash('success', 'Série crée avec succès');

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }
}
