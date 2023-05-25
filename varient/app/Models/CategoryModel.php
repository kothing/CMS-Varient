<?php namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('categories');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'name' => inputPost('name'),
            'name_slug' => inputPost('name_slug'),
            'parent_id' => inputPost('parent_id'),
            'description' => inputPost('description'),
            'keywords' => inputPost('keywords'),
            'color' => inputPost('color'),
            'category_order' => inputPost('category_order'),
            'show_at_homepage' => inputPost('show_at_homepage'),
            'show_on_menu' => inputPost('show_on_menu'),
            'block_type' => inputPost('block_type')
        ];
    }

    //add category
    public function addCategory($type)
    {
        $data = $this->inputValues();
        if (empty($data["name_slug"])) {
            $data["name_slug"] = strSlug($data["name"]);
        } else {
            $data["name_slug"] = removeSpecialCharacters($data["name_slug"], true);
            if (!empty($data['name_slug'])) {
                $data['name_slug'] = str_replace(' ', '-', $data['name_slug']);
            }
        }
        if ($type == 'sub') {
            $parent = $this->getCategory($data["parent_id"]);
            if (!empty($parent)) {
                $data["color"] = $parent->color;
            }
            $data['block_type'] = "";
            $data['category_order'] = 1;
            $data['show_at_homepage'] = 0;
        } else {
            $data['parent_id'] = 0;
        }
        if ($this->builder->insert($data)) {
            $lastId = $this->db->insertID();
            $this->updateSlug($lastId);
            return true;
        }
        return false;
    }

    //edit category
    public function editCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            $data = $this->inputValues();
            if (empty($data["name_slug"])) {
                $data["name_slug"] = strSlug($data["name"]);
            } else {
                $data["name_slug"] = removeSpecialCharacters($data["name_slug"], true);
                if (!empty($data['name_slug'])) {
                    $data['name_slug'] = str_replace(' ', '-', $data['name_slug']);
                }
            }
            if ($category->parent_id == 0) {
                $this->updateSubCategoriesColor($id, $data["color"]);
            } else {
                $parent = $this->getCategory($data["parent_id"]);
                if (!empty($parent)) {
                    $data["color"] = $parent->color;
                }
                $data['block_type'] = "";
                $data['category_order'] = 1;
                $data['show_at_homepage'] = 0;
            }
            if (empty($data['parent_id'])) {
                $data['parent_id'] = 0;
            }
            $this->builder->where('id', $category->id)->update($data);
            $this->updateSlug($category->id);
            return true;
        }
        return false;
    }

    //update slug
    public function updateSlug($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            if (empty($category->name_slug) || $category->name_slug == "-") {
                $data = [
                    'name_slug' => $category->id
                ];
                $this->builder->where('id', $category->id)->update($data);
            } else {
                if ($this->checkSlugExists($category->name_slug, $category->id)) {
                    $data = [
                        'name_slug' => $category->name_slug . "-" . $category->id
                    ];
                    $this->builder->where('id', $category->id)->update($data);
                }
            }
        }
    }

    //check slug
    public function checkSlugExists($slug, $id)
    {
        if (!empty($this->builder->where('name_slug', cleanStr($slug))->where('id !=', cleanNumber($id))->get()->getRow())) {
            return true;
        }
        return false;
    }

    //update subcategory color
    public function updateSubCategoriesColor($parentId, $color)
    {
        $categories = $this->getSubCategoriesByParentId($parentId);
        if (!empty($categories)) {
            foreach ($categories as $item) {
                $this->builder->where('parent_id', $item->id)->update(['color' => $color]);
            }
        }
    }

    //build query
    public function buildQuery()
    {
        $this->builder->select('categories.*, (SELECT name_slug FROM categories AS tbl_categories WHERE tbl_categories.id = categories.parent_id) as parent_slug');
    }

    //get category
    public function getCategory($id)
    {
        $this->buildQuery();
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get category by slug
    public function getCategoryBySlug($slug)
    {
        $this->buildQuery();
        return $this->builder->where('categories.name_slug', cleanSlug($slug))->where('categories.lang_id', cleanNumber($this->activeLang->id))->orderBy('category_order')->get()->getRow();
    }

    //input values
    public function getCategories()
    {
        $this->buildQuery();
        return $this->builder->orderBy('category_order')->get()->getResult();
    }

    //get categories by lang
    public function getCategoriesByLang($langId)
    {
        $this->buildQuery();
        return $this->builder->where('categories.lang_id', cleanNumber($langId))->orderBy('category_order')->get()->getResult();
    }

    //get parent categories
    public function getParentCategories()
    {
        return $this->builder->where('parent_id', 0)->orderBy('created_at DESC')->get()->getResult();
    }

    //get parent categories by lang
    public function getParentCategoriesByLang($langId)
    {
        return $this->builder->where('parent_id', 0)->where('lang_id', cleanNumber($langId))->orderBy('name')->get()->getResult();
    }

    //get subcategories
    public function getSubCategories()
    {
        return $this->builder->where('parent_id !=', 0)->get()->getResult();
    }

    //get subcategories by parent id
    public function getSubCategoriesByParentId($parentId)
    {
        return $this->builder->where('parent_id', cleanNumber($parentId))->orderBy('name')->get()->getResult();
    }

    //delete category
    public function deleteCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            return $this->builder->where('id', $category->id)->delete();
        }
        return false;
    }
}
