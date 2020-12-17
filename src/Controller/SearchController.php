<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
* @Route("/search", name="search_")
*/
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="users")
     */
    public function search(Request $request, UserRepository $userRepository): Response
    {
        $users = new User();
        $searchUserForm = $this->createForm(SearchUserType::class, $users);
        $searchUserForm->handleRequest($request);

        if ($searchUserForm->isSubmitted() && $searchUserForm->isValid()) {
            $level = $users->getLevel();
            $sex = $users->getSex();
            $users = $userRepository->search($level, $sex);
        } else {
            $users = $userRepository->findAll();
        }
        return $this->render('search/index.html.twig', [
            'searchForm' => $searchUserForm->createView(),
            'users' => $users,
        ]);
    }
}
