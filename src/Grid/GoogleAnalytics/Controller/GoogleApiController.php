<?php
namespace Grid\GoogleAnalytics\Controller;

use Zork\Mvc\Controller\AbstractAdminController;
use Zend\View\Model\ViewModel;
use Zork\Session\ContainerAwareTrait;
use Grid\GoogleAnalytics\Controller\AnalyticsApiTrait;
use Grid\GoogleAnalytics\Model\Api;

class GoogleApiController extends AbstractAdminController
{
    use ContainerAwareTrait;

    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\Api\AuthProcess';

    const SESSION_KEY_CLIENT_ID = 'CLIENT_ID';

    const SESSION_KEY_CLIENT_SECRET = 'CLIENT_SECRET';

    const SESSION_KEY_ANALYITICS_ID = 'ANALYITICS_ID';

    const SESSION_KEY_ADMIN_LOCALE = 'ADMIN_LOCALE';

    const SESSION_KEY_ACCESS_TOKEN = 'ACCESS_TOKEN';

    public function connectAction()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();
        
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $api = new Api($params->fromQuery('clientId'), $params->fromQuery('clientSecret'));
        
        $session[self::SESSION_KEY_CLIENT_ID] = $params->fromQuery('clientId');
        $session[self::SESSION_KEY_CLIENT_SECRET] = $params->fromQuery('clientSecret');
        $session[self::SESSION_KEY_ADMIN_LOCALE] = $params->fromRoute('locale');
        $session[self::SESSION_KEY_ANALYITICS_ID] = $params->fromQuery('analyticsId');
        
        if (isset($session[$this->getTokenKey()])) {
            $api->setAccessToken($session[$this->getTokenKey()]);
        }
        
        if ($api->isAuthenticated()) {
            return $this->redirectToRefresh();
        } else {
            return $this->redirect()->toUrl($api->getAuthenticateUrl());
        }
    }

    protected function getTokenKey()
    {
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        return self::SESSION_KEY_ACCESS_TOKEN . '-' . $session[self::SESSION_KEY_CLIENT_ID] . '-' . $session[self::SESSION_KEY_CLIENT_SECRET];
    }

    public function callbackAction()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();
        
        /* @var $session array */
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $callbackCode = $params->fromQuery('code');
        
        $api = new Api($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        
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
        
        $api = new Api($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        $api->setAccessToken($session[$this->getTokenKey()]);
        
        $profiles = $api->getProfiles($session[self::SESSION_KEY_ANALYITICS_ID]);
        
        $viewModel = new ViewModel();
        
        $viewModel->setVariable('profiles', $profiles);
        $viewModel->setTerminal(true);
        
        return $viewModel;
    }

    protected function redirectToRefresh()
    {
        /* @var $session array */
        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $locale = $session[self::SESSION_KEY_ADMIN_LOCALE];
        
        return $this->redirect()->toUrl($this->url()
            ->fromRoute('Grid\GoogleAnalytics\Admin\Api\Refresh', array(
            'locale' => $locale
        )));
    }
}

