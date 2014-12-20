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
            $this->expectFailure("You cannot set property on an interface");
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
            $this->expectFailure("You cannot set property on an interface");
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
            $this->expectFailure("You cannot set property on an interface");
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
            $this->expectFailure("You cannot set property on an interface.");
        }
        $this->assert($builder->setProperty('secret', 'ok'), equals, $builder);
    }
}
