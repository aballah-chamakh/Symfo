<?php

namespace App\Form;

use App\Entity\Jouet;
use App\Form\FournisseurType ;
use App\Entity\Fournisseur ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class JouetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_four_jouet',EntityType::class,['class' => Fournisseur::class,'choice_label' => 'des_four',"attr"=>['class'=>'form-control',"placeholder"=>"Fournisseur"]])
            ->add('des_jouet',TextType::class,["attr"=>["class"=>"form-control","placeholder"=>"des jouet"]])    
            ->add('qte_stock_jouet',IntegerType::class,["attr"=>["class"=>"form-control","placeholder"=>"qte stock jouet"]])    
            ->add('pu_jouet',MoneyType::class,["attr"=>["class"=>"form-control","placeholder"=>"pu jouet","step"=>0.01]])  
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jouet::class,
        ]);
    }
}
