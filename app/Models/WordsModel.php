<?php

namespace App\Models;

use CodeIgniter\Model;

class WordsModel extends Model
{
	protected $table = 'words';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'user_id',
		'word',
		'count',
	];

	public $timestamps = false;
}
