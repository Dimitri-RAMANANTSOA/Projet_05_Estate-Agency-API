<?php
// api/src/Controller/CreateMediaObjectAction.php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\MediaObject;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    public function __invoke(Request $request, PropertyRepository $propertyrepository): MediaObject
    {
        $property = $request->get('property');
        if (!$property)
        {
            throw new \RuntimeException('Property is required');
        }

        $propertyid = explode('/', $property);
        $propertyid = end($propertyid);

        $property = $propertyrepository->find($propertyid);

        if (!($property instanceof Property))
        {
            throw new \RuntimeException("ID $propertyid is not a valid Property");
        }
        
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;
        $mediaObject->setProperty($property);

        return $mediaObject;
    }
}