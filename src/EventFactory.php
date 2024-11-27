<?php declare(strict_types=1);

abstract class EventFactory
{
    protected object $repo;
    protected object $payload;

    function __construct(object $repo, object $payload)
    {
        $this->repo = $repo;
        $this->payload = $payload;
    }

    static function createEvent(object $event_data): EventFactory
    {
        $repo = $event_data->repo;
        $payload = $event_data->payload;
        switch ($event_data->type) {
            case 'PushEvent':
                return new PushEvent($repo, $payload);
            case 'CreateEvent':
                return new CreateEvent($repo, $payload);
            case 'ForkEvent':
                return new ForkEvent($repo, $payload);
            case 'IssuesEvent':
                return new IssuesEvent($repo, $payload);
            case 'WatchEvent':
                return new WatchEvent($repo, $payload);
        }

        throw new EventTypeNotFoundException();
    }

    abstract function getMessage();
}