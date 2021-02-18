<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-17
 * Time: 00:47
 */

namespace App\Validator;

use App\Validator\Constraints\Recaptcha;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class RecaptchaValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Recaptcha) {
            throw new UnexpectedTypeException($constraint, Recaptcha::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $siteKey = "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"; // TODO: Transfer to .env or .yaml file
        $secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; // Sample only, TODO: Transfer to .env or .yaml file
        $minScore = 0.5; // TODO: Transfer to .env or .yaml file

        $recaptchaRequest = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$value;
        $captcha = json_decode(file_get_contents($recaptchaRequest), true);

        var_dump($captcha);

        $isInvalidAction = empty($constraint->action) ? false : $captcha['action'] != $constraint->action;

        if ($captcha['success'] == false || (float) $captcha['score'] < $minScore || $isInvalidAction) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
