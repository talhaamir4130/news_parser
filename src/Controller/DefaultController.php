<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (is_null($user)) {
            return $this->redirect('login');
        }

        if (in_array('ROLE_MODERATOR', $user->getRoles())) {
            return $this->redirect('news_search');
        }

        return $this->redirect('login');
    }
}
