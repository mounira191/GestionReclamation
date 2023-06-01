<?php

namespace App\Controller;

use App\Entity\Typereclamation;
use App\Form\TypereclamationType;
use App\Repository\TypereclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;

#[Route('/typereclamation')]
class TypereclamationController extends AbstractController
{
    #[Route('/', name: 'app_typereclamation_index', methods: ['GET'])]
    public function index(TypereclamationRepository $typereclamationRepository): Response
    {
        return $this->render('typereclamation/index.html.twig', [
            'typereclamations' => $typereclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_typereclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypereclamationRepository $typereclamationRepository): Response
    {
        $typereclamation = new Typereclamation();
        $form = $this->createForm(TypereclamationType::class, $typereclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typereclamationRepository->save($typereclamation, true);

            return $this->redirectToRoute('app_typereclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typereclamation/new.html.twig', [
            'typereclamation' => $typereclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typereclamation_show', methods: ['GET'])]
    public function show(Typereclamation $typereclamation): Response
    {
        return $this->render('typereclamation/show.html.twig', [
            'typereclamation' => $typereclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typereclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typereclamation $typereclamation, TypereclamationRepository $typereclamationRepository): Response
    {
        $form = $this->createForm(TypereclamationType::class, $typereclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typereclamationRepository->save($typereclamation, true);

            return $this->redirectToRoute('app_typereclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typereclamation/edit.html.twig', [
            'typereclamation' => $typereclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typereclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Typereclamation $typereclamation, TypereclamationRepository $typereclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typereclamation->getId(), $request->request->get('_token'))) {
            $typereclamationRepository->remove($typereclamation, true);
        }

        return $this->redirectToRoute('app_typereclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
