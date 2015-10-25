<?php

namespace Concise\Core;

use PHPUnit_Framework_TestCase;

/**
 * @method A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R assertArray($valueOrFailureMessage, $value = null)
 * @method A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R verifyArray($valueOrFailureMessage, $value = null)
 * @method Bk|Bl|Bm|Bn|Bo|Bp|Bq|Br|Bs|Bt|Bu|Bv|Bw|Bx|By|Bz|Ca|Cb|Cc|Cd|Ce|Cf|Cg|Ch|Ci|Cj|Ck|Cl|Cm|Cn|Co|Cp|Cq|Cr|Cs|Ct|Cu|Cv|Cw|Cx assert($valueOrFailureMessage, $value = null)
 * @method Bk|Bl|Bm|Bn|Bo|Bp|Bq|Br|Bs|Bt|Bu|Bv|Bw|Bx|By|Bz|Ca|Cb|Cc|Cd|Ce|Cf|Cg|Ch|Ci|Cj|Ck|Cl|Cm|Cn|Co|Cp|Cq|Cr|Cs|Ct|Cu|Cv|Cw|Cx verify($valueOrFailureMessage, $value = null)
 * @method Eu|Ev assertDate($valueOrFailureMessage, $value = null)
 * @method Eu|Ev verifyDate($valueOrFailureMessage, $value = null)
 * @method Ey|Ez|Fa|Fb|Fc|Fd assertClosure($valueOrFailureMessage, $value = null)
 * @method Ey|Ez|Fa|Fb|Fc|Fd verifyClosure($valueOrFailureMessage, $value = null)
 * @method Bk|Bn assertFile($valueOrFailureMessage, $value = null)
 * @method Bk|Bn verifyFile($valueOrFailureMessage, $value = null)
 * @method Fo|Fp|Fq|Fr|Fs|Ft|Fu|Fv|Fw|Fx|Fy|Fz|Ga|Gb|Gc|Gd|Ge|Gf|Gg|Gh|Gi|Gj|Gk|Gl|Gm|Gn|Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw|Gx|Gy|Gz|Ha|Hb|Hc|Hd|He|Hf|Hg|Hh|Hi|Hj|Hk|Hl|Hm|Hn|Ho|Hp|Hq|Hr|Hs|Ht|Hu|Hv assertHash($valueOrFailureMessage, $value = null)
 * @method Fo|Fp|Fq|Fr|Fs|Ft|Fu|Fv|Fw|Fx|Fy|Fz|Ga|Gb|Gc|Gd|Ge|Gf|Gg|Gh|Gi|Gj|Gk|Gl|Gm|Gn|Go|Gp|Gq|Gr|Gs|Gt|Gu|Gv|Gw|Gx|Gy|Gz|Ha|Hb|Hc|Hd|He|Hf|Hg|Hh|Hi|Hj|Hk|Hl|Hm|Hn|Ho|Hp|Hq|Hr|Hs|Ht|Hu|Hv verifyHash($valueOrFailureMessage, $value = null)
 * @method Ke|Kf assertObject($valueOrFailureMessage, $value = null)
 * @method Ke|Kf verifyObject($valueOrFailureMessage, $value = null)
 * @method Ki|Kj|Kk|Kl|Km|Kn|K|L|Kq|Kr|Ks|Kt assertString($valueOrFailureMessage, $value = null)
 * @method Ki|Kj|Kk|Kl|Km|Kn|K|L|Kq|Kr|Ks|Kt verifyString($valueOrFailureMessage, $value = null)
 * @method Lg|Lh|Li|Lj|Lk|Ll|Lm|Ln|Lo assertUrl($valueOrFailureMessage, $value = null)
 * @method Lg|Lh|Li|Lj|Lk|Ll|Lm|Ln|Lo verifyUrl($valueOrFailureMessage, $value = null)
 */
abstract class BaseAssertions extends PHPUnit_Framework_TestCase
{
}

/**
 * And
 * @method null and($value)
 */
class Cy
{
}

/**
 * Contains
 * @method null contains($value)
 */
class Kk
{
}

/**
 * ContainsCaseInsensitive
 * @method null containsCaseInsensitive($value)
 */
class Kl
{
}

/**
 * CountIs
 * @method null countIs($value)
 */
class Q
{
}

/**
 * CountIsNot
 * @method null countIsNot($value)
 */
class R
{
}

/**
 * DoesNotContain
 * @method null doesNotContain($value)
 */
class Km
{
}

/**
 * DoesNotContainCaseInsensitive
 * @method null doesNotContainCaseInsensitive($value)
 */
class Kn
{
}

/**
 * DoesNotEndWith
 * @method null doesNotEndWith($value)
 */
class Kq
{
}

/**
 * DoesNotEqual
 * @method null doesNotEqual($value)
 */
