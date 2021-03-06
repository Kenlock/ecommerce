<?php
/**
 * Copyright © Nguyen Huu The <the.nguyen@polavi.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Polavi\Module\Setting\Middleware\Payment;

use function Polavi\_mysql;
use function Polavi\get_default_language_Id;
use function Polavi\get_js_file_url;
use Polavi\Services\Http\Request;
use Polavi\Middleware\MiddlewareAbstract;
use Polavi\Services\Http\Response;
use Polavi\Services\Routing\Router;
// TODO: move this middlewre to COD module
class CODFormMiddleware extends MiddlewareAbstract
{
    public function __invoke(Request $request, Response $response, $delegate = null)
    {
        if($request->getMethod() == 'POST')
            return $delegate;

        $stm = _mysql()
            ->executeQuery("SELECT * FROM `setting`
WHERE language_id = :language
AND `name` LIKE 'payment_cod_%'
UNION 
SELECT * FROM `setting`
WHERE `name` NOT IN (SELECT `name` FROM `setting` WHERE language_id = :language AND `name` LIKE 'payment_cod_%') 
AND language_id = 0
AND `name` LIKE 'payment_cod_%'", ['language' => $request->attributes->get('language', get_default_language_Id())!= get_default_language_Id() ? $request->attributes->get('language', get_default_language_Id()) : 0]);

        $data = [];
        while ($row = $stm->fetch()) {
            if($row['json'] == 1)
                $data[$row['name']] = json_decode($row['value'], true);
            else
                $data[$row['name']] = $row['value'];
        }

        $response->addWidget(
            'cod_payment_form',
            'payment-setting',
            10,
            get_js_file_url("production/cod/setting/cod_form.js", true),
            array_merge($data, [
                "action"=>$this->getContainer()->get(Router::class)->generateUrl('setting.payment', ['method'=>'cod']),
            ])
        );

        return $delegate;
    }
}