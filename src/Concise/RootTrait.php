<?php

namespace Concise;

trait RootTrait
{
    abstract public function performCurrentAssertion();

    /**
     * @return \Concise\Assertion\AssertionBuilder|DoesNotHaveKeyTrait|DoesNotHaveItemTrait|DoesNotHaveKeysTrait|DoesNotContainTrait|DoesNotHaveValueTrait|HasKeyTrait|HasItemTrait|HasItemsTrait|HasKeysTrait|HasValueTrait|ContainsTrait|HasValuesTrait|IsEmptyArrayTrait|IsAnEmptyArrayTrait|IsNotEmptyArrayTrait|IsNotAnEmptyArrayTrait|IsNotUniqueTrait|IsUniqueTrait|IsAnAssociativeArrayTrait|IsNotAnAssociativeArrayTrait|EqualsTrait|IsEqualToTrait|IsExactlyEqualToTrait|ExactlyEqualsTrait|IsTheSameAsTrait|DoesNotEqualTrait|IsNotEqualToTrait|NotEqualsTrait|IsNotTheSameAsTrait|DoesNotExactlyEqualTrait|IsNotExactlyEqualToTrait|IsFalseTrait|IsFalsyTrait|IsTrueTrait|IsTruthyTrait|DoesNotThrowTrait|DoesNotThrowExceptionTrait|ThrowsTrait|ThrowsAnythingExceptTrait|ThrowsExactlyTrait|ThrowsExceptionTrait|EqualsFileTrait|DoesNotEqualFileTrait|IsBetweenTrait|BetweenTrait|IsGreaterThanTrait|GreaterThanTrait|GtTrait|IsGreaterThanOrEqualToTrait|GreaterThanOrEqualTrait|GteTrait|IsLessThanTrait|LessThanTrait|LtTrait|IsLessThanOrEqualToTrait|LessThanOrEqualTrait|IsNotBetweenTrait|NotBetweenTrait|DoesNotHavePropertyTrait|HasPropertyTrait|MatchesRegularExpressionTrait|MatchesRegexTrait|DoesNotMatchRegularExpressionTrait|DoesntMatchRegularExpressionTrait|DoesNotMatchRegexTrait|DoesntMatchRegexTrait|ContainsStringTrait|DoesNotContainStringTrait|IsBlankTrait|IsNotBlankTrait|DoesNotEndWithTrait|DoesNotStartWithTrait|EndsWithTrait|StartsWithTrait|IsABooleanTrait|IsABoolTrait|IsAnArrayTrait|IsAnIntTrait|IsAnIntegerTrait|IsAnObjectTrait|IsANumberTrait|IsAStringTrait|IsAnInstanceOfTrait|IsInstanceOfTrait|InstanceOfTrait|IsNotABooleanTrait|IsNotABoolTrait|IsNotAnArrayTrait|IsNotAnIntTrait|IsNotAnIntegerTrait|IsNotAnObjectTrait|IsNotANumberTrait|IsNotAStringTrait|IsNotAnInstanceOfTrait|IsNotInstanceOfTrait|NotInstanceOfTrait|IsNotNullTrait|IsNotNumericTrait|IsNullTrait|IsNumericTrait
     */
    public function aassert($value)
    {
        $this->performCurrentAssertion();
        return $this->currentAssertion = (new \Concise\Assertion\AssertionBuilder())->_($value);
    }

    /**
     * @return \Concise\Assertion\AssertionBuilder
     */
    public function aassertFalse()
    {
        $this->performCurrentAssertion();
        return $this->currentAssertion = (new \Concise\Assertion\AssertionBuilder())->false();
    }

    /**
     * @return \Concise\Assertion\AssertionBuilder
     */
    public function aassertTrue()
    {
        $this->performCurrentAssertion();
        return $this->currentAssertion = (new \Concise\Assertion\AssertionBuilder())->true();
    }

    /**
     * @return \Concise\Assertion\AssertionBuilder|IsAfterTrait|IsBeforeTrait
     */
    public function aassertDate($value)
    {
        $this->performCurrentAssertion();
        return $this->currentAssertion = (new \Concise\Assertion\AssertionBuilder())->date($value);
    }

