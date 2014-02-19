<?php
namespace Grid\GoogleAnalytics\Model;

use Zork\Session\ContainerAwareTrait;

class Api
{
    use ContainerAwareTrait;

    protected $session;

    protected $clientId;

    protected $clientSecret;

    protected $redirectUrl;

    protected $applicationName;

    protected $scopes = array();

    public function getProfiles($webPropertyId)
    {
        $accountId = preg_replace('/^UA-/', '', $webPropertyId);
        $accountId = preg_replace('/-\d+$/', '', $accountId);
        
        $analytics = new \Google_Service_Analytics($this->getClient());

        $profiles = array();
        
        foreach( $analytics->management_profiles->listManagementProfiles($accountId, $webPropertyId) as $profile) {
            /* @var $profile \Google_Service_Analytics_Profile */
            $profiles[$profile->getId()] = $profile->getName();
        }
        
        natsort($profiles);
        
        return $profiles;
    }
    
    // INNEN mehet valami õsosztályba, trait-be
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
        
        $accessToken = $this->getAccessToken();
        
        if ($accessToken) {
            $client->setAccessToken($accessToken);
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

    public function setAccessToken($oauthToken)
    {
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        $session['ACCESS_TOKEN'] = $oauthToken;
        
        return $this;
    }

    public function getAccessToken()
    {
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        if (isset($session['ACCESS_TOKEN'])) {
            return $session['ACCESS_TOKEN'];
        }
        
        return null;
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
}

