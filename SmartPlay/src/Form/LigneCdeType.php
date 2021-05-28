<?php

namespace App\Form;

use App\Form\JouetType ; 
use App\Entity\LigneCde;
use App\Entity\Jouet ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class LigneCdeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_jouet_ligne',EntityType::class,['class'=>Jouet::class,'label'=>'jouet','choice_label'=>'des_jouet','attr'=>['class'=>'form-control','placeholder'=>'Montant']])
            ->add('qte_ligne',IntegerType::class,['attr'=>['class'=>'form-control','placeholder'=>'Qte']])
            ->add('remise_ligne',IntegerType::class,['attr'=>['class'=>'form-control','placeholder'=>'Remise']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneCde::class,
        ]);
    }
}
