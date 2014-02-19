<?php
namespace Grid\GoogleAnalytics\Model;

use Grid\GoogleAnalytics\Model\AbstractGoogleAnalyticsApi\Result\Visits;
class AbstractGoogleAnalyticsApi extends AbstractApi
{

    public function getProfiles($trackingId)
    {
        $accountId = preg_replace('/^UA-/', '', $trackingId);
        $accountId = preg_replace('/-\d+$/', '', $accountId);
        
        $analytics = new \Google_Service_Analytics($this->getClient());
        
        $profiles = array();
        
        foreach ($analytics->management_profiles->listManagementProfiles($accountId, $trackingId) as $profile) {
            /* @var $profile \Google_Service_Analytics_Profile */
            $profiles[$profile->getId()] = $profile->getName();
        }
        
        natsort($profiles);
        
        return $profiles;
    }

    public function getVisits($profileId, $from, $to)
    {
        $analytics = new \Google_Service_Analytics($this->getClient());
        
        $report = $analytics->data_ga->get(
            'ga:' . $profileId,
            $from,
            $to,
            'ga:visits,ga:newVisits,ga:visitors',
            //'ga:visits,ga:newVisits,ga:visitors',
            array(
                'dimensions' => 'ga:day'
            )
        );
        
        $profileInfo = $report->getProfileInfo();
        
        $result = new Visits();
        $result->setFrom($from);
        $result->setTo($to);
        $result->setVisits($report->totalsForAllResults['ga:visits']);
        $result->setVisitors($report->totalsForAllResults['ga:visitors']);
        $result->setNewVisits($report->totalsForAllResults['ga:newVisits']);
        $result->setTitle($profileInfo->getProfileName());
        $result->setReportLink($profileInfo->getAccountId(), $profileInfo->getInternalWebPropertyId(), $profileInfo->getProfileId());
                
        $dayIndex = 0;
        for ($time = strtotime($from); $time <= strtotime($to); $time = strtotime("+1 day", $time) ) {
        
            $date = date('Y-m-d', $time);
        
            $columns = $report->getColumnHeaders();

            for ($columnIndex = 1; $columnIndex < count($columns); $columnIndex++) {
                $columnName = preg_replace('/^ga:/', '', $columns[$columnIndex]->name);
                
                $result->addTimeData($date, $columnName, $report->rows[$dayIndex][$columnIndex]);
            }
            
            ++$dayIndex;
        }
        
        return  $result;
    }
}

