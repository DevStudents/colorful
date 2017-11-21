<?php

/**
 * COLORFULframework
 * @author sintloer <contact@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Execution;
use sintloer\COLORFUL\Nextines\Store;
use sintloer\COLORFUL\Http\Request;

class Context
{

    /**
     * Store Nextine storage.
     * @var object
     *
     */

    public $store;

    /**
     * Constructor.
     *
     */

    public function __construct(Request $request)
    {
        $this->store = Store::class;

        $requestMethod = $request->method();
        if(!empty($requestMethod))
        {
            $lower = strtolower($requestMethod);
            $upper = strtoupper($requestMethod);
            $this->$lower = true;
            $this->$upper = true;
        }
    }
}
