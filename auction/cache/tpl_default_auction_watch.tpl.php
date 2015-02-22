<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0" >
	<tr>
		<td colspan="2" height="1">&nbsp;</td>
	</tr>
<?php $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
	<tr>
		<td><?php echo $_items_val['ITEM']; ?></td>
		<td align="right">
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>auction_watch.php?delete=<?php echo $_items_val['ITEMENCODE']; ?>"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/trash.gif" border="0" alt="delete"></a>
		</td>
	</tr>
<?php }} ?>
	<tr>
		<td bgcolor="#DDDDDD" colspan=2>
			<?php echo ((isset($this->_rootref['L_25_0084'])) ? $this->_rootref['L_25_0084'] : ((isset($MSG['25_0084'])) ? $MSG['25_0084'] : '{ L_25_0084 }')); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<form action="auction_watch.php?insert=true" method="post">
            <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
			<input type="text" size="60" name="add">
			<input type="submit" value="<?php echo ((isset($this->_rootref['L_5204'])) ? $this->_rootref['L_5204'] : ((isset($MSG['5204'])) ? $MSG['5204'] : '{ L_5204 }')); ?>" class="button">
			</form>
		</td>
	</tr>
</table>
<div align="center"><?php echo ((isset($this->_rootref['L_30_0210'])) ? $this->_rootref['L_30_0210'] : ((isset($MSG['30_0210'])) ? $MSG['30_0210'] : '{ L_30_0210 }')); ?></div>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>