<?php

namespace Concise\Core;

use PHPUnit_Framework_TestCase;

/**
 * @method A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P assertArray($valueOrFailureMessage, $value = null)
 * @method A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P verifyArray($valueOrFailureMessage, $value = null)
 * @method Bg|Bh|Bi|Bj|Bk|Bl|Bm|Bn|Bo|Bp|Bq|Br|Bs|Bt|Bu|Bv|Bw|Bx|By|Bz|Ca|Cb|Cc|Cd|Ce|Cf|Cg|Ch|Ci|Cj|Ck|Cl|Cm|Cn|Co|Cp|Cq|Cr|Cs|Ct assert($valueOrFailureMessage, $value = null)
 * @method Bg|Bh|Bi|Bj|Bk|Bl|Bm|Bn|Bo|Bp|Bq|Br|Bs|Bt|Bu|Bv|Bw|Bx|By|Bz|Ca|Cb|Cc|Cd|Ce|Cf|Cg|Ch|Ci|Cj|Ck|Cl|Cm|Cn|Co|Cp|Cq|Cr|Cs|Ct verify($valueOrFailureMessage, $value = null)
 * @method Eq|Er assertDate($valueOrFailureMessage, $value = null)
 * @method Eq|Er verifyDate($valueOrFailureMessage, $value = null)
 * @method Eu|Ev|Ew|Ex|Ey|Ez assertClosure($valueOrFailureMessage, $value = null)
 * @method Eu|Ev|Ew|Ex|Ey|Ez verifyClosure($valueOrFailureMessage, $value = null)
 * @method Bg|Bj assertFile($valueOrFailureMessage, $value = null)
 * @method Bg|Bj verifyFile($valueOrFailureMessage, $value = null)
 * @method Fk assertHash($valueOrFailureMessage, $value = null)
 * @method Fk verifyHash($valueOrFailureMessage, $value = null)
 * @method Fm|Fn assertObject($valueOrFailureMessage, $value = null)
 * @method Fm|Fn verifyObject($valueOrFailureMessage, $value = null)
 * @method Fq|Fr|Fs|Ft|Fu|Fv|K|L|Fy|Fz|Ga|Gb assertString($valueOrFailureMessage, $value = null)
 * @method Fq|Fr|Fs|Ft|Fu|Fv|K|L|Fy|Fz|Ga|Gb verifyString($valueOrFailureMessage, $value = null)
 * @method Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw assertUrl($valueOrFailureMessage, $value = null)
 * @method Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw verifyUrl($valueOrFailureMessage, $value = null)
 */
abstract class BaseAssertions extends PHPUnit_Framework_TestCase
{
}

/**
 * And
 * @method null and($value)
 */
class Cu
{
}

/**
 * Contains
 * @method null contains($value)
 */
class Fs
{
}

/**
 * ContainsCaseInsensitive
 * @method null containsCaseInsensitive($value)
 */
class Ft
{
}

/**
 * DoesNotContain
 * @method null doesNotContain($value)
 */
class Fu
{
}

/**
 * DoesNotContainCaseInsensitive
 * @method null doesNotContainCaseInsensitive($value)
 */
class Fv
{
}

/**
 * DoesNotEndWith
 * @method null doesNotEndWith($value)
 */
class Fy
{
}

/**
 * DoesNotEqual
 * @method null doesNotEqual($value)
 */
class Bj
{
}

/**
 * DoesNotExactlyEqual
 * @method null doesNotExactlyEqual($value)
 */
class Bk
{
}

/**
 * DoesNotHaveItem
 * @method null doesNotHaveItem($value)
 */
class A
{
}

/**
 * DoesNotHaveKey
 * @method null doesNotHaveKey($value)
 */
class B
{
}

/**
 * DoesNotHaveKeys
 * @method null doesNotHaveKeys($value)
 */
class C
{
}

/**
 * DoesNotHaveProperty
 * @method null doesNotHaveProperty($value)
 */
class Fm
{
}

/**
 * DoesNotHaveValue
 * @method null doesNotHaveValue($value)
 */
class D
{
}

/**
 * DoesNotMatch
 * @method null doesNotMatch($value)
 */
class Fr
{
}

/**
 * DoesNotStartWith
 * @method null doesNotStartWith($value)
 */
class Fz
{
}

/**
 * DoesNotThrow
 * @method null doesNotThrow($value)
 */
class Eu
{
}

/**
 * @property null doesNotThrowException
 */
class Ev
{
}

/**
 * EndsWith
 * @method null endsWith($value)
 */
class Ga
{
}

/**
 * Equals
 * @method null equals($value)
 */
class Bg
{
}

/**
 * ExactlyEquals
 * @method null exactlyEquals($value)
 */
class Bh
{
}

/**
 * HasFragment
 * @method null hasFragment($value)
 */
class Gw
{
}

/**
 * HasHost
 * @method null hasHost($value)
 */
class Gq
{
}

/**
 * HasItem
 * @method null hasItem($value)
 */
class E
{
}

/**
 * HasItems
 * @method null hasItems($value)
 */
class F
{
}

/**
 * HasKey
 * @method null hasKey($value)
 */
