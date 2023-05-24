<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Twig\Environment;

readonly class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(private Environment $environment)
    {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return new Response($this->environment->render('security/403.html.twig'), 403);
    }
}
