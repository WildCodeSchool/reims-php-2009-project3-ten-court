<?php

namespace App\Controller;

use App\Data\SearchService;
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
        $search = new SearchService();
        $searchUserForm = $this->createForm(SearchUserType::class, $search);
        $searchUserForm->handleRequest($request);

        if ($searchUserForm->isSubmitted() && $searchUserForm->isValid()) {
            $users = $userRepository->search($search);
        } else {
            $users = $userRepository->findAll();
        }
        return $this->render('search/index.html.twig', [
            'searchForm' => $searchUserForm->createView(),
            'users' => $users,
        ]);
    }
}
