<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\AdminBaseController;
use App\Entity\Genus;
use App\Form\GenusType;
use App\Repository\GenusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/genus', name: "app_admin_genus_")]
class GenusController extends AdminBaseController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GenusRepository $genusRepository): Response
    {
        return $this->render('admin/genus/index.html.twig', [
            'genera' => $genusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenusRepository $genusRepository): Response
    {
        $genu = new Genus();
        $form = $this->createForm(GenusType::class, $genu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genusRepository->save($genu, true);

            return $this->redirectToRoute('app_admin_genus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/genus/new.html.twig', [
            'genu' => $genu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Genus $genu): Response
    {
        return $this->render('admin/genus/show.html.twig', [
            'genu' => $genu,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Genus $genu, GenusRepository $genusRepository): Response
    {
        $form = $this->createForm(GenusType::class, $genu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genusRepository->save($genu, true);

            return $this->redirectToRoute('app_admin_genus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/genus/edit.html.twig', [
            'genu' => $genu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Genus $genu, GenusRepository $genusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $genu->getId(), $request->request->get('_token'))) {
            $genusRepository->remove($genu, true);
        }

        return $this->redirectToRoute('app_admin_genus_index', [], Response::HTTP_SEE_OTHER);
    }
}
