<?php

namespace Hejunjie\SimpleRuleEngine\Operators;

use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;

class StartsWithOperator implements OperatorInterface
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
        return str_starts_with($fieldValue, $ruleValue);
    }

    /**
     * 操作符名称
     * 
     * @return string 
     */
    public function name(): string
    {
        return 'start_swith';
    }
}
