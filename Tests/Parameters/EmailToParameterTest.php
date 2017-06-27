<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 26.06.17
 * Time: 16:55
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Tests\Parameters;


use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailToParameter;

class EmailToParameterTest extends \PHPUnit_Framework_TestCase
{
    /** @var EmailToParameter */
    private $parameter;

    protected function setUp()
    {
        $this->parameter = new EmailToParameter();
    }

    public function testCommaSeparated()
    {
        $this->parameter->setValue('first@gmail.com, second@gmail.com');

        $this->assertEquals(['first@gmail.com', 'second@gmail.com'], $this->parameter->getConvertedValue());
    }

    public function testWithParam()
    {
        $this->parameter->setValue(sprintf('another@box.com, {{%s}}', $this->parameter->getCode()));
        $this->parameter->setParameters([$this->parameter->getCode() => 'admin@gmail.com']);

        $this->assertEquals(['another@box.com', 'admin@gmail.com'], $this->parameter->getConvertedValue());
    }
}
