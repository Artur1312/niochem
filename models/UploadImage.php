<?php
/**
 * Created by PhpStorm.
 * User: mint2
 * Date: 17.07.17
 * Time: 15:02
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadImage extends Model
{

    public $image;

    public function rules()
    {
        return[

        [['image'],'required'],
        [['image'],'file', 'extensions' => 'jpg, png']

        ];

    }





    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;

        $this->deleteCurrentImage($currentImage);

       return $this->saveImage();


    }

    //method for getting our file's|picture's destination

    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';

    }

    //"generating FileName" method
    //strtolower - lower register
    //md5|uniqid - for hashing

    private function hashFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    //method for replacing existing image, deleting it parallely


    public function deleteCurrentImage($currentImage){

        if($this->fileExists($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }

    //method for file existing validation

    private function fileExists($currentImage)
    {
        if(!empty($currentImage) && $currentImage != null)
        {
            return file_exists($this->getFolder() . $currentImage);
        }

    }

    private function saveImage()
    {
        $filename = $this->hashFilename();


        $this->image->saveAs($this->getFolder() . $filename); //uploading file on server

        return $filename;
    }
}