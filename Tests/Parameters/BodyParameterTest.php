<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 27.06.17
 * Time: 12:25
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Tests\Parameters;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\BodyParameter;

class BodyParameterTest extends \PHPUnit_Framework_TestCase
{
    /** @var BodyParameter */
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
        $this->parameter->setValue("Email body");

        $this->assertEquals("Email body", $this->parameter->getConvertedValue());
    }

    public function testTwigTemplateValue()
    {
        $this->parameter->setValue(sprintf("This email contains {{%s}}", $this->parameter->getCode()));
        $this->parameter->setParameters([$this->parameter->getCode() => "vary body"]);

        $this->assertEquals("This email contains vary body", $this->parameter->getConvertedValue());
    }

    public function testExtendsTemplate()
    {
        $value = '{% extends "base.html" %}{% block content %}Hello {{ name }}{% endblock %}';

        $loader = new \Twig_Loader_Array(array('base.html' => '{% block content %}{% endblock %}'));

        $this->twig->setLoader($loader);

        $parameter = $this->createParameter($this->twig);

        $parameter->setValue($value);
        $parameter->setParameters(['name' => 'World']);

        $this->assertEquals('Hello World', $parameter->getConvertedValue());
    }

    /**
     * @return BodyParameter
     */
    protected function createParameter($twig)
    {
        return new BodyParameter($twig);
    }
}
