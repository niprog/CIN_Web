<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_5142'])) ? $this->_rootref['L_5142'] : ((isset($MSG['5142'])) ? $MSG['5142'] : '{ L_5142 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_081'])) ? $this->_rootref['L_081'] : ((isset($MSG['081'])) ? $MSG['081'] : '{ L_081 }')); ?></h4>
				<form name="payments" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
					<div class="plain-box">
                    	<p><?php echo ((isset($this->_rootref['L_094'])) ? $this->_rootref['L_094'] : ((isset($MSG['094'])) ? $MSG['094'] : '{ L_094 }')); ?></p>
						<p><img src="../images/nodelete.gif" width="20" height="21" style="vertical-align:middle;"> <?php echo ((isset($this->_rootref['L_2__0030'])) ? $this->_rootref['L_2__0030'] : ((isset($MSG['2__0030'])) ? $MSG['2__0030'] : '{ L_2__0030 }')); ?></p>
                    </div>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b><?php echo ((isset($this->_rootref['L_087'])) ? $this->_rootref['L_087'] : ((isset($MSG['087'])) ? $MSG['087'] : '{ L_087 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></b></th>
                        </tr>
<?php $_countries_count = (isset($this->_tpldata['countries'])) ? sizeof($this->_tpldata['countries']) : 0;if ($_countries_count) {for ($_countries_i = 0; $_countries_i < $_countries_count; ++$_countries_i){$_countries_val = &$this->_tpldata['countries'][$_countries_i]; ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="text" name="new_countries[]" size="45" value="<?php echo $_countries_val['COUNTRY']; ?>">
                                <input type="hidden" name="old_countries[]" value="<?php echo $_countries_val['COUNTRY']; ?>">
                            </td>
                            <td align="center"><?php echo $_countries_val['SELECTBOX']; ?></td>
                        </tr>
<?php }} ?>
                        <tr>
                            <td colspan="2" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td><?php echo ((isset($this->_rootref['L_394'])) ? $this->_rootref['L_394'] : ((isset($MSG['394'])) ? $MSG['394'] : '{ L_394 }')); ?></td>
                            <td>
                                <input type="text" name="new_countries[]" size="45">
                            </td>
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