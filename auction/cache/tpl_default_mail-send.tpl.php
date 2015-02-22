<script type="text/JavaScript">
$(".form1").submit(function(){
	if ($(".to").val() == "") {
		return false;
	}
	if ($(".subject").val() == "") {
		return false;
	}
	if ($(".message").val() == "") {
		return false;
	}
	return true;
});
</script>
<center>
	<form name="form1" id="form1" method="post" action="mail.php">
    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
	<table width="80%" border="1" style="border-collapse: collapse;">
	  <tr>
		<td width="100px" nowrap="nowrap" valign="top"><label for="to"><?php echo ((isset($this->_rootref['L_241'])) ? $this->_rootref['L_241'] : ((isset($MSG['241'])) ? $MSG['241'] : '{ L_241 }')); ?>:</label></td>
		<td><input name="sendto" type="text" size="40" value="<?php echo (isset($this->_rootref['REPLY_TO'])) ? $this->_rootref['REPLY_TO'] : ''; ?>" id="to"></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap" valign="top"><label for="subject"><?php echo ((isset($this->_rootref['L_332'])) ? $this->_rootref['L_332'] : ((isset($MSG['332'])) ? $MSG['332'] : '{ L_332 }')); ?>:</label></td>
		<td><input name="subject" type="text" size="40" value="<?php echo (isset($this->_rootref['REPLY_SUBJECT'])) ? $this->_rootref['REPLY_SUBJECT'] : ''; ?>" id="subject" maxlength="50"></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap" valign="top"><label for="message"><?php echo ((isset($this->_rootref['L_333'])) ? $this->_rootref['L_333'] : ((isset($MSG['333'])) ? $MSG['333'] : '{ L_333 }')); ?>:</label></td>
		<td><textarea name="message" rows="5" id="message" style="width:90%"></textarea></td>
	  </tr>
	</table>
<?php if ($this->_rootref['B_QMKPUBLIC']) {  ?>
	<p><input type="checkbox" name="public"<?php echo (isset($this->_rootref['REPLY_PUBLIC'])) ? $this->_rootref['REPLY_PUBLIC'] : ''; ?>> <?php echo ((isset($this->_rootref['L_543'])) ? $this->_rootref['L_543'] : ((isset($MSG['543'])) ? $MSG['543'] : '{ L_543 }')); ?></p>
    <input type="hidden" name="is_question" value="0">
<?php } ?>
    <input type="hidden" name="hash" value="<?php echo (isset($this->_rootref['HASH'])) ? $this->_rootref['HASH'] : ''; ?>">
	<input name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_007'])) ? $this->_rootref['L_007'] : ((isset($MSG['007'])) ? $MSG['007'] : '{ L_007 }')); ?>">
	</form>
<?php if ($this->_rootref['B_CONVO']) {  ?>
<br class="spacer">
<div style="overflow:scroll; min-height:100px; max-height:500px; width:80%;">
	<?php $_convo_count = (isset($this->_tpldata['convo'])) ? sizeof($this->_tpldata['convo']) : 0;if ($_convo_count) {for ($_convo_i = 0; $_convo_i < $_convo_count; ++$_convo_i){$_convo_val = &$this->_tpldata['convo'][$_convo_i]; ?>
    <div style="border:#000000 solid 1px;<?php echo $_convo_val['BGCOLOUR']; ?>">
    	<?php echo $_convo_val['MSG']; ?>
    </div>
    <?php }} ?>
</div>
<?php } ?>
</center>
<br>