<?php

namespace Concise\Extensions\Pho;

use Concise\Core\VirtualTestSuiteInterface;
use PHPUnit_Extensions_PhptTestCase;
use PHPUnit_Framework_Exception;
use PHPUnit_Framework_TestSuite;
use PHPUnit_Runner_BaseTestRunner;
use PHPUnit_Util_InvalidArgumentHelper;
use ReflectionClass;

/**
 * Almost all of the code in this class has been copied from
 * PHPUnit_Framework_TestSuite. Unfortunately this is required to stop PHPUnit
 * from requiring in files in a static context. Best efforts have been made to
 * only copy the absolutele minimum code required. However, you may assume that
 * all the code below is a direct copy of the parent or another method and only
 * lines that commented are modified from the parent.
 */
class PhoTestSuite extends PHPUnit_Framework_TestSuite implements VirtualTestSuiteInterface
{
    /**
     * Copied from PHPUnit_Util_Fileloader.
     * @param string $filename
     * @return mixed
     */
    public function load($filename)
    {
        $oldVariableNames = array_keys(get_defined_vars());

        include_once $filename;

        $newVariables = get_defined_vars();
        $newVariableNames = array_diff(
            array_keys($newVariables),
            $oldVariableNames
        );

        foreach ($newVariableNames as $variableName) {
            if ($variableName != 'oldVariableNames') {
                $GLOBALS[$variableName] = $newVariables[$variableName];
            }
        }

        return $filename;
    }

    /**
     * Copied from PHPUnit_Util_Fileloader.
     * @param string $filename
     * @return string
     */
    public function checkAndLoad($filename)
    {
        $includePathFilename = stream_resolve_include_path($filename);

        if (!$includePathFilename || !is_readable($includePathFilename)) {
            throw new PHPUnit_Framework_Exception(
                sprintf('Cannot open file "%s".' . "\n", $filename)
            );
        }

        $this->load($includePathFilename);

        return $includePathFilename;
    }

    public function addTestFile($filename)
    {
        if (!is_string($filename)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        if (file_exists($filename) && substr($filename, -5) == '.phpt') {
            $this->addTest(
                new PHPUnit_Extensions_PhptTestCase($filename)
            );

            return;
        }

        // The given file may contain further stub classes in addition to the
        // test class itself. Figure out the actual test class.
        $classes = get_declared_classes();
        $filename = $this->checkAndLoad($filename);
        $newClasses = array_diff(get_declared_classes(), $classes);

        // The diff is empty in case a parent class (with test methods) is added
        // AFTER a child class that inherited from it. To account for that case,
        // cumulate all discovered classes, so the parent class may be found in
        // a later invocation.
        if ($newClasses) {
            // On the assumption that test classes are defined first in files,
            // process discovered classes in approximate LIFO order, so as to
            // avoid unnecessary reflection.
            $this->foundClasses = array_merge($newClasses, $this->foundClasses);
        }

        // The test class's name must match the filename, either in full, or as
        // a PEAR/PSR-0 prefixed shortname ('NameSpace_ShortName'), or as a
        // PSR-1 local shortname ('NameSpace\ShortName'). The comparison must be
        // anchored to prevent false-positive matches (e.g., 'OtherShortName').
        $shortname = basename($filename, '.php');
        $shortnameRegEx = '/(?:^|_|\\\\)' . preg_quote($shortname, '/') . '$/';

        foreach ($this->foundClasses as $i => $className) {
            if (preg_match($shortnameRegEx, $className)) {
                $class = new ReflectionClass($className);

                if ($class->getFileName() == $filename) {
                    $newClasses = array($className);
                    unset($this->foundClasses[$i]);
                    break;
                }
            }
        }

        foreach ($newClasses as $className) {
            $class = new ReflectionClass($className);

            if (!$class->isAbstract()) {
                if ($class->hasMethod(
                    PHPUnit_Runner_BaseTestRunner::SUITE_METHODNAME
                )
                ) {
                    $method = $class->getMethod(
                        PHPUnit_Runner_BaseTestRunner::SUITE_METHODNAME
                    );

                    if ($method->isStatic()) {
                        $this->addTest($method->invoke(null, $className));
                    }
                } elseif ($class->implementsInterface(
                    'PHPUnit_Framework_Test'
                )
                ) {
                    $this->addTestSuite($class);
                }
            }
        }

        $tokens = token_get_all(file_get_contents($filename));
        PhoTestCase::$count += count(
            array_filter(
                $tokens,
                function ($token) {
                    return
                        is_array($token) &&
                        $token[0] == 308 &&
                        $token[1] == 'it';
                }
            )
        );

        static $done = false;
        if (!$done) {
            $this->addTestSuite(
                new \ReflectionClass('Concise\Extensions\Pho\PhoTestCase')
            );
            $done = true;
        }
    }

    public function getRealCount()
    {
        return max(1, PhoTestCase::$count);
    }
}
