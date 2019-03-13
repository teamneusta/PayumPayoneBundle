# CoreShop Payone Payum Connector
This Bundle activates the Payone PaymentGateway in CoreShop.
It requires the [coreshop/payum-payone](https://github.com/coreshop/payum-payone) repository which will be installed automatically.

## Notice
The Payone Payum Implementation currently only supports following gateways:
 - PayPal
 - Klarna Sofort
 - Credit Card

## Installation

#### 1. Composer
```json
    "coreshop/payum-payone-bundle": "^1.0"
```

#### 2. Activate
Enable the Bundle in Pimcore Extension Manager

#### 3. Setup
Go to Coreshop -> PaymentProvider and add a new Provider. Choose `payone` from `type` and fill out the required fields.

### Setup in Payone Portal

Use this as Notification URL: `/payment/notify/custom/payone`
