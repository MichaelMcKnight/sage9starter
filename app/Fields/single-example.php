<?php

namespace App;

use StoutLogic\AcfBuilder\FieldsBuilder;

$singleExamplePT = new FieldsBuilder( 'single_example_pt', [ 'position' => 'side', 'style' => 'seamless' ] );

$singleExamplePT
	->addText( 'example_text_field', [
		'label' => 'Example Text',
	] )
	->setLocation( 'post_type', '==', 'example_pt' );

return $singleExamplePT;
