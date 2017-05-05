<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{

    public function authentication()
    {
        return $this->render('authentication.twig');
    }

}