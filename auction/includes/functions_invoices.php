<?php 
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

function getSeller($user_id)
{
	global $system, $DBPrefix;

	$query = "SELECT nick, country FROM " . $DBPrefix . "users WHERE id = " . $user_id;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$result = mysql_fetch_array($result);
	$address_data = array(
		'nick'      => $result['nick'],
		'country'   => $result['country'],
	);
	return $address_data;
}

function getAddressWinner($user_id)
{
	global $system, $DBPrefix;

	$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $user_id;
	$result = mysql_query($query);
	$system->check_mysql($result, $query, __LINE__, __FILE__);
	$result = mysql_fetch_array($result);
	$address_data = array(
		//'user_id'   => $result['id'],
		'nick'      => $result['nick'],
		'name'      => $result['name'],
		'company'   => (isset($result['company'])) ? $result['company'] : '',
		'address'   => $result['address'],
		'city'      => $result['city'],
		'prov'      => $result['prov'],
		'postcode'  => $result['zip'],
		'country'   => $result['country'],
		//'email'     => $result['email'],
	);
	return $address_data;
}

function getTax($is_auction, $buyer_from, $seller_from = '')
{
	global $system, $DBPrefix;

	// build the query
	$query = "SELECT tax_rate FROM " . $DBPrefix . "tax WHERE countries_buyer LIKE '" . $buyer_from . "'";
	$query .= ($is_auction) ? " AND fee_tax = 0" : " AND fee_tax = 1";
	$query .= (!empty($seller_from)) ? " AND countries_seller LIKE '" . $seller_from . "'" : '';
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if (mysql_num_rows($res) == 0)
	{
		$tax_rate = 0;
	}
	else
	{
		$tax_rate = mysql_result($res, 0);
	}

	return $tax_rate;
}

function setfeetemplate($data)
{
	global $template, $system, $MSG;

	$feenames = array(
		'signup' => $MSG['430'],
		'buyer' => $MSG['775'],
		'setup' => $MSG['432'],
		'featured' => $MSG['433'],
		'bold' => $MSG['439'],
		'highlighted' => $MSG['434'],
		'subtitle' => $MSG['803'],
		'extcat' => $MSG['804'],
		'reserve' => $MSG['440'],
		'image' => $MSG['435'],
		'relist' => $MSG['437'],
		'buynow' => $MSG['436'],
		'finalval' => $MSG['791'],
		'balance' => $MSG['935']
		);
	$total = 0;
	$total_exculding = 0;
	foreach ($data as $k => $v)
	{
		if (in_array($k, array('setup', 'featured', 'bold', 'highlighted', 'subtitle', 'relist', 'reserve', 'buynow', 'image', 'extcat', 'signup', 'buyer', 'finalval', 'balance')))
		{
			if ($v > 0)
			{
				$excluding = vatexcluding($v);
				$total += $v;
				$total_exculding += $excluding;
				$template->assign_block_vars('fees', array(
						'FEE' => $feenames[$k],
						'UNIT_PRICE' => $system->print_money($excluding),
						'UNIT_PRICE_WITH_TAX' => $system->print_money($v),
						'TOTAL' => $system->print_money($total_exculding),
						'TOTAL_WITH_TAX' => $system->print_money($total)
						));
			}
		}
	}
	return array($total, $total_exculding);
}

// add vat
function vat($price)
{
	global $system, $vat;
    $price_with_vat = $price + ($vat * ($price / 100));
    $price_with_vat = round($price_with_vat, $system->SETTINGS['moneydecimals']);
    return $price_with_vat;
}

// remove vat
function vatexcluding($gross)
{
	global $system, $vat;
	$multiplier = ($vat + 100) / 100;
	$net = $gross / $multiplier;
	return number_format($net, $system->SETTINGS['moneydecimals']);
}

function invaildinvoice($packingslip = false)
{
	global $template, $system;

	$template->assign_vars(array(
			'LOGO' => $system->SETTINGS['siteurl'] . 'themes/' . $system->SETTINGS['theme'] . '/' . $system->SETTINGS['logo'],
			'LANGUAGE' => $language,
			'SALE_ID' => 0,
			'B_INVOICE' => false
			));

	$file = ($packingslip) ? 'order_packingslip.tpl' : 'order_invoice.tpl';

	$template->set_filenames(array(
			'body' => $file
			));
	$template->display('body');
	exit;
}
?>
