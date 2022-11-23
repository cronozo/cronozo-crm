<?php

declare(strict_types=1);

namespace App\Web\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'start')]
final class IndexController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('base.html.twig');
    }
}
