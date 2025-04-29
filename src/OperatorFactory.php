<?php

namespace Hejunjie\SimpleRuleEngine;

use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;
use InvalidArgumentException;

class OperatorFactory
{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @var OperatorInterface[]
     */
    protected array $operators = [];

    public function __construct()
    {
        // 自动注册默认操作符
        $this->registerDefaults();
    }

    /**
     * 注册操作符
     * 
     * @param OperatorInterface $operator 操作验证类
     * 
     * @return void 
     */
    public function register(OperatorInterface $operator): void
    {
        $this->operators[$operator->name()] = $operator;
    }

    /**
     * 获取操作符
     * 
     * @param string $name 操作符名称
     * 
     * @return OperatorInterface 
     * @throws InvalidArgumentException 
     */
    public function get(string $name): OperatorInterface
    {
        if (!isset($this->operators[$name])) {
            throw new InvalidArgumentException("Operator [$name] is not supported.");
        }
        return $this->operators[$name];
    }

    /**
     * 默认注册操作符
     * 
     * @return void 
     */
    protected function registerDefaults(): void
    {
        $namespace = 'Hejunjie\\SimpleRuleEngine\\Operators\\';
        $default = [
            'Equal', // 等于
            'NotEqual', // 不等于
            'GreaterThan', // 大于
            'GreaterThanOrEqual', // 大于等于
            'LessThan', // 小于
            'LessThanOrEqual', // 小于等于
            'Contains', // 包含子串
            'NotContains', // 不包含
            'StartsWith', // 开头是...
            'EndsWith', // 结尾是...
            'In', // 存在于数组中
            'NotIn', // 不存在于数组中
            'Between', // 值在范围内
            'NotBetween', // 值不在范围
            'BeforeDate', // 日期早于
            'AfterDate', // 日期晚于
            'DateEqual', // 日期相等
        ];
        foreach ($default as $name) {
            $class = $namespace . $name . 'Operator';
            if (class_exists($class)) {
                $this->register(new $class());
            }
        }
    }
}
