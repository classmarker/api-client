<?php

class ClassMarkerClient
{
	private $api_key;
	private $secret;
	private $request_timestamp;

	const BASE_URL = 'https://api.classmarker.com';

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	function __construct($api_key, $secret)
	{
		$this->api_key = $api_key;
		$this->secret = $secret;
	}

	private function generateSignature()
	{
		$this->request_timestamp = time();
		$signature = md5($this->api_key . $this->secret . $this->request_timestamp);
		return $signature;
	}

	private function request($url, $method, $json_body = null)
	{

		// Create ClassMarker signature
		$signature = $this->generateSignature();
		// setup URL
		if (strpos($url, '?') === false) {
			$api_url = $url . '?api_key=' . $this->api_key . '&signature=' . $signature . '&timestamp=' . $this->request_timestamp;
		} else {
			$api_url = $url . '&api_key=' . $this->api_key . '&signature=' . $signature . '&timestamp=' . $this->request_timestamp;
		}

		$headers = array(
			'Content-type: application/json; charset=utf-8'
		);

		// create curl resource
		$ch = curl_init();

		// set url
		curl_setopt($ch, CURLOPT_URL, $api_url);

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);    // delete me
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);    // delete me
		//return transfer as string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if ($method == self::METHOD_POST || $method == self::METHOD_PUT || $method == self::METHOD_DELETE) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_body);
		}

		// $output contains the output string
		$output = curl_exec($ch);
		// Check the return value of curl_exec(), too
		if ($output === false) {
			throw new Exception(curl_error($ch), curl_errno($ch));
		}
		// close curl resource
		curl_close($ch);
		return $output;

	}

	public function get($path, $finishedAfterTimestamp = null, $limit = null)
	{
		$url = self::BASE_URL . $path;
		if ($finishedAfterTimestamp !== null || $limit != null) {
			if (strpos($url, '?') === false) {
				$url = $url . "?";
			}

			if ($finishedAfterTimestamp !== null) {
				$url = $url . "&finishedAfterTimestamp=" . $finishedAfterTimestamp;
			}
			if ($limit != null) {
				$url = $url . "&limit=" . $limit;
			}
		}
		return $this->request($url, self::METHOD_GET);
	}

	public function post($path, $json_body)
	{
		$url = self::BASE_URL . $path;
		return $this->request($url, self::METHOD_POST, $json_body);
	}

	public function put($path, $json_body)
	{
		$url = self::BASE_URL . $path;
		return $this->request($url, self::METHOD_PUT, $json_body);
	}

	public function delete($path, $json_body)
	{
		$url = self::BASE_URL . $path;
		return $this->request($url, self::METHOD_DELETE, $json_body);
	}




	/****************************************
	 * Custom functions for each request
	 ****************************************/
	public function getAllGroupLinkTest()
	{
		return $this->get('/v1.json');
	}

	public function getRecentResultForAllGroups($finishedAfterTimestamp = null, $limit = null)
	{
		return $this->get('/v1/groups/recent_results.json', $finishedAfterTimestamp, $limit);
	}

	public function getRecentResultsForAllLinks($finishedAfterTimestamp = null, $limit = null)
	{
		return $this->get('/v1/links/recent_results.json', $finishedAfterTimestamp, $limit);
	}

	public function getRecentResultsForSingleGroup($test_id, $group_id, $finishedAfterTimestamp = null, $limit = null)
	{
		$path = '/v1/groups/' . $group_id . '/tests/' . $test_id . '/recent_results.json';
		return $this->get($path, $finishedAfterTimestamp, $limit);
	}

	public function getRecentResultsForSingleLink($test_id, $link_id, $finishedAfterTimestamp = null, $limit = null)
	{
		$path = '/v1/links/' . $link_id . '/tests/' . $test_id . '/recent_results.json';
		return $this->get($path, $finishedAfterTimestamp, $limit);
	}

	public function addAccessListCodes($access_list_id, $json_body)
	{
		$path = "/v1/accesslists/" . $access_list_id . '.json';
		return $this->post($path, $json_body);
	}

	public function deleteAccessListCodes($access_list_id, $json_body)
	{
		$path = "/v1/accesslists/" . $access_list_id . '.json';
		return $this->delete($path, $json_body);
	}

	public function getAllCategories()
	{
		$path = "/v1/categories.json";
		return $this->get($path);
	}

	public function addParentCategory($parent_category_name)
	{
		$data = ["parent_category_name" => $parent_category_name];
		$json_body = json_encode($data);

		return $this->post('/v1/categories/parent_category.json', $json_body);
	}

	public function updateParentCategory($parent_category_id, $parent_category_name)
	{
		$path = '/v1/categories/parent_category/' . $parent_category_id . ".json";
		$data = ["parent_category_name" => $parent_category_name];
		$json_body = json_encode($data);
		return $this->put($path, $json_body);
	}

	public function addCategory($parent_category_id, $category_name)
	{
		$path = '/v1/categories/category.json';
		$data = ["category_name" => $category_name,
			"parent_category_id" => $parent_category_id
		];
		$json_body = json_encode($data);
		return $this->post($path, $json_body);
	}

	public function updateCategory($category_id, $parent_category_id, $category_name)
	{
		$path = '/v1/categories/category/' . $category_id . '.json';
		$data = ["category_name" => $category_name,
			"parent_category_id" => $parent_category_id
		];
		$json_body = json_encode($data);
		return $this->put($path, $json_body);
	}

	public function getAllQuestions($page = 1)
	{
		$path = '/v1/questions.json?page=' . $page;
		return $this->get($path);
	}

	public function getQuestion($question_id)
	{
		$path = '/v1/questions/' . $question_id . '.json';
		return $this->get($path);
	}

	public function addQuestion($question_json_string)
	{
		$path = '/v1/questions.json';
		return $this->post($path, $question_json_string);
	}

	public function updateQuestion($question_id, $question_json_string)
	{
		$path = '/v1/questions/' . $question_id . '.json';
		return $this->put($path, $question_json_string);
	}
}
