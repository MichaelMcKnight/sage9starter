<?php

namespace App;

use StoutLogic\AcfBuilder\FieldsBuilder;

$optionsPage = new FieldsBuilder( 'options_page', [ 'style' => 'seamless' ] );

$optionsPage
    ->addTab( 'General' )
        ->addImage( 'logo_white', [
            'label'         => 'Logo White',
            'return_format' => 'ID',
            'wrapper'       => [ 'width' => '33%' ],
        ] )
        ->addImage( 'logo_color', [
            'label'         => 'Logo Color',
            'return_format' => 'ID',
            'wrapper'       => [ 'width' => '33%' ],
        ] )
        ->addImage( 'logo_color_no_tagline', [
            'label'         => 'Logo Color No Tagline',
            'return_format' => 'ID',
            'wrapper'       => [ 'width' => '33%' ],
        ] )
        ->addUrl( 'facebook', [
            'label'   => 'Facebook',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addUrl( 'twitter', [
            'label'   => 'Twitter',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addUrl( 'youtube', [
            'label'   => 'YouTube',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addUrl( 'linkedin', [
            'label'   => 'LinkedIn',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addText( 'phone', [
            'label'   => 'Phone',
            'wrapper' => [ 'width' => '50%' ],
        ] )
    ->addTab( 'Header' )
        ->addLink( 'contact', [
            'label'   => 'Contact',
            'wrapper' => [ 'width' => '33%' ],
        ] )
        ->addLink( 'faq', [
            'label'   => 'FAQ',
            'wrapper' => [ 'width' => '33%' ],
        ] )
        ->addLink( 'support', [
            'label'   => 'Support',
            'wrapper' => [ 'width' => '33%' ],
        ] )
    ->addTab( 'Footer' )
        ->addGroup('callout_cta', [
            'label' => 'Callout CTA'
        ])
            ->addWysiwyg('callout_cta_content', [
                'label' => 'Callout CTA Content'
            ])
            ->addRepeater('callout_cta_buttons', [
                'label' => 'Callout CTA Buttons',
                'layout' => 'block',
                'max' => '2'
            ])
                ->addLink('callout_cta_button', [
                    'label' => 'Callout CTA Button',
                    'wrapper' => ['width' => '50%'],
                ])
                ->addSelect('callout_cta_button_style', [
                    'label' => 'Callout CTA Button Style',
                    'choices' => [
                        'primary',
                        'outline',
                        'outline-white',
                        'white',
                        'white-dark'
                    ],
                    'wrapper' => ['width' => '50%'],
                ])
            ->endRepeater()
        ->endGroup()
        ->addText( 'cta', [
            'label'   => 'CTA',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addLink( 'cta_button', [
            'label'   => 'CTA Button',
            'wrapper' => [ 'width' => '50%' ],
        ] )
        ->addText( 'copyright_text', [
            'label' => 'Copyright Text',
        ] )
        ->addRepeater( 'logos', [
            'label'  => 'Logos',
            'layout' => 'block',
        ] )
            ->addImage( 'logo_image', [
                'label'         => 'Logo Image',
                'return_format' => 'ID',
                'wrapper'       => [ 'width' => '50%' ],
            ] )
            ->addLink( 'logo_link', [
                'label'   => 'Logo Link',
                'wrapper' => [ 'width' => '50%' ],
            ] )
        ->endRepeater()
    ->addTab('Dropdowns')
        ->addMessage('dropdowns_message', '',  [
            'label' => 'This is for editing desktop dropdown nav items. For mobile sub-menus refer to the Menus panel.'
        ])
        ->addRepeater('dropdown_bottom_row', [
            'label' => 'Dropdown Bottom Row',
            'instructions' => 'This section is for the bottom row that shows the arrow links on the bottom of every dropdown.'
        ])
            ->addLink('link', [
                'label' => 'Link'
            ])
        ->endRepeater()
        ->addText('phone_systems_nav_heading', [
            'label' => 'Phone Systems Dropdown Title'
        ])
        ->addRepeater('phone_systems_nav', [
            'label' => 'Phone Systems Nav Item'
        ])
            ->addText('title', [
                'label' => 'Title'
            ])
            ->addTextarea('description', [
                'label' => 'Description',
                'rows' => '3'
            ])
            ->addLink('link', [
                'label' => 'Link'
            ])
        ->endRepeater()
        ->addGroup('phone_systems_side_nav')
            ->addText('heading', [
                'label' => 'Heading',
                'wrapper' => ['width' => '50%']
            ])
            ->addLink('link', [
                'label' => 'Link',
                'wrapper' => ['width' => '50%']
            ])
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'ID'
            ])
        ->endGroup()
        ->addText('industries_nav_heading', [
            'label' => 'Industries Dropdown Title'
        ])
        ->addRepeater('industries_nav', [
            'label' => 'Industries Nav Item'
        ])
            ->addText('title', [
                'label' => 'Title'
            ])
            ->addTextarea('description', [
                'label' => 'Description',
                'rows' => '3'
            ])
            ->addLink('link', [
                'label' => 'Link'
            ])
        ->endRepeater()
        ->addText('how_it_works_nav_heading', [
            'label' => 'How It Works Dropdown Title'
        ])
        ->addRepeater('how_it_works_nav', [
            'label' => 'How It Works Nav Item'
        ])
            ->addText('title', [
                'label' => 'Title'
            ])
            ->addTextarea('description', [
                'label' => 'Description',
                'rows' => '3'
            ])
            ->addLink('link', [
                'label' => 'Link'
            ])
        ->endRepeater()
        ->addText('integrations_nav_heading', [
            'label' => 'Integrations Dropdown Title'
        ])
        ->addRepeater('integrations_nav', [
            'label' => 'Integrations Nav Item',
            'layout' => 'block'
        ])
            ->addText('title', [
                'label' => 'Title',
                'wrapper' => ['width' => '50%']
            ])
            ->addRepeater('integration_item', [
                'label' => 'Integration Item'
            ])
                ->addImage('integration_icon', [
                    'label' => 'Integration Icon',
                    'return_format' => 'ID'
                ])
                ->addLink('integration_link', [
                    'label' => 'Integration Link',
                ])
            ->endRepeater()
        ->endRepeater()
        ->addText('about_us_nav_heading', [
            'label' => 'About Us Dropdown Title'
        ])
        ->addRepeater('about_us_nav', [
            'label' => 'About Us Nav Item'
        ])
            ->addText('title', [
                'label' => 'Title'
            ])
            ->addTextarea('description', [
                'label' => 'Description',
                'rows' => '3'
            ])
            ->addLink('link', [
                'label' => 'Link'
            ])
        ->endRepeater()
			->addTab('Voice Recordings')
				->addRepeater('language_options', [
					'label' => 'Language Options',
					'instructions' => 'Add Language options for the voice recordings filter here.',
					'wrapper' => ['width' => '50%']
				])
					->addText('language', [
						'label' => 'Language'
					])
				->endRepeater()
				->addRepeater('gender_and_age_options', [
					'label' => 'Gender & Age Options',
					'instructions' => 'Add Gender & Age options for the voice recordings filter here.',
					'wrapper' => ['width' => '50%']
				])
					->addText('gender_and_age', [
						'label' => 'Gender & Age'
					])
				->endRepeater()
				->addRepeater('purpose_options', [
					'label' => 'Purpose Options',
					'instructions' => 'Add Purpose options for the voice recordings filter here.',
					'wrapper' => ['width' => '50%']
				])
					->addText('purpose', [
						'label' => 'Purpose'
					])
				->endRepeater()
    ->setLocation( 'options_page', '==', 'theme-options' );

return $optionsPage;
