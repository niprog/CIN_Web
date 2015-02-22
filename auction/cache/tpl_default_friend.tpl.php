<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_139'])) ? $this->_rootref['L_139'] : ((isset($MSG['139'])) ? $MSG['139'] : '{ L_139 }')); ?></div>
		<div class="titTable3">
			<a href="item.php?id=<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_138'])) ? $this->_rootref['L_138'] : ((isset($MSG['138'])) ? $MSG['138'] : '{ L_138 }')); ?></a>
		</div>
<?php if ($this->_rootref['EMAILSENT'] == ('')) {  ?>
		<div align="center" class="padding">
			<p>
			<b><?php echo ((isset($this->_rootref['L_017'])) ? $this->_rootref['L_017'] : ((isset($MSG['017'])) ? $MSG['017'] : '{ L_017 }')); ?> : <?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?></b><br>
			<b><?php echo ((isset($this->_rootref['L_146'])) ? $this->_rootref['L_146'] : ((isset($MSG['146'])) ? $MSG['146'] : '{ L_146 }')); ?> <?php echo (isset($this->_rootref['FRIEND_EMAIL'])) ? $this->_rootref['FRIEND_EMAIL'] : ''; ?></b> 
			</p>
		</div>
<?php } else { if ($this->_rootref['ERROR'] != ('')) {  ?>
		<div class="error-box">
			<?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?>
		</div>
	<?php } ?>
		<form name="friend" action="friend.php" method="post">
        <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
		<table width="90%" cellpadding="4" cellspacing="0">
		<tr> 
			<td align="right" width="45%"><b><?php echo ((isset($this->_rootref['L_017'])) ? $this->_rootref['L_017'] : ((isset($MSG['017'])) ? $MSG['017'] : '{ L_017 }')); ?></b></td>
			<td align="left"><?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?></td>
		</tr>
		<tr> 
			<td align="right"><b><?php echo ((isset($this->_rootref['L_140'])) ? $this->_rootref['L_140'] : ((isset($MSG['140'])) ? $MSG['140'] : '{ L_140 }')); ?></b></td>
			<td align="left"><input type="text" name="friend_name" size="25" value="<?php echo (isset($this->_rootref['FRIEND_NAME'])) ? $this->_rootref['FRIEND_NAME'] : ''; ?>"> 
		</td>
		</tr>
		<tr> 
			<td align="right"><b><?php echo ((isset($this->_rootref['L_141'])) ? $this->_rootref['L_141'] : ((isset($MSG['141'])) ? $MSG['141'] : '{ L_141 }')); ?></b></td>
			<td align="left"><input type="text" name="friend_email" size="25" value="<?php echo (isset($this->_rootref['FRIEND_EMAIL'])) ? $this->_rootref['FRIEND_EMAIL'] : ''; ?>"> 
		</td>
		</tr>
		<tr> 
			<td align="right"><b><?php echo ((isset($this->_rootref['L_002'])) ? $this->_rootref['L_002'] : ((isset($MSG['002'])) ? $MSG['002'] : '{ L_002 }')); ?></b></td>
			<td align="left"><input type="text" name="sender_name" size="25" value="<?php echo (isset($this->_rootref['YOUR_NAME'])) ? $this->_rootref['YOUR_NAME'] : ''; ?>"> 
		</td>
		</tr>
		<tr> 
			<td align="right"><b><?php echo ((isset($this->_rootref['L_143'])) ? $this->_rootref['L_143'] : ((isset($MSG['143'])) ? $MSG['143'] : '{ L_143 }')); ?></b></td>
			<td align="left"><input type="text" name="sender_email" size="25" value="<?php echo (isset($this->_rootref['YOUR_EMAIL'])) ? $this->_rootref['YOUR_EMAIL'] : ''; ?>"></td>
        <tr> 
			<td colspan="2"><?php echo (isset($this->_rootref['CAPCHA'])) ? $this->_rootref['CAPCHA'] : ''; ?></td>
		</tr>
		<tr> 
			<td align="right" valign="top"><b><?php echo ((isset($this->_rootref['L_144'])) ? $this->_rootref['L_144'] : ((isset($MSG['144'])) ? $MSG['144'] : '{ L_144 }')); ?></b></td>
			<td align="left">
				<textarea name="sender_comment" cols="30" rows="6"><?php echo (isset($this->_rootref['COMMENT'])) ? $this->_rootref['COMMENT'] : ''; ?></textarea>
			</td>
		</tr>
		<tr> 
			<td align="center" colspan="2">
				<input type="hidden" name="id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>"> 
				<input type="hidden" name="item_title" value="<?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?>"> 
				<input type="hidden" name="action" value="sendmail">
				<input type="submit" name="" value="<?php echo ((isset($this->_rootref['L_5201'])) ? $this->_rootref['L_5201'] : ((isset($MSG['5201'])) ? $MSG['5201'] : '{ L_5201 }')); ?>" class="button"> 
				<input type="reset" name="" value="<?php echo ((isset($this->_rootref['L_035'])) ? $this->_rootref['L_035'] : ((isset($MSG['035'])) ? $MSG['035'] : '{ L_035 }')); ?>" class="button">
			</td>
		</tr>
		</table>
		</form>
<?php } ?>
	</div>
</div>