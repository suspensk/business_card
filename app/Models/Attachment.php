<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
Class Attachment extends Model{
    protected $table = 'attachments';

//    public $timestamps = false; TO DISABLE updated_at created_at
    public static function setData($data){
        $review = self::find($data['id']);
        $review-> title = $data['title'];
        $review-> content = $data['content'];
        $review->save();
//        $this->update([
//            'password' => password_hash($password, PASSWORD_DEFAULT)
//        ]);
    }

    public static function addNew($data){
        $review = new Review();
        $review-> title = $data['title'];
        $review-> content = $data['content'];
        $review->save();
        return $review->id;
//        $this->update([
//            'password' => password_hash($password, PASSWORD_DEFAULT)
//        ]);
    }

//    public function attachments()
//    {
//        return $this->belongsToMany('App\Role');
//    }

    public function reviews()
    {
        return $this->belongsToMany('App\Models\Review', 'review_attachment', 'attachment', 'review');
    }
}