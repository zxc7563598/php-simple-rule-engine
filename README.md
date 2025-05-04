# hejunjie/simple-rule-engine

<div align="center">
  <a href="./README.md">English</a>｜<a href="./README.zh-CN.md">简体中文</a>
  <hr width="50%"/>
</div>

A lightweight and flexible PHP rule engine supporting complex conditions and dynamic rule execution—ideal for business logic evaluation and data validation.

---

## 🧠 Purpose & Intent

When writing PHP on a daily basis, we often encounter "conditional" business logic, such as:

- Does a certain user meet a specific condition?
- Does the current order qualify for a promotional event?
- Does a particular piece of data require further processing?

These types of logic are simple at first, just a series of if, and, or statements. But when you start dealing with 5, 10, or even dozens of conditions all tangled together, things can quickly get messy.

At first, it’s manageable, but after a while, adding, changing, or removing conditions starts to feel like defusing a bomb. Forget about handing it off to someone else – even you, two weeks later, will look at it and cringe.

So, I spent some time developing this PHP Composer package with the goal of organizing these conditional checks in a clearer, more flexible way. The idea is to make the logic more structured and easier to reuse.

---

## ✨ Features

- **Easy to Use**: Quickly build rules with an intuitive API, supporting AND/OR combination logic.
- **Highly Extensible**: Includes common built-in operators and supports a custom operator registration mechanism to meet diverse business needs.
- **Flexible Data Structures**: Decouples rules from data, supporting multiple data formats such as arrays and objects.
- **Detailed Rule Evaluation**: Allows access to the evaluation results of each rule, making debugging and logging easier.

---

## 📦 Installation

Install via Composer:

```bash
composer require hejunjie/simple-rule-engine
```

---

## 🛠️ Usage Examples

```php
use Hejunjie\SimpleRuleEngine\Rule;
use Hejunjie\SimpleRuleEngine\Engine;

// Define Rules
$rules = [
    new Rule('age', '>=', 18, 'Age must be greater than or equal to 18'),
    new Rule('country', '==', 'SG', 'Country must be Singapore'),
];

// Data to be evaluated
$data = [
    'age' => 20,
    'country' => 'SG',
];

// Evaluation Result
$result = Engine::evaluate($rules, $data, 'AND'); // Return true or false

// Get Detailed Evaluation Information
$details = Engine::evaluateWithDetails($rules, $data);
/*
Return Example:
[
    ['description' => 'Age must be greater than or equal to 18', 'passed' => true],
    ['description' => 'Country must be Singapore', 'passed' => true],
]
*/
```

---

## 🧩 Built-in Operators

| Operator         | Description                | Additional Notes                                      |
| ---------------- | -------------------------- | ----------------------------------------------------- |
| ​`==`​           | Equal to                   | None                                                  |
| ​`!=`​           | Not equal to               | None                                                  |
| ​`>`​            | Greater than               | None                                                  |
| ​`>=`​           | Greater than or equal to   | None                                                  |
| ​`<`​            | Less than                  | None                                                  |
| ​`<=`​           | Less than or equal to      | None                                                  |
| ​`in`​           | In a set                   | Array: [item1, item2, ...]                            |
| ​`not_in`​       | Not in a set               | Array: [item1, item2, ...]                            |
| ​`contains`​     | Contains substring         | None                                                  |
| ​`not_contains`​ | Does not contain substring | None                                                  |
| ​`start_swith`​  | Starts with                | None                                                  |
| ​`end_swith`​    | Ends with                  | None                                                  |
| ​`between`​      | Within range               | Array: [min, max]                                     |
| ​`not_between`​  | Outside range              | Array: [min, max]                                     |
| ​`before_date`​  | Date is before             | Supports any common date format, including timestamps |
| ​`after_date`​   | Date is after              | Supports any common date format, including timestamps |
| ​`date_equal`​   | Date is equal to           | Supports any common date format, including timestamps |

You can also add custom operators through the registration mechanism.

---

## 🔌 Custom Operators

