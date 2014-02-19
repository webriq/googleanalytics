<?php
namespace Grid\GoogleAnalytics\Form\Plugin;

use Zork\Form\Plugin\SetDataInterface;

class SetData implements SetDataInterface
{
    public function __construct()
    {
    }

    public function setData(\Zork\Form\Form $form, $data)
    {
        if (isset($data['analytics']['reports'])) {
            if ($form->get('analytics') && $form->get('analytics')->get('dashboardDiagramReport')){
                /*@var $select \Zork\Form\Element\Select */
                $select = $form->get('analytics')->get('dashboardDiagramReport');
            
                $select->setValueOptions(json_decode($data['analytics']['reports'], true));
            }
        }
    }

}

