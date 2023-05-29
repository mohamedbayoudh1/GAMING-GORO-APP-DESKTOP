<?php

namespace App\Controller;


use App\Entity\Coach;


use App\Entity\Gamer;
use App\Entity\HistoriquePoint;
use App\Entity\RechargeCode;

use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BaseController extends AbstractController
{
    public $session;
    public $passwordhash;
    public $managerRegistry;
    public $sessionLifetime=3600;
    public $request;
    public $slugger;
    public $mailer;

    
    public function __construct(MailerInterface $mailer,SluggerInterface $slugger,RequestStack $requestStack ,ManagerRegistry $managerRegistry,UserPasswordHasherInterface $passwordHasher)
    {
        $this->slugger=$slugger;
        $this->managerRegistry = $managerRegistry;
        $this->passwordhash = $passwordHasher;
        $this->request=$requestStack->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->check_session(); 
        $this->mailer = $mailer;
  
    }


    public function check_session():bool{
        $this->session=$this->request->getSession();
        if ( $this->session->has('Gamer_id') ||  $this->session->has('Coach_id') || $this->session->has('Admin_id')) {
            $diff= $this->session->get('Session_time');
            $now=new DateTime();            
            $difference = $diff->getTimestamp() - $now->getTimestamp();
            if ($difference>$this->sessionLifetime) {
                 $this->session->invalidate();
                 return False;
            } else {
                return True;
            }
        }
        else
        return False;
    }


    /**
     * @return object|null
     */
    public function getUserFromSession(): ?object
    {
        $session = $this->request->getSession();
        // Check if either Gamer or Coach ID is set in session
        if ($session->has('Gamer_id')) {
            $userId = $session->get('Gamer_id');
            $user = $this->managerRegistry->getRepository(Gamer::class)->find($userId);
        } elseif ($session->has('Coach_id')) {
            $userId = $session->get('Coach_id');
            $user = $this->managerRegistry->getRepository(Coach::class)->find($userId);
        } else {
            return null;
        }
        // Check if the user is still logged in
        $sessionTime = $session->get('Session_time');
        $now = new \DateTime();
        $difference = $sessionTime->getTimestamp() - $now->getTimestamp();
        if ($difference > $this->sessionLifetime) {
            $session->invalidate();
            return null;
        }
        return $user;
    }
    




public function recharge(string $coder,int $id){
    $em = $this->managerRegistry->getManagerForClass(Gamer::class);
    $emgamer = $this->managerRegistry->getRepository(Gamer::class);
    $emcoach = $this->managerRegistry->getManagerForClass(Coach::class);
    $emcoachrep = $this->managerRegistry->getRepository(Coach::class);
    $em2 = $this->managerRegistry->getManagerForClass(HistoriquePoint::class);
    $em4 = $this->managerRegistry->getManagerForClass(RechargeCode::class);
    $em3 = $this->managerRegistry->getRepository(RechargeCode::class);
    $code=new RechargeCode();
    $code=$em3->findOneBy(["code"=>$coder]);
    if($code){
        $gamer=$emgamer->findOneBy(['id'=>$id]);
        $coach=$emcoachrep->findOneBy(['id'=>$id]);
        if($gamer){
            $gamer->setPoint($gamer->getPoint()+$code->getPoint());
            $em->persist($gamer);
            $em->flush();
            $historique=new HistoriquePoint();
            $historique->setPoint($code->getPoint());
            $historique->setType(1);
            $historique->setDates(new DateTime());
            $historique->setUserid($gamer);
            $em4->persist($historique);
            $em4->flush();
            $em2->remove($code);
            $em2->flush();
            $this->session->set('Solde', $gamer->getPoint());
            return True;
        }
        if($coach){
            $coach->setPoint($coach->getPoint()+$code->getPoint());
            $emcoach->persist($coach);
            $emcoach->flush();
            $historique=new HistoriquePoint();
            $historique->setPoint($code->getPoint());
            $historique->setType(1);
            $historique->setDates(new DateTime());
            $historique->setUserid($coach);
            $em4->persist($historique);
            $em4->flush();
            $em2->remove($code);
            $em2->flush();
            $this->session->set('Solde', $coach->getPoint());
            return True;
        }

        return false;
        
    }else
    return False;
}




public function point(int $point,int $id,int $type){
    $em = $this->managerRegistry->getManagerForClass(Gamer::class);
    $emgamer = $this->managerRegistry->getRepository(Gamer::class);
    $emcoach = $this->managerRegistry->getManagerForClass(Coach::class);
    $emcoachrep = $this->managerRegistry->getRepository(Coach::class);
    $em2 = $this->managerRegistry->getManagerForClass(HistoriquePoint::class);
    $gamer=$emgamer->findOneBy(['id'=>$id]);
    $coach=$emcoachrep->findOneBy(['id'=>$id]);   
        if($coach){
            $coach->setPoint($coach->getPoint()+$point);
            $emcoach->persist($coach);
            $emcoach->flush();
            $historique=new HistoriquePoint();
            $historique->setPoint($point);
            $historique->setType($type);
            $historique->setDates(new DateTime());
            $historique->setUserid($coach);
            $em2->persist($historique);
            $em2->flush();
            $this->session->set('Solde', $coach->getPoint());
            return True;
        }
        if($gamer){
            $gamer->setPoint($gamer->getPoint()+$point);
            $em->persist($gamer);
            $em->flush();
            $historique=new HistoriquePoint();
            $historique->setPoint($point);
            $historique->setType($type);
            $historique->setDates(new DateTime());
            $historique->setUserid($gamer);
            $em2->persist($historique);
            $em2->flush();
            $this->session->set('Solde', $gamer->getPoint());
            return True;
        }

       
        return false;
    

}


public function sendEmail()
{
    $email = (new Email())
        ->from('testmailsenderspringboot@gmail.com')
        ->to('nejdbedoui@gmail.com')
        ->subject('Test email')
        ->text('This is a test email')
        ->html('<p>This is a <strong>test email</strong></p>');

    $this->mailer->send($email);
}



}

