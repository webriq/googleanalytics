<?php
namespace Grid\GoogleAnalytics\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;
use Grid\GoogleAnalytics\Model\Api;

class DashboardAnalyticsPlugin extends AbstractPlugin
{
    public function __invoke()
    {
        $view = new ViewModel();
        
        
        $api = new Api();
        
        echo (int) $api->isAuthenticated();
        
        
        return $view->setTemplate( 'grid/google-analytics/dashboard' );
    }
}

