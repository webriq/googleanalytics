<?php
namespace Grid\GoogleAnalytics\Form\Plugin;

use Zork\Form\Plugin\BindInterface;
use Zork\Form\Form;
use Zork\Form\Plugin\BindTrait;
use Zend\Form\Fieldset;
use Grid\GoogleAnalytics\Model\Api;

class Bind implements BindInterface
{
    use BindTrait;

    public function bind(Form $form)
    {
        $fieldsets = $form->getFieldsets();
        
        if (isset($fieldsets['analytics'])) {
            /* @var $fieldset \Zend\Form\Fieldset */
            $fieldset = $fieldsets['analytics'];
            
            if ($fieldset->has('adminDashboardDiagram-report')) {
                
                /* @var $reports \Zend\Form\Element\Select */
                $reports = $fieldset->getElements()['adminDashboardDiagram-report'];
                
                $reports->setValueOptions($this->getReports($fieldset));
            }
        }
        
        return $this;
    }

    protected function getReports(Fieldset $fieldset)
    {
        $clientId = $fieldset->getElements()['adminDashboardDiagram-authorization-oauth2-clientId']->getValue();
        $clientSecret = $fieldset->getElements()['adminDashboardDiagram-authorization-oauth2-clientSecret']->getValue();
        
        $model = $this->getApiModel($clientId, $clientSecret);
        
        return $model->getReports();
    }
    
    protected function getApiModel($clientId, $clientSecret) {
        
        $model = new Api();
        $model->setCredentials($clientId, $clientSecret);
        
        return $model;
    }
}

