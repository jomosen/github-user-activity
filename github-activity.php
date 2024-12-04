<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    $total_command_line_interface_args = $argc;
    $array_command_line_interface_args = $argv;

    if ($total_command_line_interface_args !== 2) {
        throw new Exception('Usage: php github-activity.php <username>');
    }

    $username = $array_command_line_interface_args[1];

    $userActivityRetriever = new UserActivityRetriever($username);
    $userActivityRetriever->displayEvents();

} catch (Exception $e) {
    exit($e->getMessage());
}