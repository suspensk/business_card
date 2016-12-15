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
//    public $timestamps = false; TO DISABLE updated_at created_at
    public static function setData($data){
        $book = self::find($data['id']);
        $book-> title = $data['title'];
        $book-> content = $data['content'];
        $book->save();
//        $this->update([
//            'password' => password_hash($password, PASSWORD_DEFAULT)
//        ]);
    }
}