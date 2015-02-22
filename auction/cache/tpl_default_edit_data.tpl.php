<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<form name="details" action="" method="post">
<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
<table width="100%" border="0" cellpadding="4" align="center">
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_002'])) ? $this->_rootref['L_002'] : ((isset($MSG['002'])) ? $MSG['002'] : '{ L_002 }')); ?></td>
		<td><i><?php echo (isset($this->_rootref['NAME'])) ? $this->_rootref['NAME'] : ''; ?></i></td>
	</tr>
	<tr>
		<td align="right" valign="top"><?php echo ((isset($this->_rootref['L_003'])) ? $this->_rootref['L_003'] : ((isset($MSG['003'])) ? $MSG['003'] : '{ L_003 }')); ?></td>
		<td valign="top"><i><?php echo (isset($this->_rootref['NICK'])) ? $this->_rootref['NICK'] : ''; ?></i></td>
	</tr>
	<tr>
		<th colspan="2" valign="top" align="center"><?php echo ((isset($this->_rootref['L_617'])) ? $this->_rootref['L_617'] : ((isset($MSG['617'])) ? $MSG['617'] : '{ L_617 }')); ?></td>
	</tr>
	<tr>
		<td valign="top" class="errfont" style="text-align:right !important;"><?php echo ((isset($this->_rootref['L_004'])) ? $this->_rootref['L_004'] : ((isset($MSG['004'])) ? $MSG['004'] : '{ L_004 }')); ?></td>
		<td align="left"><input type="password" name="TPL_password" size=20 maxlength="20"> <?php echo ((isset($this->_rootref['L_050'])) ? $this->_rootref['L_050'] : ((isset($MSG['050'])) ? $MSG['050'] : '{ L_050 }')); ?></td>
	</tr>
	<tr>
		<td valign="top" class="errfont" style="text-align:right !important;"><?php echo ((isset($this->_rootref['L_005'])) ? $this->_rootref['L_005'] : ((isset($MSG['005'])) ? $MSG['005'] : '{ L_005 }')); ?></td>
		<td align="left">
			<input type="password" name="TPL_repeat_password" size=20 maxlength=20 />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_006'])) ? $this->_rootref['L_006'] : ((isset($MSG['006'])) ? $MSG['006'] : '{ L_006 }')); ?></td>
		<td>
			<input type="email" name="TPL_email" size=50 maxlength=50 value="<?php echo (isset($this->_rootref['EMAIL'])) ? $this->_rootref['EMAIL'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_252'])) ? $this->_rootref['L_252'] : ((isset($MSG['252'])) ? $MSG['252'] : '{ L_252 }')); ?></td>
		<td>
			<?php echo (isset($this->_rootref['DATEFORMAT'])) ? $this->_rootref['DATEFORMAT'] : ''; ?> <input type="text" name="TPL_year" size="4" maxlength="4" value="<?php echo (isset($this->_rootref['YEAR'])) ? $this->_rootref['YEAR'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_009'])) ? $this->_rootref['L_009'] : ((isset($MSG['009'])) ? $MSG['009'] : '{ L_009 }')); ?></td>
		<td>
			<input type="text" name="TPL_address" size=40 maxlength=255 value="<?php echo (isset($this->_rootref['ADDRESS'])) ? $this->_rootref['ADDRESS'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_010'])) ? $this->_rootref['L_010'] : ((isset($MSG['010'])) ? $MSG['010'] : '{ L_010 }')); ?></td>
		<td>
			<input type="text" name="TPL_city" size=25 maxlength=25 value="<?php echo (isset($this->_rootref['CITY'])) ? $this->_rootref['CITY'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_011'])) ? $this->_rootref['L_011'] : ((isset($MSG['011'])) ? $MSG['011'] : '{ L_011 }')); ?></td>
		<td>
			<input type="text" name="TPL_prov" size=10 maxlength=10 value="<?php echo (isset($this->_rootref['PROV'])) ? $this->_rootref['PROV'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_014'])) ? $this->_rootref['L_014'] : ((isset($MSG['014'])) ? $MSG['014'] : '{ L_014 }')); ?></td>
		<td>
			<select name="TPL_country">
				<?php echo (isset($this->_rootref['COUNTRYLIST'])) ? $this->_rootref['COUNTRYLIST'] : ''; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_012'])) ? $this->_rootref['L_012'] : ((isset($MSG['012'])) ? $MSG['012'] : '{ L_012 }')); ?></td>
		<td>
			<input type="text" name="TPL_zip" size=8 value="<?php echo (isset($this->_rootref['ZIP'])) ? $this->_rootref['ZIP'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_013'])) ? $this->_rootref['L_013'] : ((isset($MSG['013'])) ? $MSG['013'] : '{ L_013 }')); ?></td>
		<td>
			<input type="text" name="TPL_phone" size=40 maxlength=40 value="<?php echo (isset($this->_rootref['PHONE'])) ? $this->_rootref['PHONE'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_346'])) ? $this->_rootref['L_346'] : ((isset($MSG['346'])) ? $MSG['346'] : '{ L_346 }')); ?></td>
		<td>
			<?php echo (isset($this->_rootref['TIMEZONE'])) ? $this->_rootref['TIMEZONE'] : ''; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right"><?php echo ((isset($this->_rootref['L_352'])) ? $this->_rootref['L_352'] : ((isset($MSG['352'])) ? $MSG['352'] : '{ L_352 }')); ?></td>
		<td>
			<input type="radio" name="TPL_emailtype" value="html" <?php echo (isset($this->_rootref['EMAILTYPE1'])) ? $this->_rootref['EMAILTYPE1'] : ''; ?> />
			<?php echo ((isset($this->_rootref['L_902'])) ? $this->_rootref['L_902'] : ((isset($MSG['902'])) ? $MSG['902'] : '{ L_902 }')); ?>
			<input type="radio" name="TPL_emailtype" value="text" <?php echo (isset($this->_rootref['EMAILTYPE2'])) ? $this->_rootref['EMAILTYPE2'] : ''; ?> />
			<?php echo ((isset($this->_rootref['L_915'])) ? $this->_rootref['L_915'] : ((isset($MSG['915'])) ? $MSG['915'] : '{ L_915 }')); ?>
		</td>
	</tr>
	<tr>
