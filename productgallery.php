<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Productgallery extends Module
{
    public function __construct()
    {
        $this->name = 'productgallery';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Gustas Kurtkus';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product gallery');
        $this->description = $this->l('Creates additional gallery for product to upload customer pictures and etc.');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install() &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayAdminProductsExtra') &&
            $this->registerHook('displayAfterProductThumbs');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookBackOfficeHeader()
    {
        $ajaxUrl = $this->context->link->getAdminLink('AdminConfigureProductGallery');

        Media::addJsDef([
            'ajaxUrl' => $ajaxUrl,
        ]);

        $this->context->controller->addJS($this->_path.'views/js/back.js');
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $productGalleryClass = new ProductGalleryClass();
        $images = $productGalleryClass->getImagesForProduct($params['id_product']);

        $images = array_filter($images, function($image) {
            if (file_exists(_PS_MODULE_DIR_ . $this->name . '/img/' . $image['filename'])) {
                return $image;
            }
        });

        $this->context->smarty->assign([
            'id_product' => $params['id_product'],
            'images_path' => $this->_path . '/img/',
            'images' => $images
        ]);

        return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }

    public function hookDisplayAfterProductThumbs($params)
    {
        $productGalleryClass = new ProductGalleryClass();
        $images = $productGalleryClass->getImagesForProduct(Tools::getValue('id_product'));

        if (empty($images)) {
            return false;
        }

        $images = array_filter($images, function($image) {
            if (file_exists(_PS_MODULE_DIR_ . $this->name . '/img/' . $image['filename'])) {
                return $image;
            }
        });

        $this->context->smarty->assign([
            'id_product' => Tools::getValue('id_product'),
            'images_path' => $this->_path . '/img/',
            'images' => $images
        ]);

        return $this->display(__FILE__, 'views/templates/hook/images.tpl');
    }
}
