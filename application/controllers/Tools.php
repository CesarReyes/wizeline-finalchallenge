<?php

class Tools extends CI_Controller {
    function __construct(){
        parent::__construct();

        if(!is_cli()){
            echo "Hey this feature only is not available!".PHP_EOL;
            die();
        }
    }

	public function test_solr_add(){
        //php index.php tools test_solr_add

        $this->load->helper('solr');

        $r = solr::add([
            'hash'=>'789456',
            'url' => 'http://solarium.readthedocs.io/en/stable/getting-started/'
        ]);
	}

    public function test_solr_search(){
         //php index.php tools test_solr_search

         $this->load->helper('solr');

         $r = solr::query('hash:789456');

         var_dump($r);
    }

    public function one_million(){
        $this->load->model("urls");

        $fields_map = ['hash','url','scheme','host','port','user','pass','path','query','fragment'];

        $fl_sql = fopen('1_million.db.csv', 'w');
        //$fl_csv = fopen('1_million.csv', 'w');

        fwrite($fl_sql, implode(",", $fields_map) . "\n");
        //fwrite($fl_csv, 'hash,url' . "\n");
        for($i = 1710; $i <= 1000000; $i++){
            $url = "http://localhost/test/$i";
            $url_parts = parse_url($url);
            $url_parts['hash'] = $hash = tinyurl::hash($url);
            $url_parts['url'] = $url;
            
            //Creating the row
            $row = [];
            foreach($fields_map as $field){
                $row[$field] = isset($url_parts[$field]) ? $url_parts[$field] : NULL;
            }
            
            fwrite($fl_sql, implode(",", $row) . "\n");
            unset($row);

            //print_r($url_parts);die();
            //fwrite($fl_csv, $hash.',"'.$url.'"' . "\n");
            echo "->$url\n";
        }

        fclose($fl_sql);
        //fclose($fl_csv);
        var_dump('Done');
    }
}
