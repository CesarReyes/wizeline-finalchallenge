<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url extends CI_Controller {

	public function index()
	{
		$table = [];

		$action = $this->input->post('_action');
		if($action == 'add-urls'){
			$this->form_validation->set_rules('urls', 'Urls', 'required|callback_validate_ulrs');

			if ($this->form_validation->run() == FALSE){
				$this->load->view('create');
				return FALSE;
			}

			//Insert the urls
			$this->load->model("urls");
			$data = $this->input->post('urls');
			$urls = explode("\n", $data);
			foreach($urls as $url){
				$url = trim($url);
				if($url){
					$hash = $this->urls->add($url);
					if($hash){
						$tinyutl = tinyurl::url($hash);
						$table[] = [
							$tinyutl,
							$url
						];
					}
				}
			}
		}
		
		$this->load->view('create', ['table' => $table]);
	}

	public function validate_ulrs($value){
		$r = tinyurl::check_ulrs($value);
		if($r !== TRUE){
			$this->form_validation->set_message('validate_ulrs', $r);
			return FALSE;
		}
		return TRUE;
	}

	public function list(){
		$this->load->view('list');
	}

	public function redirect($hash){
		$this->load->helper('solr');
		$solrr = solr::query("hash:$hash");
		if(!count($solrr)){
			$this->load->view('404');
			return FALSE;
		}
		
		header("Location: " . $solrr[0]->url);
		die();

	}

	public function ajax(){
		//var_dump($_REQUEST);
		$start = $this->input->get('start');
		$length = $this->input->get('length');
		$draw = $this->input->get('draw');

		$query = $this->db->select('*')
		->from('urls')
		->limit($length, $start)
		->get();
		$urls = $query->result();

		$total = $this->db->from('urls');

		$result = [
			"draw" => $draw,
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => []
		];

		$table =[];
		foreach($urls as $url){
			$tinyurl = tinyurl::url($url->hash);
			$table[] = [
				'<a target="_blank" href="'.$tinyurl.'">'.$tinyurl.'</a>',
				$url->url,
				$url->scheme,
				$url->host,
				$url->path,
				$url->query,
				$url->fragment
			];
		}

		$result['recordsTotal'] = $result['recordsFiltered'] = $total->count_all_results();
		$result['data'] = $table;

		die(json_encode($result));
		//var_dump($urls);
	}

	public function test($index){
		var_dump($index);
	}
}
