<?php
/**
 * Plugin Groupes d'auteurs 
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('inc/ciag_commun');

function exec_ciag_gerer_gestionnaires_dist()
{
	$id_groupe= intval(_request('id_groupe'));
	
	if (!$id_groupe) {
	  $type = $titre = filtrer_entites(_T('titre_nouveau_groupe'));
	  $row = array();
	} else {
		$row = sql_fetsel("id_groupe,titre", "spip_ciag_grpauteurs", "id_groupe=$id_groupe");
		if ($row) {
			$id_groupe = $row['id_groupe'];
			$type = $row['titre'];
			$titre = typo($type);
		}
	}

	if (($id_groupe AND !$row) OR
		!autoriser('modifier','groupeauteur',$id_groupe)) {
		include_spip('inc/minipres');
		echo minipres();
	} else {

	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page("&laquo; $titre &raquo;", "naviguer", "mots");
	
	echo debut_gauche('', true);	

	echo creer_colonne_droite('', true);
	echo debut_droite('', true);
	
	if (spip_version()>=3)
		$icone_retour = icone_verticale(_T('icone_retour'), generer_url_ecrire("ciag_groupe_auteurs","id_groupe=$id_groupe"), "redacteurs-48.png", "rien.gif",$GLOBALS['spip_lang_left']);
	else
		$icone_retour = icone_inline(_T('icone_retour'), generer_url_ecrire("ciag_groupe_auteurs","id_groupe=$id_groupe"), "redacteurs-48.png", "rien.gif",$GLOBALS['spip_lang_left']);
	
	$contexte = array(
		'icone_retour'=>$icone_retour,
		'titre'=>$type,
		'redirect'=>generer_url_ecrire("ciag_groupe_auteurs","id_groupe=$id_groupe"),
		'new'=> $id_groupe,
		'ci_pagination'=> 1000,
		'ci_debut_auteur' => _request('debut_auteur_col1'),
		'config_fonc'=>''
	);

	echo recuperer_fond("prive/editer/ciag_gerer_gestionnaires", $contexte);

	
	echo '<br /><br /><div style="background-color: #FFFFFF; border: 1px solid #999999; font-size: 11px; font-family: Arial,Sans,sans-serif; margin: 20px 0 10px; position: relative; padding: 10px;">';
	echo http_img_pack("fiche-perso-24.gif", "", " class='cadre-icone'");
	echo '<div>'.typo(_T('ciag:info_gestionnaires')).'</div>'; 
	echo '<div>'.typo(_T('ciag:info2_gestionnaires')).'</div>'; 
	echo '<div>'.typo(_T('ciag:info3_gestionnaires')).'</div>'; 
	if (defined('_DIR_PLUGIN_CIAR'))
		echo '<div>'.typo(_T('ciag:info_ciar_gestionnaires')).'</div>'; 
	echo '<div>'.typo(_T('ciag:info4_gestionnaires')).'</div>'; 
	echo '</div>';
	
	
	echo fin_gauche(),
	fin_page();
	}
}
?>