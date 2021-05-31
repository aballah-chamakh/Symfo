<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Jouet ;
use App\Entity\Fournisseur ;
class Tp3Controller extends AbstractController
{
     /**
     * @Route("/tp3", name="tp3_home")
     */
    public function tp3_home(): Response
    {
        return $this->render('tp3/index.html.twig');
    }

    /**
     * @Route("/tp3/answer_question", name="tp3_answer_question")
     */
    public function tp3_answer_question(Request $request): Response
    {
        $question_nb = $request->query->get('question_nb');
        switch ($question_nb) {
            # insertion 
            case 0:
                $em = $this->getDoctrine()->getManager();
                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $fours = $four_repo->findAll() ;
                if(!$fours){
                    
                
                
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
                    
                    $four = $four_repo->findOneBy(['des_four'=>$jouet_obj["four"]]);

                    $jouet = new Jouet() ;
                    $jouet->setCodeJouet($jouet_obj["code_jouet"]) 
                          ->setDesJouet($jouet_obj["des_jouet"]) 
                          ->setQteStockJouet($jouet_obj["qte_stock_jouet"]) 
                          ->setPuJouet($jouet_obj["pu_jouet"]) 
                          ->setCodeFourJouet($four) ;
                    $em->persist($jouet);
                    $em->flush() ;
                }
            }
                $query = $four_repo->createQueryBuilder('f')
                            ->select("f.des_four,j.des_jouet,j.qte_stock_jouet,j.PU_jouet")
                            ->innerJoin("f.jouet","j")
                            ->getQuery()
                            ->getArrayResult() ;
                return $this->json(["state"=>true,"data"=>$query]);
        
                
                break;
            case 1:
                
                //Q1 : Quelles sont les jouets fournis par EduGame ? 

                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $four = $four_repo->findOneBy(['des_four'=>"EduGame"]);
                $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
                $query = $jouet_repo->createQueryBuilder('j')
                                       ->where('j.code_four_jouet= :four_code')
                                       ->setParameter("four_code",$four->getCodeFour())
                                       ->getQuery()
                                       ->getArrayResult();
                
                return $this->json(["state"=>true,"data"=>$query]);                                   
                break;
            case 2:
                
                //Q2 : Quels sont les jouets dont la quantité en stpock est la plus grande ?
                $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
                $query = $jouet_repo->createQueryBuilder('j')
                            ->select('Max(j.qte_stock_jouet) as max_qty,j.des_jouet')
                            ->getQuery()
                            ->getArrayResult();
                return $this->json(["state"=>true,"data"=>$query]); 
                break;
            case 3:
                
                //Q3 : Quel est le jouet le moins cher ?

    
                $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
                $query = $jouet_repo->createQueryBuilder('j')
                                    ->select("j.des_jouet,MIN(j.PU_jouet) AS min_price")
                                    ->getQuery()
                                    ->getArrayResult() ;
                return $this->json(["state"=>true,"data"=>$query]); 


                break;
            case 4:
                
                //Q4 : Quel est le fournisseur qui fournit le plus de jouets ?
                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $query = $four_repo->createQueryBuilder('f')
                           ->select('f.des_four , Count(j.des_jouet) AS nb ')
                           ->leftJoin("f.jouet","j")
                           ->groupBy("f.des_four")
                           ->getQuery()
                           ->getArrayResult() ;

                $max_four = $query[0] ;
                foreach($query as $four){
                    if ($four["nb"] > $max_four['nb']){
                        $max_four = $four ;
                    }
                }
                return $this->json(["state"=>true,"data"=>array($max_four)]);                
                
                break;
            case 5:
                
                //Q5 : Quel est le fournisseur qui ne fournit aucun jouet ?

                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $query = $four_repo->createQueryBuilder('f')
                            ->select('f.des_four , Count(j.des_jouet) AS nb ')
                            ->leftJoin("f.jouet","j")
                            ->groupBy("f.des_four")
                            ->having('nb=0')
                            ->getQuery()
                            ->getArrayResult() ;
                return $this->json(["state"=>true,"data"=>$query]);   
                
                break;
            case 6:
                
                //Q6 : Ajouter 10dt au PU de tous les jouest fournis par ImportSmart
                $em = $this->getDoctrine()->getManager();
                $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $importsmart_four = $four_repo->findOneBy(["des_four"=>"ImportSmart"]);
                $importsmart_four_code = $importsmart_four->getCodeFour() ;
                $query = $jouet_repo->createQueryBuilder('j')
                                    ->update()
                                    ->set("j.PU_jouet","j.PU_jouet + 10")
                                    ->where("j.code_four_jouet = :four_code")
                                    ->setParameter("four_code",$importsmart_four_code)
                                    ->getQuery() 
                                    ->execute();
                $em->flush() ;
                $query = $jouet_repo->createQueryBuilder('j')
                                    ->where("j.code_four_jouet = :four_code")
                                    ->setParameter("four_code",$importsmart_four_code)
                                    ->getQuery() 
                                    ->getArrayResult() ;

                return $this->json(["state"=>true,"data"=>$query]);   
                break;
            case 7:
                 
                // Q7 : Supprimer Le forunisseur EduGame et tous ses jouets
                $em = $this->getDoctrine()->getManager();
                $jouet_repo = $this->getDoctrine()->getRepository(Jouet::class);
                $four_repo = $this->getDoctrine()->getRepository(Fournisseur::class);
                $edugame_four = $four_repo->findOneBy(["des_four"=>"EduGame"]);
                $edugame_four_code = $edugame_four->getCodeFour() ;
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
                $query = $four_repo->createQueryBuilder('f')
                                    ->select("f.des_four,j.des_jouet,j.qte_stock_jouet,j.PU_jouet")
                                    ->innerJoin("f.jouet","j")
                                    ->getQuery()
                                    ->getArrayResult() ;
                 return $this->json(["state"=>true,"data"=>$query]);
                    
            break;

        }
        
    }
}
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
                    ->select('Max(j.qte_stock_jouet) as max_qty,j.des_jouet')
                    ->getQuery();
        $jouet = $query->getResult() ;

           
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

        

         */