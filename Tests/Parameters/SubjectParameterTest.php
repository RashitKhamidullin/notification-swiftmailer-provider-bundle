<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 27.06.17
 * Time: 12:17
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Tests\Parameters;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\SubjectParameter;

class SubjectParameterTest extends \PHPUnit_Framework_TestCase
{
    /** @var SubjectParameter */
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
        $this->parameter->setValue("Email subject");

        $this->assertEquals("Email subject", $this->parameter->getConvertedValue());
    }

    public function testTwigTemplateValue()
    {
        $this->parameter->setValue(sprintf("This email with {{%s}}", $this->parameter->getCode()));
        $this->parameter->setParameters([$this->parameter->getCode() => "important subject"]);

        $this->assertEquals("This email with important subject", $this->parameter->getConvertedValue());
    }

    /**
     * @return SubjectParameter
     */
    protected function createParameter($twig)
    {
        return new SubjectParameter($twig);
    }
}
