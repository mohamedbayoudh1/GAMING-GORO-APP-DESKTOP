<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Gamer;
use App\Entity\HistoriqueAchat;
use App\Entity\Produit;
use App\Form\CategorieType;
use App\Form\ProduitType;

use App\Repository\ProduitRepository;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends BaseController
{
    #[Route('/product', name: 'app_product')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $produit =$doctrine->getRepository(Produit::class)->findAll();
        $categorie= $doctrine->getRepository(Categorie::class)->findAll();
        $dinarAmount = $request->request->get('dinarAmount');
        $pointAmount = $dinarAmount * 230;
        //dd($produit);
        return $this->render('product/store.html.twig', [
            'produit' => $produit,
            'c'=>$categorie,
            'dinarAmount' => $dinarAmount,
            'pointAmount' => $pointAmount
        ]);
    }

    #[Route('/consultecategg/{id}', name: 'affichecategg')]
    public function consultcateg(ManagerRegistry $doctrine,Request $request,int $id): Response
    {

        $categorie= $doctrine->getRepository(Categorie::class)->find($id);
        $produit=$categorie->getProduits();
        return $this->renderForm('product/ConsultCategorie.html.twig',
            [
                'produit'=>$produit,
                'c'=>$categorie
            ]);
    }
    #[Route('/consulteproduct/{id}', name: 'afficheproduit')]
    public function oneProduct(int $id, ProduitRepository $produitRepository, ManagerRegistry $doctrine)
    {
        $produit = $produitRepository->find($id);
        $etat=false;
        // Récupérer le produit à ajouter au panier à partir de l'ID
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $gamerId = $this->session->get('Gamer_id');
        $gamer = $this->getDoctrine()->getRepository(Gamer::class)->find($gamerId);

        $entityManager = $doctrine->getManager();

        // Vérifier si le produit est déjà dans le panier du gamer
        $historiqueAchat = $this->getDoctrine()->getRepository(HistoriqueAchat::class)
            ->findOneBy(['id_gamer' => $gamer, 'idproduit' => $produit,'etatachat'=>false]);

        if ($historiqueAchat) {
           $etat=true;
        }


            return $this->render('product/produit.html.twig', [
            'p'=>$produit,
             'etat'=>$etat

        ]);

    }
    /*---------------panier------------------*/

    /**
     * @Route("/ajouterAuPanier/{id}", name="ajoutpanier")
     */
    public function ajouterAuPanier(Request $request, $id, ManagerRegistry $doctrine)
    {
        // Récupérer le produit à ajouter au panier à partir de l'ID
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $gamerId = $this->session->get('Gamer_id');
        $gamer = $this->getDoctrine()->getRepository(Gamer::class)->find($gamerId);

        $entityManager = $doctrine->getManager();

        // Vérifier si le produit est déjà dans le panier du gamer
        $historiqueAchat = $this->getDoctrine()->getRepository(HistoriqueAchat::class)
            ->findOneBy(['id_gamer' => $gamer, 'idproduit' => $produit,'etatachat'=>false]);

        if ($historiqueAchat) {
            // Si le produit est déjà dans le panier, retourner une réponse d'erreur
            return new Response('Ce produit est déjà dans votre panier.');
        } else {
            // Ajouter le produit au panier
            $pannier = new HistoriqueAchat();
            $pannier->setIdGamer($gamer);
            $pannier->setIdproduit($produit);
            $pannier->setEtatachat(false);
            $entityManager->persist($pannier);
            $entityManager->flush();

            return $this->redirect("/consulteproduct/".$id);
        }
    }


    /**
     * @Route("/pannier", name="pannier")
     */
    public function Panier(Request $request,ManagerRegistry $doctrine) {
        // Récupérer le produit à ajouter au panier à partir de l'ID
        $historique=$this->getDoctrine()->getRepository(HistoriqueAchat::class)->findBy(['id_gamer'=>$this->session->get('Gamer_id'),'etatachat'=>false]);
        $prixtotal = 0;
        $etat =true;
        $pointuser=0;
        foreach ($historique as $item) {
            $prixtotal += $item->getIdProduit()->getPrix();
            $pointuser=$item->getIdGamer()->getPoint();
        }
        if ($pointuser<$prixtotal){
            $etat=false;
        }
        return $this->render('product/panier.html.twig', [
            'produits' => $historique,
            'prixtotal'=>$prixtotal,
            'conversion'=>round($prixtotal/230),
            'etat'=>$etat
        ]);
    }
 /* *****************************  supprimer prod panier   **************************** */
    #[Route('/supprimerDuPanier/{id}', name: 'supprimer_du_panier')]
    public function supprimerDuPanier(ManagerRegistry $doctrine,Request $request, int $id)
    {
        $em =$doctrine->getManager();
        $gamer= $this->managerRegistry->getRepository(Gamer::class)->findOneBy((['id' => $request->getSession()->get('Gamer_id')]));
        $produit = $doctrine->getRepository(Produit::class)->find($id);
        $panier =$em->getRepository(HistoriqueAchat::class)->findOneBy(['id_gamer' => $gamer, 'idproduit' => $produit]);

        if (!$produit) {
            throw $this->createNotFoundException('Product not found');
        }else
        {
            if($panier->isEtatachat()==false){
                $em->remove($panier);
                $em->flush();
                return $this->redirectToRoute('pannier');
            }else
            {
                return $this->redirectToRoute('pannier');
            }
        }
    }
    /* *****************************  supprimer prod panier prod   **************************** */
    #[Route('/supprimerDuPanierB/{id}', name: 'supprimer_du_panierB')]
    public function supprimerDuPanierB(ManagerRegistry $doctrine,Request $request, int $id)
    {
        $em =$doctrine->getManager();
        $gamer= $this->managerRegistry->getRepository(Gamer::class)->findOneBy((['id' => $request->getSession()->get('Gamer_id')]));
        $produit = $doctrine->getRepository(Produit::class)->find($id);
        $panier =$em->getRepository(HistoriqueAchat::class)->findOneBy(['id_gamer' => $gamer, 'idproduit' => $produit]);

        if (!$produit) {
            throw $this->createNotFoundException('Product not found');
        }else
        {
            if($panier->isEtatachat()==false){
                $em->remove($panier);
                $em->flush();
                return $this->redirect("/consulteproduct/".$id);
            }else
            {
                return $this->redirect("/consulteproduct/".$id);
            }
        }
    }
    //list product
    #[Route('/productad', name: 'ad_product')]
    public function adlistep(ManagerRegistry $doctrine): Response
    {
        $produit =$doctrine->getRepository(Produit::class)->findAll();

        //dd($produit);
        return $this->render('product/adListeProduit.html.twig', [
            'adproduit' => $produit

        ]);
    }
    #[Route('/addc', name: 'ajoutCategorie')]
    public function add(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request): Response
    {
        $categorie =new Categorie();

        $form =$this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em =$doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('ad_categorie');
        }


        return $this->renderForm('product/categorie.html.twig', [
            'form'=>$form
        ]);
    }
    //ajout product ad
    #[Route('/addp/{idCategorie}', name: 'ajoutproduit')]
    public function addp(\Doctrine\Persistence\ManagerRegistry $doctrine,Request $request,SluggerInterface $slugger, $idCategorie): Response
    {

        $produit =new Produit();

        $form =$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            /* img*/
            $photoP = $form->get('imagep')->getData();
            if ($photoP) {
                $originalImgName = pathinfo($photoP->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeImgname = $slugger->slug($originalImgName);

                $newImgename = $safeImgname . '-' . uniqid() . '.' . $photoP->guessExtension();


                // Move the file to the directory where brochures are stored
                try {
                    $photoP->move(
                        $this->getParameter('imgpr_directory'),
                        $newImgename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $produit->setImage($newImgename);
            }
            // Récupérer l'entité Catégorie correspondante à l'ID de catégorie fourni

            /*endimg*/
            // Définir la catégorie pour le produit

            $em =$doctrine->getManager();



            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('ad_categorie');
        }
        return $this->renderForm('product/addproduct.html.twig', [
            'form'=>$form,'id'=>$idCategorie
        ]);

    }
    #[Route('/deletep/{id}', name: 'supprimerproduit')]
    public function deletep($id, \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Aucun produit trouvé pour l\'id '.$id);
        }

        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->redirectToRoute('ad_product');
    }
    #[Route('/modifier/{id}', name: 'modifierProduit')]
    public function update(Request $request, EntityManagerInterface $em, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('ad_product', ['id' => $produit->getId()]);
        }

        return $this->renderForm('product/admodifierproduit.html.twig', [
            'form' => $form,
            'produit' => $produit,
        ]);
    }
    /*nnnnnnnnnnnnnnnnnnnnn**** categorie *******nnnnnnnnnnnnnnnnnnnnnnnnnn*/
    //list categorie
    #[Route('/categoriead', name: 'ad_categorie')]
    public function adlistec(ManagerRegistry $doctrine): Response
    {
        $categorie =$doctrine->getRepository(Categorie::class)->findAll();

        //dd($produit);
        return $this->render('product/adListeCategorie.html.twig', [
            'adcategorie' => $categorie


        ]);
    }
    /*supp categ*/
    #[Route("/deletec/{id}", name:'supprimercategorie')]
    public function deletec($id, ManagerRegistry $doctrine, ProduitRepository $postRepository)
    {
        $em = $doctrine->getManager();

        // Récupérer le groupe correspondant à l'id
        $categorie= $doctrine->getRepository(Categorie:: class)->find($id);

        // Récupérer tous les produit associés
        $produits = $categorie->getProduits();

        // Supprimer chaque produit
        foreach ($produits as $produit) {
            $em->remove($produit);
        }


        // Supprimer la categorie lui-même
        $em->remove($categorie);

        $em->flush();

        return $this->redirectToRoute('ad_categorie');
    }
    /*updateeeeeeeeeeeeeee categ*/
    #[Route('/modifierc/{id}', name: 'modifierCategorie')]
    public function updatec(Request $request, EntityManagerInterface $em, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('ad_categorie', ['id' => $categorie->getId()]);
        }

        return $this->renderForm('product/admodifiercategorie.html.twig', [
            'form' => $form,
            'categorie' => $categorie,
        ]);
    }

