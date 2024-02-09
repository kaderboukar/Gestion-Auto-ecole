<?php

namespace App\Form;

use App\Entity\Instructeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InstructeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'   => true,
                'label'=>'Nom *',
                'attr' => ['placeholder'  => "Nom instructeur",'class'=>" form-control" ]])
            ->add('prenom',TextType::class,[
                'required'   => true,
                'label'=>'Prenom *',
                'attr' => ['placeholder'  => "Prenom instructeur",'class'=>" form-control" ]])
            ->add('email',EmailType::class,[
                'required'   => true,
                'label'=>'Email *',
                'attr' => ['placeholder'  => "Email instructeur",'class'=>" form-control" ]])
            ->add('telephone',NumberType::class,[
                'required'   => true,
                'label'=>'Telephone *',
                'attr' => ['placeholder'  => "Telephone instructeur",'class'=>" form-control" ]])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instructeur::class,
        ]);
    }
}
