<?php

require 'config.php';
dol_include_once('/citrusmanager2/class/citrus2.class.php');
dol_include_once('/citrusmanager2/class/citruscategory.class.php');

if(empty($user->rights->citrusmanager2->read)) accessforbidden();

$langs->load('abricot@abricot');
$langs->load('citrusmanager2@citrusmanager2');


$massaction =        GETPOST('massaction',        'alpha');
$confirmmassaction = GETPOST('confirmmassaction', 'alpha');
$toselect =          GETPOST('toselect',          'array');

$object = new Citrus2($db);

$hookmanager->initHooks(array('citrusmanager2list'));

/*
 * Actions
 */

$parameters=array();
$reshook=$hookmanager->executeHooks('doActions',$parameters,$object);    // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (!GETPOST('confirmmassaction', 'alpha') && $massaction != 'presend' && $massaction != 'confirm_presend')
{
    $massaction = '';
}


if (empty($reshook))
{
	// do action from GETPOST ... 
}

/*
 * View
 */

$category = new CitrusCategory($db);

llxHeader('',$langs->trans('CitrusManager2List'),'','');

// TODO ajouter les champs de son objet que l'on souhaite afficher
$sql = 'SELECT
        citrus.rowid,
        citrus.ref,
        citrus.label AS citrus_label,
        category.label AS category_label,
        category.code AS category_code,
        citrus.date_creation,
        citrus.tms,
        citrus.price,
        \'\' AS action';

$sql .= ' FROM '.MAIN_DB_PREFIX.'citrus2 citrus';

$sql .= ' LEFT JOIN ' . MAIN_DB_PREFIX.'c_citrusmanager2_category AS category ON (citrus.fk_category = category.rowid)';

$sql .= ' LEFT JOIN ' . MAIN_DB_PREFIX.'product AS product ON (citrus.fk_product = product.rowid)';

$sql .= ' WHERE 1=1';
//$sql.= ' AND t.entity IN ('.getEntity('CitrusManager2', 1).')';

$formcore = new TFormCore($_SERVER['PHP_SELF'], 'form_list_citrusmanager2', 'GET');

$nbLine = !empty($user->conf->MAIN_SIZE_LISTE_LIMIT) ? $user->conf->MAIN_SIZE_LISTE_LIMIT : $conf->global->MAIN_SIZE_LISTE_LIMIT;

$r = new Listview($db, 'Citrus');
echo $r->render($sql, array(
	'view_type' => 'list' // default = [list], [raw], [chart]
    ,'allow-fields-select' => true
	,'limit'=>array(
		'nbLine' => $nbLine
	)
	,'subQuery' => array()
	,'link' => array()
	,'type' => array(
		'date_creation' => 'date' // [datetime], [hour], [money], [number], [integer]
		,'tms' => 'datetime'
        ,'date_creation' => 'datetime'
        ,'price' => 'money'
	)
	,'translate' => array()
	,'hide' => array(
		'rowid' // important : rowid doit exister dans la query sql pour les checkbox de massaction
	)
    ,'operator' => array(
        'price' => '>='
    )
	,'list' => array(
		'title' => $langs->trans('CitrusManager2List')
		,'image' => 'title_generic.png'
		,'picto_precedent' => '<'
		,'picto_suivant' => '>'
		,'noheader' => 0
		,'messageNothing' => $langs->trans('NoCitrusManager2')
		,'picto_search' => img_picto('','search.png', '', 0)
        ,'massactions'=>array(
            'yourmassactioncode'  => $langs->trans('YourMassActionLabel')
        )
	)
    ,'search' => array(
        'date_creation' => array('search_type' => 'calendars', 'allow_is_null' => true, 'table' => 'citrus', 'field' => 'date_creation')
        ,'tms' => array('search_type' => 'calendars', 'allow_is_null' => false)
        ,'ref' => array('search_type' => true, 'table' => 'citrus', 'field' => 'ref')
        ,'citrus_label' => array('search_type' => true, 'table' => 'citrus', 'field' => 'label')
        ,'category_label' => array('search_type' => $category->fetchOptionsForSelect(), 'table' => 'category', 'field' => 'rowid')
        ,'price' => array('search_type' => true, 'table' => array('citrus', 'citrus'), 'field' => array('price'))
    )
	,'title'=>array(
		'ref' => $langs->trans('Ref.')
		,'citrus_label' => $langs->trans('Label')
        ,'category_label' => $langs->trans('Category')
        ,'price' => $langs->trans('Price')
		,'date_creation' => $langs->trans('DateCre')
		,'tms' => $langs->trans('DateMaj')
        ,'selectedfields' => '' // For massaction checkbox
	)
	,'eval'=>array(
		'ref' => '_getObjectNomUrl(\'@val@\')'
//		,'fk_user' => '_getUserNomUrl(@val@)' // Si on a un fk_user dans notre requête
	)
));

$js_for_UX_improvement = '<script>';
$js_for_UX_improvement .= <<<js
$(document).ready(function() {
    // turn the citrus category filter into a select2
    let categoryFilter = $('#Listview_Citrus_search_category_label');
    categoryFilter.select2();

    // make it submit the form when the user makes their choice
    categoryFilter.change(function() {
        this.form.submit();
    });
});
js;
$js_for_UX_improvement .= '</script>';
echo $js_for_UX_improvement;


$parameters=array('sql'=>$sql);
$reshook=$hookmanager->executeHooks('printFieldListFooter', $parameters, $object);    // Note that $action and $object may have been modified by hook
print $hookmanager->resPrint;

$formcore->end_form();

llxFooter('');

/**
 * TODO remove if unused
 */
function _getObjectNomUrl($ref)
{
	global $db;

	$o = new Citrus2($db);
	$res = $o->load('', $ref);
	if ($res > 0)
	{
		return $o->getNomUrl(1);
	}

	return '';
}
/**
 * TODO remove if unused
 */
/*
function _getUserNomUrl($fk_user)
{
	global $db;

	$u = new User($db);
	if ($u->fetch($fk_user) > 0)
	{
		return $u->getNomUrl(1);
	}

	return '';
}
*/