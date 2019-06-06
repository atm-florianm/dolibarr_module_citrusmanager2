<?php

require 'config.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
dol_include_once('/citrusmanager2/class/citrus2.class.php');
dol_include_once('/citrusmanager2/class/citruscategory.class.php');
dol_include_once('/citrusmanager2/lib/citrusmanager2.lib.php');

if(empty($user->rights->citrusmanager2->read)) accessforbidden();

$langs->load('citrusmanager2@citrusmanager2');

$action = GETPOST('action');
$id = GETPOST('id', 'int');
$ref = GETPOST('ref');

$mode = 'view';
if (empty($user->rights->citrusmanager2->write)) $mode = 'view'; // Force 'view' mode if can't edit object
else if ($action == 'create' || $action == 'edit') $mode = 'edit';

$object = new Citrus2($db);
$citrusCategory = new CitrusCategory($db);

if (!empty($id)) $object->load($id, '');
elseif (!empty($ref)) $object->loadBy($ref, 'ref');

$product = NULL;
if ($object->fk_product > 0) {
    $product = new Product($db);
    $product->fetch($object->fk_product);
    if ($product->id <= 0) {
        setEventMessages('The product linked with this citrus could not be loaded.', array(), 'errors');
    }
}

$hookmanager->initHooks(array('citrusmanager2card', 'globalcard'));

/*
 * Actions
 */

$parameters = array('id' => $id, 'ref' => $ref, 'mode' => $mode);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

// Si vide alors le comportement n'est pas remplacé
if (empty($reshook))
{
	$error = 0;
	switch ($action) {
        case 'save':
		    // TODO: check whether $object->setValues($_REQUEST) meets security standards
			$object->setValues($_REQUEST); // Set standard attributes
            if ($object->fk_category) {
                $citrusCategory->fetch($object->fk_category);
            }
            $object->price = ($object->price ?: $citrusCategory->default_price) ?: $conf->global->CITRUSMANAGER2_DEFAULT_PRICE;

			if ($error > 0)
			{
				$mode = 'edit';
				break;
			}
			
			$object->save();

			header('Location: '.dol_buildpath('/citrusmanager2/card.php', 1).'?id='.$object->id);
			exit;
			
			break;
        case 'create_from_product':
            $fk_product = GETPOST('fk_product');
            $product = new Product($db);
            $product->fetch($fk_product);
            if ($product->id <= 0) {
                setEventMessages('The product linked with this citrus could not be loaded.', array(), 'errors');
            }
            foreach (array('ref', 'label', 'price') as $field) {
                $object->$field = $product->$field;
            }
            $object->fk_product = $fk_product;
            $mode = 'edit';
            break;
		case 'confirm_delete':
			if (!empty($user->rights->citrusmanager2->write)) $object->delete($user);
			
			header('Location: '.dol_buildpath('/citrusmanager2/list.php', 1));
			exit;
			break;
	}
}

/**
 * View
 */

$title=$langs->trans("CitrusManager2");
llxHeader('',$title);

if ($action == 'create' && $mode == 'edit')
{
	load_fiche_titre($langs->trans("NewCitrusManager2"));
	dol_fiche_head();
}
else
{
	$head = citrusmanager2_prepare_head($object);
	$picto = 'generic';
	dol_fiche_head($head, 'card', $langs->trans("CitrusManager2"), 0, $picto);
}

$formcore = new TFormCore;
$formcore->Set_typeaff($mode);

$form = new Form($db);

$formconfirm = getFormConfirmCitrusManager2($PDOdb, $form, $object, $action);
if (!empty($formconfirm)) echo $formconfirm;

$TBS=new TTemplateTBS();
$TBS->TBS->protect=false;
$TBS->TBS->noerr=true;

if ($mode == 'edit') echo $formcore->begin_form($_SERVER['PHP_SELF'], 'form_citrusmanager2');

$linkback = '<a href="'.dol_buildpath('/citrusmanager2/list.php', 1).'">' . $langs->trans("BackToList") . '</a>';

print $TBS->render('tpl/card.tpl.php'
	,array() // Block
	,array(
		'object'=>$object
		,'view' => array(
			'mode' => $mode
			,'action' => 'save'
			,'urlcard' => dol_buildpath('/citrusmanager2/card.php', 1)
			,'urllist' => dol_buildpath('/citrusmanager2/list.php', 1)
            ,'fk_product' => $object->fk_product
            ,'productURL' => $product ? dol_buildpath('product/card.php', 1) . '?id=' . $object->fk_product : ''
            ,'productRefValue' => $product ? $product->ref : ''
			,'showRef'   => $formcore->texte('', 'ref',   $object->ref,  80, 255, 'required')
			,'showLabel' => $formcore->texte('', 'label', $object->label, 80, 255, 'required')
            ,'showPrice' => $formcore->texte('', 'price', $object->price, 80, 255)
            ,'showCategory' => $formcore->combo_sexy(
                '',
                'fk_category',
                array(0 => $langs->trans('NoCategory')) + $citrusCategory->fetchOptionsForSelect(),
                $object->fk_category
            )
            ,'refTooltip' => $form->textwithpicto('', $langs->trans('refTooltip'))
            ,'labelTooltip' => $form->textwithpicto('', $langs->trans('labelTooltip'))
            ,'priceTooltip' => $form->textwithpicto('', $langs->trans('priceTooltip'))
            ,'categoryTooltip' => $form->textwithpicto('', $langs->trans('categoryTooltip'))
		)
		,'langs' => $langs
		,'user' => $user
		,'conf' => $conf
	)
);

if ($mode == 'edit') echo $formcore->end_form();

if ($mode == 'view' && $object->id) $somethingshown = $form->showLinkedObjectBlock($object);

llxFooter();
$db->close();
