<?php

namespace App\Controller\Admin\Crud;

use App\Entity\AppPolicy;
use App\Form\AppPolicyType;
use App\Repository\AppPolicyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/app/policy', name: "app_admin_policy_")]
class AppPolicyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AppPolicyRepository $appPolicyRepository): Response
    {
        return $this->render('admin/app_policy/index.html.twig', [
            'app_policies' => $appPolicyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppPolicyRepository $appPolicyRepository): Response
    {
        $appPolicy = new AppPolicy();
        $form = $this->createForm(AppPolicyType::class, $appPolicy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appPolicyRepository->save($appPolicy, true);

            return $this->redirectToRoute('app_admin_policy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/app_policy/new.html.twig', [
            'app_policy' => $appPolicy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(AppPolicy $appPolicy): Response
    {
        return $this->render('admin/app_policy/show.html.twig', [
            'app_policy' => $appPolicy,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AppPolicy $appPolicy, AppPolicyRepository $appPolicyRepository): Response
    {
        $form = $this->createForm(AppPolicyType::class, $appPolicy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appPolicyRepository->save($appPolicy, true);

            return $this->redirectToRoute('app_admin_policy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/app_policy/edit.html.twig', [
            'app_policy' => $appPolicy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, AppPolicy $appPolicy, AppPolicyRepository $appPolicyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appPolicy->getId(), $request->request->get('_token'))) {
            $appPolicyRepository->remove($appPolicy, true);
        }

        return $this->redirectToRoute('app_admin_policy_index', [], Response::HTTP_SEE_OTHER);
    }
}