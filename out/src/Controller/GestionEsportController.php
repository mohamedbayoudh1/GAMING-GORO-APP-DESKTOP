<?php

namespace App\Controller;
use App\Entity\Coach;
use App\Entity\Gamer;
use App\Form\CoachType;
use App\Form\GamerType;
use App\Form\LoginType;
use App\Security\Users;
use DateTime;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionEsportController extends BaseController
{
    
    #[Route('/acceuil', name: 'acceuil')]
    public function acceuil(Request $request): Response{
        $this->session=$request->getSession();

        if(!$this->check_session()){
            return $this->redirect("/");
        }
        return $this->renderForm('Front_Template/acceuil.html.twig',[
            'controller_name' => 'GestionEsportController',
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout() {
        if($this->session->has('Gamer_id')){
            $em = $this->managerRegistry->getManagerForClass(Gamer::class);
            $em2 = $this->managerRegistry->getRepository(Gamer::class);
            $gamer=new Gamer();
            $gamer = $em2->findOneBy(['id' => $this->session->get('Gamer_id')]);
            $gamer->setStatus(False);
            $em->persist($gamer);
            $em->flush();
            $this->session->invalidate();
            return $this->redirect("/");
        }else if($this->session->has('Coach_id')){
            $em = $this->managerRegistry->getManagerForClass(Coach::class);
            $em2 = $this->managerRegistry->getRepository(Coach::class);
            $gamer=new Coach();
            $gamer = $em2->findOneBy(['id' => $this->session->get('Coach_id')]);
            $gamer->setStatus(False);
            $em->persist($gamer);
            $em->flush();
            $this->session->invalidate();
            return $this->redirect("/");
        }
       
    }
     
    #[Route('/', name: 'home')]
    public function signin_signout(Request $request): Response
    {   $this->session=$request->getSession();
        if($this->check_session()){
            return $this->redirect("/acceuil");
        }
            $em = $this->managerRegistry->getManagerForClass(Gamer::class);
            $user = new Gamer();
            $users=new Users();
            $user->setPoint(100);
            $form = $this->createForm(GamerType::class, $user);
            $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $photoP = $form->get('photoprofile')->getData();
                    if ($photoP) {
                        $originalImgName = pathinfo($photoP->getClientOriginalName(), PATHINFO_FILENAME);
        
                        // this is needed to safely include the file name as part of the URL
                        $safeImgname = $this->slugger->slug($originalImgName);
                        $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoP->guessExtension();
                        // Move the file to the directory where brochures are stored
                        try {
                            $filesystem = new Filesystem();
                            $imgDirectory = $this->getParameter('img_profile_directory') . '/' . $user->getTag();
                            if (!$filesystem->exists($imgDirectory)) {
                                $filesystem->mkdir($imgDirectory);
                            }                            
        
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
        
                        // updates the 'brochureFilename' property to store the PDF file name
                        // instead of its contents
                        $user->setPhotoProfil($newImgename);
                    }

                    $em2 = $this->managerRegistry->getRepository(Gamer::class);
                    
                    $hashedPassword = $this->passwordhash->hashPassword(
                        $users,
                        $user->getPassword()
                    );
                    $user->setStatus(False);
                    $user->setDateCreation(new DateTime());
                    $photoP->move($imgDirectory, $newImgename);
                    $user->setPassword($hashedPassword);
                    $user->setBannir(False);
                    $em->persist($user);
                    $em->flush();
                }
            $formLogin = $this->createForm(LoginType::class);
            $formLogin->handleRequest($request);
                if ($formLogin->isSubmitted() && $formLogin->isValid()) {
                    $em2 = $this->managerRegistry->getRepository(Gamer::class);
                    $data = $formLogin->getData();
                    $gamer=new Gamer();
                    $gamer = $em2->findOneBy(['email' => $data->getEmail()]);
                    if (!$gamer) {
                        $coach=new Coach();
                        $em2 = $this->managerRegistry->getRepository(Coach::class);
                        $coach = $em2->findOneBy(['email' => $data->getEmail()]);
                        if (!$coach) {
                            return $this->redirectToRoute('home', ['SignIn' => 'true']);
                        }
                        else if (!password_verify($data->getPassword(), $coach->getPassword())) {
                            return $this->redirectToRoute('home', ['SignIn' => 'true']);
                        }else if(!$coach->isStatus()){
                            $emcoach = $this->managerRegistry->getManagerForClass(Coach::class);
                            $coach->setStatus(True);
                            $em->persist($coach);
                            $em->flush();
                            $this->session->set('Coach_id', $coach->getId());
                            $this->session->set('Solde', $coach->getPoint());
                            $this->session->set('User_name', $coach->getNom());
                            $this->session->set('Session_time', new DateTime());
                            $this->session->set('Photo', $coach->getNom().$coach->getPrenom().'/'.$coach->getPhotoProfil());
                            return $this->redirect("/acceuil");
                        }
                    }
                    else if (!password_verify($data->getPassword(), $gamer->getPassword())) {
                        return $this->redirectToRoute('home', ['SignIn' => 'true']);
                    }else if(!$gamer->isBannir()){
                        $this->session->set('User_name', $gamer->getTag());
                        $this->session->set('Solde', $gamer->getPoint());
                        $this->session->set('Gamer_id', $gamer->getId());
                        $this->session->set('Session_time', new DateTime());
                        $this->session->set('Photo', $gamer->getTag().'/'.$gamer->getPhotoProfil());
                        $gamer->setStatus(True);
                        $em->persist($gamer);
                        $em->flush();
                        return $this->redirect("/acceuil");
                    }
                }
                return $this->renderForm('Front_Template/welcome.html.twig',[
                    'controller_name' => 'GestionEsportController','formcreateuser' => $form,'formLogin'=>$formLogin
                ]);  
    }


    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response{
        $em = $this->managerRegistry->getManagerForClass(Coach::class);
        $coach=new Coach();
            $users=new Users();
            $coach->setPoint(100);
        $form = $this->createForm(CoachType::class, $coach);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $photoP = $form->get('photoprofile')->getData();
                if ($photoP) {
                    $originalImgName = pathinfo($photoP->getClientOriginalName(), PATHINFO_FILENAME);
    
                    // this is needed to safely include the file name as part of the URL
                    $safeImgname = $this->slugger->slug($originalImgName);
                    $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoP->guessExtension();
                    // Move the file to the directory where brochures are stored
                    try {
                        $filesystem = new Filesystem();
                        $imgDirectory = $this->getParameter('img_profile_directory') . '/' . $coach->getNom().$coach->getPrenom();
                        if (!$filesystem->exists($imgDirectory)) {
                            $filesystem->mkdir($imgDirectory);
                        }
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $coach->setPhotoProfil($newImgename);
                }
                $photoC = $form->get('cv')->getData();
                if ($photoC) {
                    $originalImgName2 = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
    
                    // this is needed to safely include the file name as part of the URL
                    $safeImgname2 = $this->slugger->slug($originalImgName2);
                    $newImgename2 = $safeImgname2 . '-' . uniqid() . '.' . $photoC->guessExtension();
                    // Move the file to the directory where brochures are stored
                    try {
                        $filesystem = new Filesystem();
                        $imgDirectory2 = $this->getParameter('img_profile_directory') . '/' . $coach->getNom().$coach->getPrenom();
                        if (!$filesystem->exists($imgDirectory2)) {
                            $filesystem->mkdir($imgDirectory2);
                        }
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $coach->setCv($newImgename2);
                }
                $hashedPassword = $this->passwordhash->hashPassword(
                    $users,
                    $coach->getPassword()
                );
                $coach->setStatus(-1);
                $coach->setReview(2);
                $coach->setDateCreation(new DateTime());
                $photoP->move($imgDirectory, $newImgename);
                $photoC->move($imgDirectory2, $newImgename2);
                $coach->setPassword($hashedPassword);
                $coach->setBannir(False);
                $em->persist($coach);
                $em->flush();
                return $this->redirect("/acceuil");
            }
        return $this->renderForm('Front_Template/contact.html.twig',[
            'controller_name' => 'GestionEsportController','form'=>$form
        ]);
    }
    
}
