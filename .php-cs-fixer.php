<?php

$sourceCodeHeader = <<<'EOF'
This file is part of the {Sim Site Maintenance plugin.

Minimum supported PHP version: 7.4 (also tested on 8.0–8.2).

Design business logic to be testable without WordPress or WooCommerce.
WordPress-specific integration (hooks, options, meta) is tested separately.
Limit WordPress usage to thin integration layers tested separately.

See the PremiumPocket Coding Standards and Testing Guidelines
documentation in this repository for full details.
EOF;

$finder = Symfony\Component\Finder\Finder::create()
    ->exclude([
        'assets',
        'public',
        'bin',
        'build',
        'docs',
        'node_modules',
        'tmp',
        'vendor',
        'wordpress',
        'wp',
    ])
    // Keep bootstrap/entry files unmanaged by the fixer so headers and
    // top-level glue code can be customized if needed.
    ->notPath('sim-site-maintenance.php')
    ->notPath('tests/stubs.php')
    ->notPath('src/inc/stubs/bootstrap.php')
    ->notPath('src/inc/stubs/wp-config.php')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'protected_to_private' => false,

        // Enforce the shared project header defined above.
        'header_comment' => ['header' => $sourceCodeHeader],

        // Basic.
        'braces' => [
            'allow_single_line_closure' => false,
            // Keep anonymous class/closure opening braces on the same line as "function"/"class".
            'position_after_anonymous_constructs' => 'same',
            // PSR-12: place method/class braces on next line for readability.
            'position_after_functions_and_oop_constructs' => 'next',
        ],

        // Casing.
        'class_reference_name_casing' => true,
        'constant_case' => ['case' => 'lower'],

        // Cast Notation.
        'cast_spaces' => true,
        'lowercase_cast' => true,
        'no_short_bool_cast' => true,
        'short_scalar_cast' => true,

        // Class Notation.
        'short_scalar_cast' => true,
        //'class_attributes_separation' => true,
        'class_definition' => true,
        'no_blank_lines_after_class_opening' => true,
        //'no_null_property_initialization' => true,
        'no_php4_constructor' => true,
        // Normalizes order of class elements (properties, methods, constants).
        'ordered_class_elements' => true,
        'ordered_traits' => true,
        'self_accessor' => true,
        'single_class_element_per_statement' => true,
        'single_trait_insert_per_statement' => true,
        'visibility_required' => true,

        // Comment.
        //'multiline_comment_opening_closing' => true,
        'no_empty_comment' => true,
        'no_trailing_whitespace_in_comment' => true,
        'single_line_comment_spacing' => true,
        'single_line_comment_style' => true,

        // Control Structure.
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,
        'elseif' => true,
        'include' => true,
        'no_alternative_syntax' => true,
        'no_superfluous_elseif' => true,
        'no_unneeded_control_parentheses' => true,
        'no_useless_else' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'switch_continue_to_break' => true,
        // Allow trailing commas in multi-line structures for cleaner diffs.
        'trailing_comma_in_multiline' => true,
        'yoda_style' => true,

        // Function Notation.
        // Collapses nested dirname() calls into a single call where possible.
        'combine_nested_dirname' => true,
        'function_typehint_space' => true,
        'implode_call' => true,
        // Removes unused imported variables from closures.
        'lambda_not_used_import' => true,
        // Forces fully-qualified core functions to improve performance/clarity in some setups.
        'native_function_invocation' => true,
        'no_spaces_after_function_name' => true,
        'no_trailing_comma_in_singleline_function_call' => true,
        'no_unreachable_default_argument_value' => true,
        // Ensures nullable types are declared explicitly when default is null.
        'nullable_type_declaration_for_default_null_value' => true,
        'return_type_declaration' => true,
        //'single_line_throw' => true,
        'void_return' => true,

        // Import.
        // Turns unqualified class names into fully qualified ones in strict-types files.
        'fully_qualified_strict_types' => true,
        // Automatically imports classes/functions/constants from global namespace.
        'global_namespace_import' => true,
        'no_leading_import_slash' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,

        // Language Construct.
        //'combine_consecutive_issets' => true,
        //'combine_consecutive_unsets' => true,
        // Converts certain function calls to language constructs/constants when appropriate.
        'function_to_constant' => true,

        // Namespace Notation.
        'blank_line_after_namespace' => true,
        'clean_namespace' => true,
        'no_leading_namespace_whitespace' => true,

        // Operator.
        // Enforce "foo . bar" style for string concatenation.
        'concat_space' => ['spacing' => 'one'],
        'increment_style' => ['style' => 'post'],
        'logical_operators' => true,
        'new_with_braces' => true,
        'no_space_around_double_colon' => true,
        'not_operator_with_space' => true,
        'object_operator_without_whitespace' => true,
        'standardize_increment' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,

        // PHP Tag.
        // Normalizes short echo tags and ensures consistency.
        'echo_tag_syntax' => true,
        //'linebreak_after_opening_tag' => true,
        'no_closing_tag' => true,

        // PHPUnit.
        'php_unit_fqcn_annotation' => true,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_test_annotation' => true,
        'php_unit_test_class_requires_covers' => true,
        // Marks internal PHPUnit tests as @internal where appropriate.
        'php_unit_internal_class' => true,
        // Normalizes PHPUnit assertions to modern APIs where possible.
        'php_unit_construct' => true,

        // PHPDoc.
        'align_multiline_comment' => true,
        'general_phpdoc_annotation_remove' => true,
        'align_multiline_comment' => true,
        'no_empty_phpdoc' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_align' => true,
        'phpdoc_indent' => true,
        // Normalizes single/multi-line PHPDoc layout.
        'phpdoc_line_span' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_package' => true,
        'phpdoc_order_by_value' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_tag_type' => true,
        'phpdoc_to_comment' => true,
        // Trims excessive blank lines inside docblocks.
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => true,
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,

        // Return Notation.
        'no_useless_return' => true,
        'return_assignment' => true,

        // Semicolon.
        'multiline_whitespace_before_semicolons' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'semicolon_after_instruction' => true,
        'space_after_semicolon' => true,

        // Strict.
        //'declare_strict_types' => true,
        //'strict_comparison' => true,
        // Ensures parameter types/usage are compatible with strict typing expectations.
        'strict_param' => true,

        // Whitespace.
        'array_indentation' => true,
        'blank_line_before_statement' => true,
        'blank_line_between_import_groups' => true,
        'compact_nullable_typehint' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'method_chaining_indentation' => true,
        'no_spaces_around_offset' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'single_blank_line_at_eof' => true,
        'statement_indentation' => true,
        'types_spaces' => true,
    ])
    ->setLineEnding("\n")
    ->setIndent(str_repeat(' ', 4)) // Use 4 spaces for indentation.
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
