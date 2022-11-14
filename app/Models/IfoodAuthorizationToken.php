<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IfoodAuthorizationToken extends Model
{
    use HasFactory;
    protected $table = 'ifood_authorizations';

	protected $http;
	protected $grantType;
	// protected $accessToken;
	// protected $refreshToken;
	protected $casts = [
		'token_expires_date' => 'datetime',
		'is_valid' => 'boolean',
	];
	protected $fillable = [
		// 'merchant_id',  // ! important
		'user_code',
		'authorization_code',
		'authorization_code_verifier',
		'authorization_code_expires_date',
		'verification_url',
		'verification_url_complete',
		'access_token',
		'refresh_token',
		'token_expires_date',
	];
	protected $appends = [
		'is_valid',
		'is_expired',
	];

	/**
	 * Get the client model that the authorization code belongs to.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function authorizable()
	{
		return $this->morphTo();
	}

	public function getIsValidAttribute()
	{
		if ($this->authorization_code_expires_date > Carbon::now()) {
			return true;
		}

		// if is invalid, delete it
		$this->delete();

		return false;
	}

	public function getIsExpiredAttribute()
	{
		return !$this->is_valid;
	}
}
