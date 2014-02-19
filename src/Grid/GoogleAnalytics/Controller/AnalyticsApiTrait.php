<?php
namespace Grid\GoogleAnalytics\Controller;

use Grid\GoogleAnalytics\Model\Api;

trait AnalyticsApiTrait
{
    /**
     * 
     * @throws \Exception
     * @return \Grid\GoogleAnalytics\Controller\Api
     */
    protected function getApi()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();
    
        /* @var $session array */
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
    
        if ($params->fromQuery('clientId')) {
            $clientId = $params->fromQuery('clientId');
            $session['CLIENT_ID'] = $clientId;
        } elseif (isset($session['CLIENT_ID'])) {
            $clientId = $session['CLIENT_ID'];
        } else {
            throw new \Exception('Can\'t reteive client id');
        }
    
        if ($params->fromQuery('clientSecret')) {
            $clientSecret = $params->fromQuery('clientSecret');
            $session['CLIENT_SECRET'] = $clientSecret;
        } elseif (isset($session['CLIENT_SECRET'])) {
            $clientSecret = $session['CLIENT_SECRET'];
        } else {
            throw new \Exception('Can\'t reteive client id');
        }
    
        $redirectUrl = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $redirectUrl .= $_SERVER['HTTP_HOST'];
        $redirectUrl .= '/app/admin/googleanalytics/api/callback';
    
        $api = new Api();
        $api->setClientId($clientId);
        $api->setClientSecret($clientSecret);
        $api->setRedirectUrl($redirectUrl);
        $api->setApplicationName('gridguyz-google-analytics-module');
        $api->setScopes(array(
            'https://www.googleapis.com/auth/analytics.readonly'
        ));
        $api->setSessionManager($this->getServiceLocator()
            ->get('Zend\Session\ManagerInterface'));
    
        return $api;
    }
}

