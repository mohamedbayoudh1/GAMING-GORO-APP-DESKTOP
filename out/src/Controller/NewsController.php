<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\News;
use App\Form\NewsType;
use App\Form\NewsType2;
use App\Repository\NewsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class NewsController extends BaseController
{


    /*
     * fonction d'affichage pour les actualités
     */
    #[Route( '/news' , name : 'afficher_les_news' )]
    public function afficher_les_news ( PaginatorInterface $paginator , Request $request , ) : Response
    {

        $newsRepository = $this -> managerRegistry -> getRepository ( News::class );
        $queryBuilder   = $newsRepository -> createQueryBuilder ( 'n' )
            -> orderBy ( 'n.dateN' , 'DESC' );
        $news           = $paginator -> paginate ( $queryBuilder , $request -> query -> getInt ( 'page' , 1 ) , 10 );
        return $this -> render ( 'news/index.html.twig' , array ( 'news' => $news ) );
    }

    #[Route( '/news_back' , name : 'afficher_les_news_back' )]
    public function newsBack ( PaginatorInterface $paginator , Request $request , SluggerInterface $slugger ) : Response
    {
        $newsRepository = $this -> managerRegistry -> getRepository ( News::class );
        $queryBuilder   = $newsRepository -> createQueryBuilder ( 'n' )
            -> orderBy ( 'n.dateN' , 'DESC' );
        $news           = $paginator -> paginate ( $queryBuilder , $request -> query -> getInt ( 'page' , 1 ) , 10 );

        $newNews = new News();
        $form    = $this -> createForm ( NewsType::class , $newNews );


        $form -> handleRequest ( $request );

        if ( $form -> isSubmitted () && $form -> isValid () ) {
            $photoJ = $form -> get ( 'picture' ) -> getData ();
            if ( $photoJ ) {
                $originalImgName = pathinfo ( $photoJ -> getClientOriginalName () , PATHINFO_FILENAME );
                $safeImgname     = $slugger -> slug ( $originalImgName );
                $newImgename     = $safeImgname . '-' . uniqid () . '.' . $photoJ -> guessExtension ();
                try {
                    $photoJ -> move (
                        $this -> getParameter ( 'img_directory' ) ,
                        $newImgename
                    );
                } catch ( FileException $e ) {
                }
                $newNews -> setImage ( $newImgename );
            }
            $entityManager = $this -> managerRegistry -> getManagerForClass ( News::class );
            $entityManager -> persist ( $newNews );
            $entityManager -> flush ();

            // Redirect to the same page to avoid resubmitting the form on refresh
            return $this -> redirectToRoute ( 'afficher_les_news_back' );
        }

        $pageCount = ceil ( $news -> count () / $news -> getItemNumberPerPage () );
        return $this -> render ( 'news/newsback.html.twig' , [
            'news' => $news ,
            'form' => $form -> createView () ,
            'pageCount' => $pageCount
        ] );
    }


    #[Route( '/delete_news/{id}' , name : 'supprimer_news' )]
    public function delete_news ( $id ) : Response
    {
        $entityManager = $this -> managerRegistry -> getManagerForClass ( News::class );
        $news          = $entityManager -> getRepository ( News::class ) -> find ( $id );

        if ( ! $news ) {
            throw $this -> createNotFoundException ( 'No news found for id ' . $id );
        }

        $entityManager -> remove ( $news );
        $entityManager -> flush ();
        return $this -> redirectToRoute ( 'afficher_les_news_back' );
    }


    #[Route( '/modifiernews/{id}' , name : 'modifier_news' )]
    public function modifier_news ( Request $request , NewsRepository $repo , int $id ) : Response
    {
        $news = $repo -> findOneBy ( [ 'id' => $id ] );
        $form = $this -> createForm ( NewsType2::class , $news );
        $form -> handleRequest ( $request );
        if ( $form -> isSubmitted () && $form -> isValid () ) {
            $em = $this -> managerRegistry -> getManagerForClass ( News::class );
            $em -> persist ( $news );
            $em -> flush ();
            return $this -> redirect ( $this -> generateUrl ( 'afficher_les_news_back' ) );
        }
        return $this -> renderForm ( 'news/modifiernewsback.html.twig' , [
            'form' => $form ,
            'news' => $news
        ] );
    }


}
