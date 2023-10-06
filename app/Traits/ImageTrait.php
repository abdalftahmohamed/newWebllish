<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    function saveImage($photo,$folder)
    {
        if ($photo) {
            //save photo in folder
            $file_extension = $photo->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = $folder;
            $photo->move($path, $file_name);
//            $photo->storeAs($folder, $file_name);

            return $file_name;
        }
        return null;
    }

    function saveVideo($photo,$folder)
    {
        if ($photo) {
            //save photo in folder
            $file_extension = $photo->getClientOriginalExtension();
            $file_name = time() . '.' . $file_extension;
            $path = $folder;
            $photo->move($path, $file_name);
//            $photo->storeAs($folder, $file_name);
            return $file_name;
        }
        return null;
    }


    public function deleteFile($folder,$id)
    {
        $exists = Storage::disk('upload_attachments')->exists('attachments/'.$folder.'/'.$id);

        if($exists)
        {
            Storage::disk('upload_attachments')->deleteDirectory('attachments/'.$folder.'/'.$id);
        }
    }


}