Implement the `OperatorInterface` and register through `OperatorFactory`.

```php
use Hejunjie\SimpleRuleEngine\Interface\OperatorInterface;
use Hejunjie\SimpleRuleEngine\OperatorFactory;

class CustomizeOperator implements OperatorInterface
{
    /**
     * Evaluation Method
     *
     * @param mixed $fieldValue field Value
     * @param mixed $ruleValue rule Value
     *
     * @return bool
     */
    public function evaluate(mixed $fieldValue, mixed $ruleValue): bool
    {
        // TODO: Implement the evaluation logic
    }

    /**
     * Operator Name
     *
     * @return string
     */
    public function name(): string
    {
        return 'customize';
    }
}

// Register custom operator with customize
$factory = OperatorFactory::getInstance();
$factory->register(new CustomizeOperator());

// You can use customize when defining rules
$rules = [
    new Rule('field', 'customize', 'value', 'Custom rule description'),
    ...
    ...
];

```

---

## 🎯 Use Cases

- **Form Data Validation**: Dynamically validate field values based on user input.
- **Business Rule Evaluation**: Apply rules for scenarios like order processing, access control, etc.
- **Data Filtering and Selection**: Filter datasets based on predefined rules.
- **Config-Driven Logic Control**: Define rules via configuration files to enable flexible business logic.

---

## 🔧 Additional Toolkits (Can be used independently or installed together)

This project was originally extracted from [hejunjie/tools](https://github.com/zxc7563598/php-tools).
To install all features in one go, feel free to use the all-in-one package:

```bash
composer require hejunjie/tools
```

Alternatively, feel free to install only the modules you need：

[hejunjie/utils](https://github.com/zxc7563598/php-utils) - A lightweight and practical PHP utility library that offers a collection of commonly used helper functions for files, strings, arrays, and HTTP requests—designed to streamline development and support everyday PHP projects.

[hejunjie/cache](https://github.com/zxc7563598/php-cache) - A layered caching system built with the decorator pattern. Supports combining memory, file, local, and remote caches to improve hit rates and simplify cache logic.

[hejunjie/china-division](https://github.com/zxc7563598/php-china-division) - Regularly updated dataset of China's administrative divisions with ID-card address parsing. Distributed via Composer and versioned for use in forms, validation, and address-related features

[hejunjie/error-log](https://github.com/zxc7563598/php-error-log) - An error logging component using the Chain of Responsibility pattern. Supports multiple output channels like local files, remote APIs, and console logs—ideal for flexible and scalable logging strategies.

[hejunjie/mobile-locator](https://github.com/zxc7563598/php-mobile-locator) - A mobile number lookup library based on Chinese carrier rules. Identifies carriers and regions, suitable for registration checks, user profiling, and data archiving.

[hejunjie/address-parser](https://github.com/zxc7563598/php-address-parser) - An intelligent address parser that extracts name, phone number, ID number, region, and detailed address from unstructured text—perfect for e-commerce, logistics, and CRM systems.

[hejunjie/url-signer](https://github.com/zxc7563598/php-url-signer) - A PHP library for generating URLs with encryption and signature protection—useful for secure resource access and tamper-proof links.

[hejunjie/google-authenticator](https://github.com/zxc7563598/php-google-authenticator) - A PHP library for generating and verifying Time-Based One-Time Passwords (TOTP). Compatible with Google Authenticator and similar apps, with features like secret generation, QR code creation, and OTP verification.

[hejunjie/simple-rule-engine](https://github.com/zxc7563598/php-simple-rule-engine) - A lightweight and flexible PHP rule engine supporting complex conditions and dynamic rule execution—ideal for business logic evaluation and data validation.

👀 All packages follow the principles of being lightweight and practical — designed to save you time and effort. They can be used individually or combined flexibly. Feel free to ⭐ star the project or open an issue anytime!

---

This library will continue to be updated with more practical features. Suggestions and feedback are always welcome — I’ll prioritize new functionality based on community input to help improve development efficiency together.
