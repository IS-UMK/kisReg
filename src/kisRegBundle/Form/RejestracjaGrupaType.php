<?php

namespace kisRegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use kisRegBundle\Entity\Zajecia;
use kisRegBundle\Entity\Grupa;

class RejestracjaGrupaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('opiekun',null,array('label'=>'Opiekun','attr'=>['placeholder'=>'Imię i nazwisko...']))
        ->add('email',EmailType::class,array('label'=>'E-Mail','attr'=>['placeholder'=>'Email...']))
        ->add('szkola',null,array('label'=>'Szkoła','attr'=>['placeholder'=>'Nazwa szkoły lub instytucji...']))
        ->add('telefon',null,array('label'=>'Telefon','attr'=>['placeholder'=>'Numer telefonu...']))
        ->add('zapisy',CollectionType::class,[
            'label'=>'Zajecia',
            'entry_type'   => RejestracjaZapisType::class
        ])
        ->add('recaptcha', EWZRecaptchaType::class,array(
            'mapped'      => false,
            'constraints' => array(
                    new RecaptchaTrue()
                    )
                )
            )
        ->add('send', SubmitType::class,array('label'=>'Wyślij' ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'kisRegBundle\Entity\Grupa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kisregbundle_rejestracjagrupa';
    }


}
