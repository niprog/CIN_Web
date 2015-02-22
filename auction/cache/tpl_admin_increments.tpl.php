<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_5142'])) ? $this->_rootref['L_5142'] : ((isset($MSG['5142'])) ? $MSG['5142'] : '{ L_5142 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_128'])) ? $this->_rootref['L_128'] : ((isset($MSG['128'])) ? $MSG['128'] : '{ L_128 }')); ?></h4>
				<form name="increments" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
					<div class="plain-box">
                    	<?php echo ((isset($this->_rootref['L_135'])) ? $this->_rootref['L_135'] : ((isset($MSG['135'])) ? $MSG['135'] : '{ L_135 }')); ?>
                        <p>[&nbsp;<a href="javascript:window_open('<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>converter.php','incre',650,250,30,30);"><?php echo ((isset($this->_rootref['L_5010'])) ? $this->_rootref['L_5010'] : ((isset($MSG['5010'])) ? $MSG['5010'] : '{ L_5010 }')); ?></a>&nbsp;]</p>
                    </div>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b><?php echo ((isset($this->_rootref['L_240'])) ? $this->_rootref['L_240'] : ((isset($MSG['240'])) ? $MSG['240'] : '{ L_240 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_241'])) ? $this->_rootref['L_241'] : ((isset($MSG['241'])) ? $MSG['241'] : '{ L_241 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_137'])) ? $this->_rootref['L_137'] : ((isset($MSG['137'])) ? $MSG['137'] : '{ L_137 }')); ?></b></th>
                            <th width="10%"><b><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></b></th>
                        </tr>
<?php $_increments_count = (isset($this->_tpldata['increments'])) ? sizeof($this->_tpldata['increments']) : 0;if ($_increments_count) {for ($_increments_i = 0; $_increments_i < $_increments_count; ++$_increments_i){$_increments_val = &$this->_tpldata['increments'][$_increments_i]; ?>
                        <tr>
                             <td>&nbsp;</td>
                             <td>
                                <input type="hidden" name="id[]" value="<?php echo $_increments_val['ID']; ?>">
                                <input type="text" name="lows[]" value="<?php echo $_increments_val['LOW']; ?>" size="10">
                             </td>
                             <td><input type="text" name="highs[]" value="<?php echo $_increments_val['HIGH']; ?>" size="10"></td>
                             <td><input type="text" name="increments[]" value="<?php echo $_increments_val['INCREMENT']; ?>" size="10"></td>
                             <td align="center"><input type="checkbox" name="delete[]" value="<?php echo $_increments_val['ID']; ?>"></td>
                        </tr>
<?php }} ?>
                        <tr>
                            <td colspan="4" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td><?php echo ((isset($this->_rootref['L_518'])) ? $this->_rootref['L_518'] : ((isset($MSG['518'])) ? $MSG['518'] : '{ L_518 }')); ?></td>
                            <td>
                                <input type="hidden" name="id[]" value="">
                                <input type="text" name="lows[]" size="10">
                            </td>
                            <td><input type="text" name="highs[]" size="10"></td>
                            <td><input type="text" name="increments[]" size="10"></td>
                            <td align="center">&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_089'])) ? $this->_rootref['L_089'] : ((isset($MSG['089'])) ? $MSG['089'] : '{ L_089 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>