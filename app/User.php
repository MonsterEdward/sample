<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //boot
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    //gravatar
    public function gravatar($size = '100')
    {
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->attributes['email']))) . "?d=" . urlencode("https://www.somewhere.com/homestar.jpg") . "&s=" . $size;
        return $grav_url;
    }

    //notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    //for status
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    //不理解,把feed()错写到App\Status model中,所以user()->feed()无法使用
    public function feed()
    {
        return $this->statuses()->orderBy('created_at', 'desc');
    }
}