    /**
     * @return \Concise\Assertion\AssertionBuilder|IsValidTrait|HasSchemeTrait|HasHostTrait|HasPortTrait|HasUserTrait|HasPasswordTrait|HasPathTrait|HasQueryTrait|HasFragmentTrait
     */
    public function aassertUrl($value)
    {
        $this->performCurrentAssertion();
        return $this->currentAssertion = (new \Concise\Assertion\AssertionBuilder())->url($value);
    }
}

/**
 * @method null and($value)
 */
trait AndTrait
{
}

/**
 * @method null|AndTrait between($value)
 */
trait BetweenTrait
{
}

/**
 * @method null contains($value)
 */
trait ContainsTrait
{
}

/**
 * @method null|IgnoringCaseTrait containsString($value)
 */
trait ContainsStringTrait
{
}

/**
 * @method null doesNotContain($value)
 */
trait DoesNotContainTrait
{
}

/**
 * @method null|IgnoringCaseTrait doesNotContainString($value)
 */
trait DoesNotContainStringTrait
{
}

/**
 * @method null doesNotEndWith($value)
 */
trait DoesNotEndWithTrait
{
}

/**
 * @method null|WithinTrait doesNotEqual($value)
 */
trait DoesNotEqualTrait
{
}

/**
 * @method null doesNotEqualFile($value)
 */
trait DoesNotEqualFileTrait
{
}

/**
 * @method null doesNotExactlyEqual($value)
 */
trait DoesNotExactlyEqualTrait
{
}

/**
 * @method null doesNotHaveItem($value)
 */
trait DoesNotHaveItemTrait
{
}

/**
 * @method null|WithValueTrait doesNotHaveKey($value)
 */
trait DoesNotHaveKeyTrait
{
}

/**
 * @method null doesNotHaveKeys($value)
 */
trait DoesNotHaveKeysTrait
{
}

/**
 * @method null doesNotHaveProperty($value)
 */
trait DoesNotHavePropertyTrait
{
}

/**
 * @method null doesNotHaveValue($value)
 */
trait DoesNotHaveValueTrait
{
}

/**
 * @method null doesNotMatchRegex($value)
 */
trait DoesNotMatchRegexTrait
{
}

/**
 * @method null doesNotMatchRegularExpression($value)
 */
trait DoesNotMatchRegularExpressionTrait
{
}

/**
 * @method null doesNotStartWith($value)
 */
trait DoesNotStartWithTrait
{
}

/**
 * @method null doesNotThrow($value)
 */
trait DoesNotThrowTrait
{
}

/**
 * @method null doesNotThrowException($value)
 */
trait DoesNotThrowExceptionTrait
{
}

/**
 * @method null doesntMatchRegex($value)
 */
trait DoesntMatchRegexTrait
{
}

/**
 * @method null doesntMatchRegularExpression($value)
 */
trait DoesntMatchRegularExpressionTrait
{
}

/**
 * @method null endsWith($value)
 */
trait EndsWithTrait
{
}

/**
 * @method null|WithinTrait equals($value)
 */
trait EqualsTrait
{
}

/**
 * @method null equalsFile($value)
 */
trait EqualsFileTrait
{
}

/**
 * @method null exactlyEquals($value)
 */
trait ExactlyEqualsTrait
{
}

/**
 * @method null greaterThan($value)
 */
trait GreaterThanTrait
{
}

/**
 * @method null greaterThanOrEqual($value)
 */
trait GreaterThanOrEqualTrait
{
}

/**
 * @method null gt($value)
 */
trait GtTrait
{
}

/**
 * @method null gte($value)
 */
trait GteTrait
{
}

/**
 * @method null hasFragment($value)
 */
trait HasFragmentTrait
{
}

/**
 * @method null hasHost($value)
 */
trait HasHostTrait
{
}

/**
 * @method null hasItem($value)
 */
trait HasItemTrait
{
}

