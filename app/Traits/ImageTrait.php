<?php

namespace App\Traits;

trait ImageTrait
{
    public function uploadImage($user_image=null,$path='')
    {
        if (!$user_image) return null;
        // 1- get image
        $image=$user_image;
        // 2- change it's current name
        $NewImageName=time().'_'.$image->getClientOriginalName();
        // 3- move image to my project
        $path = $image->storeAs($path,$NewImageName , 'public');
        return [
            'name' => $NewImageName,
            'path' => $path
        ];
    }
}
