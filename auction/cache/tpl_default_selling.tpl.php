<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="4">
	<tr>
		<th>
			<?php echo ((isset($this->_rootref['L_458'])) ? $this->_rootref['L_458'] : ((isset($MSG['458'])) ? $MSG['458'] : '{ L_458 }')); ?>
		</th>
		<th>
			<?php echo ((isset($this->_rootref['L_455'])) ? $this->_rootref['L_455'] : ((isset($MSG['455'])) ? $MSG['455'] : '{ L_455 }')); ?>
		</th>
		<th>
			<?php echo ((isset($this->_rootref['L_457'])) ? $this->_rootref['L_457'] : ((isset($MSG['457'])) ? $MSG['457'] : '{ L_457 }')); ?>
		</th>
		<th>
			<?php echo ((isset($this->_rootref['L_284'])) ? $this->_rootref['L_284'] : ((isset($MSG['284'])) ? $MSG['284'] : '{ L_284 }')); ?>
		</th>
		<th>&nbsp;</th>
	</tr>
<?php $_a_count = (isset($this->_tpldata['a'])) ? sizeof($this->_tpldata['a']) : 0;if ($_a_count) {for ($_a_i = 0; $_a_i < $_a_count; ++$_a_i){$_a_val = &$this->_tpldata['a'][$_a_i]; $_w_count = (isset($_a_val['w'])) ? sizeof($_a_val['w']) : 0;if ($_w_count) {for ($_w_i = 0; $_w_i < $_w_count; ++$_w_i){$_w_val = &$_a_val['w'][$_w_i]; ?>
	<tr valign="top" <?php echo $_w_val['BGCOLOUR']; ?>>
		<td nowrap="nowrap">
			<b><a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo $_a_val['AUCTIONID']; ?>" target="_blank"><?php echo $_a_val['TITLE']; ?></a></b><br>
			<span class="smallspan">(ID: <a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo $_a_val['AUCTIONID']; ?>" target="_blank"><?php echo $_a_val['AUCTIONID']; ?></a> - <?php echo ((isset($this->_rootref['L_25_0121'])) ? $this->_rootref['L_25_0121'] : ((isset($MSG['25_0121'])) ? $MSG['25_0121'] : '{ L_25_0121 }')); ?> <?php echo $_a_val['ENDS']; ?>)</span>
		</td>
		<td width="33%">
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>profile.php?user_id=<?php echo $_w_val['WINNERID']; ?>&auction_id=<?php echo $_a_val['AUCTIONID']; ?>"><?php echo $_w_val['NICK']; ?></a> <?php echo $_w_val['FB']; ?>
		</td>
		<td width="17%" align="right">
			<?php echo $_w_val['BIDF']; ?>
		</td>
		<td width="10%">
			<?php echo $_w_val['QTY']; ?>
		</td>
		<td width="10%" nowrap="nowrap">
<?php if ($_w_val['B_PAID']) {  ?>
			<?php echo ((isset($this->_rootref['L_898'])) ? $this->_rootref['L_898'] : ((isset($MSG['898'])) ? $MSG['898'] : '{ L_898 }')); ?>
<?php } else { ?>
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>selling.php?paid=<?php echo $_w_val['ID']; echo (isset($this->_rootref['AUCID'])) ? $this->_rootref['AUCID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_899'])) ? $this->_rootref['L_899'] : ((isset($MSG['899'])) ? $MSG['899'] : '{ L_899 }')); ?></a>
<?php } ?>
			<form name="" method="post" action="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>order_packingslip.php" id="fees" target="_blank">
				<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
				<input type="hidden" name="pfval" value="<?php echo $_a_val['AUCTIONID']; ?>">
				<input type="hidden" name="pfwon" value="<?php echo $_w_val['ID']; ?>">
				<input type="hidden" name="user_id" value="<?php echo (isset($this->_rootref['SELLER_ID'])) ? $this->_rootref['SELLER_ID'] : ''; ?>">
				<input type="submit" type="button" value="Print Packingslip">
			</form>
		</td>
	</tr>
	<?php }} }} if ($this->_rootref['NUM_WINNERS'] == 0) {  ?>
	<tr>
		<td colspan="5">
			<?php echo ((isset($this->_rootref['L_198'])) ? $this->_rootref['L_198'] : ((isset($MSG['198'])) ? $MSG['198'] : '{ L_198 }')); ?>
		</td>
	</tr>
<?php } ?>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>