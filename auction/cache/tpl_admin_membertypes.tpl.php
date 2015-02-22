<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_5142'])) ? $this->_rootref['L_5142'] : ((isset($MSG['5142'])) ? $MSG['5142'] : '{ L_5142 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_25_0169'])) ? $this->_rootref['L_25_0169'] : ((isset($MSG['25_0169'])) ? $MSG['25_0169'] : '{ L_25_0169 }')); ?></h4>
				<form name="memberlevels" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
					<div class="plain-box"><?php echo ((isset($this->_rootref['L_25_0170'])) ? $this->_rootref['L_25_0170'] : ((isset($MSG['25_0170'])) ? $MSG['25_0170'] : '{ L_25_0170 }')); ?></div>
                    <table width="98%" cellpadding="0" cellspacing="0" class="blank">
                        <tr>
                            <th>&nbsp;</th>
                            <th><b><?php echo ((isset($this->_rootref['L_25_0171'])) ? $this->_rootref['L_25_0171'] : ((isset($MSG['25_0171'])) ? $MSG['25_0171'] : '{ L_25_0171 }')); ?></b></th>
                            <th><b><?php echo ((isset($this->_rootref['L_25_0167'])) ? $this->_rootref['L_25_0167'] : ((isset($MSG['25_0167'])) ? $MSG['25_0167'] : '{ L_25_0167 }')); ?></b></th>
                            <th>&nbsp;</th>
                            <th width="5%"><b><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></b></th>
                        </tr>
<?php $_mtype_count = (isset($this->_tpldata['mtype'])) ? sizeof($this->_tpldata['mtype']) : 0;if ($_mtype_count) {for ($_mtype_i = 0; $_mtype_i < $_mtype_count; ++$_mtype_i){$_mtype_val = &$this->_tpldata['mtype'][$_mtype_i]; ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" name="old_membertypes[<?php echo $_mtype_val['ID']; ?>][feedbacks]" value="<?php echo $_mtype_val['FEEDBACK']; ?>">
                                <input type="text" name="new_membertypes[<?php echo $_mtype_val['ID']; ?>][feedbacks]" value="<?php echo $_mtype_val['FEEDBACK']; ?>" size="5">
                            </td>
                            <td>
                                <input type="hidden" name="old_membertypes[<?php echo $_mtype_val['ID']; ?>][icon]" value="<?php echo $_mtype_val['ICON']; ?>">
                                <input type="text" name="new_membertypes[<?php echo $_mtype_val['ID']; ?>][icon]" value="<?php echo $_mtype_val['ICON']; ?>" size="25">
                            </td>
                            <td><img src="../images/icons/<?php echo $_mtype_val['ICON']; ?>" align="middle"></td>
                            <td align="center"><input type="checkbox" name="delete[]" value="<?php echo $_mtype_val['ID']; ?>"></td>
                        </tr>
<?php }} ?>
                        <tr>
                            <td colspan="4" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
                            <td align="center"><input type="checkbox" class="selectall" value="delete"></td>
                        </tr>
                        <tr>
                            <td><?php echo ((isset($this->_rootref['L_518'])) ? $this->_rootref['L_518'] : ((isset($MSG['518'])) ? $MSG['518'] : '{ L_518 }')); ?></td>
                            <td><input type="text" name="new_membertype[feedbacks]" size="5"></td>
                            <td><input type="text" name="new_membertype[icon]" size="30"></td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_089'])) ? $this->_rootref['L_089'] : ((isset($MSG['089'])) ? $MSG['089'] : '{ L_089 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>