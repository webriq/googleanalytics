<?php
namespace Grid\GoogleAnalytics\Form\Plugin;

use Zork\Form\Plugin\SetDataInterface;
use Zork\Form\Plugin\SetDataTrait;

class SetData implements SetDataInterface
{
    use SetDataTrait;
    public function setData(\Zork\Form\Form $form, $data)
    {
        if (isset($data['analytics']['dashboardChartAvalilableProfiles'])) {
            if ($form->get('analytics') && $form->get('analytics')->get('dashboardChartProfileId')) {
                /* @var $select \Zork\Form\Element\Select */
                $select = $form->get('analytics')->get('dashboardChartProfileId');
                
                $options = json_decode($data['analytics']['dashboardChartAvalilableProfiles'], true);
                
                if (!is_array($options)) {
                    $options = array();
                }
                
                $select->setValueOptions($options);
            }
        }
    }
}

