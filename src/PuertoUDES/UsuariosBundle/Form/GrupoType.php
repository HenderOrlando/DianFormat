<?php

namespace PuertoUDES\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('docente', null,array(
                'class'    =>  'PuertoUDESUsuariosBundle:Usuario',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    return $er->getDocentes(false, true);
                }
            ))
            ->add('usuarios', null,array(
                'class'    =>  'PuertoUDESUsuariosBundle:Usuario',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    return $er->getEstudiantes(false, true);
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\UsuariosBundle\Entity\Grupo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_usuariosbundle_grupo';
    }
}
