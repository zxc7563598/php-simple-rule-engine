<?php

namespace Hejunjie\SimpleRuleEngine\Operators;

use Carbon\Carbon;
use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;

class AfterDateOperator implements OperatorInterface
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
        return Carbon::parse($fieldValue)->greaterThan(Carbon::parse($ruleValue));
    }

    /**
     * 操作符名称
     * 
     * @return string 
     */
    public function name(): string
    {
        return 'after_date';
    }
}
