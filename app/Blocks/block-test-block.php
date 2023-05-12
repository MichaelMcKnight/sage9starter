<?php

namespace App;

use StoutLogic\AcfBuilder\FieldsBuilder;

$testBlock = new FieldsBuilder( 'test_block' );

$testBlock
	->addText( 'block_heading', [
		'label' => 'Block Heading',
	] )
	->addRepeater( 'slides', [
		'label'  => 'Slides',
		'layout' => 'block',
	] )
	->addImage( 'slide_image', [
		'label'         => 'Slide Image',
		'return_format' => 'ID',
		'wrapper'       => [ 'width' => '50%' ],
	] )
	->addText( 'slide_heading', [
		'label'   => 'Slide Heading',
		'wrapper' => [ 'width' => '50%' ],
	] )
	->addWysiwyg( 'slide_content', [
		'label' => 'Slide Content',
	] )
	->endRepeater()
	->setLocation( 'block', '==', 'acf/test-block' );

return $testBlock;
