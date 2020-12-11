<?php

  class block_firstblock extends block_base {

    public function init() {
      $this->title = get_string('firstblock', 'block_firstblock');
    }

    private function load_some_snippets(){

      $cse_id = 'YOUR CSE ID';
      $api_key = 'YOUR API KEY';

      $searchterm = $this->config->title;
      
      $url = 'https://customsearch.googleapis.com/customsearch/v1?num=4&cx='.$cse_id.'&q=' 
        . str_replace(' ','%20',$searchterm).'&key='.$api_key;
      $call = curl_init();
      curl_setopt($call, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($call, CURLOPT_URL,$url);
      $result=curl_exec($call);
      curl_close($call);

      $search = json_decode($result, true);

      $allresults = $search['items'];
      
      $somesnippets = '';

      for ($i = 0; $i < 4; $i++) {
        $somesnippets = $somesnippets . '<a href="'.$allresults[$i]['link'].'">'.$allresults[$i]['htmlTitle']  . "</a><br><em>" . $allresults[$i]['htmlSnippet'] . "</em><br>";
      }

      $this->config->text = $somesnippets;
    }

    public function get_content() {
      $this->load_some_snippets();

      $this->content         =  new stdClass;
      $this->content->text = $this->config->text;
      $this->title = $this->config->title;

      return $this->content;
    }

    public function specialization() {
      if (isset($this->config)) {
        if (empty($this->config->title)) 
            $this->config->title = get_string('defaulttitle', 'block_firstblock');

        $this->title = $this->config->title;

        if (empty($this->config->text)) {
            $this->config->text = get_string('defaulttext', 'block_firstblock');
        }
      }

    }

    public function instance_allow_multiple() {
      return true;
    }
  }
