<?php

declare(strict_types=1);

namespace App\Validators;

class Validator
{
    protected array $rules = [];

    protected array $messages = [];

    public function validate(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {

                if (is_array($rule)){
                    $ruleName = $rule['name'];
                    $ruleValue = $rule['value'];

                    if (!$this->$ruleName($ruleName, $ruleValue)) {
                        $errors[$key] = $this->messages[$key][$ruleName];
                    }
                } else {
                    if (!$this->$rule($data[$key])) {
                        $errors[$key] = $this->messages[$key][$rule];
                    }
                }

            }
        }

        return $errors;
    }

    /**
     * Returns true if validated successfully
     *
     * @param $value
     * @return bool
     */
    protected function required($value): bool
    {
        return $value !== null && $value !== '';
    }

    /**
     * @param $value
     * @return bool
     */
    protected function string($value): bool
    {
        return (string)$value === $value;
    }

    /**
     * @param $value
     * @param $max
     * @return bool
     */
    protected function maxLength($value, $max): bool
    {
        return strlen($value) <= $max;
    }
}
