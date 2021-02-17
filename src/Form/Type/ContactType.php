<?php
/**
 * Created by PhpStorm.
 * User: johnjewelldino
 * Date: 2021-02-16
 * Time: 17:14
 */

namespace App\Form\Type;

use App\Entity\Contact;
use App\Validator\Constraints\Recaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname', TextType::class, [
                'constraints' => [
                    new Length([
                        'max' => 255
                    ])
                ]
            ])
            ->add('lname', TextType::class, [
                'constraints' => [
                    new Length([
                        'max' => 255
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotNull(['message' => 'Email should not be blank.']),
                    new Email(['message' => 'Invalid Email format.']),
                ]
            ])
        ;

        if (!empty($options['recaptchaAction'])) {
            $builder->add('recaptcha', TextType::class, [
                'constraints' => [
                    new Recaptcha(['action' => $options['recaptchaAction']])
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => Contact::class,
            'csrf_protection' => false,
        ]);
    }

}
