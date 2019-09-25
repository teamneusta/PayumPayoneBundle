<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Payum\PayoneBundle\Extension;

use CoreShop\Component\Address\Model\AddressInterface;
use CoreShop\Component\Core\Model\CustomerInterface;
use CoreShop\Component\Core\Model\OrderItemInterface;
use CoreShop\Component\Order\Model\OrderInterface;
use CoreShop\Component\Order\Repository\OrderRepositoryInterface;
use CoreShop\Component\Core\Model\PaymentInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Request\Convert;

final class PopulatePayoneExtension implements ExtensionInterface
{
    /**
     * @param Context $context
     */
    public function onPostExecute(Context $context)
    {
        $action = $context->getAction();

        if (!$action) {
            return;
        }

        $previousActionClassName = get_class($action);
        if (false === stripos($previousActionClassName, 'ConvertPaymentAction')) {
            return;
        }

        /** @var Convert $request */
        $request = $context->getRequest();
        if (false === $request instanceof Convert) {
            return;
        }

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        if (false === $payment instanceof PaymentInterface) {
            return;
        }

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        /**
         * @var CustomerInterface $customer
         * @var AddressInterface $address
         */
        $customer = $order->getCustomer();
        $address = $order->getShippingAddress();

        $customerData = [
            'salutation' => $customer->getSalutation(),
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'email' => $customer->getEmail(),
            'language' => $customer->getLocaleCode()
        ];

        $addressData = [
            'town' => $address->getCity(),
            'postalCode' => $address->getPostcode(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'street' => $address->getStreet(),
            'houseNumber' => $address->getNumber(),
            'country' => $address->getCountry()->getIsoCode()
        ];

        $bankAccountData = [
            'country' => $order->getInvoiceAddress()->getCountry()->getIsoCode()
        ];

        $orderData = [
            'amount' => $order->getTotal(true),
            'currency' => $order->getCurrency()->getIsoCode()
        ];

        $basketData = [
            'basketAmount' => $order->getTotal(true),
            'currency' => $order->getCurrency()->getIsoCode()
        ];
        $basketItems = [];

        /**
         * @var OrderItemInterface $orderItem
         */
        foreach ($order->getItems() as $orderItem) {
            $basketItems[] = [
                'name' => $orderItem->getName(),
                'quantity' => $orderItem->getQuantity(),
                'itemId' => $orderItem->getId(),
                'price' => $orderItem->getTotal()
            ];
        }

        $result = ArrayObject::ensureArrayObject($request->getResult());

        $result['order'] = array_merge($result['order'] ?? [], $orderData);
        $result['basket'] = array_merge($result['basket'] ?? [], $basketData);
        $result['basketItems'] = array_merge($result['basketItems'] ?? [], $basketItems);
        $result['shippingAddress'] = array_merge($result['shippingAddress'] ?? [], $addressData);
        $result['customer'] = array_merge($result['customer'] ?? [], $customerData);
        $result['bankAccount'] = array_merge($result['bankAccount'] ?? [], $bankAccountData);
        $result['language'] = $order->getLocaleCode();

        $result['reference'] = $order->getOrderNumber();
        $result['narrative_text'] = $order->getOrderNumber();
        $result['transaction_param'] = $order->getOrderNumber();

        $request->setResult((array)$result);
    }

    /**
     * {@inheritdoc}
     */
    public function onPreExecute(Context $context)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function onExecute(Context $context)
    {
    }
}
