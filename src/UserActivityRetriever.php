<?php declare(strict_types=1);

class UserActivityRetriever 
{
    private array $events;

    public function __construct(string $username)
    {
        $this->setEventsFromUserActivity($username);
    }

    private function setEventsFromUserActivity(string $username)
    {
        $user_activity = $this->fetchUserActivity($username);
        foreach ($user_activity as $event_data) {
            try {
                $this->events[]= EventFactory::createEvent($event_data);
            } catch (EventTypeNotFoundException $e) { 

            }
        }
    }

    private function fetchUserActivity(string $username): array
    {
        $response = $this->performUserActivityRequest($username);        

        $user_activity = json_decode($response);

        if ($user_activity === null) {
            throw new Exception('Error fetching the user activity.');
        }

        return $user_activity;
    }

    private function performUserActivityRequest(string $username)
    {
        $endpoint = "https://api.github.com/users/{$username}/events";

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'User-Agent: php' ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("cURL error: " . curl_error($ch));
        }        

        curl_close($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code === 404) {
            throw new Exception("User not found.");
        }

        if ($http_code !== 200) {
            throw new Exception("The API request failed with HTTP status code " . $http_code . ".");
        }

        return $response;
    }

    public function displayEvents()
    {
        foreach ($this->events as $event) {
            echo $event->getMessage();
        }
    }
}