<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (is_null($user)) {
            return $this->redirect('login');
        }

        $this->denyAccessUnlessGranted('ROLE_MODERATOR');

        return $this->redirectToRoute('app_news_search');
    }
}
