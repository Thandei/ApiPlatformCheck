<?php namespace App\ApiResource\Action;

use App\Entity\MediaObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    public function __invoke(Request $request): MediaObject
    {

        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('Please select file at least one.');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        // If User Is Logged -> Set Uploaded By
        if ($this->getUser()) {
            $mediaObject->setUploadedby($this->getUser());
        }

        return $mediaObject;
    }

}