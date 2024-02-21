/*
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 *
 */

pimcore.registerNS('coreshop.provider.gateways.payone');
coreshop.provider.gateways.payone = Class.create(coreshop.provider.gateways.abstract, {
    getLayout: function (config) {
        var gatewayTypes = new Ext.data.ArrayStore({
            fields: ['name'],
            data: [
                ['CreditCard'],
                ['Sofort'],
                ['PayPal']
            ]
        });

        var modes = new Ext.data.ArrayStore({
            fields: ['name'],
            data: [
                ['live'],
                ['test']
            ]
        });

        return [
            {
                xtype: 'combobox',
                fieldLabel: t('payone_mode'),
                name: 'gatewayConfig.config.mode',
                value: config.mode ? config.mode : '',
                store: modes,
                triggerAction: 'all',
                valueField: 'name',
                displayField: 'name',
                mode: 'local',
                forceSelection: true,
                selectOnFocus: true
            },
            {
                xtype: 'combobox',
                fieldLabel: t('payone_payment_type'),
                name: 'gatewayConfig.config.paymentType',
                value: config.paymentType ? config.paymentType : '',
                store: gatewayTypes,
                triggerAction: 'all',
                valueField: 'name',
                displayField: 'name',
                mode: 'local',
                forceSelection: true,
                selectOnFocus: true
            },
            {
                xtype: 'textfield',
                fieldLabel: t('payone_merchant_id'),
                name: 'gatewayConfig.config.merchantId',
                length: 255,
                value: config.merchantId ? config.merchantId : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('payone_portal_id'),
                name: 'gatewayConfig.config.portalId',
                length: 255,
                value: config.portalId ? config.portalId : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('payone_account_id'),
                name: 'gatewayConfig.config.accountId',
                length: 255,
                value: config.accountId ? config.accountId : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('payone_key'),
                name: 'gatewayConfig.config.key',
                length: 255,
                value: config.key ? config.key : ""
            },
        ];
    }
});
