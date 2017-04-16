<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Urls extends CI_Model{

    function add($url){
        
        //Validate the url
        if(!tinyurl::check_ulr($url))
            return FALSE;
        
        $url = trim($url);
        $url_parts = parse_url($url);
        $url_parts['hash'] = $hash = tinyurl::hash($url);
        $url_parts['url'] = $url;
        
        $this->load->helper('solr');
        //Inserting
        //Check if exists
        $solrr = solr::query("hash:$hash");
        if(count($solrr))
            return NULL;

        $this->db->insert('urls', $url_parts);
        solr::add([
            'hash' => $hash,
            'url' => $url
        ]);
        
        return $hash;
        //debug_var($solrr);
    }
}