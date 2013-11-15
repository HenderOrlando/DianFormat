<?php

namespace PuertoUDES\CommonBundle\Controller;

use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManager;

class IndexController extends Controller implements PaginatorAwareInterface
{
    protected $em_, $request_, $formFactory_, $paginator_, $router_, $response_;
    public function __construct($em = null, $formFactory = null, $router = null, $request = null, $paginator = null, $response = null) {
//        if(!is_null($em))
            $this->em_ = $em;
//        if(!is_null($request))
            $this->request_ = $request;
//        if(!is_null($response))
            $this->response_ = $request;
//        if(!is_null($formFactory))
            $this->formFactory_ = $formFactory;
//        if(!is_null($paginator))
            $this->paginator_ = $paginator;
//        if(!is_null($router))
            $this->router_ = $router;
    }
    
    public function setRequest(Request $request = null)
    {
        $this->request_ = $request;
        return $this;
    }
    public function getRequest()
    {
        $request = null;
        if(is_null($this->request_))
            $request = parent::getRequest ();
        else
            $request = $this->request_;
            
        return $request;
    }
    
    public function setResponse(Response $response = null)
    {
        $this->response_ = $response;
        return $this;
    }
    public function getResponse_()
    {
        return $this->response_;
    }
    
    public function setEntityManager(EntityManager $em = null)
    {
        $this->em_ = $em;
        return $this;
    }
    public function getEntityManager()
    {
        $em = null;
        if(is_null($this->em_))
            $em = $this->getDoctrine ()->getEntityManager ();
        else
            $em = $this->em_;
        return $em;
    }
    
    public function setPaginator(\Knp\Component\Pager\Paginator $paginator) {
        $this->paginator_ = $paginator;
        return $this;
    }
    public function getPaginator_()
    {
        return $this->paginator_;
    }
    
    public function setRouter(Router $router) {
        $this->router_ = $router;
        return $this;
    }
    public function getRouter_()
    {
        return $this->router_;
    }
    
    public function setFormFactory(FormFactory $formFactory = null)
    {
        $this->formFactory_ = $formFactory;
        return $this;
    }
    public function getFormFactory_()
    {
        return $this->formFactory_;
    }
    /**
     * Creates and returns a form builder instance
     *
     * @param mixed $data    The initial data for the form
     * @param array $options Options for the form
     *
     * @return FormBuilder
     */
    public function createFormBuilder($data = null, array $options = array())
    {
        $form = null;
        if(!is_null($this->formFactory_))
            $form = $this->getFormFactory_()->createBuilder('form', $data, $options);
        else
            $form = parent::createFormBuilder( $data, $options);
        return $form;
    }
    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string|FormTypeInterface $type    The built type of the form
     * @param mixed                    $data    The initial data for the form
     * @param array                    $options Options for the form
     *
     * @return Form
     */
    public function createForm($type = 'form', $data = null, array $options = array())
    {
        $form = null;
        if(!is_null($this->formFactory_))
            $form = $this->getFormFactory_()->create($type, $data, $options);
        else
            $form = parent::createForm($type, $data, $options);
        return $form;
        return ;
    }
    
    /**
     * Index App.
     *
     * @Route("/", name="index_")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Index:index.html.twig")
     */
    public function indexAction(Request $request)
    {
//     * @Route("/{_locale}/", name="index_locale_", defaults={"_locale" = "es"})
//        $locale = $request->getLocale();
//        $request->setLocale($request->getPreferredLanguage());
//        
//        $this->get('session')->set('_locale',$locale);
        
        return array();
    }
    
