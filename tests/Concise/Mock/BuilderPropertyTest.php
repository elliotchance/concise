<?php

namespace Concise\Mock;

class MagicProperty
{
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            return 'not_found';
        }
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

class ParentClass
{
    private /** @noinspection PhpUnusedPrivateFieldInspection */ $a = 1;

    private /** @noinspection PhpUnusedPrivateFieldInspection */ $c = 4;

    public function a()
    {
        return $this->a;
    }

    public function c()
    {
        return $this->c;
    }
}

class ChildClass extends ParentClass
{
    private /** @noinspection PhpUnusedPrivateFieldInspection */ $a = 2;

    private /** @noinspection PhpUnusedPrivateFieldInspection */ $b = 3;

    public function a()
    {
        return $this->a;
    }

    public function b()
    {
        return $this->b;
    }
}

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
        $this->assert($this->getProperty($mock, 'hidden'))->equals('foo');
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
        $this->assert($this->getProperty($mock, 'hidden'))->equals('bar');
    }

    /**
     * @group #182
     * @dataProvider allBuilders
     */
    public function testSetAPrivatePropertyOnAMockWillSetThePropertyOnTheNonMockedClass(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->get();
        $this->setProperty($mock, 'secret', 'ok');
        $this->assert($this->getProperty($mock, 'secret'))->equals('ok');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingAPropertyWhenCreatingAMockReturnsSelfForChaining(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $this->assert($builder->setProperty('secret', 'ok'))->equals($builder);
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
        $this->assert($mock->property)->equals('ok');
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
        $mock = $builder->setProperty('property1', 'a')->setProperty(
            'property2',
            'b'
        )->get();
        $this->verify($mock->property1)->equals('a');
        $this->verify($mock->property2)->equals('b');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingPropertiesWhenCreatingAMockReturnsSelfForChaining(
        MockBuilder $builder
    ) {
        $this->assert($builder->setProperties(array()))->equals($builder);
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingMultiplePropertiesInOneStatement(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperties(
            array(
                'property1' => 'a',
                'property2' => 'b',
            )
        )->get();
        $this->verify($mock->property1)->equals('a');
        $this->verify($mock->property2)->equals('b');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     */
    public function testSettingMultiplePropertiesInOneStatementWillNotOverrideOtherPropertiesSet(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface.");
        }
        $mock = $builder->setProperty('property1', 'a')->setProperties(
            array(
                'property2' => 'b',
            )
        )->get();
        $this->verify($mock->property1)->equals('a');
        $this->verify($mock->property2)->equals('b');
    }

    /**
     * @group #199
     * @dataProvider allBuilders
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testAPropertyNameMustBeAString(MockBuilder $builder)
    {
        $builder->setProperty(123, 456);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testSetAProtectedPropertyWhenCreatingTheMock(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->setProperty('hidden', 'bar')->get();
        $this->assert($this->getProperty($mock, 'hidden'))->equals('bar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testSetAPropertyThatDoesNotExistIsPermitted(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->setProperty('does_not_exist', 'bar')->get();
        $this->assert($this->getProperty($mock, 'does_not_exist'))
            ->equals('bar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testNullPropertiesAreStillFound(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot set a property on an interface");
        }
        $mock = $builder->setProperty('does_not_exist', null)->get();
        $this->assert($this->getProperty($mock, 'does_not_exist'))->isNull;
    }

    public function testPropertiesAreAlwaysFoundIfClassHasMagicGet()
    {
        $this->assert(
            $this->getProperty(new MagicProperty(), 'does_not_exist')
        )->equals('not_found');
    }

    public function testPropertiesAreAlwaysSetIfClassHasMagicSet()
    {
        $object = new MagicProperty();
        $this->setProperty($object, 'foo', 'bar');
        $this->assert($this->getProperty($object, 'foo'))->equals('bar');
    }

    /**
     * @group #309
     */
    public function testPrivatePropertyIsSetOnChildClassByDefault()
    {
        $object = new ChildClass();
        $this->setProperty($object, 'a', 'foo');
        $this->assert($object->a())->equals('foo');
    }

    /**
     * @group #309
     */
    public function testPrivatePropertyCanBeSetOnAnExplicitClass()
    {
        $object = new ChildClass();
        $this->setProperty($object, 'a', 'foo', get_parent_class($object));
        $this->assert($object->a())->equals(2);
    }

    /**
     * @group #309
     */
    public function testPrivatePropertyOnlyOnParentClassWillBeSet()
    {
        $object = new ChildClass();
        $this->setProperty($object, 'c', 'foo');
        $this->assert($object->c())->equals('foo');
    }

    /**
     * @group #309
     */
    public function testGetAmbiguousPrivatePropertyReturnsChildClass()
    {
        $object = new ChildClass();
        $this->assert($this->getProperty($object, 'a'))->equals(2);
    }
}
