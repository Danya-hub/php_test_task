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
		$userId = service('auth')->user();

		$text = $this->request->getPost('text');
		$words = $this->getCountWords($text);

		$result = [];

		foreach ($words as $key => $value) {
			$data = [
				'user_id' => $userId,
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

	private function getCountWords($text) {
		$text = trim($text);

		$words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
		$words = array_filter($words, fn($w) => strlen(trim($w)) >= 3);
		$words = array_count_values($words);

		$a = array_slice($words, 0, 3);
		krsort($a);

		$b = array_slice($words, 3);
		ksort($b);

		$words = array_merge($a, $b);

		return $words;
	}
}
