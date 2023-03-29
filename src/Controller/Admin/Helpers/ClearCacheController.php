<?php

namespace App\Controller\Admin\Helpers;

use ApiPlatform\Api\UrlGeneratorInterface;
use App\Controller\Admin\AdminBaseController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class ClearCacheController extends AdminBaseController
{


    #[Route('/clear/cache', name: 'clear_cache')]
    public function index(UrlGeneratorInterface $urlGenerator): Response
    {

        // Prepare Redirect URL
        $redirectAfterClear = $this->generateUrl('app_admin_dashboard', [], UrlGeneratorInterface::ABS_URL);

        $this->addFlash('pageNotificationSuccess', "Application cache pool cleared.");

        try {

            $myFileSystem = new Filesystem();

            // Remove Cache Directory
            $myFileSystem->remove($this->getParameter('kernel.cache_dir'));


            // Remove Log Directory
            $myFileSystem->remove($this->getParameter('kernel.logs_dir'));

        } catch (\Exception) {

        }

        // Redirect to Page
        header('Location: ' . $redirectAfterClear);
        exit;

    }


}
