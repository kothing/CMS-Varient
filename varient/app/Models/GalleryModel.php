<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('gallery');
        $this->builderAlbum = $this->db->table('gallery_albums');
        $this->builderCategory = $this->db->table('gallery_categories');
    }

    /*
     * --------------------------------------------------------------------
     * GALLERY
     * --------------------------------------------------------------------
     */

    //input values
    public function inputValues()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'album_id' => inputPost('album_id'),
            'category_id' => 0,
            'title' => inputPost('title')
        ];
        if (!empty(inputPost('category_id'))) {
            $data['category_id'] = inputPost('category_id');
        }
        return $data;
    }

    //add image
    public function addImage()
    {
        $data = $this->inputValues();
        if (!empty($_FILES['files'])) {
            $uploadModel = new UploadModel();
            $fileCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if (isset($_FILES['files']['name'])) {
                    $tmpFilePath = $_FILES['files']['tmp_name'][$i];
                    if (isset($tmpFilePath)) {
                        $ext = $uploadModel->getFileExtension($_FILES['files']['name'][$i]);
                        $newName = 'temp_' . generateToken() . '.' . $ext;
                        $newPath = FCPATH . "uploads/tmp/" . $newName;
                        if (move_uploaded_file($tmpFilePath, FCPATH . "uploads/tmp/" . $newName)) {
                            if ($ext == 'gif') {
                                $gifPath = $uploadModel->uploadGIF($newName, 'gallery');
                                $data["path_big"] = $gifPath;
                                $data["path_small"] = $gifPath;
                            } else {
                                $data["path_big"] = $uploadModel->uploadGalleryImage($newPath, 1920);
                                $data["path_small"] = $uploadModel->uploadGalleryImage($newPath, 500);
                            }
                        }
                        $data["is_album_cover"] = 0;
                        $data["storage"] = $this->generalSettings->storage;
                        $data["created_at"] = date('Y-m-d H:i:s');
                        $db = \Config\Database::connect(null, false);
                        $db->table('gallery')->insert($data);
                        $db->close();
                        $uploadModel->deleteTempFile($newPath);
                        //move to s3
                        if ($data['storage'] == 'aws_s3') {
                            $awsModel = new AwsModel();
                            if (!empty($data['path_big'])) {
                                $awsModel->uploadFile($data['path_big']);
                            }
                            if (!empty($data['path_small']) && $ext != 'gif') {
                                $awsModel->uploadFile($data['path_small']);
                            }
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    //edit image
    public function editImage()
    {
        $id = inputPost('id');
        $image = $this->getImage($id);
        if (!empty($image)) {
            $data = $this->inputValues();
            $uploadModel = new UploadModel();
            $tempData = $uploadModel->uploadTempFile('file', true);
            if (!empty($tempData)) {
                $tempPath = $tempData['path'];
                if ($tempData['ext'] == 'gif') {
                    $gifPath = $uploadModel->uploadGIF($tempData['name'], 'gallery');
                    $data["path_big"] = $gifPath;
                    $data["path_small"] = $gifPath;
                } else {
                    $data["path_big"] = $uploadModel->uploadGalleryImage($tempPath, 1920);
                    $data["path_small"] = $uploadModel->uploadGalleryImage($tempPath, 500);
                }
                $data["storage"] = $this->generalSettings->storage;
                $this->deleteImageFile($id);
                $uploadModel->deleteTempFile($tempPath);
                //move to s3
                if ($data['storage'] == 'aws_s3') {
                    $awsModel = new AwsModel();
                    if (!empty($data['path_big'])) {
                        $awsModel->uploadFile($data['path_big']);
                    }
                    if (!empty($data['path_small']) && $tempData['ext'] != 'gif') {
                        $awsModel->uploadFile($data['path_small']);
                    }
                }
            }
            return $this->builder->where('id', cleanNumber($id))->update($data);
        }
        return false;
    }

    //get image
    public function getImage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get images count
    public function getImagesCount()
    {
        $this->filterImages();
        return $this->builder->countAllResults();
    }

    //get paginated images
    public function getImagesPaginated($perPage, $offset)
    {
        $this->filterImages();
        return $this->builder->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //images filter
    public function filterImages()
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builder->like('title', cleanStr($q));
        }
        $langId = inputGet('lang_id');
        if (!empty($langId)) {
            $this->builder->where('lang_id', cleanNumber($langId));
        }
        $album = inputGet('album');
        if (!empty($album)) {
            $this->builder->where('album_id', cleanNumber($album));
        }
        $category = inputGet('category');
        if (!empty($category)) {
            $this->builder->where('category_id', cleanNumber($category));
        }
    }

    //get gallery images by album
    public function getImagesByAlbum($albumId)
    {
        return $this->builder->where('album_id', cleanNumber($albumId))->get()->getResult();
    }

    //get category image count
    public function getCategoryImageCount($categoryId)
    {
        return $this->builder->where('category_id', cleanNumber($categoryId))->countAllResults();
    }

    //set image as album cover
    public function setAsAlbumCover($id)
    {
        $image = $this->getImage($id);
        if (!empty($image)) {
            $this->builder->where('album_id', $image->album_id)->update(['is_album_cover' => 0]);
            $this->builder->where('id', $image->id)->update(['is_album_cover' => 1]);
        }
    }

    //get gallery album cover image
    public function getCoverImage($albumId)
    {
        $row = $this->builder->where('album_id', cleanNumber($albumId))->where('is_album_cover', 1)->orderBy('id DESC')->get(1)->getRow();
        if (empty($row)) {
            $row = $this->builder->where('album_id', cleanNumber($albumId))->orderBy('id DESC')->get(1)->getRow();
        }
        return $row;
    }

    //delete image
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        if (!empty($image)) {
            $this->deleteImageFile($id);
            return $this->builder->where('id', $image->id)->delete();
        }
        return false;
    }

    //delete image file
    public function deleteImageFile($id)
    {
        $image = $this->getImage($id);
        if (!empty($image)) {
            if ($image->storage == 'aws_s3') {
                $awsModel = new AwsModel();
                $awsModel->deleteFile($image->path_big);
                $awsModel->deleteFile($image->path_small);
            } else {
                @unlink(FCPATH . $image->path_big);
                @unlink(FCPATH . $image->path_small);
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * ALBUMS
     * --------------------------------------------------------------------
     */

    //add album
    public function addAlbum()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'name' => inputPost('name')
        ];
        return $this->builderAlbum->insert($data);
    }

    //edit album
    public function editAlbum($id)
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'name' => inputPost('name')
        ];
        return $this->builderAlbum->where('id', $id)->update($data);
    }

    //get albums
    public function getAlbums()
    {
        return $this->builderAlbum->orderBy('id DESC')->get()->getResult();
    }

    //get albums by lang
    public function getAlbumsByLang($langId)
    {
        return $this->builderAlbum->where('lang_id', cleanNumber($langId))->get()->getResult();
    }

    //get album category count
    public function getAlbumCategoryCount($albumId)
    {
        return $this->builderCategory->where('album_id', cleanNumber($albumId))->countAllResults();
    }

    //get album
    public function getAlbum($id)
    {
        return $this->builderAlbum->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete album
    public function deleteAlbum($id)
    {
        $album = $this->getAlbum($id);
        if (!empty($album)) {
            return $this->builderAlbum->where('id', $album->id)->delete();
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * CATEGORIES
     * --------------------------------------------------------------------
     */

    //add category
    public function addCategory()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'album_id' => inputPost('album_id'),
            'name' => inputPost('name')
        ];
        return $this->builderCategory->insert($data);
    }

    //edit category
    public function editCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            $data = [
                'lang_id' => inputPost('lang_id'),
                'album_id' => inputPost('album_id'),
                'name' => inputPost('name')
            ];
            return $this->builderCategory->where('id', $category->id)->update($data);
        }
        return false;
    }

    //get all gallery categories
    public function getCategories()
    {
        return $this->builderCategory->orderBy('id DESC')->get()->getResult();
    }

    //get gallery categories by album
    public function getCategoriesByAlbum($albumId)
    {
        return $this->builderCategory->where('album_id', cleanNumber($albumId))->get()->getResult();
    }

    //get category
    public function getCategory($id)
    {
        return $this->builderCategory->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete category
    public function deleteCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            return $this->builderCategory->where('id', $category->id)->delete();
        }
        return false;
    }

}