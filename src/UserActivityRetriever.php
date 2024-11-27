<?php declare(strict_types=1);

class UserActivityRetriever 
{
    private string $username;
    private array $events;

    public function __construct(string $username)
    {
        $this->username = $username;
        $user_activity = $this->fetchUserActivity();
        $this->setEventsFromUserActivity($user_activity);
    }

    private function fetchUserActivity(): array
    {
        $response = $this->performUserActivityRequest();        

        $user_activity = json_decode($response);

        if ($user_activity === null) {
            throw new Exception('Error fetching the user activity.');
        }

        return $user_activity;
    }

    private function performUserActivityRequest()
    {
        $endpoint = "https://api.github.com/users/{$this->username}/events";

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

    private function setEventsFromUserActivity(array $user_activity)
    {
        foreach ($user_activity as $event_data) {
            try {
                $this->events[]= EventFactory::createEvent($event_data);
            } catch (EventTypeNotFoundException $e) { 

            }
        }
    }

    public function displayEvents()
    {
        foreach ($this->events as $event) {
            echo $event->getMessage();
        }
    }
}