<?php

namespace App\Controllers\Ajax;

use App\Controllers\BaseController;
use App\Models\WordsModel;
use CodeIgniter\API\ResponseTrait;

class FormController extends BaseController
{
	use ResponseTrait;

	public WordsModel $wordsModel;

	public function __construct()
	{
		$this->wordsModel = new WordsModel();
	}
	
	public function sendWords()
	{
		$user = service('auth')->user();

		$text = $this->request->getPost('text');

		$words = preg_split("/\s|\n/", $text);
		$words = array_filter($words, function ($w) {
			return strlen(trim($w)) >= 3;
		});
		$words = array_count_values($words);
		$result = [];
		
		ksort($words);

		foreach ($words as $key => $value) {
			$data = [
				'user_id' => $user['id'],
				'word' => $key,
				'count' => $value,
			];

			$item = $this->wordsModel->where('word', $data['word'])->first();

			if (isset($item)) {
				$this->wordsModel->update($item['id'], [
					...$item,
					'count' => +$item['count'] + +$data['count'],
				]);
			} else {
				$this->wordsModel->insert($data);
			}

			$result[] = $data;
		}
	
		return $this->respond([
			'text' => $text,
			'result' => $result,
		], 200);
	}
}
