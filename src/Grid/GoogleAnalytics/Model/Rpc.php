<?php
namespace Grid\GoogleAnalytics\Model;

use Zork\Rpc\CallableTrait;
use Zork\Rpc\CallableInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zork\Session\ContainerAwareTrait;

class Rpc implements CallableInterface, ServiceLocatorAwareInterface
{
    use CallableTrait;
    use ServiceLocatorAwareTrait;
    use ContainerAwareTrait;

    public function getGoogleApiAuthenticationUrl($clientId, $clientSecret)
    {
        /* @var $session array */
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        $session['CLIENT_ID'] = $clientId;
        $session['CLIENT_SECRET'] = $clientSecret;
        
        $api = $this->getApi($clientId, $clientSecret, $this->getRedirectBase() . '/app/admin/googleanalytics/api/callback');
        
        if ($api->isAuthenticated()) {
            return array(
                'action' => 'redirect',
                'url' => $this->getRedirectBase() . '/app/en/admin/googleanalytics/api/refresh', 
            );
        } else {
            return array(
                'action' => 'redirect',
                'url' => $api->getAuthenticateUrl()
            );
        }
    }

    protected function getRedirectBase() {
        $redirectUrl = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $redirectUrl .= $_SERVER['HTTP_HOST'];
        
        return $redirectUrl;
    }
    

    protected function getApi($clientId, $clientSecret, $redirectUrl)
    {
        $api = new Api();
        $api->setClientId($clientId);
        $api->setClientSecret($clientSecret);
        $api->setRedirectUrl($redirectUrl);
        $api->setApplicationName('gridguyz-google-analytics-module');
        $api->setScopes(array(
            'https://www.googleapis.com/auth/analytics.readonly'
        ));
        $api->setSessionManager($this->getServiceLocator()->get('Zend\Session\ManagerInterface'));
        
        return $api;
    }
}

