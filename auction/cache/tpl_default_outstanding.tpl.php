<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<table>
<tr>
    <td width="150px"><b><?php echo ((isset($this->_rootref['L_846'])) ? $this->_rootref['L_846'] : ((isset($MSG['846'])) ? $MSG['846'] : '{ L_846 }')); ?>:</b></td>
    <td style="text-align:center; width: 200px;"><?php echo (isset($this->_rootref['USER_BALANCE'])) ? $this->_rootref['USER_BALANCE'] : ''; ?></td>
    <td style="text-align:center; width: 200px;">
    	<form name="" method="post" action="pay.php" id="fees">
<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
        <?php echo (isset($this->_rootref['CURRENCY'])) ? $this->_rootref['CURRENCY'] : ''; ?> <input type="text" name="pfval" value="<?php echo (isset($this->_rootref['PAY_BALANCE'])) ? $this->_rootref['PAY_BALANCE'] : ''; ?>" size="7">&nbsp;<input type="submit" name="<?php echo ((isset($this->_rootref['L_1104'])) ? $this->_rootref['L_1104'] : ((isset($MSG['1104'])) ? $MSG['1104'] : '{ L_1104 }')); ?>" value="<?php echo ((isset($this->_rootref['L_1104'])) ? $this->_rootref['L_1104'] : ((isset($MSG['1104'])) ? $MSG['1104'] : '{ L_1104 }')); ?>" class="pay">
        </form>
    </td>
    <td><a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>invoices.php"><?php echo ((isset($this->_rootref['L_1057'])) ? $this->_rootref['L_1057'] : ((isset($MSG['1057'])) ? $MSG['1057'] : '{ L_1057 }')); ?></a></td>
</tr>
</table>

<table style="width: 100%; border: 0; text-align:center;" cellspacing="1" cellpadding="4">
<tr style="background-color:<?php echo (isset($this->_rootref['TBLHEADERCOLOUR'])) ? $this->_rootref['TBLHEADERCOLOUR'] : ''; ?>">
    <td style="width: 45%; text-align: center;"><?php echo ((isset($this->_rootref['L_018'])) ? $this->_rootref['L_018'] : ((isset($MSG['018'])) ? $MSG['018'] : '{ L_018 }')); ?></td>
    <td style="width: 10%; text-align: center;"><?php echo ((isset($this->_rootref['L_847'])) ? $this->_rootref['L_847'] : ((isset($MSG['847'])) ? $MSG['847'] : '{ L_847 }')); ?></td>
	<td style="width: 10%; text-align: center;"><?php echo ((isset($this->_rootref['L_350_1004'])) ? $this->_rootref['L_350_1004'] : ((isset($MSG['350_1004'])) ? $MSG['350_1004'] : '{ L_350_1004 }')); ?></td>
    <td style="width: 10%; text-align: center;"><?php echo ((isset($this->_rootref['L_319'])) ? $this->_rootref['L_319'] : ((isset($MSG['319'])) ? $MSG['319'] : '{ L_319 }')); ?></td>
    <td style="width: 10%; text-align: center;"><?php echo ((isset($this->_rootref['L_189'])) ? $this->_rootref['L_189'] : ((isset($MSG['189'])) ? $MSG['189'] : '{ L_189 }')); ?></td>
    <td style="text-align: center;">&nbsp;</td>
