<?php

namespace Hejunjie\SimpleRuleEngine;

use InvalidArgumentException;

class Engine
{
    /**
     * 评估规则并返回结果
     * 
     * @param array $rules 规则信息 [ new Rule('age', '>', 18, '年龄必须大于18'), new Rule('age', '>', 18, '年龄必须大于18') ]
     * @param array $data 数据信息 ['age' => 20, 'sex' => '1']
     * @param string $relation 比对策略 「AND:严格模式、全部通过则通过」「OR:宽松模式、全部拒绝则拒绝」
     * 
     * @return bool 
     * @throws InvalidArgumentException 
     */
    public static function evaluate(array $rules, array $data, string $relation = 'AND'): bool
    {
        foreach ($rules as $r) {
            if (!($r instanceof Rule)) {
                throw new \InvalidArgumentException('Invalid rule format');
            }
        }
        $group = new RuleGroup($rules, $relation);
        return $group->evaluate($data);
    }

    /**
     * 评估规则并返回详细信息
     * 
     * @param array $rules 规则信息 [['field'=>'age', 'operator'>', 'value'=>'18', 'description'=>'年龄必须大于18']]
     * @param array $data 数据信息 ['age' => 20, 'sex' => '1']
     * 
     * @return array 
     * @throws InvalidArgumentException 
     */
    public static function evaluateWithDetails(array $rules, array $data): array
    {
        foreach ($rules as $r) {
            if (!($r instanceof Rule)) {
                throw new \InvalidArgumentException('Invalid rule format');
            }
        }
        $group = new RuleGroup($rules);
        return $group->evaluateWithDetails($data);
    }
}
