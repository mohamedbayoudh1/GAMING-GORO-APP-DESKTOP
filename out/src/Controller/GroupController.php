<?php

namespace App\Controller;
use App\Entity\Gamer;
use App\Entity\Groupe;
use App\Entity\MembreGroupe;
use App\Entity\Post;
use App\Entity\ReviewJeux;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Pyrrah\OpenWeatherMapBundle\Services\Client;

use App\Form\GroupeType;
use App\Form\PostType;
use App\Repository\GroupeRepository;
use App\Repository\MembreGroupeRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use  Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class GroupController extends BaseController
{

    /*************************** affiche les groupe qui son rejoindu par utilisateur    *****************************************/

    #[Route('/groupe/mygroupe', name: 'mesgroupe')]
    public function mesGroupes(ManagerRegistry $doctrine, Request $request): Response
    {
        $gamer = $doctrine->getRepository(Gamer::class)->find($request->getSession()->get('Gamer_id'));
        $groupes = $doctrine->getRepository(Groupe::class)->findMesGroupes($gamer);

        return $this->renderForm("group/mes_groupe.html.twig", [
            'groupes' => $groupes
        ]);
    }


    /*************************** rejoindre groupe  *****************************************/


    #[Route('/groupe/{id}/rejoindre', name: 'rejoindre')]
    public function rejoindre(ManagerRegistry $doctrine,Request $request, int $id): Response
    {
        $gamer= $this->managerRegistry->getRepository(Gamer::class)->findOneBy((['id' => $request->getSession()->get('Gamer_id')]));
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);
        $existingMember = $doctrine->getRepository(MembreGroupe::class)->findOneBy(['idGamer' => $gamer, 'idGroupe' => $groupe]);
        if (!$existingMember) {

            $groupemember = new MembreGroupe();
            $groupemember->setIdGamer($gamer);
            $groupemember->setIdGroupe($groupe);
            $groupemember->setDate(new \DateTime()); // Set the current datetime


            $em = $doctrine->getManager();
            $em->persist($groupemember);
            $em->flush();
        };

        return $this->redirectToRoute('onegroupe', ['id' => $id]);
    }





















    /*************************** ajoutter groupe  *****************************************/

