<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Jouet;
use App\Entity\Fournisseur;
use App\Entity\LigneCde;
use App\Form\JouetType ;

class JouetController extends AbstractController
{
    /**
     * @Route("/jouets", name="liste_jouet")
     */
    public function jouet_liste(): Response
    {
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class) ;
   
    
        $jouets = $jouet_repo->createQueryBuilder('c')
                            ->getQuery()
                            ->getArrayResult();  
        
        return $this->render("jouet/jouet_liste.html.twig",["jouets"=>$jouets]);
    }
    /**
     * @Route("/jouet/{code_jouet}/edit", name="jouet_edit")
     */
    public function jouet_edit(Jouet $jouet,Request $request): Response
    {
        
 
        /*
        if ($jouet == null){
            return $this.redirectToRoute("liste_jouet");
        }*/ 
        
        $form = $this->createForm(JouetType::class,$jouet) ;
        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager() ;
            $manager->persist($jouet) ;
            $manager->flush() ;
            return $this->redirectToRoute("liste_jouet");
        } 
        return $this->render("jouet/jouet_edit.html.twig",['formJouet'=>$form->createView()]);
    }

    /**
     * @Route("/jouet/{code_jouet}/delete", name="delete_jouet")
     */
    public function delete_jouet(Jouet $jouet): Response
    {
        $ligne_cde_repo = $this->getDoctrine()->getRepository(LigneCde::class) ;
        $ligne_cdes = $ligne_cde_repo->findBy(["code_jouet_ligne"=>$jouet->getCodeJouet()]) ;
        
        $ligne_cdes_count = count($ligne_cdes) ;
        
        if($ligne_cdes_count == 0){
            $manager = $this->getDoctrine()->getManager() ;
            $manager->remove($jouet) ;
            $manager->flush() ;
        }
        return $this->json(["ligne_cdes_count"=>$ligne_cdes_count]);
    }
    /**
     * @Route("/create_jouet", name="create_jouet")
     */
    public function create_jouet(Request $request): Response
    {

        
  
        $jouet = new Jouet() ; 
        $form = $this->createForm(JouetType::class,$jouet) ;
                            
        /*
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class) ;
        
        $fournisseurs = $four_repo->createQueryBuilder('f')
                            ->getQuery()
                            ->getArrayResult();  */
               
        $form->handleRequest($request) ;
      
        if($form->isSubmitted() && $form->isValid()){
            
           
            /*
            $code_four = intval($request->request->get("code_four")) ;
            $four = $four_repo->findOneBy(["code_four"=>$code_four]) ;
            $jouet->setCodeFourJouet($four) ;*/

            $manager = $this->getDoctrine()->getManager() ;
            $manager->persist($jouet) ;
            $manager->flush() ;
            return $this->redirectToRoute("liste_jouet"); 
        }  

         
        return $this->render("jouet/jouet_create.html.twig",['formJouet'=>$form->createView()]);
       
    }


}
