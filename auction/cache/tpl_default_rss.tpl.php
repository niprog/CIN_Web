<?php echo (isset($this->_rootref['XML'])) ? $this->_rootref['XML'] : ''; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title><?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?> RSS: <?php echo (isset($this->_rootref['RSSTITLE'])) ? $this->_rootref['RSSTITLE'] : ''; ?></title>
		<link><?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?></link>
		<description><?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?></description>
		<copyright>Copyright <?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?>. The contents of this feed are available for non-commercial use only.</copyright>
		<generator><?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?></generator>
<?php $_rss_count = (isset($this->_tpldata['rss'])) ? sizeof($this->_tpldata['rss']) : 0;if ($_rss_count) {for ($_rss_i = 0; $_rss_i < $_rss_count; ++$_rss_i){$_rss_val = &$this->_tpldata['rss'][$_rss_i]; ?>
		<item>
			<title><![CDATA[<?php echo $_rss_val['TITLE']; ?> - <?php echo $_rss_val['PRICE']; ?>]]></title>
			<link><?php echo $_rss_val['URL']; ?></link>
			<guid isPermaLink="true"><?php echo $_rss_val['URL']; ?></guid>
			<description>
				<![CDATA[<?php echo $_rss_val['DESC']; ?><br /><?php echo $_rss_val['CAT']; ?>]]>
			</description>
			<dc:creator><?php echo $_rss_val['USER']; ?></dc:creator>
			<dc:date><?php echo $_rss_val['POSTED']; ?></dc:date>
		</item>
<?php }} ?>
	</channel>
</rss>