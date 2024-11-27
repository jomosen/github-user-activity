<?php declare(strict_types=1);

class ForkEvent extends EventFactory
{
    function getMessage(): string
    {
        return "- Forked {$this->repo->name}" . PHP_EOL;
    }
}