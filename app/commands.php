<?php

use App\Commands\{DatabaseDownCommand, DatabaseSeedsCommand, DatabaseUpCommand};
use App\Core\CLI\CLI;

CLI::addCommand('db:up', DatabaseUpCommand::class);
CLI::addCommand('db:down', DatabaseDownCommand::class);
CLI::addCommand('db:seeds', DatabaseSeedsCommand::class);
