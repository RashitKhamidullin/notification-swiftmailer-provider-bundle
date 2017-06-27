<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 27.06.17
 * Time: 11:38
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Tests\Parameters;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailFromParameter;

class EmailFromParameterTest extends \PHPUnit_Framework_TestCase
{
    /** @var EmailFromParameter */
    private $parameter;
    /** @var \PHPUnit_Framework_MockObject_MockObject | \Twig_Environment */
    private $twig;

    protected function setUp()
    {
        $this->twig = new \Twig_Environment(new \Twig_Loader_Array());
        $this->parameter = $this->createParameter($this->twig);
    }

    public function testSimpleValue()
    {
        $this->parameter->setValue('from@email.com');
        $this->parameter->setParameters([]);

        $this->assertEquals('from@email.com', $this->parameter->getConvertedValue());
    }

    public function testRenderedValue()
    {
        $this->parameter->setValue('{{param}}');
        $this->parameter->setParameters(['param' => 'value']);

        $this->assertEquals('value', $this->parameter->getConvertedValue());
    }

    /**
     * @return EmailFromParameter
     */
    protected function createParameter($twig)
    {
        return new EmailFromParameter($twig);
    }
}
