<div class="titTable2 rounded-top rounded-bottom">
	<?php echo ((isset($this->_rootref['L_215'])) ? $this->_rootref['L_215'] : ((isset($MSG['215'])) ? $MSG['215'] : '{ L_215 }')); ?>
</div>
<div class="padding" align="center">
<?php if ($this->_rootref['B_FIRST']) {  if ($this->_rootref['ERROR'] != ('')) {  ?>
    <div class="error-box">
        <?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?>
    </div>
	<?php } ?>
	<form name="user_login" action="" method="post">
    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
	<table width="80%" cellspacing="0" cellpadding="4" border="0">
	<tr>
		<td colspan="2" align="center"><?php echo ((isset($this->_rootref['L_2__0039'])) ? $this->_rootref['L_2__0039'] : ((isset($MSG['2__0039'])) ? $MSG['2__0039'] : '{ L_2__0039 }')); ?></td>
	</tr>
	<tr>
		<td width="40%" align="right"><b><?php echo ((isset($this->_rootref['L_003'])) ? $this->_rootref['L_003'] : ((isset($MSG['003'])) ? $MSG['003'] : '{ L_003 }')); ?></b></td>
		<td width="60%">
			<input type="text" NAME="TPL_username" size="25" value="<?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td align="right"><b><?php echo ((isset($this->_rootref['L_006'])) ? $this->_rootref['L_006'] : ((isset($MSG['006'])) ? $MSG['006'] : '{ L_006 }')); ?></b></td>
		<td>
			<input type="text" NAME="TPL_email" size="25" value="<?php echo (isset($this->_rootref['EMAIL'])) ? $this->_rootref['EMAIL'] : ''; ?>">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><br>
			<input type="submit" name="" value="<?php echo ((isset($this->_rootref['L_5431'])) ? $this->_rootref['L_5431'] : ((isset($MSG['5431'])) ? $MSG['5431'] : '{ L_5431 }')); ?>" class="button">
		</td>
	</tr>
	</table>
	<input type="hidden" name="action" value="ok">
	</form>
<?php } else { ?>
	<?php echo ((isset($this->_rootref['L_217'])) ? $this->_rootref['L_217'] : ((isset($MSG['217'])) ? $MSG['217'] : '{ L_217 }')); ?>
<?php } ?>
</div>