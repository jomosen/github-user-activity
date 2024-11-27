<?php declare(strict_types=1);

class PushEvent extends EventFactory
{
    function getMessage(): string
    {
        return "- Pushed {$this->payload->size} commits to {$this->repo->name}" . PHP_EOL;
    }
}