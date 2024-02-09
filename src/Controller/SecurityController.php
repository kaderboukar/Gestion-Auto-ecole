<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_backend');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

         #[Route(path: '/update_password', name: 'update_password')]
    public function update_password(Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->request->count()>0) {
            # code...
            $password=$request->request->get('password');
            $confirm_password=$request->request->get('confirm_password');
            $user=$this->getUser();

            $pattern = "/([a-z])/i";
            $pattern1 = "/([0-9])/";
            $pattern2 = "/[@\.\-\+\_\*\#\&]/";
             if( $password==$confirm_password) {

                if (strlen($password)>4 and  preg_match($pattern, $password)==1 && preg_match($pattern1, $password)==1 && preg_match($pattern2, $password)==1) {

                    $hashedPassword = $passwordHasher->hashPassword(
                        $user,
                        $password
                    );
                    $user->setPassword($hashedPassword);
                    $user->setFirstConnexion(1);
                    $em->persist($user);
                    $em->flush();

                    return $this->redirectToRoute('app_logout');

                }else{

                    $this->addFlash('alert', "le mot de passe doit contenir au moins 6 characteres dont au moins une lettre, un chiffre et un symbole (&#@.-+_*)");
                    return $this->render('security/update_password.html.twig');

                }

            }else{

                $this->addFlash('alert', "Les mots de passe saisis ne sont pas identiques, merci de re-essayer");
                return $this->render('security/update_password.html.twig');

            }
            return $this->redirectToRoute('app_logout');

        }
        return $this->render('security/update_password.html.twig');
    }
}
