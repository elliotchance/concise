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
 * @method Fk|Fl|Fm|Fn|Fo|Fp|Fq|Fr|Fs|Ft|Fu|Fv|Fw|Fx|Fy|Fz|Ga|Gb|Gc|Gd|Ge|Gf|Gg|Gh|Gi|Gj|Gk|Gl|Gm|Gn|Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw|Gx|Gy|Gz|Ha|Hb|Hc|Hd|He|Hf|Hg|Hh|Hi|Hj|Hk|Hl|Hm|Hn|Ho|Hp|Hq|Hr assertHash($valueOrFailureMessage, $value = null)
 * @method Fk|Fl|Fm|Fn|Fo|Fp|Fq|Fr|Fs|Ft|Fu|Fv|Fw|Fx|Fy|Fz|Ga|Gb|Gc|Gd|Ge|Gf|Gg|Gh|Gi|Gj|Gk|Gl|Gm|Gn|Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw|Gx|Gy|Gz|Ha|Hb|Hc|Hd|He|Hf|Hg|Hh|Hi|Hj|Hk|Hl|Hm|Hn|Ho|Hp|Hq|Hr verifyHash($valueOrFailureMessage, $value = null)
 * @method Ka|Kb assertObject($valueOrFailureMessage, $value = null)
 * @method Ka|Kb verifyObject($valueOrFailureMessage, $value = null)
 * @method Ke|Kf|Kg|Kh|Ki|Kj|K|L|Km|Kn|Ko|Kp assertString($valueOrFailureMessage, $value = null)
 * @method Ke|Kf|Kg|Kh|Ki|Kj|K|L|Km|Kn|Ko|Kp verifyString($valueOrFailureMessage, $value = null)
 * @method Lc|Ld|Le|Lf|Lg|Lh|Li|Lj|Lk assertUrl($valueOrFailureMessage, $value = null)
 * @method Lc|Ld|Le|Lf|Lg|Lh|Li|Lj|Lk verifyUrl($valueOrFailureMessage, $value = null)
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
class Kg
{
}

/**
 * ContainsCaseInsensitive
 * @method null containsCaseInsensitive($value)
 */
class Kh
{
}

/**
 * DoesNotContain
 * @method null doesNotContain($value)
 */
class Ki
{
}

/**
 * DoesNotContainCaseInsensitive
 * @method null doesNotContainCaseInsensitive($value)
 */
class Kj
{
}

/**
 * DoesNotEndWith
 * @method null doesNotEndWith($value)
 */
class Km
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
class Ka
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
class Kf
{
}

/**
 * DoesNotStartWith
 * @method null doesNotStartWith($value)
 */
class Kn
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
class Ko
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
class Lk
{
}

/**
 * HasHost
 * @method null hasHost($value)
 */
class Le
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
class Lh
{
}

/**
 * HasPath
 * @method null hasPath($value)
 */
class Li
{
}

/**
 * HasPort
 * @method null hasPort($value)
 */
class Lf
{
}

/**
 * HasProperty
 * @method null hasProperty($value)
 */
class Kb
{
}

/**
 * HasQuery
 * @method null hasQuery($value)
 */
class Lj
{
}

/**
 * HasScheme
 * @method null hasScheme($value)
 */
class Ld
{
}

/**
 * HasUser
 * @method null hasUser($value)
 */
class Lg
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
 * @property null isAValidAdler32
 */
class Fm
{
}

/**
 * @property null isAValidCrc32
 */
class Fk
{
}

/**
 * @property null isAValidCrc32b
 */
class Fl
{
}

/**
 * @property null isAValidFnv132
 */
class Fn
{
}

/**
 * @property null isAValidFnv164
 */
class Fu
{
}

/**
 * @property null isAValidGost
 */
class Hd
{
}

/**
 * @property null isAValidHaval128
 */
class Gb
{
}

/**
 * @property null isAValidHaval160
 */
class Gl
{
}

/**
 * @property null isAValidHaval192
 */
