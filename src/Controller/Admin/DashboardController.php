<?php

namespace App\Controller\Admin;

use App\Entity\Instance;
use App\Entity\InstanceList;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    #[Route('/', name: 'dashboard', defaults: ['_locale' => 'en'])]
    public function index(): Response
    {
        return $this->render('easyadmin/dashboard.html.twig');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Instance', 'fas fa-industry', Instance::class);
        yield MenuItem::linkToCrud('Instance list', 'fas fa-list', InstanceList::class);
        yield MenuItem::linkToUrl('API Documentation', 'fas fa-file', $this->urlGenerator->generate('api_doc'));
        yield MenuItem::linkToUrl('Phpunit', 'fa-solid fa-bug', '/phpunit/dashboard.html');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addWebpackEncoreEntry('app');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setLocales([
            Locale::new('en', '🇬🇧 English'),
            Locale::new('pl', '🇵🇱 Polski'),
        ]);
    }
}
