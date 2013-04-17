<?php
/**
 * Google analitycs strategy.
 * It appends a google analytics script before the end of </head> tag.
 *
 * @author Sipos Zoltán
 */

namespace Grid\GoogleAnalytics\Mvc\Strategy;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class GoogleAnalyticsStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();


    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'appendAnalyticsScriptToHeadScript'), -1000);
    }

    /**
     * Detach aggregate listeners from the specified event manager
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }


    /**
     * Populate the response object from the View
     *
     * Populates the content of the response object from the view rendering
     * results.
     *
     * @param ViewEvent $e
     * @return void
     */
    public function appendAnalyticsScriptToHeadScript(MvcEvent $e)
    {
        $app = $e->getParam('application');
        $locator = $app->getServiceManager();
        /* @var $renderer \Zend\View\Renderer\PhpRenderer */
        $renderer = $locator->get('Zend\View\Renderer\PhpRenderer');
        $analyticsId = $locator->get('Configuration')
                                    ['modules']
                                    ['Grid\GoogleAnalytics']
                                    ['access']
                                    ['analyticsId'];

        $viewModel = new ViewModel();
        $viewModel->setVariable('analyticsId', $analyticsId);
        $viewModel->setTemplate('grid/google-analytics/tracker');

        $headScript = $renderer->plugin('headScript');
        $headScript->appendScript(
            $renderer->render($viewModel)
        );
    }
}

