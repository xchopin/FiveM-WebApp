<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class AuthController extends Controller
{

    /**
     * Sign in function
     *
     * @return string
     */
    public function signin()
    {
        return $this->render('authentication.twig');
    }

    private function encoder($string)
    {

    }

    /**
     * Sign up function
     *
     * @param Request $request
     * @return string
     */
    public function signup(Request $request)
    {
        if ($request->isMethod('GET'))
            return $this->render('signup.twig');

        try {
            v::stringType()->notEmpty()->noWhiteSpace()->length(3)->check($_POST['username']);
            v::stringType()->notEmpty()->noWhiteSpace()->check($_POST['email']);
            v::stringType()->notEmpty()->noWhiteSpace()->length(6)->check($_POST['password']);
        } catch(\Exception $exception) {
            $this->flash('danger', $exception->getMainMessage());
            return $this->render('signup.twig');
        }

        $user = new User();
        $user->setUserName($_POST['username']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);

        $em = $this->getEntityManager();
       // $em->persist($user);
      //  $em->flush();
    }



}