<?php
namespace Grid\GoogleAnalytics\Model\Google;

class Api
{

    /**
     * Google Api client
     *
     * @var \Google_Client
     */
    protected $client;

    /**
     * Indicates that the client's token refreshed or not
     *
     * @var boolean
     */
    protected $tokenRefreshed = false;

    /**
     * Returns the google client
     *
     * @return \Google_Client
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new \Google_Client();
        }
        
        $client = $this->client;
        
        if ($client->getAccessToken() && $client->isAccessTokenExpired()) {
            
            $token = json_decode($client->getAccessToken());
            
            if (isset($token->refresh_token)) {
                $client->getAuth()->refreshToken($token->refresh_token);
                $client->setAccessToken($client->getAuth()->getAccessToken());
                $this->setTokenRefreshed(true);
            }
        }
        
        return $client;
    }

    public function isTokenRefreshed()
    {
        return $this->tokenRefreshed;
    }

    /**
     * Sets the google client
     *
     * @param \Google_Client $client            
     * @return \Grid\GoogleAnalytics\Model\Google\Api
     */
    public function setClient(\Google_Client $client)
    {
        $this->client = $client;
        return $this;
    }

    protected function setTokenRefreshed($tokenRefreshed)
    {
        $this->tokenRefreshed = $tokenRefreshed;
    }
}

