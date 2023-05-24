<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhpunitController extends AbstractController
{
    #[Route('/phpunit/dashboard.html', name: 'phpunit_index', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('Files is not generated. Run command <code>"php bin/phpunit --coverage-html public/phpunit"</code>.');
    }
}
