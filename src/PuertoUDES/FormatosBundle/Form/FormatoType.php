<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormatoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('nombre')
            ->add('descripcion', null, array(
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
        ;
        $info = array(
            'label' => 'Tipo de Formato',
            'empty_value' => 'Elija una Opción',
            'class'         =>  'PuertoUDESCommonBundle:Tipo',
            'query_builder' =>  function(\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->andWhere("t.aplicableA LIKE '%formato%'")
                    ->orderBy('t.nombre', 'ASC');
            }
        );
        if(isset($options['data']) && $options['data']->getTipo() !== null){
            $info = array_merge($info,array(
                'label' => ' ',
                'attr'  =>  array('class' => 'hide')
            ));
        }
        $builder->add('tipo', 'entity', $info);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\Formato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_formato';
    }
}