/********************************************************/
    #[Route('/acheterproduit', name: 'acheterproduit')]
    public function acheterproduit(ManagerRegistry $doctrine,Request $request)
    {

        $em =$doctrine->getManager();
        $gamer= $this->managerRegistry->getRepository(Gamer::class)->findOneBy((['id' => $request->getSession()->get('Gamer_id')]));

        $panier =$em->getRepository(HistoriqueAchat::class)->findBy(['id_gamer' => $gamer,'etatachat'=>false]);

        if (!$panier) {
            throw $this->createNotFoundException('Product not found');
        }else
        {
            $prixtotal = 0;

            $pointuser=0;
            foreach ($panier as $item) {
                $prixtotal += $item->getIdProduit()->getPrix();
                $pointuser=$item->getIdGamer()->getPoint();
                $item->setEtatachat(true);
                $item->setDateDachat(new \DateTime());
                $prefix = uniqid(); // unique timestamp-based prefix
                $randomBytes = random_bytes(5);
                $randomString = bin2hex($randomBytes);
                $uniqueString = $prefix . $randomString;
                $item->setReference($uniqueString);
                $em->persist($item);


            }
            if ($pointuser>=$prixtotal){
                $gamer->setPoint($gamer->getPoint()-$prixtotal);

                $request->getSession()->set('Solde',$gamer->getPoint());
                $em->persist($gamer);
                $em->flush();




            }

                return $this->redirectToRoute('pannier');

        }
    }










}