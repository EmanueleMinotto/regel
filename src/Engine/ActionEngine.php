<?php

namespace Pragmatist\Regel\Engine;

use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\ConditionEvaluator;
use Pragmatist\Regel\Rule\Rule;
use Pragmatist\Regel\RuleSetProvider\RuleSetProvider;

final class ActionEngine implements Engine
{
    /**
     * @var RuleSetProvider
     */
    private $ruleSetProvider;

    /**
     * @var ConditionEvaluator
     */
    private $conditionEvaluator;

    /**
     * @var ActionExecutor
     */
    private $actionExecutor;

    /**
     * @param RuleSetProvider $ruleSetProvider
     * @param ConditionEvaluator $conditionEvaluator
     * @param ActionExecutor $actionExecutor
     */
    public function __construct(
        RuleSetProvider $ruleSetProvider,
        ConditionEvaluator $conditionEvaluator,
        ActionExecutor $actionExecutor
    ) {
        $this->ruleSetProvider = $ruleSetProvider;
        $this->conditionEvaluator = $conditionEvaluator;
        $this->actionExecutor = $actionExecutor;
    }

    /**
     * @param string $ruleSetIdentifier
     * @param mixed $subject
     */
    public function applyRuleSetToSubject($ruleSetIdentifier, $subject)
    {
        $ruleSet = $this->ruleSetProvider->ruleSetIdentifiedBy($ruleSetIdentifier);
        foreach ($ruleSet as $rule) {
            if (!$this->applyRuleToSubject($rule, $subject)) {
                break;
            }
        }
    }

    /**
     * @param Rule $rule
     * @param mixed $subject
     * @return bool
     */
    private function applyRuleToSubject(Rule $rule, $subject)
    {
        if (!$this->conditionEvaluator->evaluate($rule->condition(), $subject)) {
            return false;
        }

        $this->actionExecutor->execute($rule->action(), $subject);
        return true;
    }
}
