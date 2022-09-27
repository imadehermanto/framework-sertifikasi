<?php
namespace App\Helpers;

class Files
{
    //2 mb
    public $fileSize=2097152;
    public $fileType= ['jpg', 'jpeg', 'png', 'gif'];
    
    //upload file
    public static function upload($file, $path)
    {
        $instance = new static;
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if (in_array($fileActualExt, $instance->fileType)) {
            if ($fileError === 0) {
                if ($fileSize < $instance->fileSize) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = $path.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $return=[
                        'status' => true,
                        'message' => 'File uploaded successfully',
                        'file_name' => $fileNameNew,
                    ];

                    return $return;
                } else {
                    $message= "Your file is too big!";
                }
            } else {
                $message= "There was an error uploading your file!";
            }
        } else {
            $message= "You cannot upload files of this type!";
        }

        $return=[
            'message'=>$message,
            'status'=>false
        ];

        return $return;
    }
}