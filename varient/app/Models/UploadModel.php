<?php namespace App\Models;

require_once APPPATH . "ThirdParty/intervention-image/vendor/autoload.php";

use CodeIgniter\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

class UploadModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->imgQuality = 85;
    }

    //upload file
    private function upload($inputName, $directory, $namePrefix, $allowedExtensions = null, $keepOrjName = false)
    {
        if ($allowedExtensions != null && is_array($allowedExtensions) && !empty($allowedExtensions[0])) {
            if (!$this->checkAllowedFileTypes($inputName, $allowedExtensions)) {
                return null;
            }
        }
        $file = $this->request->getFile($inputName);
        if (!empty($file) && !empty($file->getName())) {
            $orjName = $file->getName();
            $name = pathinfo($orjName, PATHINFO_FILENAME);
            $ext = pathinfo($orjName, PATHINFO_EXTENSION);
            $name = strSlug($name);
            if (empty($name)) {
                $name = generateToken();
            }
            $uniqiName = $namePrefix . generateToken() . '.' . $ext;
            if ($keepOrjName == true) {
                $fullName = $name . '.' . $ext;
                if (file_exists(FCPATH . $directory . '/' . $fullName)) {
                    $fullName = $name . '-' . uniqid() . '.' . $ext;
                }
                $uniqiName = $fullName;
            }
            $path = $directory . $uniqiName;
            if (!$file->hasMoved()) {
                if ($file->move(FCPATH . $directory, $uniqiName)) {
                    return ['name' => $uniqiName, 'orjName' => $orjName, 'path' => $path, 'ext' => $ext];
                }
            }
        }
        return null;
    }

    //upload temp file
    public function uploadTempFile($inputName, $isImage = false)
    {
        $allowedExtensions = array();
        if ($isImage) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        }
        return $this->upload($inputName, 'uploads/tmp/', 'temp_', $allowedExtensions);
    }

    //upload file
    public function uploadFile($inputName)
    {
        $extensions = $this->generalSettings->allowed_file_extensions;
        $extArray = array();
        if (!empty($extensions)) {
            $extArray = @explode(',', $extensions);
        }
        return $this->upload($inputName, "uploads/files/", "file_", $extArray, true);
    }

    //upload GIF image
    public function uploadGIF($fileName, $targetDirectory)
    {
        $newName = 'img_' . generateToken() . '.gif';
        $directory = $this->createUploadDirectory($targetDirectory);
        rename(FCPATH . 'uploads/tmp/' . $fileName, FCPATH . 'uploads/' . $targetDirectory . '/' . $directory . $newName);
        return 'uploads/' . $targetDirectory . '/' . $directory . $newName;
    }

    //upload CSV file
    public function uploadCSVFile($inputName)
    {
        return $this->upload($inputName, 'uploads/tmp/', 'temp_', ['csv']);
    }

    //upload post image
    public function uploadPostImage($tempPath, $type)
    {
        $img = Image::make($tempPath)->orientate();
        $name = '';
        if ($type == 'big') {
            $name = 'image_870x580_';
            $img->fit(870, 580);
        } elseif ($type == 'default') {
            $name = 'image_870x_';
            $img->resize(870, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } elseif ($type == 'slider') {
            $name = 'image_694x532_';
            $img->fit(694, 532);
        } elseif ($type == 'mid') {
            $name = 'image_430x256_';
            $img->fit(450, 280);
        } elseif ($type == 'small') {
            $name = 'image_140x98_';
            $img->fit(140, 98);
        }
        $newPath = 'uploads/images/' . $this->createUploadDirectory('images') . $name . uniqid() . '.jpg';
        $img->save(FCPATH . $newPath, $this->imgQuality);
        return $newPath;
    }

    //upload quiz image
    public function uploadQuizImage($tempPath, $type)
    {
        $img = Image::make($tempPath)->orientate();
        $name = '';
        if ($type == 'default') {
            $name = 'image_870x580_';
            $img->fit(870, 580);
        } elseif ($type == 'small') {
            $name = 'image_420x420_';
            $img->fit(420, 420);
        }
        $newPath = 'uploads/quiz/' . $this->createUploadDirectory('quiz') . $name . uniqid() . '.jpg';
        $img->save(FCPATH . $newPath, $this->imgQuality);
        return $newPath;
    }

    //gallery image upload
    public function uploadGalleryImage($tempPath, $width)
    {
        $newPath = 'uploads/gallery/' . $this->createUploadDirectory('gallery') . 'image_' . $width . 'x_' . uniqid() . '.jpg';
        $img = Image::make($tempPath)->orientate();
        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $newPath, $this->imgQuality);
        return $newPath;
    }

    //avatar image upload
    public function uploadAvatar($userId, $path)
    {
        $directory = $this->createUploadDirectory('profile');
        $newPath = 'uploads/profile/' . $directory . 'avatar_' . $userId . '_' . uniqid() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(240, 240);
        $img->save(FCPATH . $newPath, 100);
        return $newPath;
    }

    //cover image upload
    public function uploadCoverImage($userId, $path)
    {
        $directory = $this->createUploadDirectory('profile');
        $newPath = 'uploads/profile/' . $directory . 'cover_' . $userId . '_' . uniqid() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(1920, 600);
        $img->save(FCPATH . $newPath, $this->imgQuality);
        return $newPath;
    }

    //upload video
    public function uploadVideo($inputName)
    {
        $directory = $this->createUploadDirectory('profile');
        return $this->upload($inputName, 'uploads/videos/' . $directory, 'video_');
    }

    //upload audio
    public function uploadAudio($inputName)
    {
        $directory = $this->createUploadDirectory('audios');
        return $this->upload($inputName, 'uploads/audios/' . $directory, 'audio_', null, true);
    }

    //logo upload
    public function uploadLogo($inputName)
    {
        return $this->upload($inputName, "uploads/logo/", "logo_", ['jpg', 'jpeg', 'png', 'gif', 'svg']);
    }

    //favicon image upload
    //logo upload
    public function uploadFavicon($inputName)
    {
        return $this->upload($inputName, "uploads/logo/", "favicon_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //ad upload
    public function uploadAd($inputName)
    {
        return $this->upload($inputName, "uploads/blocks/", "block_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //download temp image
    function downloadTempImage($url, $ext, $fileName = 'temp')
    {
        $pathJPG = FCPATH . 'uploads/tmp/' . $fileName . '.jpg';
        $pathGIF = FCPATH . 'uploads/tmp/' . $fileName . '.gif';
        if (file_exists($pathJPG)) {
            @unlink($pathJPG);
        }
        if (file_exists($pathGIF)) {
            @unlink($pathGIF);
        }
        $path = $pathJPG;
        if ($ext == 'gif') {
            $path = $pathGIF;
        }
        $context = stream_context_create(array(
            'http' => array(
                'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201')
            )
        ));
        if (copy($url, $path, $context)) {
            return $path;
        }
        return false;
    }

    //create upload directory
    public function createUploadDirectory($folder)
    {
        $directory = date("Ym");
        $directoryPath = FCPATH . 'uploads/' . $folder . '/' . $directory . '/';
        if (!is_dir($directoryPath)) {
            @mkdir($directoryPath, 0755, true);
        }
        if (!file_exists($directoryPath . "index.html")) {
            @copy(FCPATH . "uploads/index.html", $directoryPath . "index.html");
        }
        return $directory . '/';
    }

    //check allowed file types
    public function checkAllowedFileTypes($fileName, $allowedTypes)
    {
        if (!isset($_FILES[$fileName])) {
            return false;
        }
        if (empty($_FILES[$fileName]['name'])) {
            return false;
        }

        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        if(!empty($ext)){
            $ext = strtolower($ext);
        }
        $extArray = array();
        if (!empty($allowedTypes) && is_array($allowedTypes)) {
            foreach ($allowedTypes as $item) {
                if (!empty($item)) {
                    $item = trim($item, '"');
                }
                if (!empty($item)) {
                    $item = trim($item, "'");
                }
                array_push($extArray, $item);
            }
        }
        if (!empty($extArray) && in_array($ext, $extArray)) {
            return true;
        }
        return false;
    }

    //get file extension
    public function getFileExtension($name)
    {
        $ext = '';
        if (!empty($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
        }
        if (!empty($ext)) {
            $ext = strtolower($ext);
        }
        return $ext;
    }

    //delete temp file
    public function deleteTempFile($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}