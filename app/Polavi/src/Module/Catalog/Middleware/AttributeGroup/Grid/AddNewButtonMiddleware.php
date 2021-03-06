<?php
/**
 * Copyright © Nguyen Huu The <the.nguyen@polavi.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Polavi\Module\Catalog\Middleware\AttributeGroup\Grid;

use function Polavi\generate_url;
use function Polavi\get_js_file_url;
use Polavi\Services\Helmet;
use Polavi\Services\Http\Request;
use Polavi\Services\Http\Response;
use Polavi\Middleware\MiddlewareAbstract;

class AddNewButtonMiddleware extends MiddlewareAbstract
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $delegate = null)
    {
        $response->addWidget(
            'attribute-group-grid-add-new',
            'attribute_group_grid_container',
            5,
            get_js_file_url("production/catalog/attribute_group/grid/add_new_button.js", true),
            [
                "url" => generate_url('attribute.group.create')
            ]
        );

        return $delegate;
    }
}