class Bn
{
}

/**
 * DoesNotExactlyEqual
 * @method null doesNotExactlyEqual($value)
 */
class Bo
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
class Ke
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
class Kj
{
}

/**
 * DoesNotStartWith
 * @method null doesNotStartWith($value)
 */
class Kr
{
}

/**
 * DoesNotThrow
 * @method null doesNotThrow($value)
 */
class Ey
{
}

/**
 * @property null doesNotThrowException
 */
class Ez
{
}

/**
 * EndsWith
 * @method null endsWith($value)
 */
class Ks
{
}

/**
 * Equals
 * @method null equals($value)
 */
class Bk
{
}

/**
 * ExactlyEquals
 * @method null exactlyEquals($value)
 */
class Bl
{
}

/**
 * HasFragment
 * @method null hasFragment($value)
 */
class Lo
{
}

/**
 * HasHost
 * @method null hasHost($value)
 */
class Li
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
class Ll
{
}

/**
 * HasPath
 * @method null hasPath($value)
 */
class Lm
{
}

/**
 * HasPort
 * @method null hasPort($value)
 */
class Lj
{
}

/**
 * HasProperty
 * @method null hasProperty($value)
 */
class Kf
{
}

/**
 * HasQuery
 * @method null hasQuery($value)
 */
class Ln
{
}

/**
 * HasScheme
 * @method null hasScheme($value)
 */
class Lh
{
}

/**
 * HasUser
 * @method null hasUser($value)
 */
class Lk
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
class Cf
{
}

/**
 * @property null isABoolean
 */
class Ce
{
}

/**
 * @property null isANumber
 */
class Ck
{
}

/**
 * @property null isAString
 */
class Cl
{
}

/**
 * @property null isAValidAdler32
 */
class Fq
{
}

/**
 * @property null isAValidCrc32
 */
class Fo
{
}

/**
 * @property null isAValidCrc32b
 */
class Fp
{
}

/**
 * @property null isAValidFnv132
 */
class Fr
{
}

/**
 * @property null isAValidFnv164
 */
class Fy
{
}

/**
 * @property null isAValidGost
 */
class Hh
{
}

/**
 * @property null isAValidHaval128
 */
class Gf
{
}

/**
 * @property null isAValidHaval160
 */
class Gp
{
}

/**
 * @property null isAValidHaval192
 */
class Gv
{
}

/**
 * @property null isAValidHaval224
 */
class Gz
{
}

/**
 * @property null isAValidHaval256
 */
class He
{
}

/**
 * @property null isAValidJoaat
 */
class Fs
{
}

/**
 * @property null isAValidMd2
 */
class Gc
{
}

/**
 * @property null isAValidMd4
 */
class Gb
{
}

/**
 * @property null isAValidMd5
 */
class Ga
{
}

/**
 * @property null isAValidRipemd128
 */
class Gd
{
}

/**
 * @property null isAValidRipemd160
 */
class Gn
{
}

/**
 * @property null isAValidRipemd256
 */
class Hd
{
}

/**
 * @property null isAValidRipemd320
 */
class Ho
{
}

/**
 * @property null isAValidSha1
 */
class Gm
{
}

/**
 * @property null isAValidSha224
 */
class Gy
{
}

/**
 * @property null isAValidSha256
 */
class Hc
{
}

/**
 * @property null isAValidSha384
 */
class Hq
{
}

/**
 * @property null isAValidSha512
 */
class Hs
{
}

/**
 * @property null isAValidSnefru
 */
class Hf
{
}

/**
 * @property null isAValidSnefru256
 */
class Hg
{
}

/**
 * @property null isAValidTiger128
 */
class Ge
{
}

/**
 * @property null isAValidTiger160
 */
class Go
{
}

/**
 * @property null isAValidTiger192
 */
class Gu
{
}

/**
 * @property null isAValidWhirlpool
 */
class Ht
{
}

/**
 * IsAfter
 * @method null isAfter($value)
 */
class Eu
{
}

/**
 * @property null isAnArray
 */
class Cg
{
}

/**
 * IsAnInstanceOf
 * @method null isAnInstanceOf($value)
 */
class Cd
{
}

/**
 * @property null isAnInt
 */
class Ch
{
}

/**
 * @property null isAnInteger
 */
class Ci
{
}

/**
 * @property null isAnObject
 */
class Cj
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
class Ev
{
}

/**
 * IsBetween
 * @method null|Cy isBetween($value)
 */
class Bu
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
class Bq
{
}

/**
 * @property null isFalsy
 */
class Br
{
}

/**
 * IsGreaterThan
 * @method null isGreaterThan($value)
 */
class Bx
{
}

/**
 * IsGreaterThanOrEqualTo
 * @method null isGreaterThanOrEqualTo($value)
 */
