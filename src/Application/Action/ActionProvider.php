<?php

namespace CakeParser\Application\Action;

use CakeParser\Application\Request\Request;
use Psr\Container\ContainerInterface;

/**
 * Class ActionProvider
 * @package CakeParser\Application\Action
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ActionProvider
{
    private $container;

    /**
     * ActionProvider constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param $notFoundClass
     * @return BaseAction
     */
    public function findAction(Request $request, $notFoundClass) : BaseAction {

        /** @var ActionInterface[] $actions */
        $actions = $this->container->get('action');

        foreach ($actions as $action) {
            if (strpos($request->getRequestUri(), $action->getId()) === 1) {
                $action->applyRequest($request);
                return $action;
            }
        }

        return new $notFoundClass;
    }
}