<?php

namespace App\Controller\Admin\Crud;

use App\Entity\LandingSlide;
use App\Form\LandingSlideType;
use App\Repository\LandingSlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/landing/slide', name: "app_admin_landing_slide_")]
class LandingSlideController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(LandingSlideRepository $landingSlideRepository): Response
    {
        return $this->render('admin/landing_slide/index.html.twig', [
            'landing_slides' => $landingSlideRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, LandingSlideRepository $landingSlideRepository): Response
    {
        $landingSlide = new LandingSlide();
        $form = $this->createForm(LandingSlideType::class, $landingSlide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $landingSlideRepository->save($landingSlide, true);

            return $this->redirectToRoute('app_admin_landing_slide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/landing_slide/new.html.twig', [
            'landing_slide' => $landingSlide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(LandingSlide $landingSlide): Response
    {
        return $this->render('admin/landing_slide/show.html.twig', [
            'landing_slide' => $landingSlide,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LandingSlide $landingSlide, LandingSlideRepository $landingSlideRepository): Response
    {
        $form = $this->createForm(LandingSlideType::class, $landingSlide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $landingSlideRepository->save($landingSlide, true);

            return $this->redirectToRoute('app_admin_landing_slide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/landing_slide/edit.html.twig', [
            'landing_slide' => $landingSlide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, LandingSlide $landingSlide, LandingSlideRepository $landingSlideRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$landingSlide->getId(), $request->request->get('_token'))) {
            $landingSlideRepository->remove($landingSlide, true);
        }

        return $this->redirectToRoute('app_admin_landing_slide_index', [], Response::HTTP_SEE_OTHER);
    }
}
