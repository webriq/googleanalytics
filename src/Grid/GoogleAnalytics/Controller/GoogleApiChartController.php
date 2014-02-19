<?php
namespace Grid\GoogleAnalytics\Controller;

use Zork\Mvc\Controller\AbstractAdminController;
use Zend\View\Model\ViewModel;
use Zork\Session\ContainerAwareTrait;
use Grid\GoogleAnalytics\Model\ApiChart;

class GoogleApiChartController extends AbstractAdminController
{
    use ContainerAwareTrait;

    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\Api\AuthProcess\Chart';

    const SESSION_KEY_CLIENT_ID = 'CLIENT_ID';

    const SESSION_KEY_CLIENT_SECRET = 'CLIENT_SECRET';

    const SESSION_KEY_ANALYITICS_ID = 'ANALYITICS_ID';

    const SESSION_KEY_ADMIN_LOCALE = 'ADMIN_LOCALE';

    const SESSION_KEY_ACCESS_TOKEN = 'ACCESS_TOKEN';



    public function callbackAction()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();
        
        /* @var $session array */
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $callbackCode = $params->fromQuery('code');
        
        $api = new ApiChart($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        
        $api->authenticate($callbackCode);
        
        if ($api->getAccessToken()) {
            $session[$this->getTokenKey()] = $api->getAccessToken();
        }
        
        return $this->redirectToRefresh();
    }

    public function refreshAction()
    {
        /* @var $session array */
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $api = new ApiChart($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        $api->setAccessToken($session[$this->getTokenKey()]);
        
        $config = $this->getServiceLocator()->get('config')['modules']['Grid\GoogleAnalytics'];
        
        $visits = $api->getVisits(
            $config['dashboardDiagram']['report'],
            date('Y-m-d', time() - 7 * 24 * 3600),
            date('Y-m-d', time() - 1 * 24 * 3600)
        );
        
        $viewModel = new ViewModel();
        
        $viewModel->setVariable('visits', $visits);
        $viewModel->setTerminal(true);
        
        return $viewModel;
    }

    protected function getTokenKey()
    {
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
    
        return self::SESSION_KEY_ACCESS_TOKEN . '-' . $session[self::SESSION_KEY_CLIENT_ID] . '-' . $session[self::SESSION_KEY_CLIENT_SECRET];
    }
    
    protected function redirectToRefresh()
    {
        /* @var $session array */
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        return $this->redirect()->toUrl($this->url()
            ->fromRoute('Grid\GoogleAnalytics\Admin\Api\Refresh\Chart', array(
            'locale' => 'en'
        )));
    }
}

