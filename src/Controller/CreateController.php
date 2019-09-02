<?php

namespace App\Controller;

use App\Entity\ShortUrl;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateController extends AbstractController
{
    public function create(Request $request, ValidatorInterface $validator)
    {
        $short_url = new ShortUrl();
        $short_url->setUrl($request->get('url'));
        $short_url->setCode($this->generateCode());

        $errors = $validator->validate($short_url);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($short_url);
        $entity_manager->flush();

        return $this->render('create.html.twig', [
            'short_url' => $short_url
        ]);
    }

    private function generateCode()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
    }
}
