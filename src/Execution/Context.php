<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Execution;
use sintloer\COLORFUL\Nextines\Store;

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

    public function __construct()
    {
        $this->store = Store::class;
    }
}
