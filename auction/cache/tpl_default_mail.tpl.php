<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<script type="text/javascript">
$(document).ready(function() {
	$("#checkboxall").click(function() {
		var checked_status = this.checked
		$(".deleteid").each(function() {
			this.checked = checked_status;
		});
	});
});
</script>
<div align="center"><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></div>
<?php if ($this->_rootref['REPLY_X'] == (1)) {  $this->_tpl_include('mail-send.tpl'); } ?>
<form action="mail.php" method="post" name="deletemessages">
<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
<table style="text-align: center; width: 90%; border-collapse: collapse; margin: 0 auto;" border="1" cellpadding="2" cellspacing="2">
  <thead>
	<tr>
	  <td width="100"><?php echo (isset($this->_rootref['WHENSENT'])) ? $this->_rootref['WHENSENT'] : ''; ?></td>
	  <td><?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?></td>
	  <td width="200"><?php echo (isset($this->_rootref['SENTFROM'])) ? $this->_rootref['SENTFROM'] : ''; ?></td>
	  <td nowrap="nowrap"><?php echo ((isset($this->_rootref['L_2__0028'])) ? $this->_rootref['L_2__0028'] : ((isset($MSG['2__0028'])) ? $MSG['2__0028'] : '{ L_2__0028 }')); ?><br><input type="checkbox" name="" id="checkboxall" value=""></td>
	</tr>
  </thead>
  <tbody>
<?php if ($this->_rootref['MSGCOUNT'] == 0) {  ?>
	<tr>
	  <td colspan="5"><?php echo ((isset($this->_rootref['L_2__0029'])) ? $this->_rootref['L_2__0029'] : ((isset($MSG['2__0029'])) ? $MSG['2__0029'] : '{ L_2__0029 }')); ?></td>
	</tr>
<?php } else { $_msgs_count = (isset($this->_tpldata['msgs'])) ? sizeof($this->_tpldata['msgs']) : 0;if ($_msgs_count) {for ($_msgs_i = 0; $_msgs_i < $_msgs_count; ++$_msgs_i){$_msgs_val = &$this->_tpldata['msgs'][$_msgs_i]; ?>
	<tr>
	  <td><span class="smaller"><?php echo $_msgs_val['SENT']; ?></span></td>
	  <td><a href="yourmessages.php?id=<?php echo $_msgs_val['ID']; ?>"><?php echo $_msgs_val['SUBJECT']; ?></a></td>
	  <td><?php echo $_msgs_val['SENDER']; ?></td>
	  <td><input type="checkbox" name="deleteid[]" class="deleteid" value="<?php echo $_msgs_val['ID']; ?>"></td>
	</tr>	  
	<?php }} } ?>
	</tbody>
</table>
<div align="center">
	<input type="submit" name="submit" value="<?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?>"  OnClick="if ( !confirm('<?php echo ((isset($this->_rootref['L_2__0031'])) ? $this->_rootref['L_2__0031'] : ((isset($MSG['2__0031'])) ? $MSG['2__0031'] : '{ L_2__0031 }')); ?>') ) { return false; }">
</div>
</form>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>