<?php namespace App\Models;

use CodeIgniter\Model;

class FileModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->uploadModel = new UploadModel();
        $this->builder = $this->db->table('images');
        $this->builderQuizImages = $this->db->table('quiz_images');
        $this->builderFiles = $this->db->table('files');
        $this->builderVideos = $this->db->table('videos');
        $this->builderAudios = $this->db->table('audios');
        $this->fileManagerLimit = 60;
    }

    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload image
    public function uploadImage()
    {
        $tempFile = $this->uploadModel->uploadTempFile('file', true);
        if (!empty($tempFile)) {
            if ($tempFile['ext'] == 'gif') {
                $gifPath = $this->uploadModel->uploadGIF($tempFile['name'], 'images');
                $data['image_big'] = $gifPath;
                $data['image_default'] = $gifPath;
                $data['image_slider'] = $gifPath;
                $data['image_mid'] = $gifPath;
                $data['image_small'] = $gifPath;
                $data['image_mime'] = 'gif';
                $data['file_name'] = $tempFile['orjName'];
            } else {
                $data['image_big'] = $this->uploadModel->uploadPostImage($tempFile['path'], 'big');
                $data['image_default'] = $this->uploadModel->uploadPostImage($tempFile['path'], 'default');
                $data['image_slider'] = $this->uploadModel->uploadPostImage($tempFile['path'], 'slider');
                $data['image_mid'] = $this->uploadModel->uploadPostImage($tempFile['path'], 'mid');
                $data['image_small'] = $this->uploadModel->uploadPostImage($tempFile['path'], 'small');
                $data['image_mime'] = 'jpg';
                $data['file_name'] = $tempFile['orjName'];
            }
            $data['user_id'] = user()->id;
            $data['storage'] = $this->generalSettings->storage;
            $db = \Config\Database::connect(null, false);
            $db->table('images')->insert($data);
            $db->close();
            $this->uploadModel->deleteTempFile($tempFile['path']);
            //move to s3
            if ($data['storage'] == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->uploadFile($data['image_big']);
                if ($data['image_mime'] != 'gif') {
                    $awsModel->uploadFile($data['image_default']);
                    $awsModel->uploadFile($data['image_slider']);
                    $awsModel->uploadFile($data['image_mid']);
                    $awsModel->uploadFile($data['image_small']);
                }
            }
        }
    }

    //get image
    public function getImage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get images
    public function getImages()
    {
        $this->filterFilesByUser($this->builder);
        return $this->builder->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //get more images
    public function getMoreImages($lastId)
    {
        $this->filterFilesByUser($this->builder);
        return $this->builder->where('id < ', cleanNumber($lastId))->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //search images
    public function searchImages($search)
    {
        $this->filterFilesByUser($this->builder);
        return $this->builder->like('file_name', cleanStr($search))->orderBy('id DESC')->get()->getResult();
    }

    //delete image
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        if (!empty($image) && $this->checkFileOwnership($image->user_id)) {
            if ($image->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($image->image_big);
                if ($image->image_mime != 'gif') {
                    $awsModel->deleteFile($image->image_default);
                    $awsModel->deleteFile($image->image_slider);
                    $awsModel->deleteFile($image->image_mid);
                    $awsModel->deleteFile($image->image_small);
                }
            } else {
                @unlink(FCPATH . $image->image_big);
                @unlink(FCPATH . $image->image_default);
                @unlink(FCPATH . $image->image_slider);
                @unlink(FCPATH . $image->image_mid);
                @unlink(FCPATH . $image->image_small);
            }
            $this->builder->where('id', $image->id)->delete();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * QUIZ IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload quiz image
    public function uploadQuizImage()
    {
        $tempFile = $this->uploadModel->uploadTempFile('file', true);
        if (!empty($tempFile)) {
            if ($tempFile['ext'] == 'gif') {
                $gifPath = $this->uploadModel->uploadGIF($tempFile['name'], 'quiz');
                $data['image_default'] = $gifPath;
                $data['image_small'] = $gifPath;
                $data['image_mime'] = 'gif';
                $data['file_name'] = $tempFile['orjName'];
            } else {
                $data['image_default'] = $this->uploadModel->uploadQuizImage($tempFile['path'], 'default');
                $data['image_small'] = $this->uploadModel->uploadQuizImage($tempFile['path'], 'small');
                $data['image_mime'] = 'jpg';
                $data['file_name'] = $tempFile['orjName'];
            }
            $data['user_id'] = user()->id;
            $data['storage'] = $this->generalSettings->storage;

            $db = \Config\Database::connect(null, false);
            $db->table('quiz_images')->insert($data);
            $db->close();
            $this->uploadModel->deleteTempFile($tempFile['path']);
            //move to s3
            if ($data['storage'] == 'aws_s3') {
                $data['storage'] = 'aws_s3';
                $awsModel = new AwsModel();
                $awsModel->uploadFile($data['image_default']);
                if ($data['image_mime'] != 'gif') {
                    $awsModel->uploadFile($data['image_small']);
                }
            }
        }
    }

    //get quiz image
    public function getQuizImage($id)
    {
        return $this->builderQuizImages->where('id', cleanNumber($id))->get()->getRow();
    }

    //get quiz images
    public function getQuizImages()
    {
        $this->filterFilesByUser($this->builderQuizImages);
        return $this->builderQuizImages->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //get more quiz images
    public function getMoreQuizImages($lastId)
    {
        $this->filterFilesByUser($this->builderQuizImages);
        return $this->builderQuizImages->where('id < ', cleanNumber($lastId))->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //search quiz images
    public function searchQuizImages($search)
    {
        $this->filterFilesByUser($this->builderQuizImages);
        return $this->builderQuizImages->like('file_name', cleanStr($search))->orderBy('id DESC')->get()->getResult();
    }

    //delete quiz image
    public function deleteQuizImage($id)
    {
        $image = $this->getQuizImage($id);
        if (!empty($image) && $this->checkFileOwnership($image->user_id)) {
            if ($image->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($image->image_default);
                if ($image->image_mime != 'gif') {
                    $awsModel->deleteFile($image->image_small);
                }
            } else {
                @unlink(FCPATH . $image->image_default);
                @unlink(FCPATH . $image->image_small);
            }
            $this->builderQuizImages->where('id', $image->id)->delete();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    //upload file
    public function uploadFile()
    {
        if ($this->generalSettings->storage == 'aws_s3') {
            $awsModel = new AwsModel();
            $directory = $this->uploadModel->createUploadDirectory('files');
            $path = 'uploads/files/' . $directory;
            $file = $awsModel->uploadFileDirect('file', $path);
            if (!empty($file['orjName'])) {
                $data = [
                    'file_name' => $file['orjName'],
                    'file_path' => $file['path'],
                    'user_id' => user()->id,
                    'storage' => 'aws_s3'
                ];
            }
        } else {
            $file = $this->uploadModel->uploadFile('file');
            if (!empty($file)) {
                $data = [
                    'file_name' => $file['orjName'],
                    'file_path' => $file['path'],
                    'user_id' => user()->id,
                    'storage' => 'local'
                ];
            }
        }
        if (!empty($data)) {
            $db = \Config\Database::connect(null, false);
            $db->table('files')->insert($data);
            $db->close();
        }
    }

    //get files
    public function getFiles()
    {
        $this->filterFilesByUser($this->builderFiles);
        return $this->builderFiles->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //get file
    public function getFile($id)
    {
        return $this->builderFiles->where('id', cleanNumber($id))->get()->getRow();
    }

    //get more files
    public function getMoreFiles($lastId)
    {
        $this->filterFilesByUser($this->builderFiles);
        return $this->builderFiles->where('id < ', cleanNumber($lastId))->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //search files
    public function searchFiles($search)
    {
        $this->filterFilesByUser($this->builderFiles);
        return $this->builderFiles->like('file_name', cleanStr($search))->orderBy('id DESC')->get()->getResult();
    }

    //delete file
    public function deleteFile($id)
    {
        $file = $this->getFile($id);
        if (!empty($file) && $this->checkFileOwnership($file->user_id)) {
            if ($file->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($file->file_path);
            } else {
                @unlink(FCPATH . $file->file_path);
            }
            $this->builderFiles->where('id', $file->id)->delete();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * VIDEOS
    *------------------------------------------------------------------------------------------
    */

    //upload video
    public function uploadVideo()
    {
        if ($this->generalSettings->storage == 'aws_s3') {
            $awsModel = new AwsModel();
            $directory = $this->uploadModel->createUploadDirectory('videos');
            $path = 'uploads/videos/' . $directory;
            $file = $awsModel->uploadFileDirect('file', $path);
            if (!empty($file['orjName'])) {
                $data = [
                    'video_name' => $file['orjName'],
                    'video_path' => $file['path'],
                    'user_id' => user()->id,
                    'storage' => 'aws_s3'
                ];
            }
        } else {
            $file = $this->uploadModel->uploadVideo('file');
            if (!empty($file)) {
                $data = [
                    'video_name' => $file['orjName'],
                    'video_path' => $file['path'],
                    'user_id' => user()->id,
                    'storage' => 'local'
                ];
            }
        }
        if (!empty($data)) {
            $db = \Config\Database::connect(null, false);
            $db->table('videos')->insert($data);
            $db->close();
        }
    }

    //get videos
    public function getVideos()
    {
        $this->filterFilesByUser($this->builderVideos);
        return $this->builderVideos->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //get video
    public function getVideo($id)
    {
        return $this->builderVideos->where('id', cleanNumber($id))->get()->getRow();
    }

    //get more videos
    public function getMoreVideos($lastId)
    {
        $this->filterFilesByUser($this->builderVideos);
        return $this->builderVideos->where('id < ', cleanNumber($lastId))->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //search videos
    public function searchVideos($search)
    {
        $this->filterFilesByUser($this->builderVideos);
        return $this->builderVideos->like('video_name', cleanStr($search))->orderBy('id DESC')->get()->getResult();
    }

    //delete video
    public function deleteVideo($id)
    {
        $video = $this->getVideo($id);
        if (!empty($video) && $this->checkFileOwnership($video->user_id)) {
            if ($video->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($video->video_path);
            } else {
                @unlink(FCPATH . $video->video_path);
            }
            $this->builderVideos->where('id', $video->id)->delete();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
     * AUDIOS
    *------------------------------------------------------------------------------------------
    */

    //upload audio
    public function uploadAudio()
    {
        if ($this->generalSettings->storage == 'aws_s3') {
            $awsModel = new AwsModel();
            $directory = $this->uploadModel->createUploadDirectory('audios');
            $path = 'uploads/audios/' . $directory;
            $file = $awsModel->uploadFileDirect('file', $path);
            if (!empty($file['orjName'])) {
                $data = [
                    'audio_name' => $file['orjName'],
                    'audio_path' => $file['path'],
                    'download_button' => inputPost('download_button'),
                    'user_id' => user()->id,
                    'storage' => 'aws_s3'
                ];
            }
        } else {
            $file = $this->uploadModel->uploadAudio('file');
            if (!empty($file)) {
                $data = [
                    'audio_name' => $file['orjName'],
                    'audio_path' => $file['path'],
                    'download_button' => inputPost('download_button'),
                    'user_id' => user()->id,
                    'storage' => 'local'
                ];
            }
        }
        if (!empty($data)) {
            $db = \Config\Database::connect(null, false);
            $db->table('audios')->insert($data);
            $db->close();
        }
    }

    //get audios
    public function getAudios()
    {
        $this->filterFilesByUser($this->builderAudios);
        return $this->builderAudios->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //get audio
    public function getAudio($id)
    {
        return $this->builderAudios->where('id', cleanNumber($id))->get()->getRow();
    }

    //get more audios
    public function getMoreAudios($lastId)
    {
        $this->filterFilesByUser($this->builderAudios);
        return $this->builderAudios->where('id < ', cleanNumber($lastId))->orderBy('id DESC')->get($this->fileManagerLimit)->getResult();
    }

    //search audios
    public function searchAudios($search)
    {
        $this->filterFilesByUser($this->builderAudios);
        return $this->builderAudios->like('audio_name', cleanStr($search))->orderBy('id DESC')->get()->getResult();
    }

    //delete audio
    public function deleteAudio($id)
    {
        $audio = $this->getAudio($id);
        if (!empty($audio) && $this->checkFileOwnership($audio->user_id)) {
            if ($audio->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($audio->audio_path);
            } else {
                @unlink(FCPATH . $audio->audio_path);
            }
            $this->builderAudios->where('id', $audio->id)->delete();
        }
    }

    //filter files by user
    public function filterFilesByUser($builder)
    {
        if ($this->generalSettings->file_manager_show_files != 1) {
            $builder->where('user_id', user()->id);
        }
    }

    //check file ownership
    public function checkFileOwnership($userId)
    {
        if (checkUserPermission('manage_all_posts')) {
            return true;
        }
        if ($userId == user()->id) {
            return true;
        }
        return false;
    }
}
