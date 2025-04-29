<?php

namespace Hejunjie\SimpleRuleEngine;

class RuleGroup
{
    /** @var Rule[] */
    public array $rules = [];
    public string $relation = 'AND'; // or 'OR'

    /**
     * 规则组
     * 
     * @param array $rules 规则列表
     * @param string $relation 比对策略 「AND:严格模式、全部通过则通过」「OR:宽松模式、全部拒绝则拒绝」
     * 
     * @return void 
     */
    public function __construct(array $rules, string $relation = 'AND')
    {
        $this->rules = $rules;
        $this->relation = strtoupper($relation);
    }

    /**
     * 评估规则组并返回结果
     * 
     * @param array $data 评估数据
     * 
     * @return bool 
     */
    public function evaluate(array $data): bool
    {
        $results = array_map(fn($rule) => $rule->evaluate($data), $this->rules);
        return $this->relation === 'AND'
            ? !in_array(false, $results, true)
            : in_array(true, $results, true);
    }

    /**
     * 评估规则组并返回详细信息
     * 
     * @param array $data 评估数据
     * 
     * @return array 
     */
    public function evaluateWithDetails(array $data): array
    {
        $result = [];
        foreach ($this->rules as $rule) {
            $result[] = [
                'description' => $rule->getDescription(),
                'passed' => $rule->evaluate($data)
            ];
        }
        return $result;
    }
}
