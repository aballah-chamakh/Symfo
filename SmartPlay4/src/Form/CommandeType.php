<?php

namespace App\Form;

use App\Entity\Commande ;
use App\Entity\Client ;
use App\Form\LigneCdeType ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code_clt_cde',EntityType::class,['class' => Client::class,'choice_label' => 'des_clt',"attr"=>['class'=>'form-control',"placeholder"=>"Client"]])
            ->add('date_cde',DateType::class,['attr'=>['placeholder'=>'Date']])
            ->add('heure_cde',TimeType::class,['attr'=>['placeholder'=>'Time']])
            ->add('remise_cde',IntegerType::class,['attr'=>['class'=>'form-control','placeholder'=>'Remise']])
            ->add('mnt_cde',MoneyType::class,['attr'=>['class'=>'form-control','placeholder'=>'Montant']])
            ->add('lignes',CollectionType::class,['entry_type'=>LigneCdeType::class,'entry_options' => ['label' => true],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'width:100%'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
