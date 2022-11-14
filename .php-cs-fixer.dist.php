<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'ordered_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'phpdoc_align' => false,
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
        ],
        'linebreak_after_opening_tag' => true,
        'declare_strict_types' => true,
        'mb_str_functions' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'no_php4_constructor' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'allow_unused_params' => false,
            'remove_inheritdoc' => true,
        ],
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'array_indentation' => true,
        'multiline_whitespace_before_semicolons' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->exclude('var')
            ->exclude('assets')
            ->exclude('bin')
            ->exclude('config')
            ->exclude('public')
            ->in(__DIR__)
    );
