<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\AdminBaseController;
use App\Entity\SystemLog;
use App\Form\SystemLogType;
use App\Repository\SystemLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/system/log', name: "app_admin_system_log_")]
class SystemLogController extends AdminBaseController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SystemLogRepository $systemLogRepository): Response
    {
        return $this->render('admin/system_log/index.html.twig', [
            'system_logs' => $systemLogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SystemLogRepository $systemLogRepository): Response
    {
        $systemLog = new SystemLog();
        $form = $this->createForm(SystemLogType::class, $systemLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $systemLogRepository->save($systemLog, true);

            return $this->redirectToRoute('app_admin_system_log_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/system_log/new.html.twig', [
            'system_log' => $systemLog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(SystemLog $systemLog): Response
    {
        return $this->render('admin/system_log/show.html.twig', [
            'system_log' => $systemLog,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SystemLog $systemLog, SystemLogRepository $systemLogRepository): Response
    {
        $form = $this->createForm(SystemLogType::class, $systemLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $systemLogRepository->save($systemLog, true);

            return $this->redirectToRoute('app_admin_system_log_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/system_log/edit.html.twig', [
            'system_log' => $systemLog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, SystemLog $systemLog, SystemLogRepository $systemLogRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$systemLog->getId(), $request->request->get('_token'))) {
            $systemLogRepository->remove($systemLog, true);
        }

        return $this->redirectToRoute('app_admin_system_log_index', [], Response::HTTP_SEE_OTHER);
    }
}
