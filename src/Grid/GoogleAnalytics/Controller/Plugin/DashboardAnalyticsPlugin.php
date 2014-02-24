<?php
namespace Grid\GoogleAnalytics\Controller\Plugin;


use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Model\ViewModel;


class DashboardAnalyticsPlugin extends AbstractPlugin implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function __invoke()
    {
        // we use \Zend\ServiceManager\ServiceManager instead of the \Zend\Mvc\Controller\PluginManager witch returned from the pugin
        /* @var $serviceLocator \Zend\ServiceManager\ServiceManager */
        $serviceLocator = $this->getServiceLocator()->getServiceLocator();
        
        // create view model of the box
        $view = new ViewModel();
        
        // config array
        $config = $serviceLocator->get('config')['modules']['Grid\GoogleAnalytics'];
        
        
        
        
        // empty display
        $view->setTemplate('grid/google-analytics/admin-dashboard-plugin/empty');
        
        
        
        
        
        return $view;
    }
}

