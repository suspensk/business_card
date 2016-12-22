<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
Class Review extends Model{
    protected $table = 'reviews';

//    public $timestamps = false; TO DISABLE updated_at created_at
    public static function setData($data, $files, $settings){
        $review = self::find($data['id']);
        $review-> title = $data['title'];
        $review-> content = $data['content'];


        $uploadedFile = $files['picture'];
        if(!empty($uploadedFile)){
            if(!in_array($uploadedFile->getClientMediaType(), $settings['picture_types'])){
                return array('result' => 1, 'error' => 'Wrong file type');
            }

            if($uploadedFile->getSize() > $settings['max_upload_size']){
                return array('result' => 1, 'error' => 'File is too big! Max size is: ' . $settings['max_upload_size'] / 1048576 . ' MB');
            }

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $uploadedFile->getClientFilename();
                $filePath =  $settings['upload_path'] . time() . '_' . substr($uploadFileName, -50);
                $uploadedFile->moveTo($filePath);
                try{
                    /*
                     * $image = new ImageResize('image.jpg');
                        $image->resizeToHeight(500);
                        $image->save('image2.jpg');

                        $image = new ImageResize('image.jpg');
                        $image->resizeToWidth(300);
                        $image->save('image2.jpg');
                    *
                     */
                    $image = new \Eventviva\ImageResize($filePath);
                    $image->scale(50);
                    $image->save($filePath);
                } catch (Exception $e){
                    return array('result' => 1, 'error' => 'Error resizing image: ' . $e->getMessage());
                }



                $review-> picture = $filePath;
            } else{
                return array('result' => 1, 'error' => 'Error file uploading');
            }
        }

        $review->save();
        return 0;
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

    public function attachments()
    {
        return $this->belongsToMany('App\Models\Attachment', 'review_attachment', 'review', 'attachment');
    }
}