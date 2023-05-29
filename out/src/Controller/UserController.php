<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Entity\Gamer;
use App\Entity\RechargeCode;
use App\Entity\User;
use App\Form\CoachType;
use App\Form\GamerType;
use App\Form\RechargeType;
use App\Security\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Length;

class UserController extends BaseController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $email = (new Email())
        ->from('testmailsenderspringboot@gmail.com')
        ->to('nejdbedoui@gmail.com')
        ->subject('Test email')
        ->text('This is a test email')
        ->html('<p>This is a <strong>test email</strong></p>');

    $this->mailer->send($email);
    
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/profile', name: 'profile')]
    public function profile(Request $request): Response
    {   
        $this->session=$this->request->getSession();
        $code=new RechargeCode();
        $form = $this->createForm(RechargeType::class, $code);
        $form->handleRequest($request);
        if($this->session->has('Gamer_id')){
            $em2 = $this->managerRegistry->getRepository(Gamer::class);
            $user=$em2->findOneBy(['id' => $this->session->get('Gamer_id')]);
            
            if ($form->isSubmitted() && $form->isValid()) {
                // process the form data
                $result=$this->recharge($code->getCode(),$user->getId());
                if($result){
                    return $this->redirect("/profile");
                }

                 return $this->renderForm('user/profile.html.twig', [
            'controller_name' => 'UserController','user'=>$user,"charge"=>$form,"historique"=>$user->getHistoriquePoints()
        ]);
            }
            
        }
        else if($this->session->has('Coach_id')){
            $em2 = $this->managerRegistry->getRepository(Coach::class);
            $user=$em2->findOneBy(['id' => $this->session->get('Coach_id')]);
            if ($form->isSubmitted() && $form->isValid()) {
                // process the form data
                $result=$this->recharge($code->getCode(),$user->getId());
                if($result){
                    return $this->redirect("/profile");
                }

                 return $this->renderForm('user/profile.html.twig', [
            'controller_name' => 'UserController','user'=>$user,"charge"=>$form,"historique"=>$user->getHistoriquePoints()
        ]);
            }
        }
            return $this->renderForm('user/profile.html.twig', [
            'controller_name' => 'UserController','user'=>$user,"charge"=>$form,"historique"=>$user->getHistoriquePoints()
        ]);
    }



    #[Route('/modifierprofile', name: 'modifierprofile')]
    public function modifierprofile(Request $request): Response
    {   
        $this->session=$this->request->getSession();
        
        if($this->session->has('Gamer_id')){
           
            $em2 = $this->managerRegistry->getRepository(Gamer::class);
            $user=$em2->findOneBy(['id' => $this->session->get('Gamer_id')]);
            $oldDirectory = $this->getParameter('img_profile_directory') . '/' . $user->getTag();
            $form = $this->createForm(GamerType::class, $user);
            $pass=$user->getPassword();
            $form->add('photocouverture',FileType::class, [
                'mapped' => false, //maneha maandi attribut esmo photo fl entity mte3na
                'required' => false,
                'label' => false,
            ]);
            $form->get('photoprofile')->setData(null);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() ) {
                if(!password_verify($form->get('password')->getData(), $pass)){
                    return $this->redirect("/modifierprofile");
                }
                $photoP = $form->get('photoprofile')->getData();
                $photoC = $form->get('photocouverture')->getData();
                $newDirectory =$this->getParameter('img_profile_directory') . '/'  . $form->get('tag')->getData();
                if (file_exists($oldDirectory)) {
                    rename($oldDirectory, $newDirectory);
                }
                    if ($photoP ) {
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
                        $oldimg=$this->getParameter('img_profile_directory') . '/' . $user->getTag() . '/' . $user->getPhotoProfil();
                        $file = new File($oldimg);
                        // Check if the file exists and delete it if it does
                        if ($file) {
                            $filesystem->remove($file);
                        }
                        $user->setPhotoProfil($newImgename);
                        $photoP->move($imgDirectory, $newImgename);
                         }
                    if ($photoC ) {
                        $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
        
                        // this is needed to safely include the file name as part of the URL
                        $safeImgname = $this->slugger->slug($originalImgName);
                        $newImgename2 = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();
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
                       
                        // Check if the file exists and delete it if it does
                        if ( $user->getPhotoCouverture()) {
                            $oldimg=$this->getParameter('img_profile_directory') . '/' . $user->getTag() . '/' . $user->getPhotoCouverture();
                            $file = new File($oldimg);
                            if($file){
                                $filesystem->remove($file);
                            }
                           
                        }
                        $user->setPhotoCouverture($newImgename2);
                        $photoC->move($imgDirectory, $newImgename2);
                    }
                    
                    $em = $this->managerRegistry->getManagerForClass(Gamer::class);
                    $users=new Users();
                    $hashedPassword = $this->passwordhash->hashPassword(
                        $users,
                        $user->getPassword()
                    );
                    $user->setPassword($hashedPassword);
                    $em->persist($user);
                    $em->flush();
                    $this->session->set('Photo', $user->getTag().'/'.$user->getPhotoProfil());
                    $this->session->set('User_name', $user->getTag());
                    return $this->redirect("/profile");
            }
        }
        else if($this->session->has('Coach_id')){
            $em2 = $this->managerRegistry->getRepository(Coach::class);
            $user=$em2->findOneBy(['id' => $this->session->get('Coach_id')]);
            $oldDirectory = $this->getParameter('img_profile_directory') . '/' . $user->getNom().$user->getPrenom();
            $form = $this->createForm(CoachType::class, $user);
            $pass=$user->getPassword();
            $form->add('photocouverture',FileType::class, [
                'mapped' => false, //maneha maandi attribut esmo photo fl entity mte3na
                'required' => false,
                'label' => false,
            ]);
            $form->get('photoprofile')->setData(null);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() ) {
                if(!password_verify($form->get('password')->getData(), $pass)){
                    return $this->redirect("/modifierprofile");
                }
                $photoP = $form->get('photoprofile')->getData();
                $photoC = $form->get('photocouverture')->getData();
                $newDirectory =$this->getParameter('img_profile_directory') . '/'  . $form->get('nom')->getData().$form->get('prenom')->getData();
                if (file_exists($oldDirectory)) {
                    rename($oldDirectory, $newDirectory);
                }
                    if ($photoP ) {
                        $originalImgName = pathinfo($photoP->getClientOriginalName(), PATHINFO_FILENAME);
        
                        // this is needed to safely include the file name as part of the URL
                        $safeImgname = $this->slugger->slug($originalImgName);
                        $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoP->guessExtension();
                        // Move the file to the directory where brochures are stored
                        try {
                            $filesystem = new Filesystem();
                            $imgDirectory = $this->getParameter('img_profile_directory') . '/' . $user->getNom().$user->getPrenom();

                            if (!$filesystem->exists($imgDirectory)) {
                                $filesystem->mkdir($imgDirectory);
                            }
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
        
                        // updates the 'brochureFilename' property to store the PDF file name
                        // instead of its contents
                        $oldimg=$this->getParameter('img_profile_directory') . '/' . $user->getNom().$user->getPrenom() . '/' . $user->getPhotoProfil();
                        $file = new File($oldimg);
                        // Check if the file exists and delete it if it does
                        if ($file) {
                            $filesystem->remove($file);
                        }
                        $user->setPhotoProfil($newImgename);
                        $photoP->move($imgDirectory, $newImgename);
                         }
                    if ($photoC ) {
                        $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
        
                        // this is needed to safely include the file name as part of the URL
                        $safeImgname = $this->slugger->slug($originalImgName);
                        $newImgename2 = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();
                        // Move the file to the directory where brochures are stored
                        try {
                            $filesystem = new Filesystem();
                            $imgDirectory = $this->getParameter('img_profile_directory') . '/' . $user->getNom().$user->getPrenom();

                            if (!$filesystem->exists($imgDirectory)) {
                                $filesystem->mkdir($imgDirectory);
                            }
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
        
                        // updates the 'brochureFilename' property to store the PDF file name
                        // instead of its contents
                       
                        // Check if the file exists and delete it if it does
                        if ( $user->getPhotoCouverture()) {
                            $oldimg=$this->getParameter('img_profile_directory') . '/' . $user->getNom().$user->getPrenom() . '/' . $user->getPhotoCouverture();
                            $file = new File($oldimg);
                            if($file){
                                $filesystem->remove($file);
                            }
                           
                        }
                        $user->setPhotoCouverture($newImgename2);
                        $photoC->move($imgDirectory, $newImgename2);
                    }
                    
                    $em = $this->managerRegistry->getManagerForClass(Coach::class);
                    $users=new Users();
                    $hashedPassword = $this->passwordhash->hashPassword(
                        $users,
                        $user->getPassword()
                    );
                    $user->setPassword($hashedPassword);
                    $em->persist($user);
                    $em->flush();
                    $this->session->set('Photo', $user->getNom().$user->getPrenom().'/'.$user->getPhotoProfil());
                    $this->session->set('User_name', $user->getNom());
                    return $this->redirect("/profile");
            }
        }
            return $this->renderForm('user/modifierprofile.html.twig', [
            'controller_name' => 'UserController','user'=>$user,'formmodifier'=>$form
        ]);
    }

    #[Route('/motdepasse/{email}', name: 'motdepasse')]
    public function modifiermotdepasse(Request $request,string $email): Response
    {

        $form = $this->createFormBuilder()->add('password',PasswordType::class, [
            'label' => false,
            'constraints'=>[
                new Length([
                    'min'=>8,
                    'minMessage'=>'min 8 caracteres',
                ])
            ],
            'attr' => [
                'placeholder' => 'Mot De Passe Actuel',
            ],
        ])->add('nouveaupassword',PasswordType::class, [
            'label' => false,
            'constraints'=>[
                new Length([
                    'min'=>8,
                    'minMessage'=>'min 8 caracteres',
                ])
            ],
            'attr' => [
                'placeholder' => 'Nouveau Mot De Passe',
            ],
        ])->add('confirmerpassword',PasswordType::class, [
            'label' => false,
            'constraints'=>[
                new Length([
                    'min'=>8,
                    'minMessage'=>'min 8 caracteres',
                ])
            ],
            'attr' => [
                'placeholder' => 'Confirmer Mot De Passe',
            ],
        ])->add('Enregistrer',SubmitType::class)->getForm();;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $users=new Users();
            $em2 = $this->managerRegistry->getRepository(Gamer::class);
            $gamer=new Gamer();
            $gamer = $em2->findOneBy(['email' => $email]);
            if($gamer ){
                if(password_verify( $form->get('password')->getData(), $gamer->getPassword())){
                    if($form->get('nouveaupassword')->getData() == $form->get('confirmerpassword')->getData()){
                        $hashedPassword = $this->passwordhash->hashPassword(
                            $users,
                            $form->get('confirmerpassword')->getData()
                        );
                        $gamer->setPassword($hashedPassword);
                        $em = $this->managerRegistry->getManagerForClass(Gamer::class);
                        $em->persist($gamer);
                        $em->flush();
                        return $this->redirect("/profile");
                    }
                }
                
            }
        }
        return $this->renderForm('user/modifiermotdepasse.html.twig', [
            'controller_name' => 'UserController','mdp'=>$form
        ]);
    }





//     public function forgotPassword(Request $request, MailerInterface $mailer)
// {
//     // Process the form submission and get the email address
//     $email = $request->request->get('email');

//     // Look up the user by email address and generate a password reset token
//     // ...

//     // Create an email message with a link to the reset password page
//     $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
//     $email = (new Email())
//         ->from('noreply@example.com')
//         ->to($email)
//         ->subject('Password reset request')
//         ->html("<p>Click the following link to reset your password:</p><p><a href=\"$url\">$url</a></p>");

//     // Send the email
//     $mailer->send($email);

//     // Redirect the user to a confirmation page
//     // ...
// }




}
