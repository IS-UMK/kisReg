<?php

namespace kisRegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use kisRegBundle\Form\PlikUploadFieldType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PlikType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa',null,array('label'=>'Nazwa pliku'))
            ->add('file',FileType::class,array('label'=>' '))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'kisRegBundle\Entity\Plik']);
    }
    public function getBlockPrefix(){
        return 'kisRegBundle_plik';
    }
}
