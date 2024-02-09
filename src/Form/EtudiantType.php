<?php

namespace App\Form;

use App\Entity\Etudiant;
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

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'   => true,
                'label'=>'Nom',
                'attr' => ['placeholder'  => "Nom etudiant",'class'=>" form-control" ]])
            ->add('prenom',TextType::class,[
                'required'   => true,
                'label'=>'Prenom',
                'attr' => ['placeholder'  => "Prenom etudiant",'class'=>" form-control" ]])
            ->add('email',EmailType::class,[
                'required'   => true,
                'label'=>'Email',
                'attr' => ['placeholder'  => "Email etudiant",'class'=>" form-control" ]])
            // ->add('matricule',TextType::class,[
            //     'required'   => false,
            //     'label'=>'Matr',
            //     'attr' => ['placeholder'  => "Nom etudiant",'class'=>" form-control" ]])
                        
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne matchent pas.',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirme Mot de passe'],
             ])
            ->add('telephone',NumberType::class,[
                'required'   => true,
                'label'=>'Telephone',
                'attr' => ['placeholder'  => "Telephone etudiant",'class'=>" form-control" ]])
            // ->add('created_at')
            // ->add('deleted_at')
            // ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
