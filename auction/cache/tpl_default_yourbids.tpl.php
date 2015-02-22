<?php $this->_tpl_include('user_menu_header.tpl'); ?>
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center">
	<TR>
	<TD colspan="3">
		<TABLE WIDTH=200 HEIGHT=20 BORDER=0 CELLPADDING=0 CELLSPACING=0>
		<TD WIDTH=20 BGCOLOR="#FFFF00">&nbsp;</TD>
		<TD WIDTH=150><?php echo ((isset($this->_rootref['L_30_0098'])) ? $this->_rootref['L_30_0098'] : ((isset($MSG['30_0098'])) ? $MSG['30_0098'] : '{ L_30_0098 }')); ?></TD>
		</TR>
		</TABLE>
	</TD>
	</TR>
	<tr>
		<th align="center">
			<?php echo ((isset($this->_rootref['L_168'])) ? $this->_rootref['L_168'] : ((isset($MSG['168'])) ? $MSG['168'] : '{ L_168 }')); ?>
		</th>
		<th width="15%" align="center">
			<?php echo ((isset($this->_rootref['L_461'])) ? $this->_rootref['L_461'] : ((isset($MSG['461'])) ? $MSG['461'] : '{ L_461 }')); ?>
		</th>
		<th width="15%" align="center">
			<?php echo ((isset($this->_rootref['L_116'])) ? $this->_rootref['L_116'] : ((isset($MSG['116'])) ? $MSG['116'] : '{ L_116 }')); ?>
		</th>
		<th width="15%" align="center">
			<?php echo ((isset($this->_rootref['L_171'])) ? $this->_rootref['L_171'] : ((isset($MSG['171'])) ? $MSG['171'] : '{ L_171 }')); ?>
		</th>
	</tr>
<?php $_bids_count = (isset($this->_tpldata['bids'])) ? sizeof($this->_tpldata['bids']) : 0;if ($_bids_count) {for ($_bids_i = 0; $_bids_i < $_bids_count; ++$_bids_i){$_bids_val = &$this->_tpldata['bids'][$_bids_i]; ?>
	<tr <?php echo $_bids_val['BGCOLOUR']; ?>>
		<td align="left">
			<a href="item.php?id=<?php echo $_bids_val['ID']; ?>"><?php echo $_bids_val['TITLE']; ?></a>
		</td>
		<td>
			<?php echo $_bids_val['BID']; ?> <?php if ($_bids_val['QTY'] > (1)) {  ?>(x <?php echo $_bids_val['QTY']; ?> <?php echo ((isset($this->_rootref['L_5492'])) ? $this->_rootref['L_5492'] : ((isset($MSG['5492'])) ? $MSG['5492'] : '{ L_5492 }')); ?>)<?php } if ($_bids_val['PROXYBID'] != ('')) {  ?><p><span class="smallspan"><?php echo $_bids_val['PROXYBID']; ?></span></p><?php } ?>
		</td>
		<td>
			<?php echo $_bids_val['CBID']; ?>
		</td>
		<td align="center">
			<?php echo $_bids_val['TIMELEFT']; ?>
		</td>
	</tr>
<?php }} if ($this->_rootref['NUM_BIDS'] == 0) {  ?>
	<tr align="center">
		<td colspan="5">&nbsp;</td>
	</tr>
<?php } ?>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>