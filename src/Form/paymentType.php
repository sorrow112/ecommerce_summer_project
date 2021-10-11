<?php
namespace App\Form;

use App\Paymentlocal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class paymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        ->add("nom")
        ->add("prenom")
        ->add("numeroDeCarte",IntegerType::class)
        ->add("CodeDeVerification")
        ->add("dateExpiration")
        ;
        
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paymentlocal::class,
        ]);
    }
}