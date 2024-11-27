<?php declare(strict_types=1);

class WatchEvent extends EventFactory
{
    function getMessage(): string
    {
        return "- Starred {$this->repo->name}" . PHP_EOL;
    }
}