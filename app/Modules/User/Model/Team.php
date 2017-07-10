<?php namespace App\Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['owner_id','name','created_at','updated_at'];


     /**
 	 * A user can have many roles.
 	 *
 	 */
 	public function users()
 	{
 		//return $this->hasOne('App\Db\RoleUser');
 		return $this->belongsToMany('App\Modules\User\Model\User','team_user','team_id','user_id');

 	}
}
