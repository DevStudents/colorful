<?php

require __DIR__ . '/vendor/autoload.php';

use sintloer\COLORFUL\Creation;
$COLORFULframework = new Creation('DEVELOPMENT');

/* CONFIGURATION */
require './usage/setup.php';

/* LISTENERS */
require './usage/listeners.php';

/* START METHOD */
require './usage/before.php';

/* ROUTES V1 */
require './usage/routesV1.php';

/* ROUTES V2 */
require './usage/routesV2.php';

/* FINISH METHOD */
require './usage/after.php';
