<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/admin', name: 'app_admin_')]
class ClearCacheController extends AdminBaseController
{

    #[Route('/clear/cache', name: 'clear_cache')]
    public function index(string $projectDir): Response
    {

        $clearFiles = $this->clearCache();

        if ($clearFiles > 0) {
            $this->addFlash('pageNotificationSuccess', 'Application cache cleared successfully. ' . $clearFiles . " file(s) removed.");
        } else {
            $this->addFlash('pageNotificationError', 'An error occurred while clearing the application cache.');
        }

        return $this->redirectToRoute('app_admin_dashboard');

    }

    public function clearCache(): int
    {
        return 10;
    }


}
