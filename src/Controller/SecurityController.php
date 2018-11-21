<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends FOSRestController
{
    /**
     * @Route("/login", name="login")
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    public function login(): void
    {
        // Response is already handled by App\Security\LoginFormAuthenticator
        throw new \RuntimeException('This code should not be reached.');
    }
}
