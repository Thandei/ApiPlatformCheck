<?php

namespace App\Controller\Admin\Crud;

use App\Controller\Admin\AdminBaseController;
use App\Entity\Locale;
use App\Form\LocaleType;
use App\Repository\LocaleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/locale', name: 'app_admin_locale_')]
class LocaleController extends AdminBaseController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(LocaleRepository $localeRepository): Response
    {
        return $this->render('admin/locale/index.html.twig', [
            'locales' => $localeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocaleRepository $localeRepository): Response
    {
        $locale = new Locale();
        $form = $this->createForm(LocaleType::class, $locale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localeRepository->save($locale, true);
            $this->makeSystemsDefaultIfItsPossible($locale, $localeRepository);
            return $this->redirectToRoute('app_admin_locale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/locale/new.html.twig', [
            'locale' => $locale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Locale $locale): Response
    {
        return $this->render('admin/locale/show.html.twig', [
            'locale' => $locale,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Locale $locale, LocaleRepository $localeRepository): Response
    {
        $form = $this->createForm(LocaleType::class, $locale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localeRepository->save($locale, true);
            $this->makeSystemsDefaultIfItsPossible($locale, $localeRepository);
            return $this->redirectToRoute('app_admin_locale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/locale/edit.html.twig', [
            'locale' => $locale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Locale $locale, LocaleRepository $localeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $locale->getId(), $request->request->get('_token'))) {
            $localeRepository->remove($locale, true);
        }

        return $this->redirectToRoute('app_admin_locale_index', [], Response::HTTP_SEE_OTHER);
    }

    public function makeSystemsDefaultIfItsPossible(Locale $locale, LocaleRepository $localeRepository): void
    {
        if ($locale->isSystemsdefault() === TRUE) {

            $allLocales = $localeRepository->findAll();
            foreach ($allLocales as $allLocale) {
                if ($allLocale->getId() !== $locale->getId()) {
                    $allLocale->setSystemsdefault(FALSE);
                }
                $localeRepository->save($allLocale, TRUE);
            }
        }
    }
}
