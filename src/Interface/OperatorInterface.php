<?php

namespace Hejunjie\SimpleRuleEngine\Interface;

interface OperatorInterface
{
    /**
     * 执行操作符判断逻辑
     */
    public function evaluate(mixed $fieldValue, mixed $ruleValue): bool;

    /**
     * 返回操作符名称（用于匹配规则中声明的 operator）
     */
    public function name(): string;
}
