<?php
namespace Grid\GoogleAnalytics\Model\AbstractGoogleAnalyticsApi\Result;

class Visits
{
    /**
     * Link to the report
     * 
     * @var string
     */
    protected $reportLink;
    
    /**
     * The title of the report
     * 
     * @var string
     */
    protected $title;
    
    /**
     * Start date of the query (in YYYY-MM-DD format)
     * 
     * @var string
     */
    protected $from;

    /**
     * End date of the query (in YYYY-MM-DD format)
     * 
     * @var string
     */
    protected $to;
    
    /**
     * Counts the total number of sessions.
     * 
     * @var int
     */
    protected $visits;
    
    /**
     * Total number of visitors to your property for the requested time period.
     * 
     * @var int
     */
    protected $visitors;
    
    /**
     * The number of visitors whose visit to your property was marked as a first-time visit.
     * 
     * @var int
     */
    protected $newVisits;
    
    /**
     * data 
     */
    protected $data = array();
    
    public function addTimeData($date, $type, $value) {
        $this->data[$type][$date] = $value;
    }
    
	/**
     * @return the $from
     */
    public function getFrom()
    {
        return $this->from;
    }

	/**
     * @return the $to
     */
    public function getTo()
    {
        return $this->to;
    }

	/**
     * @return the $visits
     */
    public function getVisits()
    {
        return $this->visits;
    }

	/**
     * @return the $visitors
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

	/**
     * @return the $newVisits
     */
    public function getNewVisits()
    {
        return $this->newVisits;
    }

	/**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

	/**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

	/**
     * @param number $visits
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;
    }

	/**
     * @param number $visitors
     */
    public function setVisitors($visitors)
    {
        $this->visitors = $visitors;
    }

	/**
     * @param number $newVisits
     */
    public function setNewVisits($newVisits)
    {
        $this->newVisits = $newVisits;
    }
	/**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }
	/**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

	/**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
	/**
     * @return the $reportLink
     */
    public function getReportLink()
    {
        return $this->reportLink;
    }

	/**
     * @param string $reportLink
     */
    public function setReportLink($accountId, $internalWebPropertyId, $profileId)
    {
        $this->reportLink = 'https://www.google.com/analytics/web/#report/visitors-overview/a' . $accountId . 'w' . $internalWebPropertyId . 'p' . $profileId . '/';
    }




    
}

