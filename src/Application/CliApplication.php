<?php

namespace CakeParser\Application;

use CakeParser\Application\Command\CommandNotFoundException;
use CakeParser\Application\Command\CommandNotFoundInterface;
use CakeParser\Application\Command\CommandProviderInterface;
use CakeParser\Application\Command\ErrorHandlerInterface;
use CakeParser\Application\Console\ConsoleInputInterface;

class CliApplication extends BaseApplication
{
    /**
     * @var callable
     */
    private $result;

    /**
     * @return ApplicationInterface
     * @throws CommandNotFoundInterface
     */
    public function run() : ApplicationInterface
    {
        $this->initContainer();

        $input = $this->getConsoleInput();

        $commandProvider = $this->getCommandProvider();

        try {

            $command = $commandProvider->findCommand($input);

            $this->result = $command->run($input);
        } catch (CommandNotFoundException $exception) {
            $this->result = $this->getErrorHandler()->handle($exception);
        }

        return $this;
    }

    /**
     * @return ConsoleInputInterface
     */
    private function getConsoleInput()
    {
        return $this->container->get(ConsoleInputInterface::class);
    }

    /**
     * @return CommandProviderInterface
     */
    private function getCommandProvider()
    {
        return $this->container->get(CommandProviderInterface::class);
    }

    /**
     * @return ErrorHandlerInterface
     */
    private function getErrorHandler()
    {
        return $this->container->get(ErrorHandlerInterface::class);
    }

    /**
     * @return void
     */
    public function send()
    {
        $res = $this->result;
        $res();
    }
}