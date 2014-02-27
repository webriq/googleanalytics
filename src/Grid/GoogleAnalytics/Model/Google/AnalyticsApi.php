<?php
namespace Grid\GoogleAnalytics\Model\Google;

class AnalyticsApi extends Api
{

    const GA_DIMENSION_DATE = 'ga:date';

    public function __construct()
    {
        $this->getClient()->addScope('https://www.googleapis.com/auth/analytics.readonly');
    }

    public function getAvalilableProfiles($trackingId)
    {
        $accountId = preg_replace('/^UA-/', '', $trackingId);
        $accountId = preg_replace('/-\d+$/', '', $accountId);
        
        $analytics = new \Google_Service_Analytics($this->getClient());
        
        $profiles = array();
        
        foreach ($analytics->management_profiles->listManagementProfiles($accountId, $trackingId) as $profile) {
            /* @var $profile \Google_Service_Analytics_Profile */
            $profiles[$profile->getName()] = $profile;
        }
        
        ksort($profiles);
        
        return $profiles;
    }

    public function getVisits($profileId, $from, $to)
    {
        $analytics = new \Google_Service_Analytics($this->getClient());
        
        $report = $analytics->data_ga->get('ga:' . $profileId, $from, $to, 'ga:visits', array(
            'dimensions' => self::GA_DIMENSION_DATE
        ));
        
        $result = array();
        
        foreach ($report->getRows() as $row) {
            $result['visits'][preg_replace('/^(\d{4})(\d{2})(\d{2})$/', '$1-$2-$3', $row[0])] = $row[1];
        }
        
        $result['profile']['name'] = $report->getProfileInfo()->getProfileName();
        $result['profile']['accountId'] = $report->getProfileInfo()->getAccountId();
        $result['profile']['webPropertyId'] = $report->getProfileInfo()->getInternalWebPropertyId();
        $result['profile']['profileId'] = $report->getProfileInfo()->getProfileId();
        
        return $result;
    }
}

