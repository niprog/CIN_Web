<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<script type="text/javascript">
$(document).ready(function() {
	$("#startall").click(function() {
		var checked_status = this.checked;
		$("input[name='startnow[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#deleteall").click(function() {
		var checked_status = this.checked;
		$("input[name='O_delete[]']").each(function() {
			this.checked = checked_status;
		});
	});
	$("#processdel").submit(function() {
		if (confirm('<?php echo ((isset($this->_rootref['L_30_0087'])) ? $this->_rootref['L_30_0087'] : ((isset($MSG['30_0087'])) ? $MSG['30_0087'] : '{ L_30_0087 }')); ?>')){
			return true;
		} else {
			return false;
		}
	});
});
</script>
<form name="open" method="post" action="" id="processdel">
<input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right">
			<dl class="tabs">
				<dd><a href="yourauctions.php"><?php echo ((isset($this->_rootref['L_619'])) ? $this->_rootref['L_619'] : ((isset($MSG['619'])) ? $MSG['619'] : '{ L_619 }')); ?></a></dd>
				<dd><a href="yourauctions_c.php"><?php echo ((isset($this->_rootref['L_204'])) ? $this->_rootref['L_204'] : ((isset($MSG['204'])) ? $MSG['204'] : '{ L_204 }')); ?></a></dd>
				<dd><a href="yourauctions_s.php"><?php echo ((isset($this->_rootref['L_2__0056'])) ? $this->_rootref['L_2__0056'] : ((isset($MSG['2__0056'])) ? $MSG['2__0056'] : '{ L_2__0056 }')); ?></a></dd>
				<dd><a href="yourauctions_sold.php"><?php echo ((isset($this->_rootref['L_25_0119'])) ? $this->_rootref['L_25_0119'] : ((isset($MSG['25_0119'])) ? $MSG['25_0119'] : '{ L_25_0119 }')); ?></a></dd>
			</dl>
		</td>
	</tr>
</table>
	<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
	<tr>
			<td class="titTable1">
				<a href="yourauctions_p.php?pa_ord=title&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_624'])) ? $this->_rootref['L_624'] : ((isset($MSG['624'])) ? $MSG['624'] : '{ L_624 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('title')) {  ?>
				<a href="yourauctions_p.php?pa_ord=title&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
			</td>
			<td class="titTable1" width="15%">
				<a href="yourauctions_p.php?pa_ord=starts&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_25_0116'])) ? $this->_rootref['L_25_0116'] : ((isset($MSG['25_0116'])) ? $MSG['25_0116'] : '{ L_25_0116 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('starts')) {  ?>
				<a href="yourauctions_p.php?pa_ord=starts&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
			</td>
			<td class="titTable1" width="15%">
				<a href="yourauctions_p.php?pa_ord=ends&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_25_0117'])) ? $this->_rootref['L_25_0117'] : ((isset($MSG['25_0117'])) ? $MSG['25_0117'] : '{ L_25_0117 }')); ?></a>
<?php if ($this->_rootref['ORDERCOL'] == ('ends')) {  ?>
				<a href="yourauctions_p.php?pa_ord=ends&pa_type=<?php echo (isset($this->_rootref['ORDERNEXT'])) ? $this->_rootref['ORDERNEXT'] : ''; ?>"><?php echo (isset($this->_rootref['ORDERTYPEIMG'])) ? $this->_rootref['ORDERTYPEIMG'] : ''; ?></a>
<?php } ?>
			</td>
			<td class="titTable1" width="10%" align="center">
				<?php echo ((isset($this->_rootref['L_298'])) ? $this->_rootref['L_298'] : ((isset($MSG['298'])) ? $MSG['298'] : '{ L_298 }')); ?>
			</td>
			<td class="titTable1" width="10%" align="center">
				<?php echo ((isset($this->_rootref['L_008'])) ? $this->_rootref['L_008'] : ((isset($MSG['008'])) ? $MSG['008'] : '{ L_008 }')); ?>
			</td>
			<td class="titTable1" width="9%" align="center" bgcolor="#FFFF00">
				<?php echo ((isset($this->_rootref['L_25_0118'])) ? $this->_rootref['L_25_0118'] : ((isset($MSG['25_0118'])) ? $MSG['25_0118'] : '{ L_25_0118 }')); ?>
			</td>
		</tr>
<?php if ($this->_rootref['B_AREITEMS']) {  $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
		<tr <?php echo $_items_val['BGCOLOUR']; ?>>
			<td width="32%">
				<a href="item.php?id=<?php echo $_items_val['ID']; ?>"><?php echo $_items_val['TITLE']; ?></a>
			</td>
			<td width="11%" bgcolor="#FFFFAA">
				<?php echo $_items_val['STARTS']; ?>
			</td>
			<td width="11%">
				<?php echo $_items_val['ENDS']; ?>
			</td>
			<td width="6%"  align="center">
		<?php if ($_items_val['B_HASNOBIDS']) {  ?>
				<a href="edit_active_auction.php?id=<?php echo $_items_val['ID']; ?>"><img src="images/edititem.gif" width="13" height="17" alt="<?php echo ((isset($this->_rootref['L_512'])) ? $this->_rootref['L_512'] : ((isset($MSG['512'])) ? $MSG['512'] : '{ L_512 }')); ?>" border="0"></a>
		<?php } ?>
			</td>
			<td width="8%" align="center">
		<?php if ($_items_val['B_HASNOBIDS']) {  ?>
				<input type="checkbox" name="O_delete[]" value="<?php echo $_items_val['ID']; ?>">
		<?php } ?>
			</td>
			<td width="6%" align="center">
				<input type="checkbox" name="startnow[]" value="<?php echo $_items_val['ID']; ?>">
			</td>
		</tr>
	<?php }} } ?>
	<tr <?php echo (isset($this->_rootref['BGCOLOUR'])) ? $this->_rootref['BGCOLOUR'] : ''; ?>>
	  <td colspan="4" align="right"><?php echo ((isset($this->_rootref['L_30_0102'])) ? $this->_rootref['L_30_0102'] : ((isset($MSG['30_0102'])) ? $MSG['30_0102'] : '{ L_30_0102 }')); ?></td>
	  <td align="center"><input type="checkbox" id="deleteall"></td>
	  <td align="center"><input type="checkbox" id="startall"></td>
	</tr>
		<tr>
			<td colspan="10" align="center">
				<input type="hidden" name="action" value="delopenauctions">
				<input type="submit" name="Submit" value="<?php echo ((isset($this->_rootref['L_631'])) ? $this->_rootref['L_631'] : ((isset($MSG['631'])) ? $MSG['631'] : '{ L_631 }')); ?>" class="button">
			</td>
		</tr>
	</table>
</form>

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