<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\AvatarType;
use App\Service\Slugify;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/users", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader, Slugify $slugify): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $slug = $slugify->generate($user->getPseudo() ?? '');
                $user->setSlug($slug);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{slug}", name="show", methods={"GET"})
     * @ParamConverter ("user", class="App\Entity\User", options={"mapping": {"slug": "slug"}})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{slug}", name="profile", methods={"GET"})
     * @ParamConverter ("user", class="App\Entity\User", options={"mapping": {"slug": "slug"}})
     */
    public function myProfile(User $user): Response
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     * @ParamConverter ("user", class="App\Entity\User", options={"mapping": {"slug": "slug"}})
     */
    public function edit(Request $request, User $user): Response
    {
        /* $user->setAvatar(new File($this->getParameter('image_directory').'/'.$user->getAvatar())); */
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Profile mis à jour avec succès !'
            );

            return $this->redirectToRoute('user_profile', ['slug' => $user->getSlug()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'editUserForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editAvatar", name="edit_avatar", methods={"GET","POST"})
     */
    public function editAvatar(Request $request, User $user, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(AvatarType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatar')->getData();
            if ($avatarFile) {
                $avatarFileName = $fileUploader->upload($avatarFile);
                $user->setAvatar($avatarFileName);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }
            $this->addFlash(
                'success',
                'Profile mis à jour avec succès !'
            );
            return $this->redirectToRoute('user_profile', ['slug' => $user->getSlug()]);
        }
        return $this->render('user/editAvatar.html.twig', [
                'user' => $user,
                'formAvatar' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="delete", methods={"DELETE"})
     * @ParamConverter ("user", class="App\Entity\User", options={"mapping": {"slug": "slug"}})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $fileToDelete = __DIR__ . '/../../public/uploads/' . $user->getAvatar();
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }
        $session = new Session();
        $session->invalidate();

        return $this->redirectToRoute('app_logout');
    }
}
