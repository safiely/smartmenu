<?php defined('BASEPATH') OR exit('No direct script access allowed');

//Renvoi l'URL de base du site, sans protocole ni antislash
function domain_name_human(){
	echo $_SERVER['SERVER_NAME'];
	return;
}