class G
{
}

/**
 * HasKeys
 * @method null hasKeys($value)
 */
class H
{
}

/**
 * HasPassword
 * @method null hasPassword($value)
 */
class Gt
{
}

/**
 * HasPath
 * @method null hasPath($value)
 */
class Gu
{
}

/**
 * HasPort
 * @method null hasPort($value)
 */
class Gr
{
}

/**
 * HasProperty
 * @method null hasProperty($value)
 */
class Fn
{
}

/**
 * HasQuery
 * @method null hasQuery($value)
 */
class Gv
{
}

/**
 * HasScheme
 * @method null hasScheme($value)
 */
class Gp
{
}

/**
 * HasUser
 * @method null hasUser($value)
 */
class Gs
{
}

/**
 * HasValue
 * @method null hasValue($value)
 */
class I
{
}

/**
 * HasValues
 * @method null hasValues($value)
 */
class J
{
}

/**
 * @property null isABool
 */
class Cb
{
}

/**
 * @property null isABoolean
 */
class Ca
{
}

/**
 * @property null isANumber
 */
class Cg
{
}

/**
 * @property null isAString
 */
class Ch
{
}

/**
 * IsAfter
 * @method null isAfter($value)
 */
class Eq
{
}

/**
 * @property null isAnArray
 */
class Cc
{
}

/**
 * IsAnInstanceOf
 * @method null isAnInstanceOf($value)
 */
class Bz
{
}

/**
 * @property null isAnInt
 */
class Cd
{
}

/**
 * @property null isAnInteger
 */
class Ce
{
}

/**
 * @property null isAnMd5
 */
class Fk
{
}

/**
 * @property null isAnObject
 */
class Cf
{
}

/**
 * @property null isAssociative
 */
class O
{
}

/**
 * IsBefore
 * @method null isBefore($value)
 */
class Er
{
}

/**
 * IsBetween
 * @method null|Cu isBetween($value)
 */
class Bq
{
}

/**
 * @property null isEmpty
 */
class K
{
}

/**
 * @property null isFalse
 */
class Bm
{
}

/**
 * @property null isFalsy
 */
class Bn
{
}

/**
 * IsGreaterThan
 * @method null isGreaterThan($value)
 */
class Bt
{
}

/**
 * IsGreaterThanOrEqualTo
 * @method null isGreaterThanOrEqualTo($value)
 */
class Bu
{
}

/**
 * IsLessThan
 * @method null isLessThan($value)
 */
class Bv
{
}

/**
 * IsLessThanOrEqualTo
 * @method null isLessThanOrEqualTo($value)
 */
class Bw
{
}

/**
 * @property null isNotABool
 */
class Cj
{
}

/**
 * @property null isNotABoolean
 */
class Ci
{
}

/**
 * @property null isNotANumber
 */
class Co
{
}

/**
 * @property null isNotAString
 */
class Cp
{
}

/**
 * @property null isNotAnArray
 */
class Ck
{
}

/**
 * IsNotAnInstanceOf
 * @method null isNotAnInstanceOf($value)
 */
class By
{
}

/**
 * @property null isNotAnInt
 */
class Cl
{
}

/**
 * @property null isNotAnInteger
 */
class Cm
{
}

/**
 * @property null isNotAnObject
 */
class Cn
{
}

/**
 * @property null isNotAssociative
 */
class P
{
}

/**
 * IsNotBetween
 * @method null|Cu isNotBetween($value)
 */
class Bx
{
}

/**
 * @property null isNotEmpty
 */
class L
{
}

/**
 * @property null isNotNull
 */
class Cq
{
}

/**
 * @property null isNotNumeric
 */
class Cr
{
}

/**
 * IsNotTheSameAs
 * @method null isNotTheSameAs($value)
 */
class Bl
{
}

/**
 * @property null isNotUnique
 */
class M
{
}

/**
 * IsNotWithin
 * @method null|Cv isNotWithin($value)
 */
class Br
{
}

/**
 * @property null isNull
 */
class Cs
{
}

/**
 * @property null isNumeric
 */
class Ct
{
}

/**
 * IsTheSameAs
 * @method null isTheSameAs($value)
 */
class Bi
{
}

/**
 * @property null isTrue
 */
class Bo
{
}

/**
 * @property null isTruthy
 */
class Bp
{
}

/**
 * @property null isUnique
 */
class N
{
}

/**
 * @property null isValid
 */
class Go
{
}

/**
 * IsWithin
 * @method null|Cv isWithin($value)
 */
class Bs
{
}

/**
 * Matches
 * @method null matches($value)
 */
class Fq
{
}

/**
 * Of
 * @method null of($value)
 */
class Cv
{
}

/**
 * StartsWith
 * @method null startsWith($value)
 */
class Gb
{
}

/**
 * Throws
 * @method null throws($value)
 */
class Ew
{
}

/**
 * ThrowsAnythingExcept
 * @method null throwsAnythingExcept($value)
 */
class Ex
{
}

/**
 * ThrowsExactly
 * @method null throwsExactly($value)
 */
class Ey
{
}

/**
 * @property null throwsException
 */
class Ez
{
}

