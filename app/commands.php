<?php

use App\Commands\{DatabaseDownCommand, DatabaseSeedsCommand, DatabaseUpCommand};
use App\Core\CLI\CLI;

CLI::addCommand(DatabaseUpCommand::getCommand(), DatabaseUpCommand::class);
CLI::addCommand(DatabaseDownCommand::getCommand(), DatabaseDownCommand::class);
CLI::addCommand(DatabaseSeedsCommand::getCommand(), DatabaseSeedsCommand::class);
