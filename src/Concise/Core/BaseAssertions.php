<?php

namespace Concise\Core;

use PHPUnit_Framework_TestCase;

/**
 * @method AssertionBuilder|DoesNotHaveItemTrait|DoesNotHaveKeyTrait|DoesNotHaveKeysTrait|DoesNotContainTrait|DoesNotHaveValueTrait|HasItemTrait|HasItemsTrait|HasKeyTrait|HasKeysTrait|HasValueTrait|ContainsTrait|HasValuesTrait|IsEmptyTrait|IsNotEmptyTrait|IsNotUniqueTrait|IsUniqueTrait|IsAssociativeTrait|IsNotAssociativeTrait assertArray($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|DoesNotHaveItemTrait|DoesNotHaveKeyTrait|DoesNotHaveKeysTrait|DoesNotContainTrait|DoesNotHaveValueTrait|HasItemTrait|HasItemsTrait|HasKeyTrait|HasKeysTrait|HasValueTrait|ContainsTrait|HasValuesTrait|IsEmptyTrait|IsNotEmptyTrait|IsNotUniqueTrait|IsUniqueTrait|IsAssociativeTrait|IsNotAssociativeTrait verifyArray($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|EqualsTrait|IsEqualToTrait|IsExactlyEqualToTrait|ExactlyEqualsTrait|IsTheSameAsTrait|DoesNotEqualTrait|IsNotEqualToTrait|NotEqualsTrait|IsNotTheSameAsTrait|DoesNotExactlyEqualTrait|IsNotExactlyEqualToTrait|IsFalseTrait|IsFalsyTrait|IsTrueTrait|IsTruthyTrait|DoesNotThrowTrait|DoesNotThrowExceptionTrait|ThrowsTrait|ThrowsAnythingExceptTrait|ThrowsExactlyTrait|ThrowsExceptionTrait|EqualsFileTrait|DoesNotEqualFileTrait|IsBetweenTrait|BetweenTrait|IsNotWithinTrait|IsWithinTrait|IsGreaterThanTrait|GreaterThanTrait|GtTrait|IsGreaterThanOrEqualToTrait|GreaterThanOrEqualTrait|GteTrait|IsLessThanTrait|LessThanTrait|LtTrait|IsLessThanOrEqualToTrait|LessThanOrEqualTrait|IsNotBetweenTrait|NotBetweenTrait|DoesNotHavePropertyTrait|HasPropertyTrait|MatchesRegularExpressionTrait|MatchesRegexTrait|DoesNotMatchRegularExpressionTrait|DoesntMatchRegularExpressionTrait|DoesNotMatchRegexTrait|DoesntMatchRegexTrait|ContainsStringTrait|ContainsCaseInsensitiveStringTrait|DoesNotContainStringTrait|DoesNotContainCaseInsensitiveStringTrait|IsBlankTrait|IsNotBlankTrait|DoesNotEndWithTrait|DoesNotStartWithTrait|EndsWithTrait|StartsWithTrait|IsABooleanTrait|IsABoolTrait|IsAnArrayTrait|IsAnIntTrait|IsAnIntegerTrait|IsAnObjectTrait|IsANumberTrait|IsAStringTrait|IsAnInstanceOfTrait|IsInstanceOfTrait|InstanceOfTrait|IsNotABooleanTrait|IsNotABoolTrait|IsNotAnArrayTrait|IsNotAnIntTrait|IsNotAnIntegerTrait|IsNotAnObjectTrait|IsNotANumberTrait|IsNotAStringTrait|IsNotAnInstanceOfTrait|IsNotInstanceOfTrait|NotInstanceOfTrait|IsNotNullTrait|IsNotNumericTrait|IsNullTrait|IsNumericTrait assert($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|EqualsTrait|IsEqualToTrait|IsExactlyEqualToTrait|ExactlyEqualsTrait|IsTheSameAsTrait|DoesNotEqualTrait|IsNotEqualToTrait|NotEqualsTrait|IsNotTheSameAsTrait|DoesNotExactlyEqualTrait|IsNotExactlyEqualToTrait|IsFalseTrait|IsFalsyTrait|IsTrueTrait|IsTruthyTrait|DoesNotThrowTrait|DoesNotThrowExceptionTrait|ThrowsTrait|ThrowsAnythingExceptTrait|ThrowsExactlyTrait|ThrowsExceptionTrait|EqualsFileTrait|DoesNotEqualFileTrait|IsBetweenTrait|BetweenTrait|IsNotWithinTrait|IsWithinTrait|IsGreaterThanTrait|GreaterThanTrait|GtTrait|IsGreaterThanOrEqualToTrait|GreaterThanOrEqualTrait|GteTrait|IsLessThanTrait|LessThanTrait|LtTrait|IsLessThanOrEqualToTrait|LessThanOrEqualTrait|IsNotBetweenTrait|NotBetweenTrait|DoesNotHavePropertyTrait|HasPropertyTrait|MatchesRegularExpressionTrait|MatchesRegexTrait|DoesNotMatchRegularExpressionTrait|DoesntMatchRegularExpressionTrait|DoesNotMatchRegexTrait|DoesntMatchRegexTrait|ContainsStringTrait|ContainsCaseInsensitiveStringTrait|DoesNotContainStringTrait|DoesNotContainCaseInsensitiveStringTrait|IsBlankTrait|IsNotBlankTrait|DoesNotEndWithTrait|DoesNotStartWithTrait|EndsWithTrait|StartsWithTrait|IsABooleanTrait|IsABoolTrait|IsAnArrayTrait|IsAnIntTrait|IsAnIntegerTrait|IsAnObjectTrait|IsANumberTrait|IsAStringTrait|IsAnInstanceOfTrait|IsInstanceOfTrait|InstanceOfTrait|IsNotABooleanTrait|IsNotABoolTrait|IsNotAnArrayTrait|IsNotAnIntTrait|IsNotAnIntegerTrait|IsNotAnObjectTrait|IsNotANumberTrait|IsNotAStringTrait|IsNotAnInstanceOfTrait|IsNotInstanceOfTrait|NotInstanceOfTrait|IsNotNullTrait|IsNotNumericTrait|IsNullTrait|IsNumericTrait verify($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|IsAfterTrait|IsBeforeTrait assertDate($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|IsAfterTrait|IsBeforeTrait verifyDate($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|IsValidTrait|HasSchemeTrait|HasHostTrait|HasPortTrait|HasUserTrait|HasPasswordTrait|HasPathTrait|HasQueryTrait|HasFragmentTrait assertUrl($valueOrFailureMessage, $value = null)
 * @method AssertionBuilder|IsValidTrait|HasSchemeTrait|HasHostTrait|HasPortTrait|HasUserTrait|HasPasswordTrait|HasPathTrait|HasQueryTrait|HasFragmentTrait verifyUrl($valueOrFailureMessage, $value = null)
 */
