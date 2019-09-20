<?php

namespace CakeParser\Application;


use CakeParser\Application\Action\ActionProvider;
use CakeParser\Application\Request\Request;

class WebApplication extends BaseApplication implements ApplicationInterface
{

    private $result;

    public function run(): ApplicationInterface
    {
        $this->initContainer();

        $actionsProvider = $this->getActionsProvider();

        $request = $this->getRequest();

        $action = $actionsProvider->findAction($request, Action404::class);

        $this->result = $action->run();

        return $this;
    }

    public function send()
    {

        $result = $this->result;
        $result();
    }

    /**
     * @return ActionProvider
     */
    private function getActionsProvider()
    {
        return $this->container->get(ActionProvider::class);
    }

    private function getRequest()
    {
        return $this->container->get(Request::class);
    }

}