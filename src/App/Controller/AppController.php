<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    public function home()
    {
        return $this->render('home.twig');
    }
}