abstract class BaseAssertions extends PHPUnit_Framework_TestCase
{
}

/**
 * @method null and($value)
 */
class AndTrait
{
}

/**
 * @method null|AndTrait between($value)
 */
class BetweenTrait
{
}

/**
 * @method null contains($value)
 */
class ContainsTrait
{
}

/**
 * @method null containsCaseInsensitiveString($value)
 */
class ContainsCaseInsensitiveStringTrait
{
}

/**
 * @method null containsString($value)
 */
class ContainsStringTrait
{
}

/**
 * @method null doesNotContain($value)
 */
class DoesNotContainTrait
{
}

/**
 * @method null doesNotContainCaseInsensitiveString($value)
 */
class DoesNotContainCaseInsensitiveStringTrait
{
}

/**
 * @method null doesNotContainString($value)
 */
class DoesNotContainStringTrait
{
}

/**
 * @method null doesNotEndWith($value)
 */
class DoesNotEndWithTrait
{
}

/**
 * @method null doesNotEqual($value)
 */
class DoesNotEqualTrait
{
}

/**
 * @method null doesNotEqualFile($value)
 */
class DoesNotEqualFileTrait
{
}

/**
 * @method null doesNotExactlyEqual($value)
 */
class DoesNotExactlyEqualTrait
{
}

/**
 * @method null doesNotHaveItem($value)
 */
class DoesNotHaveItemTrait
{
}

/**
 * @method null doesNotHaveKey($value)
 */
class DoesNotHaveKeyTrait
{
}

/**
 * @method null doesNotHaveKeys($value)
 */
class DoesNotHaveKeysTrait
{
}

/**
 * @method null doesNotHaveProperty($value)
 */
class DoesNotHavePropertyTrait
{
}

/**
 * @method null doesNotHaveValue($value)
 */
class DoesNotHaveValueTrait
{
}

/**
 * @method null doesNotMatchRegex($value)
 */
