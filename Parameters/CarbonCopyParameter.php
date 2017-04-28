<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 19.04.17
 * Time: 17:40
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ArrayProviderParameter;

class CarbonCopyParameter extends ArrayProviderParameter
{
    /**
     * Human readable name
     *
     * @return string
     */
    public function getName()
    {
        return "CC";
    }

    /**
     * Unique code for db search
     *
     * @return string
     */
    public function getCode()
    {
        return "carbon_copy";
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'string';
    }
}