<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection ;
use App\Entity\Commande ;
use App\Entity\LigneCde ;
use App\Form\CommandeType ;
use App\Form\LigneCdeType ;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commandes", name="liste_commande")
     */
    public function commande_liste(): Response
    {
        $commande_repo = $this->getDoctrine()->getRepository(Commande::class) ;
   
        $commandes = $commande_repo->createQueryBuilder('cde')
                            ->select('clt.des_clt ,cde.num_cde,cde.date_cde,cde.heure_cde,cde.remise_cde,cde.mnt_cde')
                            ->innerJoin("cde.code_clt_cde","clt")
                            ->getQuery()
                            ->getArrayResult();  
        return $this->render("commande/commande_liste.html.twig",["commandes"=>$commandes]);
    }
    /**
     * @Route("/commande/{num_cde}/edit", name="commande_edit")
     */
    public function commande_edit(Commande $commande,Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $orignalLignes = new ArrayCollection();
        foreach ($commande->getLignes() as $ligne) {
            $orignalLignes->add($ligne);
        }

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            foreach ($orignalLignes as $ligne) {

                if ($commande->getLignes()->contains($ligne) === false) {
                    $em->remove($ligne);
                }
            }
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute("liste_commande") ;
        }

        // replace this example code with whatever you need
        return $this->render('commande/commande_edit.html.twig', [
            'formCommande' => $form->createView()
        ]);
    

        /*
        if ($jouet == null){
            return $this.redirectToRoute("liste_jouet");
        }
        
        $form = $this->createFormBuilder($jouet)
                            ->add('des_jouet',TextType::class,["attr"=>["class"=>"form-control","placeholder"=>"des_jouet"]])    
                            ->add('qte_stock_jouet',NumberType::class,["attr"=>["class"=>"form-control","placeholder"=>"qte_stock_jouet"]])    
                            ->add('pu_jouet',MoneyType::class,["attr"=>["class"=>"form-control","placeholder"=>"pu_jouet"]])  
                            ->getForm() ;

        $form->handleRequest($request) ;
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager() ;
            $manager->persist($jouet) ;
            $manager->flush() ;
            return $this->redirectToRoute("liste_jouet");
        }  
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class) ;
        $fournisseur = $four_repo->findOneBy(['code_four'=>$jouet->getCodeFourJouet()]);  
        $des_four = $fournisseur->getDesFour();*/ 
      //  return $this->render("commande/commande_edit.html.twig") ; //,['formJouet'=>$form->createView(),"des_four"=>$des_four]);
    }

    /**
     * @Route("/commande/{num_cde}/delete", name="delete_commande")
     */
    public function delete_commande(Commande $commande): Response
    {
        
        $cde_repo = $this->getDoctrine()->getRepository(Commande::class) ;
        $cde_repo->removeCommande($commande) ;
        return $this->json(["ligne_cdes_count"=>"ligne_cdes_count"]);
    }
    /**
     * @Route("/create_commande", name="create_commande")
     */
    public function create_commande(Request $request): Response
    {

        



        $commande = new Commande() ;
        $form = $this->createForm(CommandeType::class,$commande) ;

  
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()){
            $lignes = $commande->getLignes() ;
            $commande->resetLignes();
            $em = $this->getDoctrine()->getManager() ;
            $em->persist($commande) ;
            $em->flush() ;
            foreach($lignes as $ligne){
                $ligne->setNumCdeLigne($commande) ;
                $em->persist($ligne) ;
                $em->flush() ;
                $commande->addLigne($ligne) ;
                $em->persist($ligne) ;
                $em->flush() ;             
            }
         
            return $this->redirectToRoute("liste_commande") ;
        }
        return $this->render("commande/commande_create.html.twig",['formCommande'=>$form->createView()]) ; //,['formJouet'=>$form->createView(),"fournisseurs"=>$fournisseurs]);
       
    }
}
