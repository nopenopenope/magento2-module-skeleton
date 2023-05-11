<?php

error_reporting(error_reporting() & ~E_NOTICE);

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoTrailingCommaInListCallFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();
    $ecsConfig->sets([SetList::PSR_12]);
    $ecsConfig->rule(EregToPregFixer::class);
    $ecsConfig->rule(NoAliasFunctionsFixer::class);
    $ecsConfig->rule(PowToExponentiationFixer::class);
    $ecsConfig->ruleWithConfiguration(NoMixedEchoPrintFixer::class, ['use' => 'echo']);
    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, ['syntax' => 'short']);
    $ecsConfig->rule(NoMultilineWhitespaceAroundDoubleArrowFixer::class);
    $ecsConfig->rule(NormalizeIndexBraceFixer::class);
    $ecsConfig->rule(NoWhitespaceBeforeCommaInArrayFixer::class);
    $ecsConfig->rule(TrailingCommaInMultilineFixer::class);
    $ecsConfig->rule(TrimArraySpacesFixer::class);
    $ecsConfig->rule(WhitespaceAfterCommaInArrayFixer::class);
    $ecsConfig->ruleWithConfiguration(BracesFixer::class, ['allow_single_line_closure' => true]);
    $ecsConfig->rule(EncodingFixer::class);
    $ecsConfig->rule(NonPrintableCharacterFixer::class);
    $ecsConfig->rule(LowerCaseConstantSniff::class);
    $ecsConfig->rule(LowercaseKeywordsFixer::class);
    $ecsConfig->rule(LowercaseStaticReferenceFixer::class);
    $ecsConfig->rule(MagicConstantCasingFixer::class);
    $ecsConfig->rule(NativeFunctionCasingFixer::class);
    $ecsConfig->rule(CastSpacesFixer::class);
    $ecsConfig->rule(LowercaseCastFixer::class);
    $ecsConfig->rule(ModernizeTypesCastingFixer::class);
    $ecsConfig->rule(NoShortBoolCastFixer::class);
    $ecsConfig->rule(ShortScalarCastFixer::class);
    $ecsConfig->rule(ClassAttributesSeparationFixer::class);
    $ecsConfig->ruleWithConfiguration(ClassDefinitionFixer::class, [
        'single_item_single_line' => true,
        'multi_line_extends_each_single_line' => true,
    ]);
    $ecsConfig->rule(NoBlankLinesAfterClassOpeningFixer::class);
    $ecsConfig->rule(NoNullPropertyInitializationFixer::class);
    $ecsConfig->rule(NoPhp4ConstructorFixer::class);
    $ecsConfig->rule(NoUnneededFinalMethodFixer::class);
    $ecsConfig->rule(ProtectedToPrivateFixer::class);
    $ecsConfig->rule(SelfAccessorFixer::class);
    $ecsConfig->rule(SingleClassElementPerStatementFixer::class);
    $ecsConfig->ruleWithConfiguration(VisibilityRequiredFixer::class, [
        'elements' => [
            'const',
            'property',
            'method',
        ],
    ]);
    $ecsConfig->rule(NoEmptyCommentFixer::class);
    $ecsConfig->rule(NoTrailingWhitespaceInCommentFixer::class);
    $ecsConfig->ruleWithConfiguration(SingleLineCommentStyleFixer::class, [
        'comment_types' => [
            'hash',
        ]
    ]);
    $ecsConfig->rule(ElseifFixer::class);
    $ecsConfig->rule(IncludeFixer::class);
    $ecsConfig->rule(NoBreakCommentFixer::class);
    $ecsConfig->rule(NoSuperfluousElseifFixer::class);
    $ecsConfig->rule(NoTrailingCommaInListCallFixer::class);
    $ecsConfig->rule(NoUnneededControlParenthesesFixer::class);
    $ecsConfig->rule(NoUnneededCurlyBracesFixer::class);
    $ecsConfig->rule(NoUselessElseFixer::class);
    $ecsConfig->rule(SwitchCaseSemicolonToColonFixer::class);
    $ecsConfig->rule(SwitchCaseSpaceFixer::class);
    $ecsConfig->rule(NativeConstantInvocationFixer::class);
    $ecsConfig->rule(FunctionDeclarationFixer::class);
    $ecsConfig->rule(FunctionTypehintSpaceFixer::class);
    $ecsConfig->rule(MethodArgumentSpaceFixer::class);
    $ecsConfig->rule(NoSpacesAfterFunctionNameFixer::class);
    $ecsConfig->rule(ReturnTypeDeclarationFixer::class);
    $ecsConfig->rule(NoLeadingImportSlashFixer::class);
    $ecsConfig->rule(NoUnusedImportsFixer::class);
    $ecsConfig->rule(OrderedImportsFixer::class);
    $ecsConfig->rule(SingleImportPerStatementFixer::class);
    $ecsConfig->rule(SingleLineAfterImportsFixer::class);
    $ecsConfig->rule(CombineConsecutiveIssetsFixer::class);
    $ecsConfig->rule(CombineConsecutiveUnsetsFixer::class);
    $ecsConfig->rule(DeclareEqualNormalizeFixer::class);
    $ecsConfig->rule(DirConstantFixer::class);
    $ecsConfig->rule(FunctionToConstantFixer::class);
    $ecsConfig->rule(IsNullFixer::class);
    $ecsConfig->ruleWithConfiguration(ListSyntaxFixer::class, [
        'syntax' => 'short',
    ]);
    $ecsConfig->rule(BlankLineAfterNamespaceFixer::class);
    $ecsConfig->rule(NoLeadingNamespaceWhitespaceFixer::class);
    $ecsConfig->rule(SingleBlankLineBeforeNamespaceFixer::class);
    $ecsConfig->rule(NoHomoglyphNamesFixer::class);
    $ecsConfig->rule(BinaryOperatorSpacesFixer::class);
    $ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ]);
    $ecsConfig->rule(NewWithBracesFixer::class);
    $ecsConfig->rule(ObjectOperatorWithoutWhitespaceFixer::class);
    $ecsConfig->ruleWithConfiguration(IncrementStyleFixer::class, [
        'style' => 'pre'
    ]);
    $ecsConfig->rule(StandardizeNotEqualsFixer::class);
    $ecsConfig->rule(TernaryOperatorSpacesFixer::class);
    $ecsConfig->rule(TernaryToNullCoalescingFixer::class);
    $ecsConfig->rule(UnaryOperatorSpacesFixer::class);
    $ecsConfig->rule(NoBlankLinesAfterPhpdocFixer::class);
    $ecsConfig->rule(NoEmptyPhpdocFixer::class);
    $ecsConfig->ruleWithConfiguration(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
    ]);
    $ecsConfig->rule(PhpdocIndentFixer::class);
    $ecsConfig->rule(PhpdocNoAccessFixer::class);
    $ecsConfig->rule(PhpdocNoAliasTagFixer::class);
    $ecsConfig->rule(PhpdocNoEmptyReturnFixer::class);
    $ecsConfig->rule(PhpdocNoPackageFixer::class);
    $ecsConfig->rule(PhpdocNoUselessInheritdocFixer::class);
    $ecsConfig->rule(PhpdocReturnSelfReferenceFixer::class);
    $ecsConfig->rule(PhpdocScalarFixer::class);
    $ecsConfig->rule(PhpdocSeparationFixer::class);
    $ecsConfig->rule(PhpdocSingleLineVarSpacingFixer::class);
    $ecsConfig->rule(PhpdocTrimFixer::class);
    $ecsConfig->rule(PhpdocTypesFixer::class);
    $ecsConfig->ruleWithConfiguration(PhpdocTypesOrderFixer::class, [
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ]);
    $ecsConfig->rule(PhpdocVarWithoutNameFixer::class);
    $ecsConfig->rule(BlankLineAfterOpeningTagFixer::class);
    $ecsConfig->rule(FullOpeningTagFixer::class);
    $ecsConfig->rule(NoClosingTagFixer::class);
    $ecsConfig->rule(PhpUnitDedicateAssertFixer::class);
    $ecsConfig->rule(PhpUnitFqcnAnnotationFixer::class);
    $ecsConfig->rule(NoEmptyStatementFixer::class);
    $ecsConfig->rule(NoSinglelineWhitespaceBeforeSemicolonsFixer::class);
    $ecsConfig->rule(SpaceAfterSemicolonFixer::class);
    $ecsConfig->rule(DeclareStrictTypesFixer::class);
    $ecsConfig->rule(SingleQuoteFixer::class);
    $ecsConfig->rule(BlankLineBeforeStatementFixer::class);
    $ecsConfig->rule(IndentationTypeFixer::class);
    $ecsConfig->rule(LineEndingFixer::class);
    $ecsConfig->ruleWithConfiguration(NoExtraBlankLinesFixer::class, [
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
        ],
    ]);
    $ecsConfig->rule(NoSpacesAroundOffsetFixer::class);
    $ecsConfig->rule(NoSpacesInsideParenthesisFixer::class);
    $ecsConfig->rule(NoTrailingWhitespaceFixer::class);
    $ecsConfig->rule(NoWhitespaceInBlankLineFixer::class);
    $ecsConfig->rule(SingleBlankLineAtEofFixer::class);
    $parameters = $ecsConfig->parameters();
    $parameters->set('parallel-timeout-in-seconds', 600);
    $parameters->set('skip', [
        VisibilityRequiredFixer::class => ['*Spec.php'],
    ]);
};
