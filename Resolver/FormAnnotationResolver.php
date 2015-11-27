<?php

/*
 * This file is part of the ControllerExtraBundle for Symfony2.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace Mmoreram\ControllerExtraBundle\Resolver;

use Mmoreram\ControllerExtraBundle\ValueObject\FormRouteAttributes;
use ReflectionMethod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\HttpFoundation\Request;

use Mmoreram\ControllerExtraBundle\Annotation\Abstracts\Annotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Mmoreram\ControllerExtraBundle\Resolver\Abstracts\AbstractAnnotationResolver;
use Mmoreram\ControllerExtraBundle\Resolver\Interfaces\AnnotationResolverInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * FormAnnotationResolver, an implementation of  AnnotationResolverInterface
 */
class FormAnnotationResolver extends AbstractAnnotationResolver implements AnnotationResolverInterface
{
    /**
     * @var FormRegistryInterface
     *
     * FormRegistry
     */
    protected $formRegistry;

    /**
     * @var FormRegistryInterface
     *
     * FormRegistry
     */
    protected $formFactory;

    /**
     * @var RouterInterface
     *
     * Router
     */
    protected $router;

    /**
     * @var string
     *
     * Default field name
     */
    protected $defaultName;

    /**
     * @var FormRouteAttributes
     *
     * Route attributes
     */
    protected $routeAttributes;

    /**
     * Construct method
     *
     * @param FormRegistryInterface $formRegistry Form Registry
     * @param FormFactoryInterface  $formFactory  Form Factory
     * @param string                $defaultName  Default name
     */
    public function __construct(
        FormRegistryInterface $formRegistry,
        FormFactoryInterface $formFactory,
        $defaultName
    ) {
        $this->formRegistry = $formRegistry;
        $this->formFactory = $formFactory;
        $this->defaultName = $defaultName;
    }

    /**
     * Specific annotation evaluation.
     *
     * @param Request          $request    Request
     * @param Annotation       $annotation Annotation
     * @param ReflectionMethod $method     Method
     *
     * @return FormAnnotationResolver self Object
     */
    public function evaluateAnnotation(
        Request $request,
        Annotation $annotation,
        ReflectionMethod $method
    ) {
        /**
         * Annotation is only laoded if is typeof WorkAnnotation
         */
        if ($annotation instanceof AnnotationForm) {

            /**
             * Once loaded Annotation info, we just instanced Service name
             */
            $annotationValue = $annotation->getClass();

            /**
             * Get FormType object given a service name
             */
            $type = class_exists($annotationValue)
                ? new $annotationValue()
                : $this
                    ->formRegistry
                    ->getType($annotationValue)
                    ->getInnerType();

            /**
             * Get the parameter name. If not defined, is set as $form
             */
            $parameterName = $annotation->getName() ?: $this->defaultName;
            $parameterClass = $this->getParameterType(
                $method,
                $parameterName,
                'Symfony\\Component\\Form\\FormInterface'
            );

            $this->routeAttributes = new FormRouteAttributes();
            $this->routeAttributes
                ->setMethod($annotation->getMethod())
                ->setName($annotation->getRouteName())
                ->setParameters($annotation->getRouteParameters());

            /**
             * Requiring result with calling getBuiltObject(), set as request
             * attribute desired element
             */
            $request->attributes->set(
                $parameterName,
                $this->getBuiltObject(
                    $request,
                    $this->formFactory,
                    $annotation,
                    $parameterClass,
                    $type
                )
            );
        }

        return $this;
    }

    /**
     * Set router
     *
     * @param RouterInterface $router Router service
     *
     * @return FormAnnotationResolver
     */
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Built desired object.
     *
     * @param Request              $request        Request
     * @param FormFactoryInterface $formFactory    Form Factory
     * @param AnnotationForm       $annotation     Annotation
     * @param string               $parameterClass Class type of  method parameter
     * @param AbstractType         $type           Built Type object
     *
     * @return Mixed object to inject as a method parameter
     */
    protected function getBuiltObject(
        Request $request,
        FormFactoryInterface $formFactory,
        AnnotationForm $annotation,
        $parameterClass,
        AbstractType $type
    ) {
        /**
         * Checks if parameter typehinting is AbstractType
         * In this case, form type as defined method parameter
         */
        if ('Symfony\\Component\\Form\\AbstractType' == $parameterClass) {
            return $type;
        }

        $entity = $request->attributes->get($annotation->getEntity());

        /**
         * Creates form object from type
         */
        $form = $formFactory->create($type, $entity, $this->getFormOptions($request));

        /**
         * Handling request if needed
         */
        if ($annotation->getHandleRequest()) {
            $form->handleRequest($request);

            if ($annotation->getValidate()) {
                $request->attributes->set(
                    $annotation->getValidate(),
                    $form->isValid()
                );
            }
        }

        /**
         * Checks if parameter typehinting is Form
         * In this case, inject form as defined method parameter
         */
        if (in_array(
            $parameterClass, array(
                'Symfony\\Component\\Form\\Form',
                'Symfony\\Component\\Form\\FormInterface',
            )
        )) {
            return $form;
        }

        /**
         * Checks if parameter typehinting is FormView
         * In this case, inject form's view as defined method parameter
         */
        if ('Symfony\\Component\\Form\\FormView' == $parameterClass) {
            return $form->createView();
        }
    }

    /**
     * Built form builder options.
     *
     * @param Request             $request    Request
     *
     * @return array
     */
    protected function getFormOptions(Request $request) {
        $options = array();
        if (null !== $this->router && null !== $this->routeAttributes->getName()) {
            $routeParameters = array();
            foreach ($this->routeAttributes->getParameters() as $parameterName => $parameterValue) {
                if (is_array($parameterValue)) {
                    if (array_key_exists('entity', $parameterValue) && array_key_exists('method', $parameterValue)) {
                        $entity = $request->attributes->get($parameterValue['entity']);
                        $method = $parameterValue['method'];
                        if (is_callable(array($entity, $method))) {
                            $routeParameters[$parameterName] = $entity->$method();
                        }
                    }
                } else {
                    $routeParameters[$parameterName] = $parameterValue;
                }
            }
            $options['action'] = $this->router->generate($this->routeAttributes->getName(), $routeParameters);
        }
        $options['method'] = $this->routeAttributes->getMethod();

        return $options;
    }
}
