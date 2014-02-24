<?php
namespace Grid\GoogleAnalytics\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Model\ViewModel;
use Grid\GoogleAnalytics\Model\GoogleApi\Auth\Oauth2;
use Grid\GoogleAnalytics\Model\GoogleApi;

class DashboardAnalyticsPlugin extends AbstractPlugin implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function __invoke()
    {
        // we use \Zend\ServiceManager\ServiceManager instead of the \Zend\Mvc\Controller\PluginManager witch returned from the pugin
        /* @var $serviceLocator \Zend\ServiceManager\ServiceManager */
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        
        // config array
        $config = $serviceLocator->get('config')['modules']['Grid\GoogleAnalytics'];
        
        // create view model of the box
        $view = new ViewModel();
        $view->setTemplate('grid/google-analytics/admin-dashboard-plugin/empty');
        $view->setVariable('config', $config);
        
        if ( isset($config['googleApi']['clientId']) &&
             isset($config['googleApi']['clientSecret']) &&
             isset($config['googleApi']['accessToken']) &&
             isset($config['dashboardDiagram']['profileId']) &&
             isset($config['dashboardDiagram']['enabled']) &&
             $config['dashboardDiagram']['enabled']
        )
        {
            $api = new GoogleApi();
            $api->getClient()->setClientId($config['googleApi']['clientId']);
            $api->getClient()->setClientSecret($config['googleApi']['clientSecret']);
            $api->getClient()->setAccessToken($config['googleApi']['accessToken']);
            
            $report = $api->getVisits(
                $config['dashboardDiagram']['profileId'],
                date('Y-m-d', time() - 7 * 24 * 3600),
                date('Y-m-d', time() - 1 * 24 * 3600)
            );
            
            $view->setTemplate('grid/google-analytics/admin-dashboard-plugin/chart');
            $view->setVariable('report', $report);
        }
        
        return $view;
    }
}

