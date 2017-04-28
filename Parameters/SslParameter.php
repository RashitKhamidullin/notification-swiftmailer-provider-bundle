<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 20.04.17
 * Time: 11:59
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;

class SslParameter implements ProviderConnectionParameterInterface
{
    private $value;

    /**
     * Human readable name
     *
     * @return string
     */
    public function getName()
    {
       return "Use ssl";
    }

    /**
     * Unique code for db search
     *
     * @return string
     */
    public function getCode()
    {
        return "ssl";
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'bool';
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}