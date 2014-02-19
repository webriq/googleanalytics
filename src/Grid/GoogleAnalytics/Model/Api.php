<?php
namespace Grid\GoogleAnalytics\Model;

class Api extends AbstractGoogleAnalyticsApi
{
    public function __construct($clientId = null, $clientSecret = null)
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUrl($this->getRedirectUrl());
        $this->setApplicationName('gridguyz-google-analytics-module');
        $this->setScopes(array(
            'https://www.googleapis.com/auth/analytics.readonly'
        ));
    }

    public function getRedirectUrl()
    {
        if (! isset($this->redirectUrl)) {
            $this->redirectUrl = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $this->redirectUrl .= $_SERVER['HTTP_HOST'];
            $this->redirectUrl .= '/app/admin/googleanalytics/api/callback';
        }
        
        return $this->redirectUrl;
    }
}

