<?php

$content = '';
$buttons = '';


// Einstellungen speichern
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
		['cartMaxItem', 'int'],
		['itemMaxQuantity', 'int'],
		['useCookie', 'string']
    ]));
	
    echo rex_view::success($this->i18n('mf_cart_save_success'));
}	
	
	
	
	$content .= '<fieldset><legend>'.$this->i18n('mf_cart_cart_settings').'</legend>';
	
	$cartMaxItem = 0;
	if($this->getConfig('cartMaxItem')) {
		$cartMaxItem = $this->getConfig('cartMaxItem');
		}

	$formElements = [];
	$n = [];
	$n['label'] = '<label for="mf_cart-cartMaxItem">'.$this->i18n('mf_cart_max_items_label').'</label>';
	$n['field'] = '<input class="form-control" type="text" id="mf_cart-cartMaxItem" name="config[cartMaxItem]" value="' . $cartMaxItem . '"/>
	<p class="help-block rex-note">'.$this->i18n('mf_cart_max_items_desc').'</p>';
	$formElements[] = $n;
	
	$fragment = new rex_fragment();
	$fragment->setVar('elements', $formElements, false);
	$content .= $fragment->parse('core/form/container.php');
	
	
	$itemMaxQuantity = 0;
	if($this->getConfig('itemMaxQuantity')) {
		$itemMaxQuantity = $this->getConfig('itemMaxQuantity');
		}
		
	$formElements = [];
	$n = [];
	$n['label'] = '<label for="mf_cart-itemMaxQuantity">'.$this->i18n('mf_cart_item_max_qty_label').'</label>';
	$n['field'] = '<input class="form-control" type="text" id="mf_cart-itemMaxQuantity" name="config[itemMaxQuantity]" value="' . $itemMaxQuantity . '"/>
	<p class="help-block rex-note">'.$this->i18n('mf_cart_item_max_qty_desc').'</p>';
	$formElements[] = $n;
	
	$fragment = new rex_fragment();
	$fragment->setVar('elements', $formElements, false);
	$content .= $fragment->parse('core/form/container.php');
	
	
	$checked = '';
	if($this->getConfig('useCookie') == 1) {
		$checked = 'checked';
		}
		
	$formElements = [];
	$n = [];
	$n['label'] = '<label for="mf_cart-useCookie">'.$this->i18n('mf_cart_use_cookie_label').'</label>';
	$n['field'] = '<input type="checkbox" id="mf_cart-useCookie" name="config[useCookie]" value="true" '.$checked.'/>
	<p class="help-block rex-note">'.$this->i18n('mf_cart_use_cookie_desc').'</p>';
	$formElements[] = $n;
	
	$fragment = new rex_fragment();
	$fragment->setVar('elements', $formElements, false);
	$content .= $fragment->parse('core/form/container.php');
	
	
	
	$content .= '</fieldset>';


// Save-Button
$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="Speichern">'.$this->i18n('mf_cart_btn_save').'</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">
    ' . $buttons . '
</fieldset>
';

// Ausgabe Formular
$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('mf_cart_cart_settings'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post">
<input type="hidden" name="formsubmit" value="1" />
    ' . $output . '
</form>
';

echo $output;	
?>
