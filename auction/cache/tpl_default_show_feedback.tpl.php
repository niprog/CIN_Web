<div class="content">
	<div class="tableContent2">
		<div class="titTable2">
			<?php echo ((isset($this->_rootref['L_208'])) ? $this->_rootref['L_208'] : ((isset($MSG['208'])) ? $MSG['208'] : '{ L_208 }')); ?>
		</div>
		<div class="titTable3">
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo (isset($this->_rootref['AUCT_ID'])) ? $this->_rootref['AUCT_ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_138'])) ? $this->_rootref['L_138'] : ((isset($MSG['138'])) ? $MSG['138'] : '{ L_138 }')); ?></a> |
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>profile.php?user_id=<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_505'])) ? $this->_rootref['L_505'] : ((isset($MSG['505'])) ? $MSG['505'] : '{ L_505 }')); ?></a>
		</div>
		<div class="table2">
			<table border="0" width="100%" cellspacing="0" cellpadding="4">
				<tr>
					<td colspan=5>
						<?php echo ((isset($this->_rootref['L_185'])) ? $this->_rootref['L_185'] : ((isset($MSG['185'])) ? $MSG['185'] : '{ L_185 }')); echo (isset($this->_rootref['USERNICK'])) ? $this->_rootref['USERNICK'] : ''; ?> (<?php echo (isset($this->_rootref['USERFB'])) ? $this->_rootref['USERFB'] : ''; ?>) <?php echo (isset($this->_rootref['USERFBIMG'])) ? $this->_rootref['USERFBIMG'] : ''; ?>
						<br>
						<br>
					</td>
				</tr>
				<tr class="titTable2">
					<td width="5%">&nbsp;</td>
					<td width="40%"><?php echo ((isset($this->_rootref['L_503'])) ? $this->_rootref['L_503'] : ((isset($MSG['503'])) ? $MSG['503'] : '{ L_503 }')); ?></td>
					<td width="15%"><?php echo ((isset($this->_rootref['L_240'])) ? $this->_rootref['L_240'] : ((isset($MSG['240'])) ? $MSG['240'] : '{ L_240 }')); ?></td>
					<td width="15%"><?php echo ((isset($this->_rootref['L_259'])) ? $this->_rootref['L_259'] : ((isset($MSG['259'])) ? $MSG['259'] : '{ L_259 }')); ?></td>
					<td width="15%"><?php echo ((isset($this->_rootref['L_364'])) ? $this->_rootref['L_364'] : ((isset($MSG['364'])) ? $MSG['364'] : '{ L_364 }')); ?></td>
				</tr>
<?php $_fbs_count = (isset($this->_tpldata['fbs'])) ? sizeof($this->_tpldata['fbs']) : 0;if ($_fbs_count) {for ($_fbs_i = 0; $_fbs_i < $_fbs_count; ++$_fbs_i){$_fbs_val = &$this->_tpldata['fbs'][$_fbs_i]; ?>
				<tr <?php echo $_fbs_val['BGCOLOUR']; ?>>
					<td>
						<img src="<?php echo $_fbs_val['IMG']; ?>" align="middle" alt="">
					</td>
					<td>
						<?php echo $_fbs_val['FEEDBACK']; ?>
					</td>
					<td>
						<a href="<?php echo $_fbs_val['USFLINK']; ?>"><?php echo $_fbs_val['USERNAME']; ?></a> (<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>feedback.php?id=<?php echo $_fbs_val['USERID']; ?>&faction=show"><?php echo $_fbs_val['USFEED']; ?></a>) <?php echo $_fbs_val['USICON']; ?>
					</td>
					<td>
						<?php echo $_fbs_val['AUCTIONURL']; ?>
					</td>
					<td>
						<?php echo $_fbs_val['FBDATE']; ?>
					</td>
				</tr>
<?php }} ?>
				<tr>
					<td align="center" colspan="5"><?php echo (isset($this->_rootref['PAGENATION'])) ? $this->_rootref['PAGENATION'] : ''; ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>