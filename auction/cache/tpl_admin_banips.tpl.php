<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_25_0010'])) ? $this->_rootref['L_25_0010'] : ((isset($MSG['25_0010'])) ? $MSG['25_0010'] : '{ L_25_0010 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_2_0017'])) ? $this->_rootref['L_2_0017'] : ((isset($MSG['2_0017'])) ? $MSG['2_0017'] : '{ L_2_0017 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_2_0020'])) ? $this->_rootref['L_2_0020'] : ((isset($MSG['2_0020'])) ? $MSG['2_0020'] : '{ L_2_0020 }')); ?></h4>
				<form name="errorlog" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
                    <table width="98%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td bgcolor="#FFFF66" colspan="5">
                                <?php echo ((isset($this->_rootref['L_2_0021'])) ? $this->_rootref['L_2_0021'] : ((isset($MSG['2_0021'])) ? $MSG['2_0021'] : '{ L_2_0021 }')); ?>
                                <input type="text" name="ip">
                                <input type="submit" name="Submit2" value="&gt;&gt;">
                                <?php echo ((isset($this->_rootref['L_2_0024'])) ? $this->_rootref['L_2_0024'] : ((isset($MSG['2_0024'])) ? $MSG['2_0024'] : '{ L_2_0024 }')); ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="29%"><b><?php echo ((isset($this->_rootref['L_087'])) ? $this->_rootref['L_087'] : ((isset($MSG['087'])) ? $MSG['087'] : '{ L_087 }')); ?></b></td>
                            <th width="25%"><b><?php echo ((isset($this->_rootref['L_2_0009'])) ? $this->_rootref['L_2_0009'] : ((isset($MSG['2_0009'])) ? $MSG['2_0009'] : '{ L_2_0009 }')); ?></b></td>
                            <th width="19%"><b><?php echo ((isset($this->_rootref['L_560'])) ? $this->_rootref['L_560'] : ((isset($MSG['560'])) ? $MSG['560'] : '{ L_560 }')); ?></b></td>
                            <th width="18%"><b><?php echo ((isset($this->_rootref['L_5028'])) ? $this->_rootref['L_5028'] : ((isset($MSG['5028'])) ? $MSG['5028'] : '{ L_5028 }')); ?></b></td>
                            <th width="9%"><b><?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?></b></td>
                        </tr>
<?php $_ips_count = (isset($this->_tpldata['ips'])) ? sizeof($this->_tpldata['ips']) : 0;if ($_ips_count) {for ($_ips_i = 0; $_ips_i < $_ips_count; ++$_ips_i){$_ips_val = &$this->_tpldata['ips'][$_ips_i]; ?>
                        <tr <?php echo $_ips_val['BG']; ?>>
                            <td><?php echo ((isset($this->_rootref['L_2_0025'])) ? $this->_rootref['L_2_0025'] : ((isset($MSG['2_0025'])) ? $MSG['2_0025'] : '{ L_2_0025 }')); ?></td>
                            <td align="center"><?php echo $_ips_val['IP']; ?></td>
                            <td align="center"> 
    <?php if ($_ips_val['ACTION'] == ('accept')) {  ?>
                            	<?php echo ((isset($this->_rootref['L_2_0012'])) ? $this->_rootref['L_2_0012'] : ((isset($MSG['2_0012'])) ? $MSG['2_0012'] : '{ L_2_0012 }')); ?>
    <?php } else { ?>
                            	<?php echo ((isset($this->_rootref['L_2_0013'])) ? $this->_rootref['L_2_0013'] : ((isset($MSG['2_0013'])) ? $MSG['2_0013'] : '{ L_2_0013 }')); ?>
    <?php } ?>
                            </td>
                            <td> 
    <?php if ($_ips_val['ACTION'] == ('accept')) {  ?>
                                <input type="checkbox" name="deny[]" value="<?php echo $_ips_val['ID']; ?>">
                                &nbsp;<?php echo ((isset($this->_rootref['L_2_0006'])) ? $this->_rootref['L_2_0006'] : ((isset($MSG['2_0006'])) ? $MSG['2_0006'] : '{ L_2_0006 }')); ?>
    <?php } else { ?>
                                <input type="checkbox" name="accept[]" value="<?php echo $_ips_val['ID']; ?>">
                                &nbsp;<?php echo ((isset($this->_rootref['L_2_0007'])) ? $this->_rootref['L_2_0007'] : ((isset($MSG['2_0007'])) ? $MSG['2_0007'] : '{ L_2_0007 }')); ?>
    <?php } ?>
                            </td>
                            <td align="center"><input type="checkbox" name="delete[]" value="<?php echo $_ips_val['ID']; ?>"></td>
<?php }} else { ?>
                            <td colspan="5"><?php echo ((isset($this->_rootref['L_831'])) ? $this->_rootref['L_831'] : ((isset($MSG['831'])) ? $MSG['831'] : '{ L_831 }')); ?></td>
<?php } ?>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_2_0015'])) ? $this->_rootref['L_2_0015'] : ((isset($MSG['2_0015'])) ? $MSG['2_0015'] : '{ L_2_0015 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>