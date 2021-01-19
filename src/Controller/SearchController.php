<?php

namespace App\Controller;

use App\Entity\TennisMatch;
use App\Form\SearchUserType;
use App\Form\SearchMatchType;
use App\Service\SearchService;
use App\Repository\UserRepository;
use App\Repository\TennisMatchRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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

    /**
     * @Route("/matchs", name="matchs")
     */
    public function searchMatch(Request $request, TennisMatchRepository $tennisMatch): Response
    {
        $matchs = new TennisMatch();
        $searchMatchForm = $this->createForm(SearchMatchType::class, $matchs);
        $searchMatchForm->handleRequest($request);
        //dd($matchs);
        if ($searchMatchForm->isSubmitted() && $searchMatchForm->isValid()) {
            $startHour = $matchs->getStartHour();
            $endHour = $matchs->getEndHour();
            $adress = $matchs->getAdress();
            $matchs = $tennisMatch->searchMatch($startHour, $endHour, $adress);
        } else {
            $matchs = $tennisMatch->findAll();
        }
        return $this->render('tennis_match/search.html.twig', [
            'searchMatchForm' => $searchMatchForm->createView(),
            'matchs' => $matchs,
        ]);
    }
}
