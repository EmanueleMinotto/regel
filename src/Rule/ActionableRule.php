<?php

namespace Pragmatist\Regel\Rule;

use Pragmatist\Regel\Action\Action;
use Pragmatist\Regel\Condition\Condition;

final class ActionableRule implements Rule
{
    /**
     * @var Condition
     */
    private $condition;

    /**
     * @var Action
     */
    private $action;

    /**
     * @param Condition $condition
     * @param Action $action
     */
    public function __construct(Condition $condition, Action $action)
    {
        $this->condition = $condition;
        $this->action = $action;
    }

    /**
     * @return Condition
     */
    public function condition()
    {
        return $this->condition;
    }

    /**
     * @return Action
     */
    public function action()
    {
        return $this->action;
    }
}
