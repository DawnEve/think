<?php
namespace GK\Model;
use Think\Model;
class KnowledgeModel extends RelationModel{
	Protected $_link = array(
		'knowledge' => array(
			'mapping_type' => self::MANY_TO_MANY, 
			//'class_name' => 'attr',
			//'mapping_name' => 'attrs',
			'foreign_key' => 'img_id',
			'relation_foreign_key' => 'cate_id',
			'relation_table' => 'hd_img_cate',
		),
	
	);

	
}