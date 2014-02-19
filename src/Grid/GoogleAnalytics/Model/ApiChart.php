<?php
namespace Grid\GoogleAnalytics\Model;

class ApiChart extends Api
{
    public function getRedirectUrl()
    {
        if (! isset($this->redirectUrl)) {
            $this->redirectUrl = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $this->redirectUrl .= $_SERVER['HTTP_HOST'];
            $this->redirectUrl .= '/app/admin/googleanalytics/api/callback/chart';
        }
        
        return $this->redirectUrl;
    }
}

