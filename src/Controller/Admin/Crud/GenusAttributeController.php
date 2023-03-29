<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\AdminBaseController;
use App\Entity\GenusAttribute;
use App\Form\GenusAttributeType;
use App\Repository\GenusAttributeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/genus/attribute', name: 'app_admin_genus_attribute_')]
class GenusAttributeController extends AdminBaseController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GenusAttributeRepository $genusAttributeRepository): Response
    {
        return $this->render('admin/genus_attribute/index.html.twig', [
            'genus_attributes' => $genusAttributeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenusAttributeRepository $genusAttributeRepository): Response
    {
        $genusAttribute = new GenusAttribute();
        $form = $this->createForm(GenusAttributeType::class, $genusAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genusAttributeRepository->save($genusAttribute, true);

            return $this->redirectToRoute('app_admin_genus_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/genus_attribute/new.html.twig', [
            'genus_attribute' => $genusAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(GenusAttribute $genusAttribute): Response
    {
        return $this->render('admin/genus_attribute/show.html.twig', [
            'genus_attribute' => $genusAttribute,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GenusAttribute $genusAttribute, GenusAttributeRepository $genusAttributeRepository): Response
    {
        $form = $this->createForm(GenusAttributeType::class, $genusAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genusAttributeRepository->save($genusAttribute, true);

            return $this->redirectToRoute('app_admin_genus_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/genus_attribute/edit.html.twig', [
            'genus_attribute' => $genusAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, GenusAttribute $genusAttribute, GenusAttributeRepository $genusAttributeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genusAttribute->getId(), $request->request->get('_token'))) {
            $genusAttributeRepository->remove($genusAttribute, true);
        }

        return $this->redirectToRoute('app_admin_genus_attribute_index', [], Response::HTTP_SEE_OTHER);
    }
}
