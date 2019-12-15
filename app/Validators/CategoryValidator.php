<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class CategoryValidator.
 */
class CategoryValidator extends LaravelValidator
{
    /**
     * Validation Rules.
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required|unique_translation:categories,title',
            'title.*' => 'required|min:3',
            'description.*' => 'sometimes|min:10',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'required|unique_translation:categories,title',
            'title.*' => 'required|min:3',
            'description.*' => 'sometimes|min:10',
        ],
    ];

    /**
     * @var array
     */
    protected $messages = [
        'title.unique_translation' => 'The :attribute has already been taken.',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'description.*' => 'description',
        'title.*' => 'title',
    ];
}
