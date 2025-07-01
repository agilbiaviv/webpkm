<?php

namespace App\Libraries;

class RateLimiter
{
    protected $limit; // Maximum number of attempts
    protected $timeFrame; // Time frame in seconds
    protected $sessionKey;

    public function __construct($limit = 3, $timeFrame = 30) // Adjusted to 20 seconds for testing
    {
        $this->limit = $limit;
        $this->timeFrame = $timeFrame;
        $this->sessionKey = 'login_attempts';
    }

    public function check()
    {
        $session = session();

        // Initialize if not set
        if (!$session->has($this->sessionKey)) {
            $session->set($this->sessionKey, [
                'count' => 0,
                'first_attempt_time' => time()
            ]);
        }

        $data = $session->get($this->sessionKey);

        // Reset count if time frame has passed
        if (time() - $data['first_attempt_time'] > $this->timeFrame) {
            $session->set($this->sessionKey, [
                'count' => 0,
                'first_attempt_time' => time() // Reset the time to now on a new period
            ]);
            return true; // Allow attempt since time frame has expired
        }
        
        // Check if attempts exceed limit
        if ($data['count'] >= $this->limit) {
            return false; // Rate limit exceeded
        }

        // Increment the count
        $data['count']++;
            
        // Update the timestamp on every failed attempt
        $session->set($this->sessionKey, [
            'count' => $data['count'],
            'first_attempt_time' => time() // Update the time for the last attempt
        ]);
        return true; // Allowed to proceed
    }

    public function getRemainingTime()
    {
        $session = session();
        if ($session->has($this->sessionKey)) {
            $data = $session->get($this->sessionKey);
            if ($data['count'] >= $this->limit) {
                $elapsedTime = time() - $data['first_attempt_time'];
                $remainingTime = $this->timeFrame - $elapsedTime;
                return max(0, $remainingTime); // Return remaining time or 0
            }
        }
        return 0; // No limit or attempts
    }
}
