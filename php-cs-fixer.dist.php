<?php

$finder = (new PhpCsFixer\Finder())->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
        'blank_line_after_opening_tag' => false,
        'blank_line_before_statement' => [
            'statements' => [
                'case',
                'default',
                'do',
                'for',
                'foreach',
                'if',
                'switch',
                'throw',
                'try',
                'while',
            ],
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
        ],
        'increment_style' => false,
        'linebreak_after_opening_tag' => false,
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_to_comment' => [
            'ignored_tags' => [
                'var',
                'phpstan-ignore-next-line',
            ],
        ],
        'visibility_required' => [
            'elements' => [
                'property',
                'method',
            ],
        ],
        'yoda_style' => false,
    ]);
