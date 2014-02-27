<?php
namespace Grid\GoogleAnalytics\Model;

use Zork\Rpc\CallableTrait;
use Zork\Rpc\CallableInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Grid\GoogleAnalytics\Model\GoogleApi;
use Zork\Session\ContainerAwareTrait;

class Rpc implements CallableInterface, ServiceLocatorAwareInterface
{
    use CallableTrait;
    use ServiceLocatorAwareTrait;
    use ContainerAwareTrait;    
    
    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\GoogleApi\AuthProcess';
    
    const SESSION_KEY_CLIENT_ID = 'clientId';

    const SESSION_KEY_CLIENT_SECRET = 'clientSecret';
    
    const SESSION_KEY_TRACKING_ID = 'trackingId';

    
    public function getGoogleApiAuthenticationUrl($clientId, $clientSecret, $trackingId)
    {
        $serviceLocator = $this->getServiceLocator();
        
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        
        $api = new GoogleApi();
        $api->getClient()->setClientId($clientId);
        
        $authenticationUrl = $api->getClient()->createAuthUrl();
        
        $session[self::SESSION_KEY_CLIENT_ID] = $clientId;
        $session[self::SESSION_KEY_CLIENT_SECRET] = $clientSecret;
        $session[self::SESSION_KEY_TRACKING_ID] = $trackingId;
        
        return array(
            'authenticationUrl' => $authenticationUrl
        );
    }
}

