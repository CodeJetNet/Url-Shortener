<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedirectController extends AbstractController
{
    public function redirectFromCode($code)
    {
        $repository = $this->getDoctrine()
            ->getRepository(ShortUrl::class);

        $short_url = $repository->findOneBy(['code' => $code]);

        return $this->redirect($short_url->getUrl());
    }
}
