<?php

namespace App\Controller;

use App\Entity\CommentaireNews;
use App\Entity\News;
use App\Form\CommentaireNewsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NewsRepository;
use App\Repository\CommentaireNewsRepository;

class CommentaireNewsController extends BaseController
{
    /**
     * @param array $comments
     * @return array
     * retourner la liste des utilisateur qui on postez un commentaire
     */
    private function getUserNames (array $comments ) : array
    {
        $names = [];
        foreach ( $comments as $comment ) {
            $user    = $comment -> getUser ();
            $names[] = [
                'id' => $user -> getId () ,
                'name' => $user -> getNom () . ' ' . $user -> getPrenom ()
            ];
        }
        return $names;
    }

    /**
     * @param Request $request
     * @param NewsRepository $newsRepository
     * @param CommentaireNewsRepository $commentRepository
     * @param $id
     * @return Response
     */
    #[Route( '/news/{id}' , name : 'news' )]
    public function news ( Request $request , NewsRepository $newsRepository , CommentaireNewsRepository $commentRepository , $id ) : Response
    {
        $news        = $newsRepository -> findOneBy ( [ 'id' => $id ] );
        $user        = $this -> getUserFromSession ();
        $commentaire = new CommentaireNews();
        $commentaire -> setUser ( $user );
        $commentaire -> setIdNews ( $news );
        $form = $this -> createForm ( CommentaireNewsType::class , $commentaire );
        $form -> handleRequest ( $request );
        if ( $form -> isSubmitted () && $form -> isValid () ) {
            $em = $this -> managerRegistry -> getManagerForClass ( CommentaireNews::class );
            $em -> persist ( $commentaire );
            $em -> flush ();
            return $this -> redirectToRoute ( 'news' , [ 'id' => $id ] );
        }
        $offset        = $request -> query -> get ( 'offset' , 0 );
        $limit         = 100;
        $comments      = $commentRepository -> findBy ( [ 'idNews' => $news ] , [ 'date' => 'DESC' ] , $limit , $offset );
        $totalComments = $commentRepository -> count ( [ 'idNews' => $news ] );
        $game          = $news -> getIdJeux ();
        $gameName      = $game -> getNomGame ();
        $names         = $this -> getUserNames ( $comments );
        $loadMoreUrl   = $this -> generateUrl ( 'news' , [ 'id' => $id , 'offset' => $offset + $limit ] );
        $commentCount  = $commentRepository -> count ( [ 'user' => $user ] );
        $canAddComment = $commentCount < 3;
        return $this -> render ( 'news/comments.html.twig' , [
            'news' => $news ,
            'comments' => $comments ,
            'names' => $names ,
            'gameName' => $gameName ,
            'form' => $form -> createView () ,
            'loadMoreUrl' => $loadMoreUrl ,
            'hasMoreComments' => ( $offset + $limit < $totalComments ) ,
            'canAddComment' => $canAddComment ,
        ] );
    }

    /**
     * @param Request $request
     * @param NewsRepository $newsRepository
     * @param CommentaireNewsRepository $commentRepository
     * @param $id
     * @return Response
     */
    #[Route( '/newsback/{id}' , name : 'comment_back' )]
    public function news_back ( Request $request , NewsRepository $newsRepository , CommentaireNewsRepository $commentRepository , $id ) : Response
    {
        $news        = $newsRepository -> findOneBy ( [ 'id' => $id ] );
        $user        = $this -> getUserFromSession ();
        $commentaire = new CommentaireNews();
        $commentaire -> setUser ( $user );
        $commentaire -> setIdNews ( $news );
        $form = $this -> createForm ( CommentaireNewsType::class , $commentaire );
        $form -> handleRequest ( $request );
        if ( $form -> isSubmitted () && $form -> isValid () ) {
            $em = $this -> managerRegistry -> getManagerForClass ( CommentaireNews::class );
            $em -> persist ( $commentaire );
            $em -> flush ();
        }
        $comments = $commentRepository -> findBy ( [ 'idNews' => $news ] );
        $game     = $news -> getIdJeux ();
        $gameName = $game -> getNomGame ();
        $names    = $this -> getUserNames ( $comments );
        return $this -> render ( 'news/commentsback.html.twig' , [
            'news' => $news ,
            'comments' => $comments ,
            'names' => $names ,
            'gameName' => $gameName ,
            'form' => $form -> createView () ,
        ] );
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    #[Route( '/supprimercommentaire/{id}' , name : 'supprimer_commentaire' )]
    public function delete_comment ( Request $request , $id ) : Response
    {
        $entityManager = $this -> managerRegistry -> getManagerForClass ( CommentaireNews::class );
        $comment       = $entityManager -> getRepository ( CommentaireNews::class ) -> find ( $id );

        if ( ! $comment ) {
            throw $this -> createNotFoundException ( 'No comment found for id ' . $id );
        }
        $entityManager -> remove ( $comment );
        $entityManager -> flush ();
        $referer = $request -> headers -> get ( 'referer' );

        return $this -> redirect ( $referer );
    }

    /**
     * @param Request $request
     * @param CommentaireNewsRepository $commentRepository
     * @param $id
     * @return Response
     */
    #[Route( '/news_comment/{id}' , name : 'news_comment' )]
    public function news_comment_edit ( Request $request , CommentaireNewsRepository $commentRepository , $id ) : Response
    {
        $jeux = $commentRepository -> findOneBy ( [ 'id' => $id ] );
        $form = $this -> createForm ( CommentaireNewsType::class , $jeux );
        $form -> handleRequest ( $request );
        if ( $form -> isSubmitted () && $form -> isValid () ) {
            $em = $this -> managerRegistry -> getManagerForClass ( CommentaireNews::class );
            $em -> persist ( $jeux );
            $em -> flush ();
            return $this -> redirectToRoute ( 'news' , [ 'id' => $jeux -> getIdNews () -> getId () ] );
        }
        return $this -> renderForm ( 'news/comments_edit.html.twig' , [
            'form' => $form ,
        ] );
    }


}
