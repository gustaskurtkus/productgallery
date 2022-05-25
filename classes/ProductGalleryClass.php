<?php

class ProductGalleryClass extends ObjectModel
{
    public $id_productgallery;
    public $id_product;
    public $filename;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'productgallery',
        'primary' => 'id_productgallery',
        'fields' => array(
            'id_product'    => array('type' => self::TYPE_INT, 'required' => true),
            'filename'      => array('type' => self::TYPE_STRING, 'required' => true),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
    }

    /**
     * Get images by id_product
     *
     * @param $id_product
     * @return array|bool|mysqli_result|PDOStatement|resource|null
     * @throws PrestaShopDatabaseException
     */
    public function getImagesForProduct($id_product)
    {
        $query = new DbQuery();
        $query->select('*');
        $query->from('productgallery');
        $query->where('id_product = ' . pSQL($id_product));

        return Db::getInstance()->executeS($query);
    }
}
