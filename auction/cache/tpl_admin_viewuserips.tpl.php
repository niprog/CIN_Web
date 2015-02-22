<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_25_0010'])) ? $this->_rootref['L_25_0010'] : ((isset($MSG['25_0010'])) ? $MSG['25_0010'] : '{ L_25_0010 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_045'])) ? $this->_rootref['L_045'] : ((isset($MSG['045'])) ? $MSG['045'] : '{ L_045 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_2_0004'])) ? $this->_rootref['L_2_0004'] : ((isset($MSG['2_0004'])) ? $MSG['2_0004'] : '{ L_2_0004 }')); ?></h4>
				<form name="banips" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
                	<table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td colspan="3"><?php echo ((isset($this->_rootref['L_667'])) ? $this->_rootref['L_667'] : ((isset($MSG['667'])) ? $MSG['667'] : '{ L_667 }')); ?> <b><?php echo (isset($this->_rootref['NICK'])) ? $this->_rootref['NICK'] : ''; ?></b></td>
                        <td align="right"><?php echo ((isset($this->_rootref['L_559'])) ? $this->_rootref['L_559'] : ((isset($MSG['559'])) ? $MSG['559'] : '{ L_559 }')); ?>: <?php echo (isset($this->_rootref['LASTLOGIN'])) ? $this->_rootref['LASTLOGIN'] : ''; ?></td>
                    </tr>
                    <tr>
                        <th width="35%"><b><?php echo ((isset($this->_rootref['L_087'])) ? $this->_rootref['L_087'] : ((isset($MSG['087'])) ? $MSG['087'] : '{ L_087 }')); ?></b></th>
                        <th width="27%"><b><?php echo ((isset($this->_rootref['L_2_0009'])) ? $this->_rootref['L_2_0009'] : ((isset($MSG['2_0009'])) ? $MSG['2_0009'] : '{ L_2_0009 }')); ?></b></th>
                        <th width="21%"><b><?php echo ((isset($this->_rootref['L_560'])) ? $this->_rootref['L_560'] : ((isset($MSG['560'])) ? $MSG['560'] : '{ L_560 }')); ?></b></th>
                        <th width="17%"><b><?php echo ((isset($this->_rootref['L_5028'])) ? $this->_rootref['L_5028'] : ((isset($MSG['5028'])) ? $MSG['5028'] : '{ L_5028 }')); ?></b></th>
                    </tr>
<?php $_ips_count = (isset($this->_tpldata['ips'])) ? sizeof($this->_tpldata['ips']) : 0;if ($_ips_count) {for ($_ips_i = 0; $_ips_i < $_ips_count; ++$_ips_i){$_ips_val = &$this->_tpldata['ips'][$_ips_i]; ?>
                    <tr <?php echo $_users_val['BG']; ?>>
                        <td>
	<?php if ($_ips_val['TYPE'] == ('first')) {  ?>
    						<?php echo ((isset($this->_rootref['L_2_0005'])) ? $this->_rootref['L_2_0005'] : ((isset($MSG['2_0005'])) ? $MSG['2_0005'] : '{ L_2_0005 }')); ?>
    <?php } else { ?>
    						<?php echo ((isset($this->_rootref['L_221'])) ? $this->_rootref['L_221'] : ((isset($MSG['221'])) ? $MSG['221'] : '{ L_221 }')); ?>
    <?php } ?>
                        </td>
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
                    </tr>
<?php }} ?>
                    </table>
                    <input type="hidden" name="offset" value="<?php echo (isset($this->_rootref['OFFSET'])) ? $this->_rootref['OFFSET'] : ''; ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_2_0015'])) ? $this->_rootref['L_2_0015'] : ((isset($MSG['2_0015'])) ? $MSG['2_0015'] : '{ L_2_0015 }')); ?>">
				</form>
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
				<div class="plain-box"><a href="listusers.php?offset=<?php echo (isset($this->_rootref['OFFSET'])) ? $this->_rootref['OFFSET'] : ''; ?>" class="small"><?php echo ((isset($this->_rootref['L_5279'])) ? $this->_rootref['L_5279'] : ((isset($MSG['5279'])) ? $MSG['5279'] : '{ L_5279 }')); ?></a></div>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>