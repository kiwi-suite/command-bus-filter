<?php
/**
 * kiwi-suite/command-bus-validation (https://github.com/kiwi-suite/command-bus-validation)
 *
 * @package kiwi-suite/command-bus-validation
 * @link https://github.com/kiwi-suite/command-bus-validation
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace Ixocreate\CommandBusFilter;

use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\DispatchInterface;
use Ixocreate\Contract\CommandBus\HandlerInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;
use Ixocreate\Filter\Filter;

final class FilterHandler implements HandlerInterface
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * FilterHandler constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param CommandInterface $command
     * @param DispatchInterface $dispatcher
     * @throws \Exception
     * @return ResultInterface
     */
    public function handle(CommandInterface $command, DispatchInterface $dispatcher): ResultInterface
    {
        if (!$this->filter->supports($command)) {
            return $dispatcher->dispatch($command);
        }

        return $dispatcher->dispatch($this->filter->filter($command));
    }
}