class DoesNotMatchRegexTrait
{
}

/**
 * @method null doesNotMatchRegularExpression($value)
 */
class DoesNotMatchRegularExpressionTrait
{
}

/**
 * @method null doesNotStartWith($value)
 */
class DoesNotStartWithTrait
{
}

/**
 * @method null doesNotThrow($value)
 */
class DoesNotThrowTrait
{
}

/**
 * @property null doesNotThrowException
 */
class DoesNotThrowExceptionTrait
{
}

/**
 * @method null doesntMatchRegex($value)
 */
class DoesntMatchRegexTrait
{
}

/**
 * @method null doesntMatchRegularExpression($value)
 */
class DoesntMatchRegularExpressionTrait
{
}

/**
 * @method null endsWith($value)
 */
class EndsWithTrait
{
}

/**
 * @method null equals($value)
 */
class EqualsTrait
{
}

/**
 * @method null equalsFile($value)
 */
class EqualsFileTrait
{
}

/**
 * @method null exactlyEquals($value)
 */
class ExactlyEqualsTrait
{
}

/**
 * @method null greaterThan($value)
 */
class GreaterThanTrait
{
}

/**
 * @method null greaterThanOrEqual($value)
 */
class GreaterThanOrEqualTrait
{
}

/**
 * @method null gt($value)
 */
class GtTrait
{
}

/**
 * @method null gte($value)
 */
class GteTrait
{
}

/**
 * @method null hasFragment($value)
 */
class HasFragmentTrait
{
}

/**
 * @method null hasHost($value)
 */
class HasHostTrait
{
}

/**
 * @method null hasItem($value)
 */
class HasItemTrait
{
}

/**
 * @method null hasItems($value)
 */
class HasItemsTrait
{
}

/**
 * @method null hasKey($value)
 */
class HasKeyTrait
{
}

/**
 * @method null hasKeys($value)
 */
class HasKeysTrait
{
}

/**
 * @method null hasPassword($value)
 */
class HasPasswordTrait
{
}

/**
 * @method null hasPath($value)
 */
class HasPathTrait
{
}

/**
 * @method null hasPort($value)
 */
class HasPortTrait
{
}

/**
 * @method null hasProperty($value)
 */
class HasPropertyTrait
{
}

/**
 * @method null hasQuery($value)
 */
class HasQueryTrait
{
}

/**
 * @method null hasScheme($value)
 */
class HasSchemeTrait
{
}

/**
 * @method null hasUser($value)
 */
class HasUserTrait
{
}

/**
 * @method null hasValue($value)
 */
class HasValueTrait
{
}

/**
 * @method null hasValues($value)
 */
class HasValuesTrait
{
}

/**
 * @method null instanceOf($value)
 */
class InstanceOfTrait
{
}

/**
 * @property null isABool
 */
class IsABoolTrait
{
}

/**
 * @property null isABoolean
 */
class IsABooleanTrait
{
}

/**
 * @property null isANumber
 */
class IsANumberTrait
{
}

/**
 * @property null isAString
 */
class IsAStringTrait
{
}

/**
 * @method null isAfter($value)
 */
class IsAfterTrait
{
}

/**
 * @property null isAnArray
 */
class IsAnArrayTrait
{
}

/**
 * @method null isAnInstanceOf($value)
 */
class IsAnInstanceOfTrait
{
}

/**
 * @property null isAnInt
 */
class IsAnIntTrait
{
}

/**
 * @property null isAnInteger
 */
class IsAnIntegerTrait
{
}

/**
 * @property null isAnObject
 */
class IsAnObjectTrait
{
}

/**
 * @property null isAssociative
 */
class IsAssociativeTrait
{
}

/**
 * @method null isBefore($value)
 */
class IsBeforeTrait
{
}

/**
 * @method null|AndTrait isBetween($value)
 */
class IsBetweenTrait
{
}

/**
 * @property null isBlank
 */
class IsBlankTrait
{
}

/**
 * @property null isEmpty
 */
class IsEmptyTrait
{
}

/**
 * @method null isEqualTo($value)
 */
class IsEqualToTrait
{
}

/**
 * @method null isExactlyEqualTo($value)
 */
class IsExactlyEqualToTrait
{
}

/**
 * @property null isFalse
 */
class IsFalseTrait
{
}

/**
 * @property null isFalsy
 */
class IsFalsyTrait
{
}

/**
 * @method null isGreaterThan($value)
 */
