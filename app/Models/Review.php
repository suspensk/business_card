<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
Class Review extends Model{
    protected $table = 'reviews';

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