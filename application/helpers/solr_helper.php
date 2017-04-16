<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class solr{

    static function ping(){
        $CI = &get_instance();
        $config = $CI->config->item('solr');

        // create a client instance
        $client = new Solarium\Client($config);

        // create a ping query
        $ping = $client->createPing();

        // execute the ping query
        try {
            $result = $client->ping($ping);
            return TRUE;
        } catch (Solarium\Exception $e) {
            return FALSE;
        }
    }

    static function query($str){
        $CI = &get_instance();
        $config = $CI->config->item('solr');

        // create a client instance
        $client = new Solarium\Client($config);

        // get a select query instance
        $query = $client->createSelect();
        $query->setQuery($str);

        // this executes the query and returns the result
        $resultset = $client->select($query);

        // display the total number of documents found by solr
        //echo 'NumFound: '.$resultset->getNumFound();

        // show documents using the resultset iterator
        $result = [];
        foreach ($resultset as $document) {
            $result[] = $document;
        }

        return $result;
    }

    static function add($data){
        $CI = &get_instance();
        $config = $CI->config->item('solr');

        // create a client instance
        $client = new Solarium\Client($config);

        // get an update query instance
        $update = $client->createUpdate();

        // create a new document for the data
        $doc = $update->createDocument();
        foreach($data as $k => $v)
            $doc->$k = $v;
        
        $update->addDocuments(array($doc));
        $update->addCommit();

        $result = $client->update($update);

    }
}