<?php $this->_tpl_include('user_menu_header.tpl'); ?>

<div class="padding">
	<table width="98%" cellpadding="1" cellspacing="0" border="0">
<?php $_items_count = (isset($this->_tpldata['items'])) ? sizeof($this->_tpldata['items']) : 0;if ($_items_count) {for ($_items_i = 0; $_items_i < $_items_count; ++$_items_i){$_items_val = &$this->_tpldata['items'][$_items_i]; ?>
		<tr align="center" <?php echo $_items_val['ROWCOLOUR']; ?>>
			<td align="center" width="15%">
				<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo $_items_val['ID']; ?>"><img src="<?php echo $_items_val['IMAGE']; ?>" border="0"></a>
			</td>
			<td align="left"<?php if ($_items_val['B_BOLD']) {  ?> style="font-weight: bold;"<?php } ?>>
                <a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo $_items_val['ID']; ?>" class="bigfont"><?php echo $_items_val['TITLE']; ?></a>
				<?php if ($this->_rootref['B_SUBTITLE'] && $_items_val['SUBTITLE'] != ('')) {  ?><p class="smallspan"><?php echo $_items_val['SUBTITLE']; ?></p><?php } ?>
				<p><?php echo ((isset($this->_rootref['L_949'])) ? $this->_rootref['L_949'] : ((isset($MSG['949'])) ? $MSG['949'] : '{ L_949 }')); ?> <?php echo $_items_val['CLOSES']; ?></p>
			</td>
			<td align="center" width="15%">
	<?php if ($_items_val['BUY_NOW'] != ('')) {  ?>
				<span class="redfont bigfont"><?php echo $_items_val['BUY_NOW']; ?></span>
	<?php } else { ?>
				<span class="grayfont"><?php echo ((isset($this->_rootref['L_951'])) ? $this->_rootref['L_951'] : ((isset($MSG['951'])) ? $MSG['951'] : '{ L_951 }')); ?></span>
	<?php } ?>
			</td>
			<td align="center" width="15%">
				<span class="bigfont"><?php echo $_items_val['BIDFORM']; ?></span>
				<p class="smallspan"><?php echo $_items_val['NUMBIDS']; ?></p>
			</td>
			<td width="10%" align="center">
				<a href="item_watch.php?delete=<?php echo $_items_val['ID']; ?>"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/trash.gif" border="0"></a>
			</td>
		</tr>
<?php }} else { ?>
		<tr align="center">
			<td align="center" colspan="6">
				<?php echo ((isset($this->_rootref['L_853'])) ? $this->_rootref['L_853'] : ((isset($MSG['853'])) ? $MSG['853'] : '{ L_853 }')); ?>
			</td>
		</tr>
<?php } ?>
	</table>
</div>

<?php $this->_tpl_include('user_menu_footer.tpl'); ?>