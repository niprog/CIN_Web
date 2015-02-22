<div class="content">
	<div class="tableContent2">
		<div class="titTable2 rounded-top rounded-bottom">
			<?php echo ((isset($this->_rootref['L_207'])) ? $this->_rootref['L_207'] : ((isset($MSG['207'])) ? $MSG['207'] : '{ L_207 }')); ?>
		</div>
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
		<div class="error-box">
			<?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?>
		</div>
<?php } ?>
		<div class="table2" style="padding:20px;">
			<form name="addfeedback" action="<?php echo (isset($this->_rootref['SSLURL'])) ? $this->_rootref['SSLURL'] : ''; ?>feedback.php?wid=<?php echo (isset($this->_rootref['WID'])) ? $this->_rootref['WID'] : ''; ?>&sid=<?php echo (isset($this->_rootref['SID'])) ? $this->_rootref['SID'] : ''; ?>&ws=<?php echo (isset($this->_rootref['WS'])) ? $this->_rootref['WS'] : ''; ?>" method="post">
            	<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
				<table width="100%" border="0" cellpadding="4" cellspacing="0" >
					<tr>
						<td width="40%" align="right"><b><?php echo ((isset($this->_rootref['L_168'])) ? $this->_rootref['L_168'] : ((isset($MSG['168'])) ? $MSG['168'] : '{ L_168 }')); ?>:</b></td>
						<td>
							<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo (isset($this->_rootref['AUCT_ID'])) ? $this->_rootref['AUCT_ID'] : ''; ?>"><?php echo (isset($this->_rootref['AUCT_TITLE'])) ? $this->_rootref['AUCT_TITLE'] : ''; ?></a>
						</td>
					</tr>
					<tr>
						<td width="40%" align="right"><b><?php echo (isset($this->_rootref['SBMSG'])) ? $this->_rootref['SBMSG'] : ''; ?>:</b></td>
						<td>
							<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>profile.php?user_id=<?php echo (isset($this->_rootref['THEM'])) ? $this->_rootref['THEM'] : ''; ?>&auction_id=<?php echo (isset($this->_rootref['AUCT_ID'])) ? $this->_rootref['AUCT_ID'] : ''; ?>"><?php echo (isset($this->_rootref['USERNICK'])) ? $this->_rootref['USERNICK'] : ''; ?></a> (<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>feedback.php?id=<?php echo (isset($this->_rootref['THEM'])) ? $this->_rootref['THEM'] : ''; ?>&faction=show"><?php echo (isset($this->_rootref['USERFB'])) ? $this->_rootref['USERFB'] : ''; ?></a>) <?php echo (isset($this->_rootref['USERFBIMG'])) ? $this->_rootref['USERFBIMG'] : ''; ?>
						</td>
					</tr>
					<tr>
						<td align="right"><b><?php echo ((isset($this->_rootref['L_503'])) ? $this->_rootref['L_503'] : ((isset($MSG['503'])) ? $MSG['503'] : '{ L_503 }')); ?>:</b> </td>
						<td>
							<input type="radio" name="TPL_rate" value="1" <?php echo (isset($this->_rootref['RATE1'])) ? $this->_rootref['RATE1'] : ''; ?>>
							<img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/positive.png" border="0" alt="+1"> 
							<input type="radio" name="TPL_rate" value="0" <?php echo (isset($this->_rootref['RATE2'])) ? $this->_rootref['RATE2'] : ''; ?>>
							<img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/neutral.png" border="0" alt="0">
							<input type="radio" name="TPL_rate" value="-1" <?php echo (isset($this->_rootref['RATE3'])) ? $this->_rootref['RATE3'] : ''; ?>>
							<img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/negative.png" border="0" alt="-1">
					</tr>
					<tr>
						<td align="right" valign="top"><b><?php echo ((isset($this->_rootref['L_227'])) ? $this->_rootref['L_227'] : ((isset($MSG['227'])) ? $MSG['227'] : '{ L_227 }')); ?>:</b></td>
						<td>
							<textarea name="TPL_feedback" rows="10" cols="50"><?php echo (isset($this->_rootref['FEEDBACK'])) ? $this->_rootref['FEEDBACK'] : ''; ?></textarea>
						</td>
					</tr>
<?php if ($this->_rootref['B_USERAUTH']) {  ?>
					<tr>
						<td align="right"><b><?php echo ((isset($this->_rootref['L_188'])) ? $this->_rootref['L_188'] : ((isset($MSG['188'])) ? $MSG['188'] : '{ L_188 }')); ?>:</b></td>
						<td>
							<input type="password" name="TPL_password" size="20" maxlength="20" value="">
						</td>
					</tr>
<?php } ?>
					<tr>
						<td colspan="2" align="center"><br>
							<input type="submit" name="" value="<?php echo ((isset($this->_rootref['L_207'])) ? $this->_rootref['L_207'] : ((isset($MSG['207'])) ? $MSG['207'] : '{ L_207 }')); ?>" class="button">
							<input type="reset" name="" class="button">
						</td>
					</tr>
				</table>
				<input type="hidden" name="TPL_nick_hidden" value="<?php echo (isset($this->_rootref['USERNICK'])) ? $this->_rootref['USERNICK'] : ''; ?>">
				<input type="hidden" name="addfeedback" value="true">
				<input type="hidden" name="auction_id" value="<?php echo (isset($this->_rootref['AUCT_ID'])) ? $this->_rootref['AUCT_ID'] : ''; ?>">
			</form>
		</div>
	</div>
</div>