class Gr
{
}

/**
 * @property null isAValidHaval224
 */
class Gv
{
}

/**
 * @property null isAValidHaval256
 */
class Ha
{
}

/**
 * @property null isAValidJoaat
 */
class Fo
{
}

/**
 * @property null isAValidMd2
 */
class Fy
{
}

/**
 * @property null isAValidMd4
 */
class Fx
{
}

/**
 * @property null isAValidMd5
 */
class Fw
{
}

/**
 * @property null isAValidRipemd128
 */
class Fz
{
}

/**
 * @property null isAValidRipemd160
 */
class Gj
{
}

/**
 * @property null isAValidRipemd256
 */
class Gz
{
}

/**
 * @property null isAValidRipemd320
 */
class Hk
{
}

/**
 * @property null isAValidSha1
 */
class Gi
{
}

/**
 * @property null isAValidSha224
 */
class Gu
{
}

/**
 * @property null isAValidSha256
 */
class Gy
{
}

/**
 * @property null isAValidSha384
 */
class Hm
{
}

/**
 * @property null isAValidSha512
 */
class Ho
{
}

/**
 * @property null isAValidSnefru
 */
class Hb
{
}

/**
 * @property null isAValidSnefru256
 */
class Hc
{
}

/**
 * @property null isAValidTiger128
 */
class Ga
{
}

/**
 * @property null isAValidTiger160
 */
class Gk
{
}

/**
 * @property null isAValidTiger192
 */
class Gq
{
}

/**
 * @property null isAValidWhirlpool
 */
class Hp
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
 * @property null isNotAValidAdler32
 */
class Fr
{
}

/**
 * @property null isNotAValidCrc32
 */
class Fp
{
}

/**
 * @property null isNotAValidCrc32b
 */
class Fq
{
}

/**
 * @property null isNotAValidFnv132
 */
class Fs
{
}

/**
 * @property null isNotAValidFnv164
 */
class Fv
{
}

/**
 * @property null isNotAValidGost
 */
class Hj
{
}

/**
 * @property null isNotAValidHaval128
 */
class Gh
{
}

/**
 * @property null isNotAValidHaval160
 */
class Gp
{
}

/**
 * @property null isNotAValidHaval192
 */
class Gt
{
}

/**
 * @property null isNotAValidHaval224
 */
class Gx
{
}

/**
 * @property null isNotAValidHaval256
 */
class Hg
{
}

/**
 * @property null isNotAValidJoaat
 */
class Ft
{
}

/**
 * @property null isNotAValidMd2
 */
class Ge
{
}

/**
 * @property null isNotAValidMd4
 */
class Gd
{
}

/**
 * @property null isNotAValidMd5
 */
class Gc
{
}

/**
 * @property null isNotAValidRipemd128
 */
class Gf
{
}

/**
 * @property null isNotAValidRipemd160
 */
class Gn
{
}

/**
 * @property null isNotAValidRipemd256
 */
class Hf
{
}

/**
 * @property null isNotAValidRipemd320
 */
class Hl
{
}

/**
 * @property null isNotAValidSha1
 */
class Gm
{
}

/**
 * @property null isNotAValidSha224
 */
class Gw
{
}

/**
 * @property null isNotAValidSha256
 */
class He
{
}

/**
 * @property null isNotAValidSha384
 */
class Hn
{
}

/**
 * @property null isNotAValidSha512
 */
class Hq
{
}

/**
 * @property null isNotAValidSnefru
 */
class Hh
{
}

/**
 * @property null isNotAValidSnefru256
 */
class Hi
{
}

/**
 * @property null isNotAValidTiger128
 */
class Gg
{
}

/**
 * @property null isNotAValidTiger160
 */
class Go
{
}

/**
 * @property null isNotAValidTiger192
 */
class Gs
{
}

/**
 * @property null isNotAValidWhirlpool
 */
class Hr
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
class Lc
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
class Ke
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
class Kp
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

