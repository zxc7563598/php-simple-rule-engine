# hejunjie/simple-rule-engine

一个轻量、易用的 PHP 规则引擎，支持多条件组合与动态规则执行，适用于业务规则判断、数据校验等场景。

---

## 🧠 用途 & 初衷

日常写 PHP 的时候，我们经常会遇到一类“判断性”的业务逻辑，比如：

- 某个用户是否符合某个条件？
- 当前订单是否满足参加活动的资格？
- 某条数据是否需要做进一步处理？

这些逻辑写起来很简单，就是一个又一个的 if、and、or，但当你遇到 5 条、10 条甚至几十条判断条件混在一起逐渐变得越来越多....

一开始还能接受，后来每次加条件、改条件、删条件都像拆炸弹，别说别人接手了，连你自己两周后回来看都要皱眉。

于是我花了一些时间，写了这个 PHP Composer 包，它的目标是：用更清晰、更灵活的方式去组织这些判断条件，让判断逻辑更结构化，也更容易复用。

---

## ✨ 特点

- **简单易用**：通过直观的 API 快速构建规则，支持 AND / OR 组合逻辑。
- **高度可扩展**：内置常用操作符，支持自定义操作符注册机制，满足多样化业务需求。
- **灵活的数据结构**：规则与数据解耦，支持数组、对象等多种数据形式。
- **详细的规则评估**：可获取每条规则的评估结果，便于调试与日志记录。

---

## 📦 安装

使用 Composer 安装：

```bash
composer require hejunjie/simple-rule-engine
```

---

## 🛠️ 用法示例

```php
use Hejunjie\SimpleRuleEngine\Rule;
use Hejunjie\SimpleRuleEngine\Engine;

// 定义规则
$rules = [
    new Rule('age', '>=', 18, '年龄必须大于等于18岁'),
    new Rule('country', '==', 'SG', '国家必须是新加坡'),
];

// 待评估的数据
$data = [
    'age' => 20,
    'country' => 'SG',
];

// 评估结果
$result = Engine::evaluate($rules, $data, 'AND'); // 返回 true 或 false

// 获取详细评估信息
$details = Engine::evaluateWithDetails($rules, $data);
/*
返回示例：
[
    ['description' => '年龄必须大于等于18岁', 'passed' => true],
    ['description' => '国家必须是新加坡', 'passed' => true],
]
*/
```

---

## 🧩 内置操作符

| 操作符           | 描述             | 额外说明                         |
| ---------------- | ---------------- | -------------------------------- |
| ​`==`​           | 等于             | 无                               |
| ​`!=`​           | 不等于           | 无                               |
| ​`>`​            | 大于             | 无                               |
| ​`>=`​           | 大于等于         | 无                               |
| ​`<`​            | 小于             | 无                               |
| ​`<=`​           | 小于等于         | 无                               |
| ​`in`​           | 包含于集合中     | 数组：[内容 1,内容 2,...]        |
| ​`not_in`​       | 不包含于集合中   | 数组：[内容 1,内容 2,...]        |
| ​`contains`​     | 包含字符串       | 无                               |
| ​`not_contains`​ | 不包含字符串     | 无                               |
| ​`start_swith`​  | 以指定字符串开头 | 无                               |
| ​`end_swith`​    | 以指定字符串结尾 | 无                               |
| ​`between`​      | 在指定范围内     | 数组：[最大值,最小值]            |
| ​`not_between`​  | 不在指定范围内   | 数组：[最大值,最小值]            |
| ​`before_date`​  | 日期早于         | 任意常规日期格式，包括时间戳均可 |
| ​`after_date`​   | 日期晚于         | 任意常规日期格式，包括时间戳均可 |
| ​`date_equal`​   | 日期相等         | 任意常规日期格式，包括时间戳均可 |

你也可以通过注册机制添加自定义操作符。

---

## 🔌 自定义操作符

实现 `OperatorInterface`​ 接口，并通过 `OperatorFactory`​ 注册：

```php
use Hejunjie\SimpleRuleEngine\Operators\OperatorInterface;
use Hejunjie\SimpleRuleEngine\OperatorFactory;

class CustomizeOperator implements OperatorInterface
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
        // TODO: 实现判断逻辑
    }

    /**
     * 操作符名称
     *
     * @return string
     */
    public function name(): string
    {
        return 'customize';
    }
}

// 注册自定义操作符 customize
$factory = OperatorFactory::getInstance();
$factory->register(new CustomizeOperator());

// 可以在定义规则时使用 customize
$rules = [
    new Rule('field', 'customize', 'value', '自定义规则描述'),
    ...
    ...
];

```

---

## 🎯 应用场景

- **表单数据验证**：根据用户输入动态验证字段值。
- **业务规则判断**：如订单处理、权限控制等。
- **数据过滤与筛选**：根据规则筛选符合条件的数据集。
- **配置驱动的逻辑控制**：通过配置文件定义规则，实现灵活的业务逻辑。

---

## 🔧 更多工具包（可独立使用，也可统一安装）

本项目最初是从 [hejunjie/tools](https://github.com/zxc7563598/php-tools) 拆分而来，如果你想一次性安装所有功能组件，也可以使用统一包：

```bash
composer require hejunjie/tools
```

当然你也可以按需选择安装以下功能模块：

[hejunjie/cache](https://github.com/zxc7563598/php-cache) - 多层缓存系统，基于装饰器模式。

[hejunjie/china-division](https://github.com/zxc7563598/php-china-division) - 中国省市区划分数据包。

[hejunjie/error-log](https://github.com/zxc7563598/php-error-log) - 责任链日志上报系统。

[hejunjie/utils](https://github.com/zxc7563598/php-utils) - 常用工具方法集合。

[hejunjie/address-parser](https://github.com/zxc7563598/php-address-parser) - 收货地址智能解析工具，支持从非结构化文本中提取用户/地址信息。

[hejunjie/mobile-locator](https://github.com/zxc7563598/php-mobile-locator) - 国内手机号归属地 & 运营商识别。

[hejunjie/url-signer](https://github.com/zxc7563598/php-url-signer) - URL 签名工具，支持对 URL 进行签名和验证。

[hejunjie/google-authenticator](https://github.com/zxc7563598/php-google-authenticator) - Google Authenticator 及类似应用的密钥生成、二维码创建和 OTP 验证。

👀 所有包都遵循「轻量实用、解放双手」的原则，能单独用，也能组合用，自由度高，欢迎 star 🌟 或提 issue。

---

该库后续将持续更新，添加更多实用功能。欢迎大家提供建议和反馈，我会根据大家的意见实现新的功能，共同提升开发效率。
