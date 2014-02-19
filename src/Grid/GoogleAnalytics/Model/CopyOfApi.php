<?php
namespace Grid\GoogleAnalytics\Model;

class Api
{

    protected $clientId;

    protected $clientSecret;

    public function setCredentials($clientId, $clientSecret)
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
    }

    public function getReports()
    {
        $client = $this->getClient();
        
        $accounts = $client->management_accounts->listManagementAccounts();
        
        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            
            foreach ($items as $item) {
                echo '<pre>';
                print_r($items);
                echo '</pre>';
            }
        } else {
            return array();
        }
        
        return array(
            '???',
            '!!!'
        );
    }

    protected function getClient()
    {
        $client = new \Google_Client();
        
        $client->setClientId($this->getClientId());
        $client->setClientSecret($this->getClientSecret());
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/app/en/admin/settings/google');
        $client->setApplicationName('gridguyz-google-analytics-module');
        $client->setScopes(array(
            'https://www.googleapis.com/auth/analytics.readonly'
        ));
        
        // todo ez menjen egy külön kontrollerbe
        if (isset($_SESSION['token'])) {
            try {
                $client->setAccessToken($_SESSION['token']);
            } catch (\Exception $e) {
                return array(
                    'session error',
                    $e->getMessage(),
                    $_SESSION['token']
                );
            }
        } elseif (isset($_GET['code'])) {
            try {
                $client->authenticate($_GET['code']);
            } catch (\Exception $e) {
                return array(
                    'code error',
                    $e->getMessage(),
                    $_GET['code']
                );
            }
            
            $_SESSION['token'] = $client->getAccessToken();
        }
        
        if (! $client->getAccessToken()) {
            $authUrl = $client->createAuthUrl();
            print "<a class='login' href='$authUrl'>Connect Me! $authUrl</a>";
            echo '<pre>';
            print_r($_GET);
            print_r($_POST);
            print_r($_SERVER);
            die();
        }
        
        return new \Google_Service_Analytics($client);
        ;
    }

    /**
     *
     * @return the $clientId
     */
    protected function getClientId()
    {
        return $this->clientId;
    }

    /**
     *
     * @return the $clientSecret
     */
    protected function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     *
     * @param field_type $clientId            
     */
    protected function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     *
     * @param field_type $clientSecret            
     */
    protected function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }
}

