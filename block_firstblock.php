<?php

  class block_firstblock extends block_base {

		private $searchterm;

    public function init() {
      
	    $this->title = get_string('firstblock', 'block_firstblock');
      $this->$searchterm = 'Moodle Block';
    }

		private function load_some_snippets(){
      $cse_id = '[YOUR_CSE_ID]';
      $api_key = '[YOUR_API_KEY]';

			$url = 'https://customsearch.googleapis.com/customsearch/v1?num=4&cx='.$cse_id.'&q=' 
				. str_replace(' ','%20',$this->$searchterm).'&key='.$api_key;
      $ch = curl_init();
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,$url);
      $result=curl_exec($ch);
      curl_close($ch);

      $search = json_decode($result, true);

      $allresults = $search['items'];
      
			$somesnippets = '';

      for ($i = 0; $i < 4; $i++) {
        $somesnippets = $somesnippets . '<a href="'.$allresults[$i]['link'].'">'.$allresults[$i]['htmlTitle']  . "</a><br><em>" . $allresults[$i]['htmlSnippet'] . "</em><br>";
			}

      $this->config->title = $this->$searchterm;
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
				if (empty($this->config->title)) {
            $this->title = get_string('defaulttitle', 'block_simplehtml');
        } else {
            $this->title = $this->config->title;
        }

        if (empty($this->config->text)) {
            $this->config->text = get_string('defaulttext', 'block_simplehtml');
        }
        //$searchterm = get_string('defaulttext', 'block_firstblock');
				//$this->load_some_snippets();
      }
    }

    public function instance_allow_multiple() {
      return true;
    }
  }
