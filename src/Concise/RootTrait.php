<?php

namespace Concise;

trait RootTrait
{
    abstract public function performCurrentAssertion();

    /**
     * @return \Concise\Assertion\AssertionBuilder|DoesNotHaveItemTrait|DoesNotHaveKeyTrait|DoesNotHaveKeysTrait|DoesNotContainTrait|DoesNotHaveValueTrait|HasItemTrait|HasItemsTrait|HasKeyTrait|HasKeysTrait|HasValueTrait|ContainsTrait|HasValuesTrait|IsEmptyArrayTrait|IsAnEmptyArrayTrait|IsNotEmptyArrayTrait|IsNotAnEmptyArrayTrait|IsNotUniqueTrait|IsUniqueTrait|IsAnAssociativeArrayTrait|IsNotAnAssociativeArrayTrait|EqualsTrait|IsEqualToTrait|IsExactlyEqualToTrait|ExactlyEqualsTrait|IsTheSameAsTrait|DoesNotEqualTrait|IsNotEqualToTrait|NotEqualsTrait|IsNotTheSameAsTrait|DoesNotExactlyEqualTrait|IsNotExactlyEqualToTrait|IsFalseTrait|IsFalsyTrait|IsTrueTrait|IsTruthyTrait|DoesNotThrowTrait|DoesNotThrowExceptionTrait|ThrowsTrait|ThrowsAnythingExceptTrait|ThrowsExactlyTrait|ThrowsExceptionTrait|EqualsFileTrait|DoesNotEqualFileTrait|IsBetweenTrait|BetweenTrait|IsNotWithinTrait|IsWithinTrait|IsGreaterThanTrait|GreaterThanTrait|GtTrait|IsGreaterThanOrEqualToTrait|GreaterThanOrEqualTrait|GteTrait|IsLessThanTrait|LessThanTrait|LtTrait|IsLessThanOrEqualToTrait|LessThanOrEqualTrait|IsNotBetweenTrait|NotBetweenTrait|DoesNotHavePropertyTrait|HasPropertyTrait|MatchesRegularExpressionTrait|MatchesRegexTrait|DoesNotMatchRegularExpressionTrait|DoesntMatchRegularExpressionTrait|DoesNotMatchRegexTrait|DoesntMatchRegexTrait|ContainsStringTrait|ContainsCaseInsensitiveStringTrait|DoesNotContainStringTrait|DoesNotContainCaseInsensitiveStringTrait|IsBlankTrait|IsNotBlankTrait|DoesNotEndWithTrait|DoesNotStartWithTrait|EndsWithTrait|StartsWithTrait|IsABooleanTrait|IsABoolTrait|IsAnArrayTrait|IsAnIntTrait|IsAnIntegerTrait|IsAnObjectTrait|IsANumberTrait|IsAStringTrait|IsAnInstanceOfTrait|IsInstanceOfTrait|InstanceOfTrait|IsNotABooleanTrait|IsNotABoolTrait|IsNotAnArrayTrait|IsNotAnIntTrait|IsNotAnIntegerTrait|IsNotAnObjectTrait|IsNotANumberTrait|IsNotAStringTrait|IsNotAnInstanceOfTrait|IsNotInstanceOfTrait|NotInstanceOfTrait|IsNotNullTrait|IsNotNumericTrait|IsNullTrait|IsNumericTrait
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
 * @method null containsCaseInsensitiveString($value)
 */
trait ContainsCaseInsensitiveStringTrait
{
}

/**
 * @method null containsString($value)
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
 * @method null doesNotContainCaseInsensitiveString($value)
 */
trait DoesNotContainCaseInsensitiveStringTrait
{
}

/**
 * @method null doesNotContainString($value)
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
 * @method null doesNotEqual($value)
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
 * @method null doesNotHaveKey($value)
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
 * @property null doesNotThrowException
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
 * @method null equals($value)
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
 * @method null hasKey($value)
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
 * @method null hasProperty($value)
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
 * @method null instanceOf($value)
 */
trait InstanceOfTrait
{
}

/**
 * @property null isABool
 */
trait IsABoolTrait
{
}

/**
 * @property null isABoolean
 */
trait IsABooleanTrait
{
}

/**
 * @property null isANumber
 */
trait IsANumberTrait
{
}

/**
 * @property null isAString
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
 * @property null isAnArray
 */
trait IsAnArrayTrait
{
}

/**
 * @property null isAnAssociativeArray
 */
trait IsAnAssociativeArrayTrait
{
}

/**
 * @property null isAnEmptyArray
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
 * @property null isAnInt
 */
trait IsAnIntTrait
{
}

/**
 * @property null isAnInteger
 */
trait IsAnIntegerTrait
{
}

/**
 * @property null isAnObject
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
 * @property null isBlank
 */
trait IsBlankTrait
{
}

/**
 * @property null isEmptyArray
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
 * @property null isFalse
 */
trait IsFalseTrait
{
}

/**
 * @property null isFalsy
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
 * @property null isNotABool
 */
trait IsNotABoolTrait
{
}

/**
 * @property null isNotABoolean
 */
trait IsNotABooleanTrait
{
}

/**
 * @property null isNotANumber
 */
trait IsNotANumberTrait
{
}

/**
 * @property null isNotAString
 */
trait IsNotAStringTrait
{
}

/**
 * @property null isNotAnArray
 */
trait IsNotAnArrayTrait
{
}

/**
 * @property null isNotAnAssociativeArray
 */
trait IsNotAnAssociativeArrayTrait
{
}

/**
 * @property null isNotAnEmptyArray
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
 * @property null isNotAnInt
 */
trait IsNotAnIntTrait
{
}

/**
 * @property null isNotAnInteger
 */
trait IsNotAnIntegerTrait
{
}

/**
 * @property null isNotAnObject
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
 * @property null isNotBlank
 */
trait IsNotBlankTrait
{
}

/**
 * @property null isNotEmptyArray
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
 * @property null isNotNull
 */
trait IsNotNullTrait
{
}

/**
 * @property null isNotNumeric
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
 * @property null isNotUnique
 */
trait IsNotUniqueTrait
{
}

/**
 * @method null|OfTrait isNotWithin($value)
 */
trait IsNotWithinTrait
{
}

/**
 * @property null isNull
 */
trait IsNullTrait
{
}

/**
 * @property null isNumeric
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
 * @property null isTrue
 */
trait IsTrueTrait
{
}

/**
 * @property null isTruthy
 */
trait IsTruthyTrait
{
}

/**
 * @property null isUnique
 */
trait IsUniqueTrait
{
}

/**
 * @property null isValid
 */
trait IsValidTrait
{
}

/**
 * @method null|OfTrait isWithin($value)
 */
trait IsWithinTrait
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
 * @method null of($value)
 */
trait OfTrait
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
 * @property null throwsException
 */
trait ThrowsExceptionTrait
{
}

