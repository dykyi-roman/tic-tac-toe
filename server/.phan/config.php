<?php

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 */
return [
    'target_php_version' => null,

    'inherit_phpdoc_types' => true,

    'read_magic_property_annotations' => true,
    'read_magic_method_annotations' => true,
    'read_type_annotations' => true,

    'directory_list' => [
        'src',
        'vendor'
    ],

    'exclude_analysis_directory_list' => [
        'vendor/',
        'var/',
        'web/',
    ],

    'plugins' => [ 
        'AlwaysReturnPlugin',
        'UnreachableCodePlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin'
    ],

    'whitelist_issue_types' => [],
];
