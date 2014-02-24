<?php
namespace Grid\GoogleAnalytics\Model;

use Grid\GoogleAnalytics\Model\Google\AnalyticsApi;

class GoogleApi extends AnalyticsApi
{

    /**
     * Application name for the google api
     *
     * @var string
     */
    const GOOGLE_API_APPLICATION_NAME = 'Gridguyz Google Analytics - DEV';

    public function __construct()
    {
        parent::__construct();
        
        $redirectUri = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $redirectUri .= $_SERVER['HTTP_HOST'];
        //$redirectUri .= '/app/admin/googleanalytics/api/callback';
        $redirectUri .= '/app/en/admin/dashboard';
        
        $this->getClient()->setRedirectUri($redirectUri);
        $this->getClient()->setAccessType('offline');
        $this->getClient()->setApprovalPrompt('force');
        $this->getClient()->setApplicationName(static::GOOGLE_API_APPLICATION_NAME);
    }
}

