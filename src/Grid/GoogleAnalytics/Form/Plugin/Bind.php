<?php
namespace Grid\GoogleAnalytics\Form\Plugin;

use Zork\Form\Plugin\BindInterface;
use Zork\Form\Form;
use Zork\Form\Plugin\BindTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zork\ServiceManager\ServiceLocatorAwareTrait;

class Bind implements BindInterface, ServiceLocatorAwareInterface
{
    use BindTrait;
    use ServiceLocatorAwareTrait;

    /**
     *
     * @var \Zend\Form\Form
     */
    protected $form;

    /**
     *
     * @var \Zend\form\Fieldset
     */
    protected $analyticsFieldset;

    public function bind(Form $form)
    {
        $this->setForm($form);
        $this->setServiceLocator($this->getForm()->getFormFactory()->getServiceLocator());
        
        $this->setReportsOptions();
        
        
        return $this;
    }

    protected function setReportsOptions()
    {
        if ($this->getForm()->get('analytics') && $this->getForm()->get('analytics')->get('dashboardChartProfileId')){
            /*@var $select \Zork\Form\Element\Select */
            $select = $this->getForm()->get('analytics')->get('dashboardChartProfileId');
            
            /* @var $dataField \Zork\Form\Element\Hidden  */
            $dataField = $this->getForm()->get('analytics')->get('dashboardChartAvalilableProfiles');
            
            $data = json_decode($dataField->getValue(), true);
            
            if (!is_array($data)) {
                $data = array();
            }
           
            $select->setValueOptions($data);
        }
        
        return $this;
    }

    protected function getForm()
    {
        return $this->form;
    }

    protected function setForm($form)
    {
        $this->form = $form;
        
        return $this;
    }
}

