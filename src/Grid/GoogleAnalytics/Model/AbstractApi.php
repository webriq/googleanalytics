<?php
namespace Grid\GoogleAnalytics\Model;

use Zork\Session\ContainerAwareTrait;

class AbstractApi
{

    protected $clientId;

    protected $clientSecret;

    protected $redirectUrl;

    protected $applicationName;

    protected $scopes = array();

    protected $accessToken;

    public function isAuthenticated()
    {
        $client = $this->getClient();
        
        return $client->getAccessToken() && ! $client->isAccessTokenExpired();
    }

    public function getAuthenticateUrl()
    {
        $client = $this->getClient();
        
        return $client->createAuthUrl();
    }

    public function getClient()
    {
        $client = new \Google_Client();
        
        $client->setClientId($this->getClientId());
        $client->setClientSecret($this->getClientSecret());
        $client->setRedirectUri($this->getRedirectUrl());
        $client->setApplicationName($this->getApplicationName());
        $client->setScopes($this->getScopes());
        
        if (!is_null($this->getAccessToken())) {
            $client->setAccessToken($this->getAccessToken());
        }
        
        return $client;
    }

    public function authenticate($callbackCode)
    {
        $client = $this->getClient();
        
        $client->authenticate($callbackCode);
        
        $this->setAccessToken($client->getAccessToken());
        
        return $this;
    }

    /**
     *
     * @return the $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     *
     * @return the $clientSecret
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     *
     * @param field_type $clientId            
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     *
     * @param field_type $clientSecret            
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     *
     * @return the $redirectUrl
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     *
     * @param field_type $redirectUrl            
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     *
     * @return the $applicationName
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     *
     * @param field_type $applicationName            
     */
    public function setApplicationName($applicationName)
    {
        $this->applicationName = $applicationName;
    }

    /**
     *
     * @return the $scopes
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     *
     * @param multitype: $scopes            
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     *
     * @return the $accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     *
     * @param field_type $accessToken            
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}

