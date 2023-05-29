<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{categoryName}', methods: ['GET'], name: 'category_show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'Category ' . $categoryName . ' doesn\'t exist.'
            );
        }

        $programs = $category->getPrograms();
        //$programs = $programRepository->findBy(['category' => $category->getId()], ['id' => 'ASC'], 3, 0);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

    #[Route('/category/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $this->addFlash('success', 'Catégorie crée avec succès');

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }
}
