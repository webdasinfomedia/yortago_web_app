<?php

namespace App\Http\Traits;

trait ImageUploadTrait
{

    public function upload_image($file)
    {
        $name = $file->getClientOriginalName();
        $name = str_replace(" ", "-", $name);
        $file->move('uploads/cms/', $name);
        return "uploads/cms/" . $name;
    }

    public function upload_file($file)
    {
        $name = $file->getClientOriginalName();
        $name = str_replace(" ", "-", $name);
        $file->move('uploads/exercise/', $name);
        return "uploads/exercise/" . $name;
    }

    public function upload_livewire_file($file, $directory = 'uploads/exercise/')
    {
        // Ensure directory exists
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $name = time() . '_' . $file->getClientOriginalName();
        $name = str_replace(" ", "-", $name);
        
        // Get the real path of the temporary file
        $tempPath = $file->getRealPath();
        
        // Move to public directory
        $destinationPath = public_path($directory . $name);
        
        // Copy file from temp location to destination
        if (copy($tempPath, $destinationPath)) {
            return $directory . $name;
        }
        
        throw new \Exception('Failed to upload file');
    }
    
}
