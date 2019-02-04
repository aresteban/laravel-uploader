<?php
namespace aresteban\LaravelUploader;

use Illuminate\Http\UploadedFile;
use Storage;

class Uploader
{
    /**
     * Temporary location for uploaded files.
     * Overriden on construct.
     * @var String
     */
    private $temporary_path = '';

    /**
     * File location for saved files.
     * Overriden on construct.
     * @var String
     */
    private $storage_path = '';

    /**
     * Data of uploaded file
     * @var array
     */
    private $uploaded = [];

    /**
     * Manually defined save location property
     * @var String
     */
    private $saveTo = '';

    //TODO file prefix
    //TODO file extension


    /**
     * Configure uploader
     * @return void
     */
     public function __construct ($temporary_path, $storage_path)
    {
        $this->temporary_path = $temporary_path;
        $this->storage_path = $storage_path;
    }


    /**
     * Upload file in tmp folder
     * @param  UploadedFile $file Object of file that will be stored
     * @return Object       Reference to this instance
     */
    public function upload(UploadedFile $file)
    {
        $upload_path = '';

        $original_name = $file->getClientOriginalName();

        $upload_path = Storage::put($this->temporary_path, $file);

        $filename = $this->getFilename($upload_path);
        $file_url = url(Storage::url($upload_path));

        $this->uploaded = [
            'original_filename' => $original_name,
            'filename' => $filename,
            'file_url' => $file_url,
        ];

        return $this;
    }


    /**
     * Parse path to get filename
     * @param  String $upload_path  Location of file
     * @return String               Parsed file name
     */
    private function getFilename($upload_path) {
        return str_replace($this->temporary_path . '/', '', $upload_path);
    }


    /**
     * Manually define save path
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function saveTo($path)
    {
        $this->saveTo = $path;

        return $this;
    }


    /**
     * Retrieve stored objects data
     * @return Object [Reference to this instance]
     */
    public function get()
    {
        return $this->uploaded;
    }


    /**
     * Moves uploaded file from temporary storage to permanent location
     * @param  String $photoUrl Name of file in tmp
     * @return bool
     */
    public function save($tmp_file = null)
    {
        if (empty($tmp_file) && empty($this->uploaded)) {
            return "No file has been uploaded!";
        }

        // File in temporary path
        $filename = (!empty($tmp_file)) ?
            $tmp_file :
            $this->uploaded['filename'];

        // Retrieve save path
        $save_path = (empty($this->saveTo)) ?
            config('uploading.storage_path.permanent') :
            $this->saveTo;

        // Make save path
        $tmp_file_location = $this->temporary_path. '/' .$filename;
        $perm_file_location = $save_path.'/'.$filename;

        $relocation_result = Storage::copy($tmp_file_location, $perm_file_location);

        return $relocation_result;
    }


    /**
     * Move and rename file to permanent location and rename.
     * Include new file extension on rename
     * @param  String $rename   New name of file on permanent location
     * @param  String $tmp_file Name of file in temporary location
     * @return bool
     */
    public function saveAs($rename, $tmp_file = null)
    {

        if (empty($tmp_file) && empty($this->uploaded)) {
            return "No File was found!";
        }

        // File in temporary path
        $filename = (!empty($tmp_file)) ?
            $tmp_file :
            $this->uploaded['filename'];

        // Retrieve save path
        $save_path = (empty($this->saveTo)) ?
            config('uploading.storage_path.permanent') :
            $this->saveTo;

        // Make save path
        $tmp_file_location = $this->temporary_path. '/' .$filename;
        $perm_file_location = $save_path.'/'.$rename;

        $relocation_result = Storage::copy($tmp_file_location, $perm_file_location);

        return $relocation_result;
    }

}
