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

namespace CoreShop\Payum\PayoneBundle\Controller;

use Payum\Bundle\PayumBundle\Controller\PayumController;
use Payum\Core\Request\Notify;
use Payum\Core\Security\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotifyController extends PayumController
{
    public function doUnsafePayoneAction(Request $request)
    {
        if (!$request->get('param')) {
            return new Response('Token parameter "param" is missing or empty', 400, ['Content-Type' => 'text/plain']);
        }

        $token = $this->getPayum()->getTokenStorage()->find($request->get('param'));

        if (!$token instanceof TokenInterface) {
            return new Response('Token param found, but no active token for it', 400, ['Content-Type' => 'text/plain']);
        }

        $gateway = $this->getPayum()->getGateway($token->getGatewayName());
        $gateway->execute(new Notify($token));

        return new Response('', 204);
    }
}
