<?php

namespace kisRegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PytanieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tresc')->add('odpowiedzA')->add('odpowiedzB')->add('odpowiedzC')->add('odpowiedzD')->add('poprawnaOdpowiedz')->add('kolejnosc')->add('aktywne');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'kisRegBundle\Entity\Pytanie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kisregbundle_pytanie';
    }


}
