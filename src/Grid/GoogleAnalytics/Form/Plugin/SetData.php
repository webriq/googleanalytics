<?php
namespace Grid\GoogleAnalytics\Form\Plugin;

use Zork\Form\Plugin\SetDataInterface;
use Zork\Form\Plugin\SetDataTrait;

class SetData implements SetDataInterface
{
    use SetDataTrait;
    public function setData(\Zork\Form\Form $form, $data)
    {
        if (isset($data['analytics']['reports'])) {
            if ($form->get('analytics') && $form->get('analytics')->get('dashboardDiagramReport')) {
                /* @var $select \Zork\Form\Element\Select */
                $select = $form->get('analytics')->get('dashboardDiagramReport');
                
                $options = json_decode($data['analytics']['reports'], true);
                
                if (!is_array($options)) {
                    $options = array();
                }
                
                $select->setValueOptions($options);
            }
        }
    }
}

