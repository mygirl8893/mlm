<?php
/* Holy naming batman */
class OpenIDDriver extends \Laravel\Auth\Drivers\Driver {
	
	public function retrieve($id) {
		if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
			return User::find($id);
		}
	}
	
	public function attempt($arguments = array()) {
		$oid = Openid::where_identity($arguments["identity"])->first();
		
		if(is_null($oid)) {
			return false;
		} else {
			return $this->login($oid->user->id, array_get($arguments, 'remember'));
		}
	}
}