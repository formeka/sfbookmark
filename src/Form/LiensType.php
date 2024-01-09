<?php

namespace App\Form;

use App\Entity\Liens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

date_default_timezone_set('UTC');

class LiensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url')
            ->add('titre')
            ->add('resume')
            ->add('description')
            ->add('createdAt',DateTimeType::class,[
                'model_timezone' => 'UTC',
                'view_timezone' => 'Europe/Paris',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Liens::class,
        ]);
    }
}