/**
 * @method null hasItems($value)
 */
trait HasItemsTrait
{
}

/**
 * @method null|WithValueTrait hasKey($value)
 */
trait HasKeyTrait
{
}

/**
 * @method null hasKeys($value)
 */
trait HasKeysTrait
{
}

/**
 * @method null hasPassword($value)
 */
trait HasPasswordTrait
{
}

/**
 * @method null hasPath($value)
 */
trait HasPathTrait
{
}

/**
 * @method null hasPort($value)
 */
trait HasPortTrait
{
}

/**
 * @method null|WithExactValueTrait|WithValueTrait hasProperty($value)
 */
trait HasPropertyTrait
{
}

/**
 * @method null hasQuery($value)
 */
trait HasQueryTrait
{
}

/**
 * @method null hasScheme($value)
 */
trait HasSchemeTrait
{
}

/**
 * @method null hasUser($value)
 */
trait HasUserTrait
{
}

/**
 * @method null hasValue($value)
 */
trait HasValueTrait
{
}

/**
 * @method null hasValues($value)
 */
trait HasValuesTrait
{
}

/**
 * @method null ignoringCase($value)
 */
trait IgnoringCaseTrait
{
}

/**
 * @method null instanceOf($value)
 */
trait InstanceOfTrait
{
}

/**
 * @method null isABool($value)
 */
trait IsABoolTrait
{
}

/**
 * @method null isABoolean($value)
 */
trait IsABooleanTrait
{
}

/**
 * @method null isANumber($value)
 */
trait IsANumberTrait
{
}

/**
 * @method null isAString($value)
 */
trait IsAStringTrait
{
}

/**
 * @method null isAfter($value)
 */
trait IsAfterTrait
{
}

/**
 * @method null isAnArray($value)
 */
trait IsAnArrayTrait
{
}

/**
 * @method null isAnAssociativeArray($value)
 */
trait IsAnAssociativeArrayTrait
{
}

/**
 * @method null isAnEmptyArray($value)
 */
trait IsAnEmptyArrayTrait
{
}

/**
 * @method null isAnInstanceOf($value)
 */
trait IsAnInstanceOfTrait
{
}

/**
 * @method null isAnInt($value)
 */
trait IsAnIntTrait
{
}

/**
 * @method null isAnInteger($value)
 */
trait IsAnIntegerTrait
{
}

/**
 * @method null isAnObject($value)
 */
trait IsAnObjectTrait
{
}

/**
 * @method null isBefore($value)
 */
trait IsBeforeTrait
{
}

/**
 * @method null|AndTrait isBetween($value)
 */
trait IsBetweenTrait
{
}

/**
 * @method null isBlank($value)
 */
trait IsBlankTrait
{
}

/**
 * @method null isEmptyArray($value)
 */
trait IsEmptyArrayTrait
{
}

/**
 * @method null isEqualTo($value)
 */
trait IsEqualToTrait
{
}

/**
 * @method null isExactlyEqualTo($value)
 */
trait IsExactlyEqualToTrait
{
}

/**
 * @method null isFalse($value)
 */
trait IsFalseTrait
{
}

/**
 * @method null isFalsy($value)
 */
trait IsFalsyTrait
{
}

/**
 * @method null isGreaterThan($value)
 */
trait IsGreaterThanTrait
{
}

/**
 * @method null isGreaterThanOrEqualTo($value)
 */
trait IsGreaterThanOrEqualToTrait
{
}

/**
 * @method null isInstanceOf($value)
 */
trait IsInstanceOfTrait
{
}

/**
 * @method null isLessThan($value)
 */
trait IsLessThanTrait
{
}

/**
 * @method null isLessThanOrEqualTo($value)
 */
trait IsLessThanOrEqualToTrait
{
}

/**
 * @method null isNotABool($value)
 */
trait IsNotABoolTrait
{
}

/**
 * @method null isNotABoolean($value)
 */
trait IsNotABooleanTrait
{
}

/**
 * @method null isNotANumber($value)
 */
trait IsNotANumberTrait
{
}

