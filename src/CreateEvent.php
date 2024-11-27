<?php declare(strict_types=1);

class CreateEvent extends EventFactory
{
    function getMessage(): string
    {
        return "- Created {$this->payload->ref_type} in {$this->repo->name}" . PHP_EOL;
    }
}