class By
{
}

/**
 * IsLessThan
 * @method null isLessThan($value)
 */
class Bz
{
}

/**
 * IsLessThanOrEqualTo
 * @method null isLessThanOrEqualTo($value)
 */
class Ca
{
}

/**
 * @property null isNotABool
 */
class Cn
{
}

/**
 * @property null isNotABoolean
 */
class Cm
{
}

/**
 * @property null isNotANumber
 */
class Cs
{
}

/**
 * @property null isNotAString
 */
class Ct
{
}

/**
 * @property null isNotAValidAdler32
 */
class Fv
{
}

/**
 * @property null isNotAValidCrc32
 */
class Ft
{
}

/**
 * @property null isNotAValidCrc32b
 */
class Fu
{
}

/**
 * @property null isNotAValidFnv132
 */
class Fw
{
}

/**
 * @property null isNotAValidFnv164
 */
class Fz
{
}

/**
 * @property null isNotAValidGost
 */
class Hn
{
}

/**
 * @property null isNotAValidHaval128
 */
class Gl
{
}

/**
 * @property null isNotAValidHaval160
 */
class Gt
{
}

/**
 * @property null isNotAValidHaval192
 */
class Gx
{
}

/**
 * @property null isNotAValidHaval224
 */
class Hb
{
}

/**
 * @property null isNotAValidHaval256
 */
class Hk
{
}

/**
 * @property null isNotAValidJoaat
 */
class Fx
{
}

/**
 * @property null isNotAValidMd2
 */
class Gi
{
}

/**
 * @property null isNotAValidMd4
 */
class Gh
{
}

/**
 * @property null isNotAValidMd5
 */
class Gg
{
}

/**
 * @property null isNotAValidRipemd128
 */
class Gj
{
}

/**
 * @property null isNotAValidRipemd160
 */
class Gr
{
}

/**
 * @property null isNotAValidRipemd256
 */
class Hj
{
}

/**
 * @property null isNotAValidRipemd320
 */
class Hp
{
}

/**
 * @property null isNotAValidSha1
 */
class Gq
{
}

/**
 * @property null isNotAValidSha224
 */
class Ha
{
}

/**
 * @property null isNotAValidSha256
 */
class Hi
{
}

/**
 * @property null isNotAValidSha384
 */
class Hr
{
}

/**
 * @property null isNotAValidSha512
 */
class Hu
{
}

/**
 * @property null isNotAValidSnefru
 */
class Hl
{
}

/**
 * @property null isNotAValidSnefru256
 */
class Hm
{
}

/**
 * @property null isNotAValidTiger128
 */
class Gk
{
}

/**
 * @property null isNotAValidTiger160
 */
class Gs
{
}

/**
 * @property null isNotAValidTiger192
 */
class Gw
{
}

/**
 * @property null isNotAValidWhirlpool
 */
class Hv
{
}

/**
 * @property null isNotAnArray
 */
class Co
{
}

/**
 * IsNotAnInstanceOf
 * @method null isNotAnInstanceOf($value)
 */
class Cc
{
}

/**
 * @property null isNotAnInt
 */
class Cp
{
}

/**
 * @property null isNotAnInteger
 */
class Cq
{
}

/**
 * @property null isNotAnObject
 */
class Cr
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
 * @method null|Cy isNotBetween($value)
 */
class Cb
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
class Cu
{
}

/**
 * @property null isNotNumeric
 */
class Cv
{
}

/**
 * IsNotTheSameAs
 * @method null isNotTheSameAs($value)
 */
class Bp
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
 * @method null|Cz isNotWithin($value)
 */
class Bv
{
}

/**
 * @property null isNull
 */
class Cw
{
}

/**
 * @property null isNumeric
 */
class Cx
{
}

/**
 * IsTheSameAs
 * @method null isTheSameAs($value)
 */
class Bm
{
}

/**
 * @property null isTrue
 */
class Bs
{
}

/**
 * @property null isTruthy
 */
class Bt
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
class Lg
{
}

/**
 * IsWithin
 * @method null|Cz isWithin($value)
 */
class Bw
{
}

/**
 * Matches
 * @method null matches($value)
 */
class Ki
{
}

/**
 * Of
 * @method null of($value)
 */
class Cz
{
}

/**
 * StartsWith
 * @method null startsWith($value)
 */
class Kt
{
}

/**
 * Throws
 * @method null throws($value)
 */
class Fa
{
}

/**
 * ThrowsAnythingExcept
 * @method null throwsAnythingExcept($value)
 */
class Fb
{
}

/**
 * ThrowsExactly
 * @method null throwsExactly($value)
 */
class Fc
{
}

/**
 * @property null throwsException
 */
class Fd
{
}

