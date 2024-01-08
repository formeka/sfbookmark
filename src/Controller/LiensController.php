<?php

namespace App\Controller;

use App\Entity\Liens;
use App\Form\LiensType;
use App\Repository\LiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/liens')]
class LiensController extends AbstractController
{
    #[Route('/', name: 'app_liens_index', methods: ['GET'])]
    public function index(LiensRepository $liensRepository): Response
    {
        return $this->render('liens/index.html.twig', [
            'liens' => $liensRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_liens_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lien = new Liens();
        $form = $this->createForm(LiensType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lien);
            $entityManager->flush();

            return $this->redirectToRoute('app_liens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liens/new.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liens_show', methods: ['GET'])]
    public function show(Liens $lien): Response
    {
        return $this->render('liens/show.html.twig', [
            'lien' => $lien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liens_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liens $lien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LiensType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_liens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liens/edit.html.twig', [
            'lien' => $lien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liens_delete', methods: ['POST'])]
    public function delete(Request $request, Liens $lien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lien->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liens_index', [], Response::HTTP_SEE_OTHER);
    }
}
