<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Photo extends Model
{
    public static function imageUpload($image, $resource, $type, $resource_tag)
    {
        // Set some base vars.
        // Extract image path from resource.
        // Leave resource ID and image name.
        $base_path = config('filesystems.disks.' . $type . '.url');

        if ($resource->$resource_tag != NULL)
        {
            $old = str_replace($base_path, '', $resource->$resource_tag);
         
          if ($old != "default-avatar.png")
            {
            if (Storage::disk($type)->exists($old)) {
                Storage::disk($type)->delete($old);
            }
            } 
        }


        // Check if it's an update and
        // resource has old image stored.
        // If it does, first delete it.

        // If the images folder requires Resource ID folder
        if ($type == 'users') {
            Storage::disk($type)->putFileAs($resource->id, $image, $image->getClientOriginalName());
            $path = $base_path . $resource->id . '/' . $image->getClientOriginalName();
        }
    
   

        return $path;
    }
    public static function imageDelete($resource, $type, $resource_tag)
    {
    $base_path = config('filesystems.disks.' . $type . '.url');
    $old = str_replace($base_path, '', $resource->$resource_tag);

   
    if ($old != "default-avatar.png")
          {
          if (Storage::disk($type)->exists($old)) {
              Storage::disk($type)->delete($old);
              if (is_dir($base_path . $resource->id))
                rmdir($base_path . $resource->id);
              return true;
          }
        }
    }
}