class IsGreaterThanTrait
{
}

/**
 * @method null isGreaterThanOrEqualTo($value)
 */
class IsGreaterThanOrEqualToTrait
{
}

/**
 * @method null isInstanceOf($value)
 */
class IsInstanceOfTrait
{
}

/**
 * @method null isLessThan($value)
 */
class IsLessThanTrait
{
}

/**
 * @method null isLessThanOrEqualTo($value)
 */
class IsLessThanOrEqualToTrait
{
}

/**
 * @property null isNotABool
 */
class IsNotABoolTrait
{
}

/**
 * @property null isNotABoolean
 */
class IsNotABooleanTrait
{
}

/**
 * @property null isNotANumber
 */
class IsNotANumberTrait
{
}

/**
 * @property null isNotAString
 */
class IsNotAStringTrait
{
}

/**
 * @property null isNotAnArray
 */
class IsNotAnArrayTrait
{
}

/**
 * @method null isNotAnInstanceOf($value)
 */
class IsNotAnInstanceOfTrait
{
}

/**
 * @property null isNotAnInt
 */
class IsNotAnIntTrait
{
}

/**
 * @property null isNotAnInteger
 */
class IsNotAnIntegerTrait
{
}

/**
 * @property null isNotAnObject
 */
class IsNotAnObjectTrait
{
}

/**
 * @property null isNotAssociative
 */
class IsNotAssociativeTrait
{
}

/**
 * @method null|AndTrait isNotBetween($value)
 */
class IsNotBetweenTrait
{
}

/**
 * @property null isNotBlank
 */
class IsNotBlankTrait
{
}

/**
 * @property null isNotEmpty
 */
class IsNotEmptyTrait
{
}

/**
 * @method null isNotEqualTo($value)
 */
class IsNotEqualToTrait
{
}

/**
 * @method null isNotExactlyEqualTo($value)
 */
class IsNotExactlyEqualToTrait
{
}

/**
 * @method null isNotInstanceOf($value)
 */
class IsNotInstanceOfTrait
{
}

/**
 * @property null isNotNull
 */
class IsNotNullTrait
{
}

/**
 * @property null isNotNumeric
 */
class IsNotNumericTrait
{
}

/**
 * @method null isNotTheSameAs($value)
 */
class IsNotTheSameAsTrait
{
}

/**
 * @property null isNotUnique
 */
class IsNotUniqueTrait
{
}

/**
 * @method null|OfTrait isNotWithin($value)
 */
class IsNotWithinTrait
{
}

/**
 * @property null isNull
 */
class IsNullTrait
{
}

/**
 * @property null isNumeric
 */
class IsNumericTrait
{
}

/**
 * @method null isTheSameAs($value)
 */
class IsTheSameAsTrait
{
}

/**
 * @property null isTrue
 */
class IsTrueTrait
{
}

/**
 * @property null isTruthy
 */
class IsTruthyTrait
{
}

/**
 * @property null isUnique
 */
class IsUniqueTrait
{
}

/**
 * @property null isValid
 */
class IsValidTrait
{
}

/**
 * @method null|OfTrait isWithin($value)
 */
class IsWithinTrait
{
}

/**
 * @method null lessThan($value)
 */
class LessThanTrait
{
}

/**
 * @method null lessThanOrEqual($value)
 */
class LessThanOrEqualTrait
{
}

/**
 * @method null lt($value)
 */
class LtTrait
{
}

/**
 * @method null matchesRegex($value)
 */
class MatchesRegexTrait
{
}

/**
 * @method null matchesRegularExpression($value)
 */
class MatchesRegularExpressionTrait
{
}

/**
 * @method null|AndTrait notBetween($value)
 */
class NotBetweenTrait
{
}

/**
 * @method null notEquals($value)
 */
class NotEqualsTrait
{
}

/**
 * @method null notInstanceOf($value)
 */
class NotInstanceOfTrait
{
}

/**
 * @method null of($value)
 */
class OfTrait
{
}

/**
 * @method null startsWith($value)
 */
class StartsWithTrait
{
}

/**
 * @method null throws($value)
 */
class ThrowsTrait
{
}

/**
 * @method null throwsAnythingExcept($value)
 */
class ThrowsAnythingExceptTrait
{
}

/**
 * @method null throwsExactly($value)
 */
class ThrowsExactlyTrait
{
}

/**
 * @property null throwsException
 */
class ThrowsExceptionTrait
{
}

