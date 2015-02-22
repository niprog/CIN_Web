<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<table width="90%" border="0" cellpadding="1" cellspacing="0" align="center">
	<tr>
		<td colspan="2" align="right">
			<b><?php echo (isset($this->_rootref['USERNICK'])) ? $this->_rootref['USERNICK'] : ''; ?></b> (<?php echo (isset($this->_rootref['USERFB'])) ? $this->_rootref['USERFB'] : ''; ?>) <?php echo (isset($this->_rootref['USERFBIMG'])) ? $this->_rootref['USERFBIMG'] : ''; ?>
		</td>
	</tr>
<?php $_fbs_count = (isset($this->_tpldata['fbs'])) ? sizeof($this->_tpldata['fbs']) : 0;if ($_fbs_count) {for ($_fbs_i = 0; $_fbs_i < $_fbs_count; ++$_fbs_i){$_fbs_val = &$this->_tpldata['fbs'][$_fbs_i]; ?>
	<tr <?php echo $_fbs_val['BGCOLOUR']; ?>>
		<td valign="top">
			<img src="<?php echo $_fbs_val['IMG']; ?>" align="middle" alt="">
		</td>
		<td valign="top">
			<b><a href="<?php echo $_fbs_val['USFLINK']; ?>"><?php echo $_fbs_val['USERNAME']; ?> (<?php echo $_fbs_val['USFEED']; ?>)</a></b>&nbsp;<?php echo $_fbs_val['USICON']; ?>
			(<?php echo ((isset($this->_rootref['L_506'])) ? $this->_rootref['L_506'] : ((isset($MSG['506'])) ? $MSG['506'] : '{ L_506 }')); echo $_fbs_val['FBDATE']; ?> <?php echo ((isset($this->_rootref['L_25_0177'])) ? $this->_rootref['L_25_0177'] : ((isset($MSG['25_0177'])) ? $MSG['25_0177'] : '{ L_25_0177 }')); ?> <?php echo $_fbs_val['AUCTIONURL']; ?>)
			<br>
			<b><?php echo ((isset($this->_rootref['L_504'])) ? $this->_rootref['L_504'] : ((isset($MSG['504'])) ? $MSG['504'] : '{ L_504 }')); ?>: </b><?php echo $_fbs_val['FEEDBACK']; ?>
		</td>
	</tr>
<?php }} ?>
	<tr <?php echo (isset($this->_rootref['BGCOLOUR'])) ? $this->_rootref['BGCOLOUR'] : ''; ?>>
		<td colspan="2" align="right">
			<?php echo (isset($this->_rootref['PAGENATION'])) ? $this->_rootref['PAGENATION'] : ''; ?>
		</td>
	</tr>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>