<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
Class User extends Model{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'password'
    ];

    public function setPassword($password){
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}