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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include $include_path . 'functions_admin.php';
include $include_path . 'dates.inc.php';
include 'loggedin.inc.php';
include $include_path . 'membertypes.inc.php';

foreach ($membertypes as $idm => $memtypearr)
{
	$memtypesarr[$memtypearr['feedbacks']] = $memtypearr;
}
ksort($memtypesarr, SORT_NUMERIC);

$secid = intval($_GET['id']);
$query = "SELECT nick, rate_sum, rate_num FROM " . $DBPrefix . "users WHERE id = " . $secid;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bg = '';

if (mysql_num_rows($res) > 0)
{
	$arr = mysql_fetch_array($res);
	$num_fbs = $arr['rate_num'];
	// get page limits
	if (!isset($_GET['PAGE']) || $_GET['PAGE'] == '')
	{
		$OFFSET = 0;
		$PAGE = 1;
	}
	else
	{
		$PAGE = intval($_GET['PAGE']);
		$OFFSET = ($PAGE - 1) * $system->SETTINGS['perpage'];
	}
	$PAGES = ($num_fbs == 0) ? 1 : ceil($num_fbs / $system->SETTINGS['perpage']);

	$i = 0;
	foreach ($memtypesarr as $k => $l)
	{
		if ($k >= $arr['rate_sum'] || $i++ == (count($memtypesarr)-1))
		{
			$feedback_image = '<img src="' . $system->SETTINGS['siteurl'] . '/images/icons/' . $l['icon'] . '" class="fbstar">';
			break;
		}
	}

	$query = "SELECT * FROM " . $DBPrefix . "feedbacks WHERE rated_user_id = " . $secid . " ORDER by feedbackdate DESC";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	while ($arrfeed = mysql_fetch_array($res))
	{
		switch($arrfeed['rate'])
		{
			case 1:
				$fb_type = 'positive';
				break;
			case -1:
				$fb_type = 'negative';
				break;
			case 0:
				$fb_type = 'neutral';
				break;
		}

		$template->assign_block_vars('feedback', array(
				'FB_TYPE' => $fb_type,
				'FB_FROM' => $arrfeed['rater_user_nick'],
				'FB_TIME' => FormatDate($arrfeed['feedbackdate'], '/', false),
				'FB_MSG' => nl2br($arrfeed['feedback']),
				'FB_ID' => $arrfeed['id'],
				'BG' => $bg
				));
		$bg = ($bg == '') ? 'class="bg"' : '';
	}
}
else
{
	$ERR = $ERR_105;
}

$PREV = intval($PAGE - 1);
$NEXT = intval($PAGE + 1);
if ($PAGES > 1)
{
	$LOW = $PAGE - 5;
	if ($LOW <= 0) $LOW = 1;
	$COUNTER = $LOW;
	while ($COUNTER <= $PAGES && $COUNTER < ($PAGE + 6))
	{
		$template->assign_block_vars('pages', array(
				'PAGE' => ($PAGE == $COUNTER) ? '<b>' . $COUNTER . '</b>' : '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $COUNTER . '"><u>' . $COUNTER . '</u></a>'
				));
		$COUNTER++;
	}
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $secid,
		'NICK' => $arr['nick'],
		'FB_NUM' => $arr['rate_num'],
		'FB_IMG' => $feedback_image,

		'PREV' => ($PAGES > 1 && $PAGE > 1) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $PREV . '"><u>' . $MSG['5119'] . '</u></a>&nbsp;&nbsp;' : '',
		'NEXT' => ($PAGE < $PAGES) ? '<a href="' . $system->SETTINGS['siteurl'] . 'admin/userfeedback.php?PAGE=' . $NEXT . '"><u>' . $MSG['5120'] . '</u></a>' : '',
		'PAGE' => $PAGE,
		'PAGES' => $PAGES
		));

$template->set_filenames(array(
		'body' => 'userfeedback.tpl'
		));
$template->display('body');
?>
