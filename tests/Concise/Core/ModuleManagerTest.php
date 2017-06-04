<?php

namespace Concise\Core;

use Concise\Console\Theme\NoColorTheme;
use Concise\Module\AbstractModule;
use Concise\Core\TestCase;

class MyBadMatcher extends AbstractModule
{
    public function match()
    {
        return false;
    }

    public function getName()
    {
    }
}

class ModuleManagerTest extends TestCase
{
    /** @var ModuleManager */
    protected $parser;

    public function setUp()
    {
        parent::setUp();
        $this->parser = new ModuleManager();
        $this->theme = new NoColorTheme();
    }

    public function testGetInstanceIsASingleton()
    {
        $this->assert(ModuleManager::getInstance())
            ->exactlyEquals(ModuleManager::getInstance());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such matcher for syntax 'something'.
     */
    public function testGetMatcherForSyntaxThrowsExceptionIfNoMatchersAreFound()
    {
        $this->parser->getMatcherForSyntax('something');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (123) must be regex.
     */
    public function testWillValidateAllAttributes()
    {
        $this->assertString("abc")->doesNotMatch(123);
    }

    /**
     * @param string[] $supportedSyntaxes
     * @return AbstractModule
     */
    protected function getAbstractMatcherMockWithSupportedSyntaxes(
        $supportedSyntaxes
    ) {
        return $this->mock('\Concise\Module\AbstractModule')->stub(
            array('supportedSyntaxes' => $supportedSyntaxes)
        )->get();
    }

    public function testOnErrorIsReturnedWhenLocatingTheMatcher()
    {
        $parser = ModuleManager::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array(''));
        $this->assertArray($matcher)->hasKey('on_error');
    }

    public function testOnErrorIsNotReturnedIfNotInTheSyntax()
    {
        $parser = ModuleManager::getInstance();
        $matcher = $parser->getMatcherForSyntax('? equals ?', array());
        $this->assertArray($matcher)->doesNotHaveKey('on_error');
    }

    public function testOnErrorIsReturnedFromData()
    {
        $parser = ModuleManager::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array('foo'));
        $this->assert($matcher['on_error'])->equals('foo');
    }

    public function testOnErrorMustBeTheLastData()
    {
        $parser = ModuleManager::getInstance();
        $matcher = $parser->getMatcherForSyntax(
            '? equals ? on error ?',
            array('foo', 'bar')
        );
        $this->assert($matcher['on_error'])->equals('bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testSyntaxMustBeAString()
    {
        $parser = new ModuleManager();
        $parser->getMatcherForSyntax(123);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (null) must be regex.
     */
    public function testWillUseValueRendererForValuesInExceptionMessages()
    {
        $this->assertString("abc")->doesNotMatch(null);
    }

    public function testGetModules()
    {
        $this->assert($this->parser->getModules())->isAnArray;
    }
}