<?php if ($this->_rootref['B_NEWLETTER']) {  ?>
		<td align="right" height="2"><?php echo ((isset($this->_rootref['L_603'])) ? $this->_rootref['L_603'] : ((isset($MSG['603'])) ? $MSG['603'] : '{ L_603 }')); ?><td>
			<input type="radio" name="TPL_nletter" value="1" <?php echo (isset($this->_rootref['NLETTER1'])) ? $this->_rootref['NLETTER1'] : ''; ?> />
			<?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?>
			<input type="radio" name="TPL_nletter" value="2" <?php echo (isset($this->_rootref['NLETTER2'])) ? $this->_rootref['NLETTER2'] : ''; ?> />
			<?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?><br><span class="smallspan"><i><?php echo ((isset($this->_rootref['L_609'])) ? $this->_rootref['L_609'] : ((isset($MSG['609'])) ? $MSG['609'] : '{ L_609 }')); ?></i></span>
		</td>
	</tr>
<?php } ?>
</table>

<div class="padding">
	<h2><?php echo ((isset($this->_rootref['L_719'])) ? $this->_rootref['L_719'] : ((isset($MSG['719'])) ? $MSG['719'] : '{ L_719 }')); ?></h2>
</div>

<table width="100%" border="0" cellpadding="4" align="center">
<?php if ($this->_rootref['B_PAYPAL']) {  ?>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_720'])) ? $this->_rootref['L_720'] : ((isset($MSG['720'])) ? $MSG['720'] : '{ L_720 }')); ?></td>
		<td>
			<input type="text" name="TPL_pp_email" size=40 value="<?php echo (isset($this->_rootref['PP_EMAIL'])) ? $this->_rootref['PP_EMAIL'] : ''; ?>">
		</td>
	</tr>
<?php } if ($this->_rootref['B_AUTHNET']) {  ?>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_773'])) ? $this->_rootref['L_773'] : ((isset($MSG['773'])) ? $MSG['773'] : '{ L_773 }')); ?></td>
		<td>
			<input type="text" name="TPL_authnet_id" size=40 value="<?php echo (isset($this->_rootref['AN_ID'])) ? $this->_rootref['AN_ID'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_774'])) ? $this->_rootref['L_774'] : ((isset($MSG['774'])) ? $MSG['774'] : '{ L_774 }')); ?></td>
		<td>
			<input type="text" name="TPL_authnet_pass" size=40 value="<?php echo (isset($this->_rootref['AN_PASS'])) ? $this->_rootref['AN_PASS'] : ''; ?>">
		</td>
	</tr>
<?php } if ($this->_rootref['B_WORLDPAY']) {  ?>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_824'])) ? $this->_rootref['L_824'] : ((isset($MSG['824'])) ? $MSG['824'] : '{ L_824 }')); ?></td>
		<td>
			<input type="text" name="TPL_worldpay_id" size=40 value="<?php echo (isset($this->_rootref['WP_ID'])) ? $this->_rootref['WP_ID'] : ''; ?>">
		</td>
	</tr>
<?php } if ($this->_rootref['B_TOOCHECKOUT']) {  ?>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_826'])) ? $this->_rootref['L_826'] : ((isset($MSG['826'])) ? $MSG['826'] : '{ L_826 }')); ?></td>
		<td>
			<input type="text" name="TPL_toocheckout_id" size=40 value="<?php echo (isset($this->_rootref['TC_ID'])) ? $this->_rootref['TC_ID'] : ''; ?>">
		</td>
	</tr>
<?php } if ($this->_rootref['B_MONEYBOOKERS']) {  ?>
	<tr>
		<td align="right" width="30%"><?php echo ((isset($this->_rootref['L_825'])) ? $this->_rootref['L_825'] : ((isset($MSG['825'])) ? $MSG['825'] : '{ L_825 }')); ?></td>
		<td>
			<input type="text" name="TPL_moneybookers_email" size=40 value="<?php echo (isset($this->_rootref['MB_EMAIL'])) ? $this->_rootref['MB_EMAIL'] : ''; ?>">
		</td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2 align="center">
			<input type="submit" name="Input" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>" class="button">
			<input type="reset" name="Input" class="button">
		</td>
	</tr>
</table>
<input type="hidden" name="action" value="update">
</form>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>