</tr>
<?php $_to_pay_count = (isset($this->_tpldata['to_pay'])) ? sizeof($this->_tpldata['to_pay']) : 0;if ($_to_pay_count) {for ($_to_pay_i = 0; $_to_pay_i < $_to_pay_count; ++$_to_pay_i){$_to_pay_val = &$this->_tpldata['to_pay'][$_to_pay_i]; ?>
<tr>
    <td style="text-align: center;">
    <?php if ($_to_pay_val['B_NOTITLE']) {  ?>
    	<?php echo ((isset($this->_rootref['L_113'])) ? $this->_rootref['L_113'] : ((isset($MSG['113'])) ? $MSG['113'] : '{ L_113 }')); ?> <?php echo $_to_pay_val['ID']; ?>
    <?php } else { ?>
    	<a href="<?php echo $_to_pay_val['URL']; ?>" target="_blank"><?php echo $_to_pay_val['TITLE']; ?></a>
    <?php } ?>
    </td>
    <td style="text-align: center;"><?php echo $_to_pay_val['BID']; ?></td>
	<td style="text-align: center;"><?php echo $_to_pay_val['QUANTITY']; ?></td>
    <td style="text-align: center;"><?php echo $_to_pay_val['SHIPPING']; ?></td>
	<td style="text-align: center;">
		<?php echo $_to_pay_val['SHIPPING']; ?> X 1 =<br><?php echo $_to_pay_val['SHIPPING']; ?>
		<br><br><b><?php echo ((isset($this->_rootref['L_350_1009'])) ? $this->_rootref['L_350_1009'] : ((isset($MSG['350_1009'])) ? $MSG['350_1009'] : '{ L_350_1009 }')); ?></b><br><?php echo $_to_pay_val['ADDITIONAL_SHIPPING']; ?> X <?php echo $_to_pay_val['ADDITIONAL_SHIPPING_QUANTITYS']; ?> =<br><?php echo $_to_pay_val['ADDITIONAL_SHIPPING_COST']; ?></td> 
		<td style="text-align: center;"><?php echo $_to_pay_val['TOTAL']; ?>
	</td>
    <td style="text-align: center; background-color: #FFFFaa;">
    	<form name="" method="post" action="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>pay.php?a=2" id="fees">
        <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
    	<input type="hidden" name="pfval" value="<?php echo $_to_pay_val['ID']; ?>">
        <input type="submit" name="Pay" value="<?php echo ((isset($this->_rootref['L_756'])) ? $this->_rootref['L_756'] : ((isset($MSG['756'])) ? $MSG['756'] : '{ L_756 }')); ?>" class="pay">
        </form>
    </td>
    <td style="text-align: center; background-color: #FFFFaa;">
    <form name="" method="post" action="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>order_print.php" id="fees" title="Print Invoice" target="_blank">
        <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
    	<input type="hidden" name="pfval" value="<?php echo $_to_pay_val['ID']; ?>">
		<input type="hidden" name="pfwon" value="<?php echo $_to_pay_val['WINID']; ?>">
		<input type="hidden" name="user_id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>">
        <input type="submit" type="button" value="<?php echo ((isset($this->_rootref['L_1058'])) ? $this->_rootref['L_1058'] : ((isset($MSG['1058'])) ? $MSG['1058'] : '{ L_1058 }')); ?>">
        </form>
</td>
</tr>
<?php }} ?>
</table>

<br /><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
    <td align="center">
        <?php echo ((isset($this->_rootref['L_5117'])) ? $this->_rootref['L_5117'] : ((isset($MSG['5117'])) ? $MSG['5117'] : '{ L_5117 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>&nbsp;<?php echo ((isset($this->_rootref['L_5118'])) ? $this->_rootref['L_5118'] : ((isset($MSG['5118'])) ? $MSG['5118'] : '{ L_5118 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGES'])) ? $this->_rootref['PAGES'] : ''; ?>
        <br />
        <?php echo (isset($this->_rootref['PREV'])) ? $this->_rootref['PREV'] : ''; ?>
<?php $_pages_count = (isset($this->_tpldata['pages'])) ? sizeof($this->_tpldata['pages']) : 0;if ($_pages_count) {for ($_pages_i = 0; $_pages_i < $_pages_count; ++$_pages_i){$_pages_val = &$this->_tpldata['pages'][$_pages_i]; ?>
		<?php echo $_pages_val['PAGE']; ?>&nbsp;&nbsp;
<?php }} ?>
        <?php echo (isset($this->_rootref['NEXT'])) ? $this->_rootref['NEXT'] : ''; ?>
    </td>
</tr>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>