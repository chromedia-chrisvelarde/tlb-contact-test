<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-17
 * Time: 00:48
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Recaptcha extends Constraint
{
    public $message = 'reCAPTCHA Authorization Failed.';
    public $action;

    /**
     * Recaptcha constructor.
     * @param array|null $options
     * @param null $groups
     * @param mixed|null $payload
     */
    public function __construct(array $options = null, $groups = null, ?mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->action = empty($options['action']) ? '' : $options['action'];
    }

    public function validatedBy()
    {
        return 'App\Validator\RecaptchaValidator';
    }
}
