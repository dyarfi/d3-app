<?php namespace App\Modules\Participant\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model {

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'participants';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'provider_id',
			'provider',
			'profile_url',
			'photo_url',
			'name',
			'username',
			'email',
			'password',
			'avatar',
			'about',
			'phone_number',
			'phone_home',
			'address',
			'region',
			'province',
			'urban_district',
			'sub_urban',
			'zip_code',
			'website',
			'gender',
			'age',
			'nationality',
			'id_number',
			'file_name',
			'verify',
			'completed',
			'logged_in',
			'last_login',
			'session_id',
			'join_date',
			'status'
			];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

	/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'verify'      => 'boolean',
        'completed'   => 'boolean',        
        'logged_in'   => 'boolean',
        'status'      => 'boolean'
    ];

    /**
	 * A user can have many tasks.
	 *
	 */
	public function images()
	{
		return $this->hasMany('App\Modules\Participant\Model\Image','participant_id');
	}

	// Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1);

    }

}
