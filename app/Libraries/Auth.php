<?php

namespace App\Libraries;

use App\Models\UsersModel;

class Auth {
	public static function user() {
		$request = service('request');
        $model = new UsersModel();

        $ip = $request->getIPAddress();
        
		$user = $model->where('ip', $ip)->first();

		if (isset($user)) {
			return $user;
		}

        return $model->insert([
            'ip' => $ip,
        ]);
	}
}