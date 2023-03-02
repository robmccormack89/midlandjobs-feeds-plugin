<?php

namespace Rmcc;
use XMLReader;

class MidlandjobsFeed
{

  public $publisher;
  public $jobs;

  public function __construct($url) {
    if(!empty($url) && self::urlIsValidXml($url)){

      /*
      The following propertiess get set as long as the url is valid & xml, regardless of being smartjobboard or not.
      jobs will only get results if the given xml contains 'job' elements etc
      and publisher will ony get results if 'job' & 'publisher/publisherurl' elements exist in the xml
      publisher also gets extra data when a main info source is available, which should be the case with smartjobboard urls
      */

      $this->url = $url; // the given url, validated
      $this->domain = self::getUrlSchemeAndHost($this->url); // something like https://midlandjobs.ie

      $this->string = file_get_contents($this->url); // the given xml file as a string, the file should be validated already by this point
      $this->xmlObject = simplexml_load_string($this->string); // php object from xml feed
      $this->feedAsJson = json_encode($this->xmlObject); // json data from php object from xml feed
      $this->jsonToArray = json_decode($this->feedAsJson, true); // associative array from json data from php object from xml feed

      $this->jobs = $this->getJobs(); // array of jobs items. maybe would use a new class/object for each Job item.
      if($this->jobs) $this->publisher = $this->getPublisher(); // Object. Get the publisher, but only if there are jobs already (this ensures only src feeds into the shortcode that contain JOB elements will get results here)

      // print_r($this->getPublisher());
      // die();

    }
  }

  private function getJobs() {
    $data = array();
    if(is_array($this->jsonToArray) && !empty($this->jsonToArray)){
      if(array_key_exists('job', $this->jsonToArray)){
        $jobs_array = $this->jsonToArray['job'];
        if(is_array($jobs_array) && !empty($jobs_array)){
          foreach($jobs_array as $job){
            $item = (object) [];
            if(!empty($job['title'])) $item->title = $job['title'];
            if(!empty($job['date'])) $item->date = $job['date'];
            if(!empty($job['expirationdate'])) $item->expirationdate = $job['expirationdate'];
            if(!empty($job['referencenumber'])) $item->referencenumber = $job['referencenumber'];
            if(!empty($job['url'])) $item->url = $job['url'];
            if(!empty($job['city'])) $item->city = $job['city'];
            if(!empty($job['state'])) $item->state = $job['state'];
            if(!empty($job['country'])) $item->country = $job['country'];
            if(!empty($job['postalcode'])) $item->postalcode = $job['postalcode'];
            if(!empty($job['location'])) $item->location = $job['location'];
            if(!empty($job['remote'])) $item->remote = $job['remote'];
            if(!empty($job['description'])) $item->description = $job['description'];
            if(!empty($job['salary'])) $item->salary = $job['salary'];
            if(!empty($job['salaryfrom'])) $item->salaryfrom = $job['salaryfrom'];
            if(!empty($job['salaryto'])) $item->salaryto = $job['salaryto'];
            if(!empty($job['salaryperiod'])) $item->salaryperiod = $job['salaryperiod'];
            if(!empty($job['applyurl'])) $item->applyurl = $job['applyurl'];
            if(!empty($job['jobtype'])) $item->jobtype = $job['jobtype'];
            if(!empty($job['category'])) $item->category = $job['category'];
            if(!empty($job['company'])) $item->company = $job['company'];
            if(!empty($job['companydescription'])) $item->companydescription = $job['companydescription'];
            if(!empty($job['companywebsite'])) $item->companywebsite = $job['companywebsite'];
            if(!empty($job['companylogo'])) $item->companylogo = $job['companylogo'];
            $data[]= $item;
          };
        };
      }
    };
    return $data;
  }
  private function getPublisher() {

    $data = ''; //  will be empty to start. this is coz the shortcode's url may be valid, but the alternate src for publisher info may not be. so this defaults for that
    //  we should be setting the publisher data from the feeds lists in any case

    // if the given url in the shortcode is valid for xml & is smartjobboard, this url should be the one for the main feed with the main publisher data (alternative)
    // we cant get that data in just the jobs feeds
    $main_info_src = $this->domain . '/feeds/rss.xml';

    // we create a new object for the publisher info....
    $publisherObj = (object) [];

    // adding 'publisher' field from the jobs feed src to the publisher object
    if(isset($this->jsonToArray['publisher']) && !empty($this->jsonToArray['publisher']) && is_string($this->jsonToArray['publisher'])){
      $publisherObj->publisher = $this->jsonToArray['publisher'];
    }

    // adding 'publisherurl' field from the jobs feed src to the publisher object
    if(isset($this->jsonToArray['publisherurl']) && !empty($this->jsonToArray['publisherurl']) && is_string($this->jsonToArray['publisherurl'])){
      $publisherObj->publisherurl = $this->jsonToArray['publisherurl'];
    }

    // we wanna check if the potential src for that main publisher info (alternative) has results first!
    if(!empty($main_info_src) && self::urlIsValidXml($main_info_src)){
      $main_info_src_string = file_get_contents($main_info_src); // the given xml file as a string, the file should be validated already by this point
      $main_info_src_xmlObject = simplexml_load_string($main_info_src_string); // php object from xml feed
      $main_info_src_feedAsJson = json_encode($main_info_src_xmlObject); // json data from php object from xml feed
      $main_info_src_jsonToArray = json_decode($main_info_src_feedAsJson, true); // associative array from json data from php object from xml feed
      $publisherArray = $main_info_src_jsonToArray['channel'];
      foreach($publisherArray as $key => $value){
        if($key !== 'item' && $key !== 'image'){
          $publisherObj->$key = $value;
        }
        if($key == 'image'){
          $value_arr = $value;
          $imageObj = (object) [];
          foreach($value_arr as $_key => $_value){
            if($_key == 'url'){
              $imageObj->src = $_value;
            }
            if($_key == 'url'){
              $imageObj->src = $_value;
            }
            if($_key == 'title'){
              $imageObj->title = $_value;
            }
            if($_key == 'link'){
              $imageObj->link = $_value;
            }
          }
          $publisherObj->$key = $imageObj;
        }
      }
    }

    $data = $publisherObj;
    
    return $data;
  }
  public static function getUrlSchemeAndHost($url) {
    $parsed_url = parse_url($url);
    $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
    $data = $scheme.$host;
    return $data;
  }
  public static function isXml($string) {
    $prev = libxml_use_internal_errors(true);
    $doc = simplexml_load_string($string);
    $errors = libxml_get_errors();
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    if($doc && empty($errors)) return true;
    return false;
  }
  public static function urlIsValidXml($url) {
    if (filter_var($url, FILTER_VALIDATE_URL)) { // if its a valid url
      $parsed_url = parse_url($url);
      $ext = pathinfo($parsed_url['path'], PATHINFO_EXTENSION);
      if($ext == 'xml'){ // if its a valid xml url/file 
        if(str_contains(get_headers($url)[0], "200 OK")){ // file is found with no 404 errors
          $string = file_get_contents($url);
          if(self::isXml($string)){ // file contents is valid xml
            return true;
          }
        }
      }
    }
    return false;
  }

}