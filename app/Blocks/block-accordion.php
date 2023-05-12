<?php

namespace App;

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockAccordion = new FieldsBuilder( 'block_accordion' );

$blockAccordion
	->addAccordion( 'block_accordion', [
		'label' => 'Block - Accordions',
	])
		->addRepeater( 'accordion_panels', [
			'label'     => 'Accordion Panels',
			'collapsed' => 'accordion_panel_title',
			'layout'    => 'block',
		])
			->addText( 'accordion_panel_title', [
				'label' => 'Panel Title',
				'required' => 1,
				'wrapper' => ['width' => '50%'],
			])
			->addWysiwyg( 'accordion_panel_content', [
				'label' => 'Panel Content',
				'required' => 1,
				'wrapper' => ['width' => '50%'],
			])
		->endRepeater()
	->addAccordion( 'end_block_accordion' )->endpoint()
	->setLocation( 'block', '==', 'acf/accordion' );

return $blockAccordion;
