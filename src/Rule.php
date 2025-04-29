<?php

namespace Hejunjie\SimpleRuleEngine;

use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;
use InvalidArgumentException;

class Rule
{
    public string $field;
    public string $operatorName;
    public mixed $value;
    public string $description;
    protected OperatorInterface $operator;

    /**
     * 规则函数
     * 
     * @param string $field 规则字段
     * @param string $operatorName 规则操作符
     * @param mixed $value 规则值
     * @param string $description 规则说明
     * 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(string $field, string $operatorName, mixed $value, string $description = '')
    {
        $this->field = $field;
        $this->operatorName = $operatorName;
        $this->value = $value;
        $this->description = $description;
        $factory = OperatorFactory::getInstance();
        $this->operator = $factory->get($this->operatorName);
    }

    /**
     * 获取规则说明
     * 
     * @return string 
     */
    public function getDescription(): string
    {
        return !empty($this->description) ? $this->description : "{$this->field} {$this->operatorName} {$this->value}";
    }

    /**
     * 评估规则
     * 
     * @param array $data 评估数据
     * 
     * @return bool 
     */
    public function evaluate(array $data): bool
    {
        if (!array_key_exists($this->field, $data)) {
            return false;
        }
        return $this->operator->evaluate($data[$this->field], $this->value);
    }
}
