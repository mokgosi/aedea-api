<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'placeholder' => 'Enter your name',
                    'class' => 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-200',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email Address',
                'attr' => [
                    'placeholder' => 'john@example.com',
                    'class' => 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-200',
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'placeholder' => 'How can we help?',
                    'class' => 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-200',

                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Write your message here...',
                    'class' => 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-200 resize-none',

                ],
            ])
            ->add('captcha', ReCaptchaType::class);
            // ->add('captcha', Recaptcha3Type::class, [
            //     'constraints' => new Recaptcha3(),
            //     'action_name' => 'contact',
            //     'locale' => 'en',
            // ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}



