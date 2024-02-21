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

namespace CoreShop\Payum\PayoneBundle\Action;

use CoreShop\Component\Payment\Model\PaymentInterface;
use Payum\Core\Request\Convert;

class ConvertPaymentAction extends \CoreShop\Payum\Payone\Action\ConvertPaymentAction
{
    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            'array' === $request->getTo();
    }
}
