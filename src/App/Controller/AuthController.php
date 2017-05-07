<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Respect\Validation\Validator as v;
use Defuse\Crypto\Crypto;

class AuthController extends Controller
{

    const SECRET_KEY = 'CHANGE_THIS_KEY';

    /**
     * Encrypt a plain text
     *
     * @param $plainText
     * @return String
     */
    private function encrypt($plainText)
    {
        return Crypto::encryptWithPassword($plainText, self::SECRET_KEY, 0);
    }

    /**
     * Decrypt a plain text
     *
     * @param $plainText
     * @return String
     */
    private function decrypt($cipherText)
    {
        return Crypto::decryptWithPassword($cipherText, self::SECRET_KEY, 0);
    }

    /**
     * Sign in function
     *
     * @return string
     */
    public function signin(Request $request)
    {
        if ($request->isMethod('GET'))
            return $this->render('authentication.twig');

        $user = $this->getEntityManager()->getRepository('App\Entity\User')->findOneByUsername($_POST['username']);
        if ($user == null) {
            $this->flash('error', 'Ce pseudo n\'existe pas');
            return $this->render('authentication.twig');
        }

        if ($this->decrypt($user->getPassword()) !== $_POST['password']) {
            $this->flash('error', 'Mot de passe incorrect');
            return $this->render('authentication.twig');
        }

        $_SESSION['email'] = $user->getEmail();
        $_SESSION['username'] = $user->getUsername();

        return $this->redirect('home');
    }

    /**
     * Disconnect an user
     *
     */
    public function disconnect()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        return $this->redirect('home');
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
            $this->flash('error', $exception->getMainMessage());
            return $this->render('signup.twig');
        }

        $isEmailUsed = $this->getEntityManager()->getRepository('App\Entity\User')->findByEmail($_POST['email']);
        $isUsernameUsed = $this->getEntityManager()->getRepository('App\Entity\User')->findByUsername($_POST['username']);

        if ($isEmailUsed != null) {
            $this->flash('error', 'Cette adresse email est déjà utilisée');
        } else if ($isUsernameUsed != null) {
            $this->flash('error', 'Ce pseudo est déjà utilisé');
        } else {
            $user = new User($_POST['username'], $_POST['email'], $this->encrypt($_POST['password']));
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            $this->flash('positive', 'Bienvenue sur Cana RP !');
        }

        return $this->redirect('authentication');
    }

}