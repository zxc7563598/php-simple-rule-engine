<?php

namespace Hejunjie\SimpleRuleEngine\Operators;

use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;

class NotBetweenOperator implements OperatorInterface
{
    /**
     * 评估方法
     * 
     * @param mixed $fieldValue 用户输入数据
     * @param mixed $ruleValue 对比数据
     * 
     * @return bool 
     */
    public function evaluate(mixed $fieldValue, mixed $ruleValue): bool
    {
        [$min, $max] = array_map('floatval', $ruleValue);
        $fieldValue = (float)$fieldValue;
        return !($fieldValue >= $min && $fieldValue <= $max);
    }

    /**
     * 操作符名称
     * 
     * @return string 
     */
    public function name(): string
    {
        return 'not_between';
    }
}
