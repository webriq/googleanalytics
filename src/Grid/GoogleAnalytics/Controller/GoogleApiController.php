<?php
namespace Grid\GoogleAnalytics\Controller;

use Zork\Mvc\Controller\AbstractAdminController;
use Zend\View\Model\ViewModel;
use Zork\Session\ContainerAwareTrait;
use Grid\GoogleAnalytics\Controller\AnalyticsApiTrait;

class GoogleApiController extends AbstractAdminController
{
    use ContainerAwareTrait;
    use AnalyticsApiTrait;

    const ADMIN_LOCALE = 'ADMIN_LOCALE';

    public function connectAction()
    {
        /* @var $session array */
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        $session['ANALYITICS_ID'] = $this->params()->fromQuery('analyticsId');
        
        $api = $this->getApi();
        
        if ($api->isAuthenticated()) {
            return $this->redirectToRefresh();
        } else {
            $locale = $this->params()->fromRoute('locale');
            $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession')->offsetSet(self::ADMIN_LOCALE, $locale);
            return $this->redirect()->toUrl($api->getAuthenticateUrl());
        }
    }

    public function callbackAction()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();
        
        /* @var $session array */
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        $callbackCode = $params->fromQuery('code');
        
        $api = $this->getApi();
        $api->authenticate($callbackCode);
        
        $locale = $session[self::ADMIN_LOCALE];
        
        return $this->redirectToRefresh($locale);
    }

    public function refreshAction()
    {
        /* @var $session array */
        $session = $this->getSessionContainer('Grid\GoogleAnalytics\ApiSession');
        
        $viewModel = new ViewModel();
        
        $api = $this->getApi();
        
        $profiles = $api->getProfiles($session['ANALYITICS_ID']);
        
        $viewModel->setVariable('profiles', $profiles);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    protected function redirectToRefresh($locale = null)
    {
        if (is_null($locale)) {
            $locale = $this->params()->fromRoute('locale', null);
        }
        
        return $this->redirect()->toUrl($this->url()
            ->fromRoute('Grid\GoogleAnalytics\Admin\Api\Refresh', array(
            'locale' => $locale
        )));
    }
}

