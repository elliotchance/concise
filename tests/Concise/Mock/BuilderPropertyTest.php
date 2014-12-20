<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderPropertyTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testGetAProtectedProperty(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->get();
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testSetAProtectedProperty(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->get();
        $this->setProperty($mock, 'hidden', 'bar');
        $this->assert($this->getProperty($mock, 'hidden'), equals, 'bar');
    }

    /**
     * @group #182
     * @dataProvider allBuilders
     */
    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->get();
        $this->setProperty($mock, 'secret', 'ok');
        $this->assert($this->getProperty($mock, 'secret'), equals, 'ok');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingAPropertyWhenCreatingAMockReturnsSelfForChaining(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $this->assert($builder->setProperty('secret', 'ok'), equals, $builder);
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingASingleProperty(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperty('property', 'ok')->get();
        $this->assert($mock->property, equals, 'ok');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingMultipleProperties(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperty('property1', 'a')->setProperty('property2', 'b')->get();
        $this->verify($mock->property1, equals, 'a');
        $this->verify($mock->property2, equals, 'b');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingPropertiesWhenCreatingAMockReturnsSelfForChaining(MockBuilder $builder, $type)
    {
        $this->assert($builder->setProperties(array()), equals, $builder);
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingMultiplePropertiesInOneStatement(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperties(array(
                'property1' => 'a',
                'property2' => 'b',
            ))->get();
        $this->verify($mock->property1, equals, 'a');
        $this->verify($mock->property2, equals, 'b');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingMultiplePropertiesInOneStatementWillNotOverrideOtherPropertiesSet(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperty('property1', 'a')
            ->setProperties(array(
                'property2' => 'b',
            ))->get();
        $this->verify($mock->property1, equals, 'a');
        $this->verify($mock->property2, equals, 'b');
    }
}
