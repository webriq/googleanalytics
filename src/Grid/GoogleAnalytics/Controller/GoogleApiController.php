<?php
namespace Grid\GoogleAnalytics\Controller;

use Zork\Mvc\Controller\AbstractAdminController;
use Zend\View\Model\ViewModel;
use Zork\Session\ContainerAwareTrait;
use Grid\GoogleAnalytics\Model\GoogleApi;

class GoogleApiController extends AbstractAdminController
{
    use ContainerAwareTrait;
    
    const SESSION_NAMESPACE = 'Grid\GoogleAnalytics\GoogleApi\AuthProcess';
    
    const SESSION_KEY_CLIENT_ID = 'clientId';
    
    const SESSION_KEY_CLIENT_SECRET = 'clientSecret';

    const SESSION_KEY_TRACKING_ID = 'trackingId';

    const SESSION_KEY_ACCESS_TOKEN = 'accessToken';
    
    public function callbackAction()
    {
        /* @var $params \Zend\Mvc\Controller\Plugin\Params */
        $params = $this->params();

        $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        
        try {
        
            $api = new GoogleApi();
            $api->getClient()->setClientId($session[self::SESSION_KEY_CLIENT_ID]);
            $api->getClient()->setClientSecret($session[self::SESSION_KEY_CLIENT_SECRET]);
            
            $callbackCode = $params->fromQuery('code');
            
            
            
            $api->getClient()->authenticate($callbackCode);
            
            $accessToken = $api->getClient()->getAccessToken();
            
            $avalilableProfiles = $api->getAvalilableProfiles($session[self::SESSION_KEY_TRACKING_ID]);
            
            $viewModel->setVariable('accessToken', $accessToken);
            $viewModel->setVariable('avalilableProfiles', $avalilableProfiles);
            
        } catch (\Exception $e) {
            
            $message = $e->getMessage();
            
            if (preg_match('/^Error calling GET .+ \(400\) invalid accountId: .+$/', $message)) {
                $message = 'Invalid accountId.';
            }
            
            $viewModel->setVariable('errorMessage', $message);
        }
        
        
        
        
        
        
        
        return $viewModel;
        
        /* @var $session array */
       // $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        /*
        
        
        $api = new Api($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        
        $api->authenticate($callbackCode);
        
        if ($api->getAccessToken()) {
            $session[$this->getTokenKey()] = $api->getAccessToken();
        }
        
        return $this->redirectToRefresh();*/
        /* @var $session array */
       // $session = $this->getSessionContainer(self::SESSION_NAMESPACE);
        
        /*$api = new Api($session[self::SESSION_KEY_CLIENT_ID], $session[self::SESSION_KEY_CLIENT_SECRET]);
        $api->setAccessToken($session[$this->getTokenKey()]);
        
        $profiles = $api->getProfiles($session[self::SESSION_KEY_ANALYITICS_ID]);
        */
        
        
        //$viewModel->setVariable('profiles', $profiles);
        
        
    }
}

