<?php declare(strict_types=1);
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Payum\PayoneBundle\Form\Payment;

use ArvPayoneApi\Request\PaymentTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paymentType', ChoiceType::class, [
                'choices' => [
                    PaymentTypes::PAYONE_CREDIT_CARD,
                    PaymentTypes::PAYONE_SOFORT,
                    PaymentTypes::PAYONE_PAY_PAL,
                ],
            ])
            ->add('mode', ChoiceType::class, [
                'choices' => [
                    'live', 'test',
                ],
            ])
            ->add('merchantId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('portalId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('accountId', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('key', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ]);
    }
}
