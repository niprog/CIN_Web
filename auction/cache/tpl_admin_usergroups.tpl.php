<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_25_0010'])) ? $this->_rootref['L_25_0010'] : ((isset($MSG['25_0010'])) ? $MSG['25_0010'] : '{ L_25_0010 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_448'])) ? $this->_rootref['L_448'] : ((isset($MSG['448'])) ? $MSG['448'] : '{ L_448 }')); ?></h4>
				<form name="errorlog" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
                    <table width="98%" cellpadding="0" cellspacing="0">
                    <tr>
                        <th><b><?php echo ((isset($this->_rootref['L_449'])) ? $this->_rootref['L_449'] : ((isset($MSG['449'])) ? $MSG['449'] : '{ L_449 }')); ?></b></th>
                        <th><b><?php echo ((isset($this->_rootref['L_450'])) ? $this->_rootref['L_450'] : ((isset($MSG['450'])) ? $MSG['450'] : '{ L_450 }')); ?></b></th>
                        <th><b><?php echo ((isset($this->_rootref['L_451'])) ? $this->_rootref['L_451'] : ((isset($MSG['451'])) ? $MSG['451'] : '{ L_451 }')); ?></b></th>
                        <th><b><?php echo ((isset($this->_rootref['L_578'])) ? $this->_rootref['L_578'] : ((isset($MSG['578'])) ? $MSG['578'] : '{ L_578 }')); ?></b></th>
                        <th><b><?php echo ((isset($this->_rootref['L_579'])) ? $this->_rootref['L_579'] : ((isset($MSG['579'])) ? $MSG['579'] : '{ L_579 }')); ?></b></th>
                        <th><b><?php echo ((isset($this->_rootref['L_580'])) ? $this->_rootref['L_580'] : ((isset($MSG['580'])) ? $MSG['580'] : '{ L_580 }')); ?></b></th>
                        <th>&nbsp;</th>
                    </tr>
<?php if ($this->_rootref['B_EDIT']) {  ?>
                    <tr>
                        <td colspan="7"><b><?php echo ((isset($this->_rootref['L_452'])) ? $this->_rootref['L_452'] : ((isset($MSG['452'])) ? $MSG['452'] : '{ L_452 }')); ?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo (isset($this->_rootref['GROUP_ID'])) ? $this->_rootref['GROUP_ID'] : ''; ?></td>
                        <td><input type="text" name="group_name" value="<?php echo (isset($this->_rootref['EDIT_NAME'])) ? $this->_rootref['EDIT_NAME'] : ''; ?>"></td>
                        <td><input type="text" name="user_count" value="<?php echo (isset($this->_rootref['USER_COUNT'])) ? $this->_rootref['USER_COUNT'] : ''; ?>"></td>
                        <td>
                            <select name="can_sell">
                                <option value="1" <?php echo (isset($this->_rootref['CAN_SELL_Y'])) ? $this->_rootref['CAN_SELL_Y'] : ''; ?>><?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?></option>
                                <option value="0" <?php echo (isset($this->_rootref['CAN_SELL_N'])) ? $this->_rootref['CAN_SELL_N'] : ''; ?>><?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?></option>
                            </select>
                        </td>
                        <td>
                            <select name="can_buy">
                                <option value="1" <?php echo (isset($this->_rootref['CAN_BUY_Y'])) ? $this->_rootref['CAN_BUY_Y'] : ''; ?>><?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?></option>
                                <option value="0" <?php echo (isset($this->_rootref['CAN_BUY_N'])) ? $this->_rootref['CAN_BUY_N'] : ''; ?>><?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?></option>
                            </select>
                        </td>
                        <td>
                            <select name="auto_join">
                                <option value="1" <?php echo (isset($this->_rootref['AUTO_JOIN_Y'])) ? $this->_rootref['AUTO_JOIN_Y'] : ''; ?>><?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?></option>
                                <option value="0" <?php echo (isset($this->_rootref['AUTO_JOIN_N'])) ? $this->_rootref['AUTO_JOIN_N'] : ''; ?>><?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?></option>
                            </select>
                        </td>
                        <td><input type="hidden" name="id" value="<?php echo (isset($this->_rootref['GROUP_ID'])) ? $this->_rootref['GROUP_ID'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th colspan="7">&nbsp;</th>
                    </tr>
<?php } $_groups_count = (isset($this->_tpldata['groups'])) ? sizeof($this->_tpldata['groups']) : 0;if ($_groups_count) {for ($_groups_i = 0; $_groups_i < $_groups_count; ++$_groups_i){$_groups_val = &$this->_tpldata['groups'][$_groups_i]; ?>
                    <tr>
                        <td><?php echo $_groups_val['ID']; ?></td>
                        <td><?php echo $_groups_val['NAME']; ?></td>
                        <td><?php echo $_groups_val['USER_COUNT']; ?></td>
                        <td><?php echo $_groups_val['CAN_SELL']; ?></td>
                        <td><?php echo $_groups_val['CAN_BUY']; ?></td>
                        <td><?php echo $_groups_val['AUTO_JOIN']; ?></td>
                        <td><a href="usergroups.php?id=<?php echo $_groups_val['ID']; ?>&action=edit"><?php echo ((isset($this->_rootref['L_298'])) ? $this->_rootref['L_298'] : ((isset($MSG['298'])) ? $MSG['298'] : '{ L_298 }')); ?></a></td>
                    </tr>
<?php }} ?>
                    <tr>
                        <td colspan="7"><a href="usergroups.php?action=new"><?php echo ((isset($this->_rootref['L_518'])) ? $this->_rootref['L_518'] : ((isset($MSG['518'])) ? $MSG['518'] : '{ L_518 }')); ?></a></td>
                    </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>