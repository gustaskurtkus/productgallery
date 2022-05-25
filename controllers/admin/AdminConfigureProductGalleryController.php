<?php

class AdminConfigureProductGalleryController extends ModuleAdminController
{
    const allowedExtensions = [
        'gif',
        'jpg',
        'jpeg',
        'jpe',
        'png',
        'svg'
    ];

    public function ajaxProcessUpload()
    {
        $id_product = Tools::getValue('id_product');

        if (isset($_FILES) && !empty($_FILES)) {
            $image = $_FILES['file'];
            $fileTmpName = $image['tmp_name'];
            $filename = $image['name'];
            $fileName = uniqid() . '.' . pathinfo($filename, PATHINFO_EXTENSION);;

            if (!ImageManager::isCorrectImageFileExt($image['name'], self::allowedExtensions)) {
                $this->ajaxDie(json_encode([
                    'success' => false,
                    'message' => $this->module->l(sprintf('Wrong image format. Allowed formats are: %s', implode(', ', self::allowedExtensions)))
                ]));
            }

            if (!file_exists(_PS_MODULE_DIR_ . $this->module->name . '/img')) {
                mkdir(_PS_MODULE_DIR_ . $this->module->name . '/img');
            }

            move_uploaded_file($fileTmpName, _PS_MODULE_DIR_ . $this->module->name . '/img/' . $fileName);

            $productGallery = new ProductGalleryClass();
            $productGallery->id_product = (int) $id_product;
            $productGallery->filename = $fileName;

            if ($productGallery->save()) {
                $this->ajaxDie(json_encode([
                    'success' => true,
                    'data' => [
                        'url' => __PS_BASE_URI__ . 'modules/' . $this->module->name . '/img/' . $fileName,
                        'id' => $productGallery->id
                    ],
                    'message' => $this->module->l('Image uploaded successfully!')
                ]));
            }

            $this->ajaxDie(json_encode([
                'status' => true,
                'message' => $this->module->l('Serverside error occurred! Contact system administrator.')
            ]));
        }
    }


    public function ajaxProcessDelete()
    {
        $id_productgallery = Tools::getValue('id_productgallery');
        $productGallery = new ProductGalleryClass((int) $id_productgallery);
        $path = _PS_MODULE_DIR_ . $this->module->name . '/img/' . $productGallery->filename;

        if (file_exists($path)) {
            unlink($path);
        }

        if ($productGallery->delete()) {
            $this->ajaxDie(json_encode([
                'success' => true,
                'message' => $this->module->l('Deleted successfully!')
            ]));
        } else {
            $this->ajaxDie(json_encode([
                'success' => false,
                'message' => $this->module->l('Serverside error occurred! Contact system administrator.')
            ]));
        }
    }
}
