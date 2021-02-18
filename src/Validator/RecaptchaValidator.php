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
    const MINIMUM_SCORE = 0.6;

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

        $secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
        $recaptchaRequest = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$value;
        $recaptcha = json_decode(file_get_contents($recaptchaRequest), true);

        $isInvalidAction = empty($constraint->action) ? false : $recaptcha['action'] != $constraint->action;

        if ($recaptcha['success'] == false || (float) $recaptcha['score'] < $this::MINIMUM_SCORE || $isInvalidAction) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
