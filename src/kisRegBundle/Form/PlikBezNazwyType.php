<?php

namespace kisRegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use kisRegBundle\Form\PlikUploadFieldType;


class PlikBezNazwyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file',FileType::class,array('label'=>'Wybierz plik','multiple'=>false))
            ->add('kolejnosc')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'kisRegBundle\Entity\Plik']);
    }
    public function getBlockPrefix(){
        return 'kisRegBundle_plik_bez_nazwy';
    }
}
