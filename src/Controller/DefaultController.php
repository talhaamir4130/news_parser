<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
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
