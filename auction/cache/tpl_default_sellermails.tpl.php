<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<div class="padding">
	<form action="" method="post" name="thisform" id="thisform">
	<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
	<table width="100%" cellspacing="0" cellpadding="4" border="0" >
		<tr>
			<td width="93%">
				<?php echo ((isset($this->_rootref['L_25_0195'])) ? $this->_rootref['L_25_0195'] : ((isset($MSG['25_0195'])) ? $MSG['25_0195'] : '{ L_25_0195 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="startemailmod" value="yes"<?php echo (isset($this->_rootref['B_AUCSETUPY'])) ? $this->_rootref['B_AUCSETUPY'] : ''; ?>>
				<?php echo ((isset($this->_rootref['L_25_0196'])) ? $this->_rootref['L_25_0196'] : ((isset($MSG['25_0196'])) ? $MSG['25_0196'] : '{ L_25_0196 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="startemailmod" value="no"<?php echo (isset($this->_rootref['B_AUCSETUPN'])) ? $this->_rootref['B_AUCSETUPN'] : ''; ?>>
				<?php echo ((isset($this->_rootref['L_25_0197'])) ? $this->_rootref['L_25_0197'] : ((isset($MSG['25_0197'])) ? $MSG['25_0197'] : '{ L_25_0197 }')); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="93%">
				<?php echo ((isset($this->_rootref['L_25_0189'])) ? $this->_rootref['L_25_0189'] : ((isset($MSG['25_0189'])) ? $MSG['25_0189'] : '{ L_25_0189 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="endemailmod" value="one"<?php echo (isset($this->_rootref['B_CLOSEONE'])) ? $this->_rootref['B_CLOSEONE'] : ''; ?>>
				<?php echo ((isset($this->_rootref['L_25_0190'])) ? $this->_rootref['L_25_0190'] : ((isset($MSG['25_0190'])) ? $MSG['25_0190'] : '{ L_25_0190 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="endemailmod" value="cum"<?php echo (isset($this->_rootref['B_CLOSEBULK'])) ? $this->_rootref['B_CLOSEBULK'] : ''; ?>>
				<?php echo ((isset($this->_rootref['L_25_0191'])) ? $this->_rootref['L_25_0191'] : ((isset($MSG['25_0191'])) ? $MSG['25_0191'] : '{ L_25_0191 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="endemailmod" value="none"<?php echo (isset($this->_rootref['B_CLOSENONE'])) ? $this->_rootref['B_CLOSENONE'] : ''; ?>>
				<?php echo ((isset($this->_rootref['L_25_0193'])) ? $this->_rootref['L_25_0193'] : ((isset($MSG['25_0193'])) ? $MSG['25_0193'] : '{ L_25_0193 }')); ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="93%">
				<?php echo ((isset($this->_rootref['L_903'])) ? $this->_rootref['L_903'] : ((isset($MSG['903'])) ? $MSG['903'] : '{ L_903 }')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="emailtype" value="text"<?php echo (isset($this->_rootref['B_EMAILTYPET'])) ? $this->_rootref['B_EMAILTYPET'] : ''; ?>> <?php echo ((isset($this->_rootref['L_915'])) ? $this->_rootref['L_915'] : ((isset($MSG['915'])) ? $MSG['915'] : '{ L_915 }')); ?> <input type="radio" name="emailtype" value="html"<?php echo (isset($this->_rootref['B_EMAILTYPEH'])) ? $this->_rootref['B_EMAILTYPEH'] : ''; ?>> <?php echo ((isset($this->_rootref['L_902'])) ? $this->_rootref['L_902'] : ((isset($MSG['902'])) ? $MSG['902'] : '{ L_902 }')); ?>
			</td>
		</tr>
		<tr>
			<td align="center">
				<input type="hidden" name="action" value="update">
				<input type="submit" name="Submit" value="<?php echo ((isset($this->_rootref['L_530'])) ? $this->_rootref['L_530'] : ((isset($MSG['530'])) ? $MSG['530'] : '{ L_530 }')); ?>" class="button">
				<br>
				<br>
			</td>
		</tr>
	</table>
	</form>
</div>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>