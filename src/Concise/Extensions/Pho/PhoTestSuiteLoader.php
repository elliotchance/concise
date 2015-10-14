<?php

namespace {
    // Drop out here if they do not have the Pho package installed.
    if (!class_exists('pho\Runnable\Spec')) {
        return;
    }
}

namespace pho\Reporter {
    /**
     * Pho will only let us load a reporter by name if it exists in the
     * pho\Reporter namespace. Since we don't want to put the bulk of the code
     * here we create basically an alias to the real class that the class loader
     * can find.
     */
    class ConciseReporter extends \Concise\Extensions\Pho\ConciseReporter
    {
    }
}

namespace Concise\Extensions\Pho {
    use Concise\Core\TestCase;
    use Concise\Core\VirtualTestSuiteInterface;
    use pho\Console\Console;
    use pho\Reporter\ConciseReporter;
    use pho\Runner\Runner;
    use PHPUnit_Framework_TestCase;
    use PHPUnit_Framework_TestResult;
    use PHPUnit_Runner_StandardTestSuiteLoader;
    use ReflectionClass;

    class PhoTestCase extends PHPUnit_Framework_TestCase implements VirtualTestSuiteInterface
    {
        public static $count = 0;

        public function test()
        {
        }

        public function count()
        {
            return 1;
        }

        public function run(PHPUnit_Framework_TestResult $result = null)
        {
            if ($result === null) {
                $result = $this->createResult();
            }

            ConciseReporter::$test = $this;
            ConciseReporter::$testCase = new TestCase();
            ConciseReporter::$result = $result;

            // Create a new Console and parse arguments
            $console = new Console(
                array('--reporter', 'concise'),
                'php://stdout'
            );
            $console->parseArguments();

            // Start the runner
            Runner::$console = $console;
            Runner::getInstance()->run();

            return $result;
        }

        public function getRealCount()
        {
            return self::$count;
        }
    }

    class PhoTestSuiteLoader extends PHPUnit_Runner_StandardTestSuiteLoader
    {
        public function load($suiteClassName, $suiteClassFile = '')
        {
            if (substr($suiteClassName, -4) === 'Spec') {
                $tokens = token_get_all(file_get_contents($suiteClassFile));
                PhoTestCase::$count = count(
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

                require_once($suiteClassFile);

                return new ReflectionClass(
                    'Concise\Extensions\Pho\PhoTestCase'
                );
            }
            return parent::load($suiteClassName, $suiteClassFile);
        }
    }
}

namespace {

    use pho\Expectation\Expectation;
    use pho\Runner\Runner;

    /**
     * Calls the runner's describe() method, creating a test suite with the
     * provided closure.
     *
     * @param string   $title A title associated with this suite
     * @param \Closure $closure The closure associated with the suite, which
     *     may
     *                          contain nested suites and specs
     */
    function describe($title, \Closure $closure)
    {
        Runner::getInstance()->describe($title, $closure);
    }

    /**
     * Calls the runner's xdescribe() method, creating a pending test suite with
     * the provided closure.
     *
     * @param string   $title A title associated with this suite
     * @param \Closure $closure The closure associated with the suite, which may
     *                          contain nested suites and specs
     */
    function xdescribe($title, \Closure $closure)
    {
        Runner::getInstance()->xdescribe($title, $closure);
    }

    /**
     * An alias for describe. Creates a test suite with the given closure.
     *
     * @param string   $title A title associated with this suite
     * @param \Closure $closure The closure associated with the suite, which may
     *                          contain nested suites and specs
     */
    function context($title, \Closure $closure)
    {
        Runner::getInstance()->describe($title, $closure);
    }

    /**
     * An alias for xdescribe. Creates a pending test suite with the given
     * closure.
     *
     * @param string   $title A title associated with this suite
     * @param \Closure $closure The closure associated with the suite, which
     *     may
     *                          contain nested suites and specs
     */
    function xcontext($title, \Closure $closure)
    {
        Runner::getInstance()->xdescribe($title, $closure);
    }

    /**
     * Calls the runner's it() method, creating a test spec with the provided
     * closure.
     *
     * @param string   $title A title associated with this spec
     * @param \Closure $closure The closure associated with the spec
     */
    function it($title, \Closure $closure = null)
    {
        Runner::getInstance()->it($title, $closure);
    }

    /**
     * Calls the runner's xit() method, creating a pending test spec with the
     * provided closure.
     *
     * @param string   $title A title associated with this spec
     * @param \Closure $closure The closure associated with the spec
     */
    function xit($title, \Closure $closure = null)
    {
        Runner::getInstance()->xit($title, $closure);
    }

    /**
     * Calls the runner's before() method, defining a closure to be ran prior to
     * the parent suite's closure.
     *
     * @param \Closure $closure The closure to be ran before the suite
     */
    function before(\Closure $closure)
    {
        Runner::getInstance()->before($closure);
    }

    /**
     * Calls the runner's after() method, defining a closure to be ran after the
     * parent suite's closure.
     *
     * @param \Closure $closure The closure to be ran after the suite
     */
    function after(\Closure $closure)
    {
        Runner::getInstance()->after($closure);
    }

    /**
     * Calls the runner's beforeEach() method, defining a closure to be ran
     * prior to each of the parent suite's nested suites and specs.
     *
     * @param \Closure $closure The closure to be ran before each spec
     */
    function beforeEach(\Closure $closure)
    {
        Runner::getInstance()->beforeEach($closure);
    }

    /**
     * Calls the runner's afterEach() method, defining a closure to be ran after
     * each of the parent suite's nested suites and specs.
     *
     * @param \Closure $closure The closure to be ran after the suite
     */
    function afterEach(\Closure $closure)
    {
        Runner::getInstance()->afterEach($closure);
    }

    /**
     * Creates and returns a new Expectation for the supplied value.
     *
     * @param mixed $actual The value to test
     */
    function expect($actual)
    {
        return new Expectation($actual);
    }
}
