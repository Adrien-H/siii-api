<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 * @package App\Controller\Rest
 */
class UserController extends FOSRestController
{
    /**
     * @todo Fetch collection
     *
     * @Rest\Get("/users/{id}", name="api.users.fetch", defaults={"id"=null}, requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"default", "users"})
     *
     * @param  EntityManagerInterface  $em
     * @param  int|null                $id
     *
     * @return View
     */
    public function fetch(EntityManagerInterface $em, ?int $id = null): View
    {
        return View::create(
            $em->getRepository(User::class)->find($id),
            Response::HTTP_OK
        );
    }

    /**
     * @Rest\Get("/users/me", name="api.users.me")
     * @Rest\View(serializerGroups={"default", "users"})
     *
     * @return View
     */
    public function me(): View
    {
        return View::create($this->getUser(), Response::HTTP_OK);
    }
}
