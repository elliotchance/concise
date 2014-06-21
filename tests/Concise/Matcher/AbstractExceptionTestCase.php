<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class MyException extends \Exception
{
}

class OtherException extends \Exception
{
}

class AbstractExceptionTestCase extends AbstractMatcherTestCase
{
	protected function createExceptionTests(array $data)
	{
		$throw = array(
			'throwNothing' => function() {},
			'throwException' => function() { throw new \Exception(); },
			'throwMyException' => function() { throw new \Concise\Matcher\MyException(); },
			'throwOtherException' => function() { throw new \Concise\Matcher\OtherException(); },
		);
		$expect = array(
			'expectException' => 'Exception',
			'expectMyException' => 'Concise\Matcher\MyException',
			'expectOtherException' => 'Concise\Matcher\OtherException',
		);
		$result = array(
			'FAIL' => true,
			'PASS' => false,
		);

		$r = array();
		foreach($data as $d) {
			if(array_key_exists($d[2], $result)) {
				$r[] = array($throw[$d[0]], $expect[$d[1]], $result[$d[2]]);
			}
			else {
				$r[] = array($throw[$d[0]], $expect[$d[1]], $d[2]);
			}
		}
		return $r;
	}
}
