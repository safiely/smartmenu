<?php

defined('BASEPATH') or exit('No direct script access allowed');


//IMPORTANT : Le nom de l'entrée correspond à la classe/méthode qui va checker le form


$config = array(


/*
 *
 *LOGIN
 *
 */

'home/registration_check_form' => array( 
		array( 
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email|is_unique[subscribers.email]'
		),
		array( 
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|regex_match[/^[0-9a-zA-Z]{6,12}$/]'
		),
		array( 
			'field' => 'passwordConfirm',
			'label' => 'lang:passwordConfirm',
			'rules' => 'trim|required|matches[password]'
		)
	),
	

	'home/login_check_form' => array( 
		array( 
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email'
		),
		array( 
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required'
		)
	),
	
	'home/forgotten_password_check_form' => array( 
		array( 
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email'
		),
		array( 
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'trim|required|regex_match[/^[0-9a-zA-Z]{6,12}$/]'
		),
		array( 
			'field' => 'passwordConfirm',
			'label' => 'lang:passwordConfirm',
			'rules' => 'trim|required|matches[password]'
		)
	),
	'home/contact_check_form' => array( 
		array( 
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email'
		),
		array( 
			'field' => 'subject',
			'label' => 'Sujet',
			'rules' => 'trim|required|max_length[128]'
		),
		array( 
			'field' => 'message',
			'label' => 'Message',
			'rules' => 'trim|required|max_length[1000]'
		)
	),



/*
 *
 * MANAGER INFORMATIONS
 *
 */



'manager/establishment_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'url',
			'label' => '"Adresse web d\'accès"',
			'rules' => array( 
				'trim',
				'required',
				'max_length[64]',
				'regex_match[/^[0-9a-zA-Z-_]{1,64}$/]',
				array( 
					'forbidden_urls',
					function ($str){
						$forbidden_urls = array( 
							'dispatch',
							'home',
							'manager',
							'user',
							'assets',
							'system',
							'uploads'
						);
						return !in_array(strtolower($str), $forbidden_urls);
					}
				)
			)
		)
		,
		array( 
			'field' => 'adress',
			'label' => 'Adresse',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'postal_code',
			'label' => 'Code postal',
			'rules' => 'trim|required|max_length[5]|regex_match[/^([0-9]{5})$/]'
		),
		array( 
			'field' => 'city',
			'label' => 'Ville',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'phone',
			'label' => 'Téléphone',
			'rules' => 'trim|max_length[10]|regex_match[/^([0-9]{10})$/]'
		),
		array( 
			'field' => 'web_site',
			'label' => 'Site web',
			'rules' => 'trim|max_length[128]|valid_url'
		)
	),
	

	'manager/mod_social_check_form' => array( 
		array( 
			'field' => 'facebook',
			'label' => 'Facebook',
			'rules' => 'trim|max_length[256]|integer'
		),
		array( 
			'field' => 'twitter',
			'label' => 'Twitter',
			'rules' => 'trim|max_length[256]|valid_url'
		),
		array( 
			'field' => 'instagram',
			'label' => 'Instagram',
			'rules' => 'trim|max_length[256]|valid_url'
		)
	),







/*
 *
 * MANAGER CATEGORIES
 *
 */


'manager/add_category_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'trim|max_length[254]'
		)
	),
	
	'manager/edit_category_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'trim|max_length[254]'
		)
	),

/*
 *
 *CATEGORIES PRICES
 *
 */

'manager/add_prices_category_check_form' => array( 
		array( 
			'field' => 'prices_category_name',
			'label' => 'Nom de la quantité',
			'rules' => 'trim|required|max_length[64]'
		)
	),






/*
 *
 *MANAGER PRODUCTS
 *
 */

'manager/add_product_check_form' => array( 
		array( 
			'field' => 'category',
			'label' => 'Catégorie',
			'rules' => 'required|is_natural_no_zero'
		),
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[128]'
		),
		array( 
			'field' => 'composition',
			'label' => 'Description',
			'rules' => 'trim|max_length[256]'
		),
		array( 
			'field' => 'price',
			'label' => 'Prix',
			'rules' => 'trim|regex_match[/^(\d+(?:[\.,][\d]{1,2})?)$/]'
		) // Ok pour validation avec toujours une virgule : [/^[0-9]{1,4}[,][0-9]{1,2}$/]

	),
	'manager/edit_product_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[128]'
		),
		array( 
			'field' => 'composition',
			'label' => 'Description',
			'rules' => 'trim|max_length[256]'
		),
		array( 
			'field' => 'price',
			'label' => 'Prix',
			'rules' => 'trim|regex_match[/^(\d+(?:[\.,][\d]{1,2})?)$/]'
		) // Ok pour validation avec toujours une virgule : [/^[0-9]{1,4}[,][0-9]{1,2}$/]

	),

/*
 *CONTACT
 */
'manager/contact_check_form' => array( 
		array( 
			'field' => 'subject',
			'label' => 'Sujet',
			'rules' => 'trim|required|max_length[128]'
		),
		array( 
			'field' => 'message',
			'label' => 'Message',
			'rules' => 'trim|required|max_length[1000]'
		)
	),



/*
 *MANAGER / MENUS
 */
/*
 *
 * MANAGER CATEGORIES
 *
 */


'manager/add_menu_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'price',
			'label' => 'Prix',
			'rules' => 'trim|required|regex_match[/^(\d+(?:[\.,][\d]{1,2})?)$/]'
		),
		array( 
			'field' => 'note',
			'label' => 'information',
			'rules' => 'trim|max_length[256]'
		)
	),
	

	'manager/edit_menu_check_form' => array( 
		array( 
			'field' => 'name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'price',
			'label' => 'Prix',
			'rules' => 'trim|required|regex_match[/^(\d+(?:[\.,][\d]{1,2})?)$/]'
		),
		array( 
			'field' => 'note',
			'label' => 'information',
			'rules' => 'trim|max_length[256]'
		)
	),
	
	'manager/add_composition' => array( 
		array( 
			'field' => 'composition_name',
			'label' => 'Nom',
			'rules' => 'trim|required|max_length[64]'
		)
	),
	
	'manager/edit_composition_check_form' => array( 
		array( 
			'field' => 'composition_name',
			'label' => 'Nom de la section',
			'rules' => 'trim|required|max_length[64]'
		),
		array( 
			'field' => 'composition_note',
			'label' => 'Information complémentaire',
			'rules' => 'trim|max_length[256]'
		)
	)
)

;