    /**
     * get form filter
     * 
     * Crea un formulario de búsqueda.
     *
     * @param   Array      $defaultData Arreglo con datos base
     * @param   Request    $request     Entity Manager
     *
     * @return  Form|FormBuilder  formulario
     */
    public function getFormFilter(array $defaultData, $route = null, $formBuilder = false,Request $request = null){
        if(is_null($request))
            $request = $this->getRequest ();
        $opts = array('attr' => array(
                'id' => 'fitro', 
                'role' => 'form', 
                'class' => 'form-inline form-buscar'
            ));
        $form = $this->createFormBuilder(
                $defaultData,
                $opts
            )->add('Pagina', 'hidden',
                array(
                    'label'=> false,
                    'data'  =>  $request->query->get('pagina', 1),
                )
            )
            ->setMethod('GET');
        
        if(is_bool($formBuilder) && !$formBuilder){
            $form
                ->add('Buscar', 'submit',
                    array(
                        'label'=> ' Buscar',
                        'attr' => array('class' => 'btn btn-success btn-lg input-group-addon glyphicon glyphicon-search')
                    )
                )
                ->add('filtro', 'text', 
                    array(
                        'required' => false, 
                        'label' =>false,
                        'attr' => array('class' => 'form-control input-lg'),
                    )
                );
            if(!is_null($route) && !empty($route)){
                $r = $this->generateUrl($route);
                $form->setAction($r);
            }
            $form = $form->getForm();
            if(!is_null($request)){
                $form->handleRequest($request);
            }
        }
         return $form;
    }
    /**
     * get paginacion
     * 
     * Crea la paginación y un formulario de búsqueda.
     *
     * @param   String      $entity     Nombre de la Entidad a manejar
     * @param   String      $bundle     Nombre del bundle donde está la entity
     * @param   String      $route      Ruta para el formulario de búsqueda
     * @param   Integer     $limit      Máximo de items por página
     * @param   Doctrine    $em         Entity Manager
     * @param   Request     $request    Entity Manager
     *
     * @return  array   Arreglo con 2 variables, la paginación "pag", y el formulario "form_filter"
     */
    public function getPaginacion($entity, $bundle, $limit = 5, $route = null,$qb = null,EntityManager $em = null,Request $request = null){
        if(is_null($em))
            $em = $this->em_;
        if(is_null($request))
            $request = $this->getRequest();
        $data = array();
        $defaultData = array();
        
        if(is_null($qb) && !is_null($route)){
           $form = $this->getFormFilter($defaultData, $route);
           if ($form->isValid()) {
              $data = $form->getData();
           }
           $qb = $em->createQueryBuilder();
           $qb->select('a');
           $qb->from('PuertoUDES'.$bundle.'Bundle:'.$entity, 'a');
            
           if (array_key_exists("filtro", $data)){
               $data['filtro'] = trim($data['filtro']);
               if (strlen($data['filtro'])>0)
               {
                    $qb
                       ->orWhere($qb->expr()->like("a.nombre", "?1"))
                       ->orWhere($qb->expr()->like("a.canonical", "?1"))
                       ->orWhere($qb->expr()->like("a.descripcion", "?1"))
                       ->setParameter(1,"%".$data['filtro']."%")
                       ->getQuery();
               }
           }
        }else{
            $form = null;
        }
         
        if(!is_null($this->paginator_))
            $paginator  = $this->paginator_;
        else
            $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb,
            $request->query->get('pagina', 1),
            $limit
        );
        if(!is_null($route) && !empty($route))
            $pagination->setUsedRoute($route);
        return array(
            'pag'           => $pagination,
            'form_filter'   => $form
        );
    }
    
    /**
     * Creates a form to delete a entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm($id, $url, $label = 'Borrar')
    {
        $opts = array('attr' => array(
                'id' => 'fitro', 
                'role' => 'form', 
                'class' => 'form-inline'
            ));
        $form = $this->createFormBuilder(
            array(),
            $opts
        );
        return $form
            ->setAction($this->generateUrl($url, array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $label))
            ->getForm()
        ;
    }
    
    /**
    * Creates a form to create a entity.
    *
    * @param Entity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createCreateForm($entity, $label = null, $url = null)
    {
        $form = $this->createFormEntity($entity, $label, 'POST', 'new', $url);
        return $form;
    }
    
    /**
    * Creates a form to edit a entity.
    *
    * @param mixed $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createEditForm($entity, $label = null, $url = null)
    {
        $form = $this->createFormEntity($entity, $label, 'PUT', 'edit', $url);
        return $form;
    }
    /**
    * Creates a form Entity
    *
    * @param mixed $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    public function createFormEntity($entity, $label = null, $method = 'GET', $sufijo = '', $url = null)
    {
        $className = get_class($entity);
        $typeName = $className.'Type';
        if(is_null($url) || empty($url))
            $url = strtolower($className).'__'.strtolower ($sufijo);
        
        $url = $this->generateUrl($url, array('id' => $entity->getId()));
        
        $form = $this->createForm(new $typeName(), $entity, array(
            'action' => $url,
            'method' => $method,
        ));

        if(is_null($label) || empty($label))
            $label = 'Enviar';
        
        $form->add('submit', 'submit', array('label' => $label));

        return $form;
    }
    
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH) {
        if(!is_null($this->router_))
            $route = $this->getRouter_()->generate($route, $parameters, $referenceType);
        else
            $route = parent::generateUrl($route, $parameters, $referenceType);
        return $route;
    }
    
    /**
     * Get controller name
     */
    public function getControllerName($request = null) {
        if(!is_null($this->request_))
            $request = $this->getRequest();
        $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
        $matches = array();
        preg_match($pattern, $request->get('_controller'), $matches);

        return $matches[1];
    }

    /**
     * Get action name 
     */
    public function getActionName($request = null) {
        if(!is_null($this->request_))
            $request = $this->getRequest();
        $pattern = "#::([a-zA-Z]*)Action#";
        $matches = array();
        preg_match($pattern, $request->get('_controller'), $matches);

        return $matches[1];
    }
    
    /**
     * Encode
     * 
     * @param   mixed   $data   Dato a codificar
     * @param   mixed   $key    Llave
     */

    public function encode($data, $key = null) {
        return str_replace('=', '', base64_encode($data));
    }

    /**
     * Decode
     * 
     * @param   mixed   $data   Dato a decodificar
     * @param   mixed   $key    Llave
     */

    public function decode($data, $key = null) {
        return base64_decode($data);
    }

    public function dump($var, $pre = true, $die = true) {
        if(is_bool($pre) && $pre){
            echo '<pre>';
        }
//        if (is_array($var))
//            foreach($var as $v){
//                var_dump($v);
//            }
//        else
            var_dump($var);
        if(is_bool($pre) && $pre){
            echo '</pre>';
        }
        if (is_bool($die) && $die)
            die;
    }
    /**
     * get Query Filter
     * 
     * Arma la consulta del Filtro con base en las columnas, para la vista cuando cada columna tiene un campo para filtrar.
     * Soporta búsqueda por varios campos y varias búsquedas e el mismo campo.
     * 
     * @param   array           $data
     * @param   array           $columnas
     * @param   QueryBuilder    $qb
     * 
     * @return string $str_query
     */
    public function getQueryFilter($data, array $columnas = array(), $qb = null) {
        $l = count($columnas)-1;
        $i = 0;
        $str_query = '';
        foreach($columnas as $col){
            $col_name = str_replace(array(' ','-'), '', $col['dato']);
            if(!isset($data[$col_name]) && isset($col['label']))
                $col_name = str_replace(array(' ','-'), '', $col['label']);
            if (array_key_exists($col_name, $data)){
                $data_bd = strtolower(substr($col['dato'], 0, 1)).substr($col['dato'], 1);
                $data_bd = str_replace(' ','',$data_bd);
                $data_bd = str_replace('-','',$data_bd);
                $data[$col_name] = trim($data[$col_name]);
                if (strlen($data[$col_name])>0){
                    $letra = 'a';
                    if(isset($col['join']) && !empty($col['join'])){
                        $join = $col['join'];
                        if(is_string($join) && strlen($join) < 2)
                            $letra = $join;
                        elseif(!is_null($qb) && !empty ($qb) && is_string($join)){
                            $letra = strtolower(substr($join, 0,4));
                            $qb->innerJoin('a.'.$join, $letra);
                        }
                    }
                    $letra .= '.';
                    if($i > 0 && $i < $l)
                        $str_query .= ' AND ';
                    $col_datos = explode(',', $data[$col_name]);
                    $count = count($col_datos)-1;
                    if($count >= 1){
//                        $str_query .= '(';
                        foreach($col_datos as $j => $cd){
                            $str_operacion = "LIKE";
                            if($j > 0 && $j <= $count)
                                $str_query .= ' AND ';
                            $query = $letra.$data_bd." ?operacion? '%".$cd."%'";
//                            if(is_numeric($data[$col_name])){
//                                $str_operacion = '=';
//                                $str_query = str_replace(array("'","%"),'',$str_query);
//                            }
                            $str_query .= str_replace('?operacion?', $str_operacion, $query);
                        }
//                        $str_query .= ')';
                    }else{
                        $str_operacion = "LIKE";
                        $query = $letra.$data_bd." ?operacion? '%".$data[$col_name]."%'";
//                        if(is_numeric($data[$col_name])){
//                            $str_operacion = '=';
//                            $str_query = str_replace(array("'","%"),'',$str_query);
//                        }
                        $str_query .= str_replace('?operacion?', $str_operacion, $query);
                    }
                    $i++;
                }
            }
        }
        return $str_query;
    }
    
    /**
     * get Head Filtro
     * 
     * Construye el head de la tabla con filtros, uno por cada columna de la tabla.\n
     * Las clumnas pueden contener datos para saber que dicha columna necesita un JOIN. 
     * El dato que consulta lo busca en $fils[n]['col'][m]['join']; donde n y m son numeros enteros que referencian la n fila y m columna.
     * 
     * @param   FormBuilder     $form
     * @param   String          $route
     * @param   QueryBuilder    $qb
     * @param   array           $fils
     * 
     * @return array Head con formulario de campos y ['filtros']
     */
    public function getHeadFiltro($fils,  \Symfony\Component\Form\FormBuilder $form, $route){
        $head['fil'] = $fils;
        foreach($head['fil'][0]['col'] as $col){
            if(!isset($col['acciones'])){
                $n = $col['dato'];
//                if($form->has($n) && isset($col['label']))
//                    $n = $col['label'];
                $form->add(str_replace(' ', '', $n), 'text', 
                    array(
                        'required' => false, 
                        'label' =>false,
                        'attr' => array('class' => 'form-control'),
                    )
                );
            }
        }
        $form->add('Buscar', 'submit',
            array(
                    'label'=> ' Buscar',
                    'attr' => array('class' => 'btn btn-success btn-lg glyphicon glyphicon-search')
                )
            )
            ->setAction($this->generateUrl($route));
        $form = $form->getForm();
        $head['filtros'] = $form;
        return $head;
    }
    
    /**/
    public function normaliza ($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return str_replace(' ', '-', utf8_encode($cadena));
    }
}