#[Route('/group', name: 'app_group')]
    public function  add(ManagerRegistry $doctrine, Request  $request, SluggerInterface $slugger) : Response
    { $groupe = new Groupe() ;
        $fifi = $this->createForm(GroupeType::class, $groupe);
        $fifi->handleRequest($request);
        if ($fifi->isSubmitted() )
        {
            $groupe->setEtat(0);
            $photoC = $fifi->get('img')->getData();
            if ($photoC ) {
                $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeImgname = $slugger->slug($originalImgName);

                $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $photoC->move(
                        $this->getParameter('imgg_directory'),
                        $newImgename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $groupe->setImage($newImgename);
            }


            $groupe->setIdOwner($this->session->get('Gamer_id'));
            $groupe->setNbrUser($groupe->getNbrUser()+1);
            $em = $doctrine->getManager();
            $em->persist($groupe);
            $em->flush();
            return $this->redirectToRoute('our_groupe');
        }
        return $this->renderForm("group/addg.html.twig",
            ["form"=>$fifi]) ;


    }


    /*************************** affiche groupe  *****************************************/

    #[Route('/ourgroupe', name: 'our_groupe')]
    public function affiche(): Response
    {
        $groupe =$this->getDoctrine()->getRepository(Groupe::class)->findAll();


        return $this->render('group/allgroupe.html.twig', [
            'groupe' => $groupe
        ]);
    }

    /*************************** affiche admin    *****************************************/
    #[Route('/admin/groupe', name: 'allgroupe')]
    public function afficheback(): Response
    {
        $groupe =$this->getDoctrine()->getRepository(Groupe::class)->findAll();
        return $this->render('group/admingroupe.html.twig', [
            'groupe' => $groupe
        ]);
    }



/*
    #[Route('/post/{id}', name: 'post')]
    public function post(int $id, GroupeRepository $grouperep, \Doctrine\Persistence\ManagerRegistry $doctrine) : Response
    {
        $post = $doctrine->getRepository(Groupe::class)->find($id);
        return $this->render('group/post.html.twig', [
            'post' => $post,
        ]);
    }
    */

/***************************affciche et ajout post  *****************************************/
    #[Route('/groupe/{id}', name: 'onegroupe')]
    public function oneCourse(int $id, GroupeRepository $postgroupe, Request $request, EntityManagerInterface $em,SluggerInterface $slugger)
    {
        $groupe = $postgroupe->find($id);
        $post = new Post();
        $post->setIdGroupe($groupe); // définir l'objet Groupe sur l'objet Post
        $form = $this->createForm(PostType::class, $post);
        $form->add('ajouter', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $photoC = $form->get('imgp')->getData();
            if ($photoC) {
                $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeImgname = $slugger->slug($originalImgName);

                $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $photoC->move(
                        $this->getParameter('imgp_directory'),
                        $newImgename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImage($newImgename);
            }




            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('onegroupe', ['id' => $id]);
        }

        return $this->render('group/post.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }


    /***************************remove post   *****************************************/
    #[Route("/delete/{id}", name:'delete_post')]
    public function delete($id, ManagerRegistry $doctrine, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        $groupId = $post->getIdGroupe()->getId();

        $c = $doctrine
        ->getRepository(Post::class)
        ->find($id);
        $em = $doctrine->getManager();
        $em->remove($c);
        $em->flush() ;
        return $this->redirectToRoute('onegroupe', ['id' => $groupId]);
    }

    /*************************** edit post   *****************************************/

    #[Route('/post/edit/{id}', name: 'edit_post')]
    public function editPost(Post $post, Request $request, EntityManagerInterface $em, SluggerInterface $slugger,ManagerRegistry $doctrine)
    {

        $form = $this->createForm(PostType::class, $post);
        $form->add('modifier', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $photoC= $form->get('imgp')->getData();
            if ($photoC) {
                $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImgname = $slugger->slug($originalImgName);
                $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();

                try {
                    $photoC->move(
                        $this->getParameter('imgp_directory'),
                        $newImgename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                // delete the old image
                $oldImgename = $post->getImage();
                if ($oldImgename) {
                    $oldImgPath = $this->getParameter('imgp_directory') . '/' . $oldImgename;
                    if (file_exists($oldImgPath)) {
                        unlink($oldImgPath);
                    }
                }

                $post->setImage($newImgename);
            }

            $em->flush();

            return $this->redirectToRoute('onegroupe', ['id' => $post->getIdGroupe()->getId()]);
        }

        return $this->render('group/updatepost.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /*************************** edit groupe   *****************************************/

    #[Route("/update/{id}", name:'updategroupe')]
    public function edit(Request $request, Groupe $groupe, SluggerInterface $slugger)
    {
        $form = $this->createForm(GroupeType::class, $groupe);

        $form->handleRequest($request);
        $currentImg = $groupe->getImage(); // Get current image value
        $form->get('img')->setData($currentImg);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoC= $form->get('img')->getData();
            if ($photoC) {
                $originalImgName = pathinfo($photoC->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImgname = $slugger->slug($originalImgName);
                $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoC->guessExtension();

                try {
                    $photoC->move(
                        $this->getParameter('imgg_directory'),
                        $newImgename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                // delete the old image
                $oldImgename = $groupe->getImage();
                if ($oldImgename) {
                    $oldImgPath = $this->getParameter('img_directory') . '/' . $oldImgename;
                    if (file_exists($oldImgPath)) {
                        unlink($oldImgPath);
                    }
                }

                $groupe->setImage($newImgename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('our_groupe');
        }

        return $this->renderForm('group/update.html.twig', [
            'form' => $form
        ]);
    }



    /***************************remove groupe   *****************************************/
    #[Route("/supp/{id}", name:'deletegroupe')]
    public function supp($id, ManagerRegistry $doctrine, PostRepository $postRepository, MembreGroupeRepository $membreGroupeRepository)
    {
        $em = $doctrine->getManager();

        // Récupérer le groupe correspondant à l'id
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);

        // Récupérer tous les posts associés
        $posts = $groupe->getPosts();

        // Supprimer chaque post
        foreach ($posts as $post) {
            $em->remove($post);
        }

        // Supprimer toutes les entrées liées à ce groupe dans la table membre_groupe
        $membres = $membreGroupeRepository->findBy(['idGroupe' => $id]);
        foreach ($membres as $membre) {
            $em->remove($membre);
        }

        // Supprimer le groupe lui-même
        $em->remove($groupe);

        $em->flush();

        return $this->redirectToRoute('our_groupe');
    }


    /***************************remove groupe  by admin  *****************************************/


    #[Route("/admin/groupe/{id}", name:'deletegroupeadmin')]
    public function delt($id, ManagerRegistry $doctrine, PostRepository $postRepository, MembreGroupeRepository $membreGroupeRepository)
    {
        $em = $doctrine->getManager();

        // Récupérer le groupe correspondant à l'id
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);

        // Récupérer tous les posts associés
        $posts = $groupe->getPosts();

        // Supprimer chaque post
        foreach ($posts as $post) {
            $em->remove($post);
        }

        // Supprimer toutes les entrées liées à ce groupe dans la table membre_groupe
        $membres = $membreGroupeRepository->findBy(['idGroupe' => $id]);
        foreach ($membres as $membre) {
            $em->remove($membre);
        }

        // Supprimer le groupe lui-même
        $em->remove($groupe);

        $em->flush();

        return $this->redirectToRoute('allgroupe',['deletegroupe'=>false]);
    }

    /*************************** activer groupe par admin    *****************************************/

    #[Route('/groupe/true/{id}', name: 'activegroupe')]
    public function acceptgroupe(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request, int $id): Response
    {
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);
        if($groupe)
        {
            $groupe->setEtat(1);
            $em =$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('allgroupe',['groupe'=>true]);
        }else
            return $this->redirectToRoute('allgroupe',['groupe'=>false]);
    }
    /*************************** deactiver groupe    *****************************************/

    #[Route('/groupe/false/{id}', name: 'deactivegroupe')]
    public function refusertgroupe(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request, int $id): Response
    {
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);
        if($groupe)
        {
            $groupe->setEtat(-1);

            $em =$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('allgroupe',['groupe'=>true]);
        }else
            return $this->redirectToRoute('allgroupe',['groupe'=>false]);
    }

    /*************************** en attent groupe    *****************************************/

    #[Route('/groupe/attent/{id}', name: 'enttente')]
    public function enattent(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request, int $id): Response
    {
        $groupe = $doctrine->getRepository(Groupe::class)->find($id);
        if($groupe)
        {
            $groupe->setEtat(0);

            $em =$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('allgroupe',['groupe'=>true]);
        }else
            return $this->redirectToRoute('allgroupe',['groupe'=>false]);
    }


















}
