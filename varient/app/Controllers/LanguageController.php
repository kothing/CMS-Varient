<?php

namespace App\Controllers;

use App\Models\LanguageModel;

class LanguageController extends BaseAdminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('settings');
        $this->languageModel = new LanguageModel();
    }

    /**
     * Languages
     */
    public function languages()
    {
        $data["title"] = trans("language_settings");
        $data["languages"] = $this->languageModel->getLanguages();
        

        echo view('admin/includes/_header', $data);
        echo view('admin/language/languages', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Set Language Post
     */
    public function setDefaultLanguagePost()
    {
        if ($this->languageModel->setDefaultLanguage()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('language-settings'));
    }

    /**
     * Add Language Post
     */
    public function addLanguagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("language_name"), 'required|max_length[200]');
        $val->setRule('short_form', trans("short_form"), 'required|max_length[100]');
        $val->setRule('language_code', trans("language_code"), 'required|max_length[100]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('language-settings'))->withInput();
        } else {
            $langId = $this->languageModel->addLanguage();
            if (!empty($langId)) {
                $this->languageModel->addLanguageRows($langId);
                $this->languageModel->addLanguagePages($langId);
                $this->session->setFlashdata('success', trans("msg_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('language-settings'));
    }

    /**
     * Edit Language
     */
    public function editLanguage($id)
    {
        $data['title'] = trans("update_language");
        $data['language'] = $this->languageModel->getLanguage($id);
        if (empty($data['language'])) {
            return redirect()->to(adminUrl('language-settings'));
        }
        

        echo view('admin/includes/_header', $data);
        echo view('admin/language/edit_language', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Language Post
     */
    public function editLanguagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("language_name"), 'required|max_length[200]');
        $val->setRule('short_form', trans("short_form"), 'required|max_length[100]');
        $val->setRule('language_code', trans("language_code"), 'required|max_length[100]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $language = getLanguage($id);
            if (!empty($language) && $language->id == $this->generalSettings->site_lang && inputPost('status') != 1) {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
            if ($this->languageModel->editLanguage($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('language-settings'));
    }

    /**
     * Edit Translations
     */
    public function editTranslations($id)
    {
        $data['title'] = trans('edit_translations');
        $data['language'] = $this->languageModel->getLanguage($id);
        if (empty($data['language'])) {
            return redirect()->to(adminUrl('language-settings'));
        }
        
        $numRows = $this->languageModel->getTranslationCount($data['language']->id);
        $pager = paginate($this->perPage, $numRows);
        $data['translations'] = $this->languageModel->getTranslationsPaginated($data['language']->id, $this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/language/translations', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Translations Post
     */
    public function editTranslationsPost()
    {
        $langId = inputPost("lang_id");
        $ids = \Config\Services::request()->getPost();
        foreach ($ids as $key => $value) {
            if ($key != "lang_id") {
                $this->languageModel->editTranslations($langId, $key, $value);
            }
        }
        $this->session->setFlashdata('success', trans("msg_updated"));
        return redirect()->back();
    }

    /**
     * Import Language
     */
    public function importLanguagePost()
    {
        if ($this->languageModel->importLanguage()) {
            $this->session->setFlashdata('success', trans("the_operation_completed"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('language-settings'));
    }

    /**
     * Export Language
     */
    public function exportLanguagePost()
    {
        if (!is_writable(FCPATH . 'uploads/tmp')) {
            $this->session->setFlashdata('error', '"uploads/tmp" folder is not writable!');
            return redirect()->back();
        }
        $files = glob(FCPATH . 'uploads/tmp/*.json');
        if (!empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
        $arrayLang = $this->languageModel->exportLanguage();
        if (!empty($arrayLang)) {
            $filePath = FCPATH . 'uploads/tmp/' . $arrayLang['language']->name . '.json';
            $json = json_encode($arrayLang);
            $file = fopen($filePath, 'w+');
            fwrite($file, $json);
            fclose($file);
            if (file_exists($filePath)) {
                return \Config\Services::response()->download($filePath, null);
            }
        }
        return redirect()->to(adminUrl('language-settings'));
    }

    /**
     * Delete Language Post
     */
    public function deleteLanguagePost()
    {
        $id = inputPost('id');
        $language = $this->languageModel->getLanguage($id);
        if ($language->id == 1) {
            $this->session->setFlashdata('error', trans("msg_language_delete"));
            exit();
        }
        if ($this->languageModel->deleteLanguage($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }
}
