<?php

use Controllers\MainController;

return [
    '~^hello$~' => [MainController::class, 'hello'],
];
