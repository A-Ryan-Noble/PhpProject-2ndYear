<?php
namespace Itb;


class AdminController
{
    private $sessionManager;
    private $twig;

    public function __construct($twig, $sessionManager)
    {
        $this->twig = $twig;

        $this->sessionManager = $sessionManager;

        $this->adminController = new AdminController($twig, $sessionManager);
    }

    public function adminLoggedInAction()
    {
        $isLoggedIn = $this->sessionManager->isLoggedIn();

        $username = $this->sessionManager->usernameFromSession();

        $args =
            [
                'isLoggedIn' => $isLoggedIn,
                'username' => $username,
            ];

        // default - not authorised
        $template = 'errorNotLoggedIn.html.twig';

        // if is logged in - allow access to admin home page
        if($isLoggedIn)
        {
            $template = 'adminLoggedIn.html.twig';
        }

        $html = $this->twig->render($template, $args);
        print $html;
    }


}