/**
 * @method null isNotAString($value)
 */
trait IsNotAStringTrait
{
}

/**
 * @method null isNotAnArray($value)
 */
trait IsNotAnArrayTrait
{
}

/**
 * @method null isNotAnAssociativeArray($value)
 */
trait IsNotAnAssociativeArrayTrait
{
}

/**
 * @method null isNotAnEmptyArray($value)
 */
trait IsNotAnEmptyArrayTrait
{
}

/**
 * @method null isNotAnInstanceOf($value)
 */
trait IsNotAnInstanceOfTrait
{
}

/**
 * @method null isNotAnInt($value)
 */
trait IsNotAnIntTrait
{
}

/**
 * @method null isNotAnInteger($value)
 */
trait IsNotAnIntegerTrait
{
}

/**
 * @method null isNotAnObject($value)
 */
trait IsNotAnObjectTrait
{
}

/**
 * @method null|AndTrait isNotBetween($value)
 */
trait IsNotBetweenTrait
{
}

/**
 * @method null isNotBlank($value)
 */
trait IsNotBlankTrait
{
}

/**
 * @method null isNotEmptyArray($value)
 */
trait IsNotEmptyArrayTrait
{
}

/**
 * @method null isNotEqualTo($value)
 */
trait IsNotEqualToTrait
{
}

/**
 * @method null isNotExactlyEqualTo($value)
 */
trait IsNotExactlyEqualToTrait
{
}

/**
 * @method null isNotInstanceOf($value)
 */
trait IsNotInstanceOfTrait
{
}

/**
 * @method null isNotNull($value)
 */
trait IsNotNullTrait
{
}

/**
 * @method null isNotNumeric($value)
 */
trait IsNotNumericTrait
{
}

/**
 * @method null isNotTheSameAs($value)
 */
trait IsNotTheSameAsTrait
{
}

/**
 * @method null isNotUnique($value)
 */
trait IsNotUniqueTrait
{
}

/**
 * @method null isNull($value)
 */
trait IsNullTrait
{
}

/**
 * @method null isNumeric($value)
 */
trait IsNumericTrait
{
}

/**
 * @method null isTheSameAs($value)
 */
trait IsTheSameAsTrait
{
}

/**
 * @method null isTrue($value)
 */
trait IsTrueTrait
{
}

/**
 * @method null isTruthy($value)
 */
trait IsTruthyTrait
{
}

/**
 * @method null isUnique($value)
 */
trait IsUniqueTrait
{
}

/**
 * @method null isValid($value)
 */
trait IsValidTrait
{
}

/**
 * @method null lessThan($value)
 */
trait LessThanTrait
{
}

/**
 * @method null lessThanOrEqual($value)
 */
trait LessThanOrEqualTrait
{
}

/**
 * @method null lt($value)
 */
trait LtTrait
{
}

/**
 * @method null matchesRegex($value)
 */
trait MatchesRegexTrait
{
}

/**
 * @method null matchesRegularExpression($value)
 */
trait MatchesRegularExpressionTrait
{
}

/**
 * @method null|AndTrait notBetween($value)
 */
trait NotBetweenTrait
{
}

/**
 * @method null notEquals($value)
 */
trait NotEqualsTrait
{
}

/**
 * @method null notInstanceOf($value)
 */
trait NotInstanceOfTrait
{
}

/**
 * @method null startsWith($value)
 */
trait StartsWithTrait
{
}

/**
 * @method null throws($value)
 */
trait ThrowsTrait
{
}

/**
 * @method null throwsAnythingExcept($value)
 */
trait ThrowsAnythingExceptTrait
{
}

/**
 * @method null throwsExactly($value)
 */
trait ThrowsExactlyTrait
{
}

/**
 * @method null throwsException($value)
 */
trait ThrowsExceptionTrait
{
}

/**
 * @method null withExactValue($value)
 */
trait WithExactValueTrait
{
}

/**
 * @method null withValue($value)
 */
trait WithValueTrait
{
}

/**
 * @method null within($value)
 */
trait WithinTrait
{
}

