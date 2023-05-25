<?php namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('languages');
        $this->builderTranslations = $this->db->table('language_translations');
    }

    //input values
    public function inputValues()
    {
        return [
            'name' => inputPost('name'),
            'short_form' => inputPost('short_form'),
            'language_code' => inputPost('language_code'),
            'language_order' => inputPost('language_order'),
            'text_direction' => inputPost('text_direction'),
            'text_editor_lang' => inputPost('text_editor_lang'),
            'status' => inputPost('status')
        ];
    }

    //add language
    public function addLanguage()
    {
        $data = $this->inputValues();
        if ($this->builder->insert($data)) {
            $lastId = $this->db->insertID();
            $translations = $this->getLanguageTranslations(1);
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $dataTranslation = [
                        'lang_id' => $lastId,
                        'label' => $translation->label,
                        'translation' => $translation->translation
                    ];
                    $this->builderTranslations->insert($dataTranslation);
                }
            }
            return $lastId;
        }
        return false;
    }

    //add language rows
    public function addLanguageRows($langId)
    {
        //add widgets
        $data = [
            'lang_id' => $langId,
            'content' => '',
            'visibility' => 1,
            'is_custom' => 0,
        ];

        $data['title'] = 'Follow Us';
        $data['widget_order'] = 1;
        $data['type'] = 'follow-us';
        $this->db->table('widgets')->insert($data);

        $data['title'] = 'Popular Posts';
        $data['widget_order'] = 2;
        $data['type'] = 'popular-posts';
        $this->db->table('widgets')->insert($data);

        $data['title'] = 'Recommended Posts';
        $data['widget_order'] = 3;
        $data['type'] = 'recommended-posts';
        $this->db->table('widgets')->insert($data);

        $data['title'] = 'Popular Tags';
        $data['widget_order'] = 4;
        $data['type'] = 'tags';
        $this->db->table('widgets')->insert($data);

        $data['title'] = 'Voting Poll';
        $data['widget_order'] = 5;
        $data['type'] = 'poll';
        $this->db->table('widgets')->insert($data);

        //add settings
        $settings = [
            'lang_id' => $langId,
            'site_title' => 'Varient - News Magazine',
            'home_title' => 'Index',
            'site_description' => 'Varient - News Magazine',
            'keywords' => 'Varient, News, Magazine',
            'application_name' => 'Varient',
            'primary_font' => 20,
            'secondary_font' => 10,
            'tertiary_font' => 34,
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'pinterest_url' => '',
            'linkedin_url' => '',
            'vk_url' => '',
            'telegram_url' => '',
            'youtube_url' => '',
            'optional_url_button_name' => 'Click Here To See More',
            'about_footer' => '',
            'contact_text' => '',
            'contact_address' => '',
            'contact_email' => '',
            'contact_phone' => '',
            'copyright' => '',
            'cookies_warning' => 0,
            'cookies_warning_text' => ''
        ];
        $this->db->table('settings')->insert($settings);
    }

    //add language pages
    public function addLanguagePages($langId)
    {
        $page = ['lang_id' => $langId, 'title' => 'Gallery', 'slug' => 'gallery', 'description' => 'Varient Gallery Page', 'keywords' => 'varient, gallery , page', 'is_custom' => 0, 'page_default_name' => 'gallery', 'page_content' => '', 'page_order' => 2, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => 'main', 'link' => '', 'parent_id' => 0, 'page_type' => 'page',];
        $this->db->table('pages')->insert($page);

        $page = ['lang_id' => $langId, 'title' => 'Contact', 'slug' => 'contact', 'description' => 'Varient Contact Page', 'keywords' => 'varient, contact, page', 'is_custom' => 0, 'page_default_name' => 'contact', 'page_content' => '', 'page_order' => 1, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => 'top', 'link' => '', 'parent_id' => 0, 'page_type' => 'page',];
        $this->db->table('pages')->insert($page);

        $page = ['lang_id' => $langId, 'title' => 'Terms & Conditions', 'slug' => 'terms-conditions', 'description' => 'Varient Terms Conditions Page', 'keywords' => 'varient, terms, conditions', 'is_custom' => 0, 'page_default_name' => 'terms_conditions', 'page_content' => '', 'page_order' => 1, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => 'footer', 'link' => '', 'parent_id' => 0, 'page_type' => 'page',];
        $this->db->table('pages')->insert($page);
    }

    //edit language
    public function editLanguage($id)
    {
        $language = $this->getLanguage($id);
        if (!empty($language)) {
            $data = $this->inputValues();
            return $this->builder->where('id', $language->id)->update($data);
        }
        return false;
    }

    //get language
    public function getLanguage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get languages
    public function getLanguages()
    {
        return $this->builder->orderBy('language_order')->get()->getResult();
    }

    //get language translations
    public function getLanguageTranslations($langId)
    {
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->get()->getResult();
    }

    //get paginated translations
    public function getTranslationsPaginated($langId, $perPage, $offset)
    {
        $this->filterTranslations();
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->orderBy('id')->limit($perPage, $offset)->get()->getResult();
    }

    //get translations count
    public function getTranslationCount($langId)
    {
        $this->filterTranslations();
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->countAllResults();
    }

    //filter translations
    public function filterTranslations()
    {
        $q = cleanStr(inputGet('q'));
        if (!empty($q)) {
            $this->builderTranslations->groupStart()->like('label', $q)->orLike('translation', $q)->groupEnd();
        }
    }

    //get language translation by label
    public function getTransByLabel($label, $langId)
    {
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->where('label', cleanStr($label))->get()->getRow();
    }

    //set default language
    public function setDefaultLanguage()
    {
        $data = ['site_lang' => inputPost('site_lang')];
        $lang = $this->getLanguage($data['site_lang']);
        if (!empty($lang)) {
            return $this->db->table('general_settings')->where('id', 1)->update($data);
        }
        return false;
    }

    //edit translation
    public function editTranslations($langId, $id, $translation)
    {
        $data = ['translation' => $translation];
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->where('id', cleanNumber($id))->update($data);
    }

    //import language
    public function importLanguage()
    {
        $uploadModel = new UploadModel();
        $uploadedFile = $uploadModel->uploadTempFile('file');
        if (!empty($uploadedFile) && !empty($uploadedFile['path'])) {
            $json = file_get_contents($uploadedFile['path']);
            if (!empty($json)) {
                $count = countItems($this->getLanguages());
                $jsonArray = json_decode($json);
                $language = $jsonArray->language;
                //add language
                if (isset($jsonArray->language)) {
                    $data = array(
                        'name' => isset($jsonArray->language->name) ? $jsonArray->language->name : 'language',
                        'short_form' => isset($jsonArray->language->short_form) ? $jsonArray->language->short_form : 'ln',
                        'language_code' => isset($jsonArray->language->language_code) ? $jsonArray->language->language_code : 'cd',
                        'text_direction' => isset($jsonArray->language->text_direction) ? $jsonArray->language->text_direction : 'ltr',
                        'text_editor_lang' => isset($jsonArray->language->text_editor_lang) ? $jsonArray->language->text_editor_lang : 'ln',
                        'status' => 1,
                        'language_order' => $count + 1
                    );
                    $this->builder->insert($data);
                    $insertId = $this->db->insertID();
                    $this->addLanguageRows($insertId);
                    $this->addLanguagePages($insertId);
                    if (isset($jsonArray->translations)) {
                        foreach ($jsonArray->translations as $translation) {
                            $dataTranslation = [
                                'lang_id' => $insertId,
                                'label' => $translation->label,
                                'translation' => $translation->translation
                            ];
                            $this->builderTranslations->insert($dataTranslation);
                        }
                    }
                }
            }
            @unlink($uploadedFile['path']);
            return true;
        }
        return false;
    }

    //export language
    public function exportLanguage()
    {
        $langId = inputPost("lang_id");
        $language = $this->getLanguage($langId);
        if (!empty($language)) {
            $arrayLang = array();
            $objLang = new \stdClass();
            $objLang->name = $language->name;
            $objLang->short_form = $language->short_form;
            $objLang->language_code = $language->language_code;
            $objLang->text_direction = $language->text_direction;
            $objLang->text_editor_lang = $language->text_editor_lang;
            $arrayLang['language'] = $objLang;
            $arrayLang['translations'] = $this->builderTranslations->select('label,translation')->where('lang_id', cleanNumber($langId))->orderBy('id')->get()->getResult();
            return $arrayLang;
        }
        return null;
    }

    //delete language
    public function deleteLanguage($id)
    {
        $language = $this->getLanguage($id);
        if (!empty($language)) {
            $this->builderTranslations->where('lang_id', $language->id)->delete();
            $this->db->table('settings')->where('lang_id', $language->id)->delete();
            $this->db->table('pages')->where('lang_id', $language->id)->delete();
            $this->db->table('widgets')->where('lang_id', $language->id)->delete();
            return $this->builder->where('id', $language->id)->delete();
        }
        return false;
    }
}
