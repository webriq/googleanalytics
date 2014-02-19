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

    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\Api\AuthProcess';

    const SESSION_KEY_CLIENT_ID = 'CLIENT_ID';

    const SESSION_KEY_CLIENT_SECRET = 'CLIENT_SECRET';

    const SESSION_KEY_ANALYITICS_ID = 'ANALYITICS_ID';

    const SESSION_KEY_ADMIN_LOCALE = 'ADMIN_LOCALE';

    const SESSION_KEY_ACCESS_TOKEN = 'ACCESS_TOKEN';

    public function getGoogleApiAuthenticationUrl($clientId, $clientSecret, $analiticsId)
    {
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $api = new Api($clientId, $clientSecret);
        
        
        
        $session[self::SESSION_KEY_CLIENT_ID] = $clientId;
        $session[self::SESSION_KEY_CLIENT_SECRET] = $clientSecret;
        $session[self::SESSION_KEY_ADMIN_LOCALE] = 'en';
        $session[self::SESSION_KEY_ANALYITICS_ID] = $analiticsId;
        
        if (isset($session[$this->getTokenKey()])) {
            $api->setAccessToken($session[$this->getTokenKey()]);
        }
        
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

    protected function getRedirectBase()
    {
        $redirectUrl = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $redirectUrl .= $_SERVER['HTTP_HOST'];
        
        return $redirectUrl;
    }
    
    protected function getTokenKey()
    {
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
    
        return self::SESSION_KEY_ACCESS_TOKEN . '-' . $session[self::SESSION_KEY_CLIENT_ID] . '-' . $session[self::SESSION_KEY_CLIENT_SECRET];
    }
    
}

