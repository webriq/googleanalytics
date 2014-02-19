<?php
namespace Grid\GoogleAnalytics\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zork\Session\ContainerAwareTrait;
use Grid\GoogleAnalytics\Model\Api;
use Grid\GoogleAnalytics\Model\ApiChart;

class DashboardAnalyticsPlugin extends AbstractPlugin implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use ContainerAwareTrait;

    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\Api\AuthProcess\Chart';

    const SESSION_KEY_CLIENT_ID = 'CLIENT_ID';

    const SESSION_KEY_CLIENT_SECRET = 'CLIENT_SECRET';

    const SESSION_KEY_ACCESS_TOKEN = 'ACCESS_TOKEN';

    public function __invoke()
    {
        // we use \Zend\ServiceManager\ServiceManager instead of the \Zend\Mvc\Controller\PluginManager witch returned from the pugin
        /* @var $serviceLocator \Zend\ServiceManager\ServiceManager */
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        
        // we set the session manager - because the class' ->getServiceLocator() method uses the \Zend\Mvc\Controller\PluginManager
        $this->setSessionManager($serviceLocator->get('Zend\Session\ManagerInterface'));
        
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $view = new ViewModel();
        $view->setTemplate('grid/google-analytics/dashboard-empty');
        
        $config = $serviceLocator->get('config')['modules']['Grid\GoogleAnalytics'];
        
        if ( ! isset($config['googleApi']['clientId']) || 
             ! isset($config['googleApi']['clientSecret']) || 
             ! isset($config['dashboardDiagram']['report']) || 
             ! isset($config['dashboardDiagram']['enabled']) ||
             ! $config['dashboardDiagram']['enabled']
        ) {
            // we dont have valid (displayable) config, so disable the whole view
            $view->setVariable('enabled', false);
            return $view;
        } else {
            $view->setVariable('enabled', true);
            $view->setVariable('config', $config);
        }
              
        // credentials from config 
        $clientId = $config['googleApi']['clientId'];
        $clientSecret = $config['googleApi']['clientSecret'];
        
        $api = new ApiChart($clientId, $clientSecret);
        
        // if we have token fro the given clientId and clientSecret then we set to the api object
        if (isset($session[$this->getTokenKey()])) {
            $api->setAccessToken($session[$this->getTokenKey()]);
        }
        
        // if the token is valid...
        if ($api->isAuthenticated()) {
            // ...we can query from the google api
            
            $visits = $api->getVisits(
                $config['dashboardDiagram']['report'], 
                date('Y-m-d', time() - 7 * 24 * 3600),
                date('Y-m-d', time() - 1 * 24 * 3600) 
            );

            $view->setVariable('visits', $visits);
            
            $view->setTemplate('grid/google-analytics/dashboard');
            
        } else {
            // ...we need to authenticate with oauth
            
            $view->setTemplate('grid/google-analytics/dashboard-auth');
            $view->setVariable('authenticateUrl', $api->getAuthenticateUrl());
            
            // save credentials to session for the callback process
            $session[self::SESSION_KEY_CLIENT_ID] = $clientId;
            $session[self::SESSION_KEY_CLIENT_SECRET] = $clientSecret;
        }
        
        return $view;
    }

    protected function getTokenKey()
    {
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        return self::SESSION_KEY_ACCESS_TOKEN . '-' . $session[self::SESSION_KEY_CLIENT_ID] . '-' . $session[self::SESSION_KEY_CLIENT_SECRET];
    }
}

