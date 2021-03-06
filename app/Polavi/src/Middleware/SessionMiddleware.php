<?php
/**
 * Copyright © Nguyen Huu The <the.nguyen@polavi.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Polavi\Middleware;

use function Polavi\get_current_language_id;
use Polavi\Services\Http\Request;
use Polavi\Services\Http\Response;
use Polavi\Services\Locale\Language;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionMiddleware extends MiddlewareAbstract
{
    public function __invoke(Request $request, Response $response, $delegate = null)
    {
        $session_name = $request->isAdmin() ? 'admin' : 'front';
        $this->getContainer()->get(Session::class)->setName($session_name);
        // TODO: Set lifetime for session
        $this->getContainer()->get(Session::class)->start();
        $request->setSession($this->getContainer()->get(Session::class));
        $response->addState('language', Language::listLanguagesV2()[get_current_language_id()]);

        return $delegate;
    }
}