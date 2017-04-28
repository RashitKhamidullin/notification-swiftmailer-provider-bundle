<?php
/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 13.04.17
 * Time: 16:51
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\StringProviderParameter;

class BodyParameter extends StringProviderParameter
{

    /**
     * Human readable name
     *
     * @return string
     */
    public function getName()
    {
        return 'message_body';
    }

    /**
     * Unique code for db search
     *
     * @return string
     */
    public function getCode()
    {
        return 'Body';
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'text';
    }
}