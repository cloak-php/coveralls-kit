<?php

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\FixerInterface;

$fixers = [
    'extra_empty_lines',
    'no_blank_lines_after_class_opening',
    'no_empty_lines_after_phpdocs',
    'operators_spaces',
    'phpdoc_indent',
    'phpdoc_no_empty_return',
    'phpdoc_no_package',
    'phpdoc_params',
    'phpdoc_separation',
    'phpdoc_to_comment',
    'phpdoc_trim',
    'phpdoc_var_without_name',
    'remove_leading_slash_use',
    'remove_lines_between_uses',
    'return',
    'single_array_no_trailing_comma',
    'spaces_before_semicolon',
    'spaces_cast',
    'standardize_not_equal',
    'ternary_spaces',
    'whitespacy_lines',
    'ordered_use',
    'short_array_syntax'
];

$finder = DefaultFinder::create();
$finder->in(__DIR__)
    ->exclude('spec/fixtures');

$config = Config::create()
    ->level(FixerInterface::PSR2_LEVEL)
    ->finder($finder)
    ->fixers($fixers);

return $config;
