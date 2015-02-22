<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_5142'])) ? $this->_rootref['L_5142'] : ((isset($MSG['5142'])) ? $MSG['5142'] : '{ L_5142 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_069'])) ? $this->_rootref['L_069'] : ((isset($MSG['069'])) ? $MSG['069'] : '{ L_069 }')); ?></h4>
				<form name="durations" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b><?php echo ((isset($this->_rootref['L_097'])) ? $this->_rootref['L_097'] : ((isset($MSG['097'])) ? $MSG['097'] : '{ L_097 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_087'])) ? $this->_rootref['L_087'] : ((isset($MSG['087'])) ? $MSG['087'] : '{ L_087 }')); ?></b></th>
                            <th width="5%"><b><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></b></th>
                        </tr>
<?php $_dur_count = (isset($this->_tpldata['dur'])) ? sizeof($this->_tpldata['dur']) : 0;if ($_dur_count) {for ($_dur_i = 0; $_dur_i < $_dur_count; ++$_dur_i){$_dur_val = &$this->_tpldata['dur'][$_dur_i]; ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="text" name="new_days[<?php echo $_dur_val['ID']; ?>]" value="<?php echo $_dur_val['DAYS']; ?>" size="5"></td>
                            <td><input type="text" name="new_durations[<?php echo $_dur_val['ID']; ?>]" value="<?php echo $_dur_val['DESC']; ?>" size="25"></td>
                            <td align="center"><input type="checkbox" name="delete[]" value="<?php echo $_dur_val['ID']; ?>"></td>
                        </tr>
<?php }} ?>
                        <tr>
                            <td colspan="3" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td><?php echo ((isset($this->_rootref['L_518'])) ? $this->_rootref['L_518'] : ((isset($MSG['518'])) ? $MSG['518'] : '{ L_518 }')); ?></td>
                            <td><input type="text" name="new_days[]" size="5" maxlength="5"></td>
                            <td><input type="text" name="new_durations[]" size="25"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_089'])) ? $this->_rootref['L_089'] : ((isset($MSG['089'])) ? $MSG['089'] : '{ L_089 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>