<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_25_0012'])) ? $this->_rootref['L_25_0012'] : ((isset($MSG['25_0012'])) ? $MSG['25_0012'] : '{ L_25_0012 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_1083'])) ? $this->_rootref['L_1083'] : ((isset($MSG['1083'])) ? $MSG['1083'] : '{ L_1083 }')); ?></h4>
				<form name="errorlog" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
				<form name="tax_edit" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th><b><?php echo ((isset($this->_rootref['L_1082'])) ? $this->_rootref['L_1082'] : ((isset($MSG['1082'])) ? $MSG['1082'] : '{ L_1082 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1083'])) ? $this->_rootref['L_1083'] : ((isset($MSG['1083'])) ? $MSG['1083'] : '{ L_1083 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1084'])) ? $this->_rootref['L_1084'] : ((isset($MSG['1084'])) ? $MSG['1084'] : '{ L_1084 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1085'])) ? $this->_rootref['L_1085'] : ((isset($MSG['1085'])) ? $MSG['1085'] : '{ L_1085 }')); ?></b></th>
                        </tr>
                        <tr>
                            <td><input type="text" name="tax_name" value="<?php echo (isset($this->_rootref['TAX_NAME'])) ? $this->_rootref['TAX_NAME'] : ''; ?>"></td>
                            <td><input type="text" name="tax_rate" value="<?php echo (isset($this->_rootref['TAX_RATE'])) ? $this->_rootref['TAX_RATE'] : ''; ?>"> %</td>
                            <td>
								<select name="seller_countries[]" multiple>
									<?php echo (isset($this->_rootref['TAX_SELLER'])) ? $this->_rootref['TAX_SELLER'] : ''; ?>
								</select>
							</td>
                            <td>
								<select name="buyer_countries[]" multiple>
									<?php echo (isset($this->_rootref['TAX_BUYER'])) ? $this->_rootref['TAX_BUYER'] : ''; ?>
								</select>
							</td>
                        </tr>
                    </table>
                    <input type="hidden" name="tax_id" value="<?php echo (isset($this->_rootref['TAX_ID'])) ? $this->_rootref['TAX_ID'] : ''; ?>">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>">
				</form>
				<form name="tax_update" action="" method="post">
					<table width="98%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th><b><?php echo ((isset($this->_rootref['L_1082'])) ? $this->_rootref['L_1082'] : ((isset($MSG['1082'])) ? $MSG['1082'] : '{ L_1082 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1083'])) ? $this->_rootref['L_1083'] : ((isset($MSG['1083'])) ? $MSG['1083'] : '{ L_1083 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1084'])) ? $this->_rootref['L_1084'] : ((isset($MSG['1084'])) ? $MSG['1084'] : '{ L_1084 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1085'])) ? $this->_rootref['L_1085'] : ((isset($MSG['1085'])) ? $MSG['1085'] : '{ L_1085 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_1086'])) ? $this->_rootref['L_1086'] : ((isset($MSG['1086'])) ? $MSG['1086'] : '{ L_1086 }')); ?></b></th>
                            <th>&nbsp;</th>
                        </tr>
<?php $_tax_rates_count = (isset($this->_tpldata['tax_rates'])) ? sizeof($this->_tpldata['tax_rates']) : 0;if ($_tax_rates_count) {for ($_tax_rates_i = 0; $_tax_rates_i < $_tax_rates_count; ++$_tax_rates_i){$_tax_rates_val = &$this->_tpldata['tax_rates'][$_tax_rates_i]; ?>
                        <tr>
                            <td><?php echo $_tax_rates_val['TAX_NAME']; ?></td>
                            <td><?php echo $_tax_rates_val['TAX_RATE']; ?>%</td>
                            <td><?php echo $_tax_rates_val['TAX_SELLER']; ?></td>
                            <td><?php echo $_tax_rates_val['TAX_BUYER']; ?></td>
                            <td><input type="radio" name="site_fee" value="<?php echo $_tax_rates_val['ID']; ?>"<?php if ($_tax_rates_val['TAX_SITE_RATE'] == (1)) {  ?> checked="checked"<?php } ?>></td>
                            <td>
								<a href="tax_levels.php?id=<?php echo $_tax_rates_val['ID']; ?>&type=edit"><?php echo ((isset($this->_rootref['L_298'])) ? $this->_rootref['L_298'] : ((isset($MSG['298'])) ? $MSG['298'] : '{ L_298 }')); ?></a><br>
								<a href="tax_levels.php?id=<?php echo $_tax_rates_val['ID']; ?>&type=delete" onClick="return confirm('<?php echo ((isset($this->_rootref['L_1087'])) ? $this->_rootref['L_1087'] : ((isset($MSG['1087'])) ? $MSG['1087'] : '{ L_1087 }')); ?>')"><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></a>
							</td>
                        </tr>
<?php }} ?>
                    </table>
                    <input type="hidden" name="action" value="sitefee">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>