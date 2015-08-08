<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\AbstractMatcherTestCase;
use Exception;

class MyException extends Exception
{
}

class OtherException extends Exception
{
}

abstract class AbstractExceptionTestCase extends AbstractMatcherTestCase
{
    protected function createExceptionTests(array $data)
    {
        $throw = array(
            'throwNothing' => function () {
            },
            'throwException' => function () {
                throw new Exception();
            },
            'throwMyException' => function () {
                throw new MyException();
            },
            'throwOtherException' => function () {
                throw new OtherException();
            },
        );
        $expect = array(
            'expectException' => 'Exception',
            'expectMyException' => 'Concise\Modules\Exceptions\MyException',
            'expectOtherException' => 'Concise\Modules\Exceptions\OtherException',
        );
        $result = array(
            'FAIL' => true,
            'PASS' => false,
        );

        $r = array();
        foreach ($data as $d) {
            if (array_key_exists($d[2], $result)) {
                $r[] = array($throw[$d[0]], $expect[$d[1]], $result[$d[2]]);
            } else {
                $r[] = array($throw[$d[0]], $expect[$d[1]], $d[2]);
            }
        }

        return $r;
    }
}
