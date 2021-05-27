<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Jouet;
use App\Entity\Fournisseur;
class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test_script")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager() ;
        
        /*Q1 : 
        $fournisseur_arr = array(
            array("des_four"=>"PlayTunisia"),
            array("des_four"=>"ImportSmart"),
            array("des_four"=>"EduGame"),
        );
        $jouet_arr = array(
            array("code_jouet"=>1,"des_jouet"=>"Camionnette Lego","qte_stock_jouet"=>130,"pu_jouet"=>20.00,"four"=>"ImportSmart"),
            array("code_jouet"=>2,"des_jouet"=>"Voiture télécommandéé","qte_stock_jouet"=>120,"pu_jouet"=>45.4,"four"=>"ImportSmart"),
            array("code_jouet"=>3,"des_jouet"=>"Puzzle La reine des neiges","qte_stock_jouet"=>300,"pu_jouet"=>3,"four"=>"EduGame"),
            array("code_jouet"=>4,"des_jouet"=>"Scrable","qte_stock_jouet"=>270,"pu_jouet"=>32,"four"=>"EduGame"),
            array("code_jouet"=>5,"des_jouet"=>"Monopoly","qte_stock_jouet"=>300,"pu_jouet"=>34.6,"four"=>"EduGame"),
        );
        
        foreach($fournisseur_arr as $four_obj ){
            $fournisseur = new Fournisseur() ;
            $fournisseur->setDesFour($four_obj["des_four"]) ;
            $em->persist($fournisseur);
            $em->flush() ;
        }
        foreach($jouet_arr as $jouet_obj ){
            $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
            $four = $four_repo->findOneBy(['des_four'=>$jouet_obj["four"]]);
            dump($four);
            $jouet = new Jouet() ;
            $jouet->setCodeJouet($jouet_obj["code_jouet"]) 
                  ->setDesJouet($jouet_obj["des_jouet"]) 
                  ->setQteStockJouet($jouet_obj["qte_stock_jouet"]) 
                  ->setPuJouet($jouet_obj["pu_jouet"]) 
                  ->setCodeFourJouet($four) ;
            $em->persist($jouet);
            $em->flush() ;

        }*/
        /*
        Q1 : 
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $four = $four_repo->findOneBy(['des_four'=>"EduGame"]);
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $jouet_qs = $jouet_repo->findBy(['code_four_jouet'=>$four]);
        foreach($jouet_qs as $jouet){
            dump($jouet->getDesJouet()) ;
        }*/
        /*
        Q2 : 
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $query = $jouet_repo->createQueryBuilder('j')
                    ->OrderBy('j.qte_stock_jouet','DESC')
                    ->getQuery();
        $jouet_qs = $query->getResult() ;

        
        foreach($jouet_qs as $jouet){
            dump("jouet : ".$jouet->getDesJouet()." ||  qte_stock_jouet : ".strval($jouet->getQteStockJouet())) ;
        }    
        */
        /*
        Q3 : 
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $query = $jouet_repo->createQueryBuilder('j')
                    ->select("j.des_jouet,MIN(j.PU_jouet) AS min_price")
                    ->getQuery();    
        $jouet_qs = $query->getResult() ;
        dump($jouet_qs) ;
        dump($jouet_qs[0]["des_jouet"]);
        dump($jouet_qs[0]["min_price"]) ; 
        # Q4
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $query = $four_repo->createQueryBuilder('f')
                           ->select('f.des_four , Count(j.des_jouet) AS nb ')
                           ->leftJoin("f.jouet","j")
                           ->groupBy("f.des_four")
                           ->getQuery()
                           ->getResult() ;
        dump($query) ;
        $max_four = $query[0] ;
        foreach($query as $four){
            if ($four["nb"] > $max_four['nb']){
                $max_four = $four ;
            }
        }
        dump($max_four) ;
        # Q5 :  
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $query = $four_repo->createQueryBuilder('f')
                            ->select('f.des_four , Count(j.des_jouet) AS nb ')
                            ->leftJoin("f.jouet","j")
                            ->groupBy("f.des_four")
                            ->having('nb=0')
                            ->getQuery()
                            ->getResult() ;
        dump($query) ;

        */
        /*
        Q1 : 
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $importsmart_four = $four_repo->findOneBy(["des_four"=>"ImportSmart"]);
        $importsmart_four_code = $importsmart_four->getCodeFour() ;
        dump($importsmart_four_code);
        $query = $jouet_repo->createQueryBuilder('j')
                    ->update()
                    ->set("j.PU_jouet","j.PU_jouet + 10")
                    ->where("j.code_four_jouet = :four_code")
                    ->setParameter("four_code",$importsmart_four_code)
                    ->getQuery() 
                    ->execute();
        $em->flush() ;
        */
        /*
        Q1 : 
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $edugame_four = $four_repo->findOneBy(["des_four"=>"EduGame"]);
        $edugame_four_code = $edugame_four->getCodeFour() ;
        dump($edugame_four);
        $query = $jouet_repo->createQueryBuilder('j')
                    ->delete()
                    ->where("j.code_four_jouet = :four_code")
                    ->setParameter("four_code",$edugame_four_code)
                    ->getQuery() 
                    ->execute();
        $query = $four_repo->createQueryBuilder('f')
                    ->delete()
                    ->where("f.code_four = :four_code")
                    ->setParameter("four_code",$edugame_four_code)
                    ->getQuery() 
                    ->execute();
        $em->flush() ;
        
        $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
        $query = $jouet_repo->createQueryBuilder('j')
                    ->select('f.des_four , Count(j.des_jouet) AS nb ')
                    ->leftJoin("j.code_four_jouet","f")
                    ->groupBy("f.des_four")
                    ->getQuery()
                    ->getResult() ;
        

         */
        return $this->render('test/test.html.twig');
    }
}
