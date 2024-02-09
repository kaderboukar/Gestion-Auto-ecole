<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Instructeur;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reservation',DateType::class,[
                'required'   => true,
                'label'=>'Date reservation *',
                 'widget' => 'single_text',
    // this is actually the default format for single_text
                 'format' => 'yyyy-MM-dd',
                'attr' => ['class'=>"form-control" ]])
            ->add('heure_reservation',TimeType::class,[
                'required'   => true,
                'label'=>'Heure *',
                 'widget' => 'single_text',
    // this is actually the default format for single_text
                 'input_format' => 'h:i',
                'attr' => ['class'=>" form-control" ]])
            // ->add('created_at')
            // ->add('deleted_at')
            // ->add('status')
            // ->add('id_etudiant', EntityType::class, [
            //     'class' => Etudiant::class,
            //     'choice_label' => 'nom',
            // ])
            ->add('id_instructeur', EntityType::class, [
                'class' => Instructeur::class,
                'attr' => ['class'=>" form-control" ],
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
