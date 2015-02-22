<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<script type="text/javascript">
$(document).ready(function() {
	var relist_fee = <?php echo (isset($this->_rootref['RELIST_FEE'])) ? $this->_rootref['RELIST_FEE'] : ''; ?>;
	$("#processrelist").submit(function() {
		if (confirm('<?php echo ((isset($this->_rootref['L_30_0087'])) ? $this->_rootref['L_30_0087'] : ((isset($MSG['30_0087'])) ? $MSG['30_0087'] : '{ L_30_0087 }')); ?>')){
			return true;
		} else {
			return false;
		}
	});
	$("#relistid").click(function(){
		if (this.is(':checked'))
			$("#to_pay").text(parseFloat($("#to_pay").text()) - relist_fee);
		else
			$("#to_pay").text(parseFloat($("#to_pay").text()) + relist_fee);
	});
});
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right">
			<dl class="tabs">
				<dd><a href="yourauctions_p.php"><?php echo ((isset($this->_rootref['L_25_0115'])) ? $this->_rootref['L_25_0115'] : ((isset($MSG['25_0115'])) ? $MSG['25_0115'] : '{ L_25_0115 }')); ?></a></dd>
				<dd><a href="yourauctions.php"><?php echo ((isset($this->_rootref['L_619'])) ? $this->_rootref['L_619'] : ((isset($MSG['619'])) ? $MSG['619'] : '{ L_619 }')); ?></a></dd>
				<dd><a href="yourauctions_c.php"><?php echo ((isset($this->_rootref['L_204'])) ? $this->_rootref['L_204'] : ((isset($MSG['204'])) ? $MSG['204'] : '{ L_204 }')); ?></a></dd>
				<dd><a href="yourauctions_s.php"><?php echo ((isset($this->_rootref['L_2__0056'])) ? $this->_rootref['L_2__0056'] : ((isset($MSG['2__0056'])) ? $MSG['2__0056'] : '{ L_2__0056 }')); ?></a></dd>
			</dl>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
	<tr>
		<td class="titTable1" width="40%">
			<a href="yourauctions_sold.php?solda_ord=title&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_624'])) ? $this->_rootref['L_624'] : ((isset($MSG['624'])) ? $MSG['624'] : '{ L_624 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('title')) {  ?>
			<a href="yourauctions_sold.php?solda_ord=title&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_sold.php?solda_ord=starts&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_625'])) ? $this->_rootref['L_625'] : ((isset($MSG['625'])) ? $MSG['625'] : '{ L_625 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('starts')) {  ?>
			<a href="yourauctions_sold.php?solda_ord=starts&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%">
			<a href="yourauctions_sold.php?solda_ord=ends&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_626'])) ? $this->_rootref['L_626'] : ((isset($MSG['626'])) ? $MSG['626'] : '{ L_626 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('ends')) {  ?>
			<a href="yourauctions_sold.php?solda_ord=ends&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%" align="center">
			<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_627'])) ? $this->_rootref['L_627'] : ((isset($MSG['627'])) ? $MSG['627'] : '{ L_627 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('num_bids')) {  ?>
			<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%" align="center">
			<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_628'])) ? $this->_rootref['L_628'] : ((isset($MSG['628'])) ? $MSG['628'] : '{ L_628 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('current_bid')) {  ?>
			<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
		</td>
		<td class="titTable1" width="10%">&nbsp;</td>
	</tr>
<?php $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
	<tr <?php echo $_items_val['BGCOLOUR']; ?>>
		<td width="40%">
			<a href="item.php?id=<?php echo $_items_val['ID']; ?>"><?php echo $_items_val['TITLE']; ?></a><br />
            <span class="smallspan"><a href="selling.php?id=<?php echo $_items_val['ID']; ?>"><?php echo ((isset($this->_rootref['L_900'])) ? $this->_rootref['L_900'] : ((isset($MSG['900'])) ? $MSG['900'] : '{ L_900 }')); ?></a></span>
		</td>
		<td width="10%">
			<?php echo $_items_val['STARTS']; ?>
		</td>
		<td width="10%">
			<?php echo $_items_val['ENDS']; ?>
		</td>
		<td width="10%" align="center">
			<?php echo $_items_val['BIDS']; ?>
		</td>
		<td align="center">
	<?php if ($_items_val['B_HASNOBIDS']) {  ?>
			-
	<?php } else { ?>
			<?php echo $_items_val['BID']; ?>
	<?php } ?>
		</td>
		<td width="10%" align="center">
	<?php if ($_items_val['B_CLOSED']) {  ?>
			<a href="sellsimilar.php?id=<?php echo $_items_val['ID']; ?>"><?php echo ((isset($this->_rootref['L_2__0050'])) ? $this->_rootref['L_2__0050'] : ((isset($MSG['2__0050'])) ? $MSG['2__0050'] : '{ L_2__0050 }')); ?></a>
	<?php } else { ?>
			-
	<?php } ?>
		</td>
	</tr>
<?php }} ?>
</table>

<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td align="center">
			<?php echo ((isset($this->_rootref['L_5117'])) ? $this->_rootref['L_5117'] : ((isset($MSG['5117'])) ? $MSG['5117'] : '{ L_5117 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>&nbsp;<?php echo ((isset($this->_rootref['L_5118'])) ? $this->_rootref['L_5118'] : ((isset($MSG['5118'])) ? $MSG['5118'] : '{ L_5118 }')); ?>&nbsp;<?php echo (isset($this->_rootref['PAGES'])) ? $this->_rootref['PAGES'] : ''; ?>
			<br>
			<?php echo (isset($this->_rootref['PREV'])) ? $this->_rootref['PREV'] : ''; ?>
<?php $_pages_count = (isset($this->_tpldata['pages'])) ? sizeof($this->_tpldata['pages']) : 0;if ($_pages_count) {for ($_pages_i = 0; $_pages_i < $_pages_count; ++$_pages_i){$_pages_val = &$this->_tpldata['pages'][$_pages_i]; ?>
			<?php echo $_pages_val['PAGE']; ?>&nbsp;&nbsp;
<?php }} ?>
			<?php echo (isset($this->_rootref['NEXT'])) ? $this->_rootref['NEXT'] : ''; ?>
		</td>
	</tr>
</table>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>