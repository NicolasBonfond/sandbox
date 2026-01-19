<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('content')
            ->add('duration')
            ->add('save', SubmitType::class,
                ['label' => 'Enregistrer']
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                $this->autoSlug(...)
                )
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                $this->autoTimestamps(...)
                )   
        ;
    }

    // fonction qui permet de generer un slug automatiquement si le champ est vide
    public function autoSlug(PreSubmitEvent $event): void {
       $event->getData();
       if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $data['slug'] = strToLower($slugger->slug($data['title']));
            $event->setData($data);

       }

    }

    // fonction qui met a jour les timestamps de creation et de modification
    public function autoTimestamps(PostSubmitEvent $event): void {
        $event->getData();
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}