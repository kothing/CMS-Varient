<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class GalleryController extends BaseAdminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('gallery');
        $this->galleryModel = new GalleryModel();
    }

    /**
     * Images
     */
    public function images()
    {
        $data['title'] = trans("images");
        $numRows = $this->galleryModel->getImagesCount();
        $pager = paginate($this->perPage, $numRows);
        
        $data['images'] = $this->galleryModel->getImagesPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/images', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Image
     */
    public function addImage()
    {
        $data['title'] = trans("add_image");
        $data['albums'] = $this->galleryModel->getAlbumsByLang($this->activeLang->id);
        

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/add_image', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Image Post
     */
    public function addImagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'max_length[500]');
        $val->setRule('album_id', trans("album"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('gallery-add-image'))->withInput();
        } else {
            if ($this->galleryModel->addImage()) {
                $this->session->setFlashdata('success', trans('msg_added'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('gallery-add-image'))->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-add-image'));
    }

    /**
     * Edit Image
     */
    public function editImage($id)
    {
        $data['title'] = trans("update_image");
        $data['image'] = $this->galleryModel->getImage($id);
        if (empty($data['image'])) {
            return redirect()->to(adminUrl('gallery-images'));
        }
        
        $data['albums'] = $this->galleryModel->getAlbumsByLang($this->activeLang->id);
        $data['categories'] = $this->galleryModel->getCategoriesByAlbum($data['image']->album_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit_image', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Image Post
     */
    public function editImagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'max_length[500]');
        $val->setRule('album_id', trans("album"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->galleryModel->editImage()) {
                $this->session->setFlashdata('success', trans('msg_updated'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-images'));
    }

    /**
     * Delete Image Post
     */
    public function deleteImagePost()
    {
        $id = inputPost('id');
        if ($this->galleryModel->deleteImage($id)) {
            $this->session->setFlashdata('success', trans('msg_deleted'));
        } else {
            $this->session->setFlashdata('error', trans('msg_error'));
        }
    }

    /**
     * Albums
     */
    public function albums()
    {
        $data['title'] = trans("albums");
        $data['albums'] = $this->galleryModel->getAlbums();
        $data['langSearchColumn'] = 2;
        

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/albums', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Album Post
     */
    public function addAlbumPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("album_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('gallery-albums'))->withInput();
        } else {
            if ($this->galleryModel->addAlbum()) {
                $this->session->setFlashdata('success', trans('msg_added'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('gallery-albums'))->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-albums'));
    }

    /**
     * Edit Album
     */
    public function editAlbum($id)
    {
        $data['title'] = trans("update_album");
        $data['album'] = $this->galleryModel->getAlbum($id);
        if (empty($data['album'])) {
            return redirect()->to(adminUrl('gallery-albums'));
        }
        

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit_album', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Album Post
     */
    public function editAlbumPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("album_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->galleryModel->editAlbum($id)) {
                $this->session->setFlashdata('success', trans('msg_updated'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-albums'));
    }

    /**
     * Delete Album Post
     */
    public function deleteAlbumPost()
    {
        $id = inputPost('id');
        if ($this->galleryModel->getAlbumCategoryCount($id) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_album"));
            exit();
        }
        if ($this->galleryModel->deleteAlbum($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
            exit();
        }
        $this->session->setFlashdata('error', trans("msg_error"));
    }

    //get albums by lang
    public function getAlbumsByLang()
    {
        $langId = inputPost('lang_id');
        if (!empty($langId)) {
            $albums = $this->galleryModel->getAlbumsByLang($langId);
            if (!empty($albums)) {
                foreach ($albums as $item) {
                    echo '<option value="' . $item->id . '">' . esc($item->name) . '</option>';
                }
            }
        }
    }

    //set image as album cover
    public function setAsAlbumCover()
    {
        $id = inputPost('image_id');
        $this->galleryModel->setAsAlbumCover($id);
    }

    /**
     * Categories
     */
    public function categories()
    {
        $data['title'] = trans("gallery_categories");
        $data['categories'] = $this->galleryModel->getCategories();
        $data['albums'] = $this->galleryModel->getAlbumsByLang($this->activeLang->id);
        
        $data['langSearchColumn'] = 3;

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/categories', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Category Post
     */
    public function addCategoryPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('gallery-categories'))->withInput();
        } else {
            if ($this->galleryModel->addCategory()) {
                $this->session->setFlashdata('success', trans('msg_added'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('gallery-categories'))->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-categories'));
    }

    /**
     * Edit Category
     */
    public function editCategory($id)
    {
        $data['title'] = trans("update_category");
        $data['category'] = $this->galleryModel->getCategory($id);
        if (empty($data['category'])) {
            return redirect()->to(adminUrl('gallery-categories'));
        }
        
        $data['albums'] = $this->galleryModel->getAlbumsByLang($data['category']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit_category', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Category Post
     */
    public function editCategoryPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->galleryModel->editCategory($id)) {
                $this->session->setFlashdata('success', trans('msg_updated'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        }
        return redirect()->to(adminUrl('gallery-categories'));
    }

    /**
     * Delete Category Post
     */
    public function deleteCategoryPost()
    {
        $id = inputPost('id');
        if ($this->galleryModel->getCategoryImageCount($id) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_images"));
            exit();
        }
        if ($this->galleryModel->deleteCategory($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
            exit();
        }
        $this->session->setFlashdata('error', trans("msg_error"));
    }

    //get categories by album
    public function getCategoriesByAlbum()
    {
        $albumId = inputPost('album_id');
        if (!empty($albumId)) {
            $categories = $this->galleryModel->getCategoriesByAlbum($albumId);
            if (!empty($categories)) {
                foreach ($categories as $item) {
                    echo '<option value="' . $item->id . '">' . esc($item->name) . '</option>';
                }
            }
        }
    }

}
