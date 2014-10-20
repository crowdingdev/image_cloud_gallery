<?php

class DBQueryHelperClass extends ObjectModel
{
	/**
	* Now only displays category from the first language id == 1.
	* @author Linus Karlsson
	*/
	public static function getAllAttributes()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT  a.id_attribute, al.name FROM '._DB_PREFIX_.'attribute a'.
		' JOIN '._DB_PREFIX_.'attribute_lang al ON a.id_attribute = al.id_attribute '.
		' WHERE al.id_lang = 1'
		);
		return $result;
	}


	public static function getAllCategories()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT c.id_category, cl.name FROM '._DB_PREFIX_.'category c '.
		' JOIN '._DB_PREFIX_.'category_lang cl ON c.id_category = cl.id_category '.
		' WHERE cl.id_lang = 1'
		);
		return $result;
	}

	public static function getAllProducts()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT p.id_product, pl.name FROM '._DB_PREFIX_.'product p '.
		' JOIN '._DB_PREFIX_.'product_lang pl ON p.id_product = pl.id_product '.
		' WHERE pl.id_lang = 1'
		);
		return $result;
	}
	

	public static function insertPrettypegsAttributePreference($id_attribute, $id_category, $id_product, $description)
	{
		$sql = '
		INSERT INTO '._DB_PREFIX_.'prettypegs_attribute_preferences (`id_attribute`,`id_category`,`id_product`, `description`)
				VALUES (' .
					(int)$id_attribute.', '.
					(int)$id_category.', '.
					(int)$id_product.', '.
					'\''.pSQL($description).'\''.
					')';

		$result = Db::getInstance()->Execute($sql);
		if($result)
			return true;
		else
			return false;
	}

	public static function updatePrettypegsAttributePreference($id_item, $id_attribute, $id_category, $id_product, $description)
	{

		$result = Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'prettypegs_attribute_preferences` SET
					id_attribute = '.(int)$id_attribute.', '.
					'id_category = '.(int)$id_category.', '.
					'id_product = '.(int)$id_product.', '.
					'description = '.'\''.pSQL($description).'\' '.
			' WHERE id_prettypegs_attribute_preferences = '.(int)$id_item
		);
		return $result;

	}

	public static function getAllPrettypegsAttributePreference()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT * FROM '._DB_PREFIX_.'prettypegs_attribute_preferences'
		);
		return $result;
	}

	public static function getAllEnabledPrettypegsAttributePreference()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT * FROM '._DB_PREFIX_.'prettypegs_attribute_preferences'.
		' WHERE enabled = 1 '
		);
		return $result;
	}

	public static function attributeDesc($id_attribute, $id_lang)
	{
		$sql = '
		SELECT  ad.*
		FROM  '._DB_PREFIX_.'obs_attribute_desc_lang ad
		WHERE ad.`id_attribute` = '.(int) $id_attribute.' AND ad.`id_lang` = '.(int) $id_lang;
		
		$result = Db::getInstance()->getRow($sql);
		
		return $result['desc'];
	}
	
}

?>