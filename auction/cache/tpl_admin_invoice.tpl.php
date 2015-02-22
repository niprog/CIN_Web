<?php $this->_tpl_include('header.tpl'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>inc/calendar.css">
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_854'])) ? $this->_rootref['L_854'] : ((isset($MSG['854'])) ? $MSG['854'] : '{ L_854 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_854'])) ? $this->_rootref['L_854'] : ((isset($MSG['854'])) ? $MSG['854'] : '{ L_854 }')); ?></h4>
				<div class="plain-box">
                	<form action="" method="get">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                	<table cellpadding="0" cellspacing="0" width="100%" class="blank">
                    <tr>
                    	<td><?php echo ((isset($this->_rootref['L_313'])) ? $this->_rootref['L_313'] : ((isset($MSG['313'])) ? $MSG['313'] : '{ L_313 }')); ?></td>
                    	<td>
                        	<input type="text" name="username" value="<?php echo (isset($this->_rootref['USER_SEARCH'])) ? $this->_rootref['USER_SEARCH'] : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo ((isset($this->_rootref['L_856'])) ? $this->_rootref['L_856'] : ((isset($MSG['856'])) ? $MSG['856'] : '{ L_856 }')); ?></td>
                    	<td>
                        <input type="text" name="from_date" id="from_date" value="<?php echo (isset($this->_rootref['FROM_DATE'])) ? $this->_rootref['FROM_DATE'] : ''; ?>" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'from_date','controlname': 'from_date'});
						</script>
                        -
                        <input type="text" name="to_date" id="to_date" value="<?php echo (isset($this->_rootref['TO_DATE'])) ? $this->_rootref['TO_DATE'] : ''; ?>" size="20" maxlength="19">
                        <script type="text/javascript">
							new tcal ({'id': 'to_date','controlname': 'to_date'});
						</script>
                        </td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td>
                        	<input type="submit" name="act" value="<?php echo ((isset($this->_rootref['L_275'])) ? $this->_rootref['L_275'] : ((isset($MSG['275'])) ? $MSG['275'] : '{ L_275 }')); ?>">
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <table width="98%" cellpadding="0" cellspacing="0">
                <tr style="background-color:<?php echo (isset($this->_rootref['TBLHEADERCOLOUR'])) ? $this->_rootref['TBLHEADERCOLOUR'] : ''; ?>">
					<th align="center"><?php echo ((isset($this->_rootref['L_1041'])) ? $this->_rootref['L_1041'] : ((isset($MSG['1041'])) ? $MSG['1041'] : '{ L_1041 }')); ?></th>
<?php if ($this->_rootref['NO_USER_SEARCH']) {  ?>
					<th align="center"><?php echo ((isset($this->_rootref['L_313'])) ? $this->_rootref['L_313'] : ((isset($MSG['313'])) ? $MSG['313'] : '{ L_313 }')); ?></th>
<?php } ?>
					<th><?php echo ((isset($this->_rootref['L_1039'])) ? $this->_rootref['L_1039'] : ((isset($MSG['1039'])) ? $MSG['1039'] : '{ L_1039 }')); ?></th>
					<th align="center"><?php echo ((isset($this->_rootref['L_1053'])) ? $this->_rootref['L_1053'] : ((isset($MSG['1053'])) ? $MSG['1053'] : '{ L_1053 }')); ?></th>
					<th align="center"><?php echo ((isset($this->_rootref['L_560'])) ? $this->_rootref['L_560'] : ((isset($MSG['560'])) ? $MSG['560'] : '{ L_560 }')); ?></th>
				</tr>
<?php $_invoices_count = (isset($this->_tpldata['invoices'])) ? sizeof($this->_tpldata['invoices']) : 0;if ($_invoices_count) {for ($_invoices_i = 0; $_invoices_i < $_invoices_count; ++$_invoices_i){$_invoices_val = &$this->_tpldata['invoices'][$_invoices_i]; ?>
				<tr>
					<td align="center">
						<span class="titleText125"><?php echo ((isset($this->_rootref['L_1041'])) ? $this->_rootref['L_1041'] : ((isset($MSG['1041'])) ? $MSG['1041'] : '{ L_1041 }')); ?>: <?php echo $_invoices_val['INVOICE']; ?></span>
						<p class="smallspan"><?php echo $_invoices_val['DATE']; ?></p>
					</td>
	<?php if ($this->_rootref['NO_USER_SEARCH']) {  ?>
					<td align="center"><?php echo $_invoices_val['USER']; ?></td>
	<?php } ?>
					<td><?php echo $_invoices_val['INFO']; ?></td>
					<td align="center"><?php echo $_invoices_val['TOTAL']; ?></td>
					<td align="center">
						<?php if ($_invoices_val['PAID']) {  ?><p><?php echo ((isset($this->_rootref['L_898'])) ? $this->_rootref['L_898'] : ((isset($MSG['898'])) ? $MSG['898'] : '{ L_898 }')); ?></p><?php } ?><a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>order_print.php?id=<?php echo $_invoices_val['INVOICE']; ?>" tagret="_blank"><?php echo ((isset($this->_rootref['L_1058'])) ? $this->_rootref['L_1058'] : ((isset($MSG['1058'])) ? $MSG['1058'] : '{ L_1058 }')); ?></a>
					</td>
				</tr>
<?php }} ?>
                </table>
<?php if ($this->_rootref['PAGNATION']) {  ?>
                <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td align="center">
                            <?php echo ((isset($this->_rootref['L_5117'])) ? $this->_rootref['L_5117'] : ((isset($MSG['5117'])) ? $MSG['5117'] : '{ L_5117 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>&nbsp;<?php echo ((isset($this->_rootref['L_5118'])) ? $this->_rootref['L_5118'] : ((isset($MSG['5118'])) ? $MSG['5118'] : '{ L_5118 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGES'])) ? $this->_rootref['PAGES'] : ''; ?>
                            <br>
                            <?php echo (isset($this->_rootref['PREV'])) ? $this->_rootref['PREV'] : ''; ?>
	<?php $_pages_count = (isset($this->_tpldata['pages'])) ? sizeof($this->_tpldata['pages']) : 0;if ($_pages_count) {for ($_pages_i = 0; $_pages_i < $_pages_count; ++$_pages_i){$_pages_val = &$this->_tpldata['pages'][$_pages_i]; ?>
                            <?php echo $_pages_val['PAGE']; ?>&nbsp;&nbsp;
	<?php }} ?>
                            <?php echo (isset($this->_rootref['NEXT'])) ? $this->_rootref['NEXT'] : ''; ?>
                        </td>
                    </tr>
				</table>
<?php } ?>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>