<?php

namespace fkrzski\Validator;

use fkrzski\Validator\Exceptions\InvalidRuleException;

class Validator {
    /**
     * Variables to validation
     * 
     * @var array
     */
    protected array $variables;

    /**
     * Validation rules
     * 
     * @var array
     */
    protected $rules;

    /**
     * Available validation rules
     * 
     * @var array
     */
    protected const AVAILABLE_RULES = [
        'required',
        'string',
        'integer',
        'float',
        'boolean',
        'array'
    ];

    /**
     * Run new Validator instance
     * 
     * @param array $variables Variables to validation
     * @param array $rules     Validation rules
     * 
     * @return void
     */
    public function __construct(array $variables, array $rules) {
        $this->variables = $variables;
        $this->rules     = $this->resolveValidationRules($rules);
    }

    /**
     * Create new Validator object
     * 
     * @param array $variables Variables to validation
     * @param array $rules     Validation rules
     */
    public static function create(array $variables, array $rules) {
        return new Validator($variables, $rules);
    }

    /**
     * Check if validation rules are correct
     * 
     * @param array  $rules Validation rules for specific variable
     * @param string $name  Validated variable name
     * 
     * @throws fkrzski\Validator\Exceptions\InvalidRuleException
     * 
     * @return void
     */
    protected function checkRules($rules, $variable) {
        foreach ($rules as $key => $value) {
            if (!in_array($value, Validator::AVAILABLE_RULES)) {
                throw new InvalidRuleException(sprintf("Invalid Validator rule in: %s => %s", $variable, $value));
            };
        }
    }
    
    /**
     * Resolve a string of rules into an array
     * 
     * @param array $rules Validation rules
     * 
     * @return array
     */
    protected function resolveValidationRules($rules) {
        foreach ($rules as $key => $value) {
            $rules[$key] = explode('|', $value);
            $this->checkRules($rules[$key], $key);
        }
        return $rules;
    }
}