<?php declare(strict_types=1);

class IssuesEvent extends EventFactory
{
    function getMessage(): string
    {
        return "- " . ucfirst($this->payload->action) . " an issue in {$this->repo->name}" . PHP_EOL;
    }
}