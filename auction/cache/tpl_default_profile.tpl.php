<div class="content">
<div class="tableContent2">
	<div class="titTable2 rounded-top rounded-bottom">
		<?php echo ((isset($this->_rootref['L_206'])) ? $this->_rootref['L_206'] : ((isset($MSG['206'])) ? $MSG['206'] : '{ L_206 }')); ?>
	</div>
<?php if ($this->_rootref['B_VIEW']) {  ?>
		<div class="titTable3">
<?php if ($this->_rootref['B_AUCID']) {  ?>
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>item.php?id=<?php echo (isset($this->_rootref['AUCTION_ID'])) ? $this->_rootref['AUCTION_ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_138'])) ? $this->_rootref['L_138'] : ((isset($MSG['138'])) ? $MSG['138'] : '{ L_138 }')); ?></a> | 
<?php } ?>
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>active_auctions.php?user_id=<?php echo (isset($this->_rootref['USER_ID'])) ? $this->_rootref['USER_ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_213'])) ? $this->_rootref['L_213'] : ((isset($MSG['213'])) ? $MSG['213'] : '{ L_213 }')); ?></a> | 
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>closed_auctions.php?user_id=<?php echo (isset($this->_rootref['USER_ID'])) ? $this->_rootref['USER_ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_214'])) ? $this->_rootref['L_214'] : ((isset($MSG['214'])) ? $MSG['214'] : '{ L_214 }')); ?></a> | 
<?php if ($this->_rootref['B_CONTACT']) {  ?>
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>email_request.php?user_id=<?php echo (isset($this->_rootref['USER_ID'])) ? $this->_rootref['USER_ID'] : ''; ?>&amp;username=<?php echo (isset($this->_rootref['USER'])) ? $this->_rootref['USER'] : ''; ?>&amp;auction_id=<?php echo (isset($this->_rootref['AUCTION_ID'])) ? $this->_rootref['AUCTION_ID'] : ''; ?>"><?php echo ((isset($this->_rootref['L_210'])) ? $this->_rootref['L_210'] : ((isset($MSG['210'])) ? $MSG['210'] : '{ L_210 }')); echo (isset($this->_rootref['USER'])) ? $this->_rootref['USER'] : ''; ?></a> | 
<?php } ?>
			<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>feedback.php?id=<?php echo (isset($this->_rootref['USER_ID'])) ? $this->_rootref['USER_ID'] : ''; ?>&amp;faction=show"><?php echo ((isset($this->_rootref['L_208'])) ? $this->_rootref['L_208'] : ((isset($MSG['208'])) ? $MSG['208'] : '{ L_208 }')); ?></a>
		</div>
	<div class="padding">		
		<div class="table2">
			<table width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr>
					<td width="45%" valign="top">
						<b><?php echo (isset($this->_rootref['USER'])) ? $this->_rootref['USER'] : ''; ?> (<?php echo (isset($this->_rootref['SUM_FB'])) ? $this->_rootref['SUM_FB'] : ''; ?>)</b><?php echo (isset($this->_rootref['RATE_VAL'])) ? $this->_rootref['RATE_VAL'] : ''; ?><br>
						<?php echo ((isset($this->_rootref['L_209'])) ? $this->_rootref['L_209'] : ((isset($MSG['209'])) ? $MSG['209'] : '{ L_209 }')); ?> <b><?php echo (isset($this->_rootref['REGSINCE'])) ? $this->_rootref['REGSINCE'] : ''; ?></b><br>
						<?php echo ((isset($this->_rootref['L_240'])) ? $this->_rootref['L_240'] : ((isset($MSG['240'])) ? $MSG['240'] : '{ L_240 }')); ?> <b><?php echo (isset($this->_rootref['COUNTRY'])) ? $this->_rootref['COUNTRY'] : ''; ?></b><br>
						<?php echo ((isset($this->_rootref['L_502'])) ? $this->_rootref['L_502'] : ((isset($MSG['502'])) ? $MSG['502'] : '{ L_502 }')); ?> <b><?php echo (isset($this->_rootref['NUM_FB'])) ? $this->_rootref['NUM_FB'] : ''; ?></b><br>
						<?php echo (isset($this->_rootref['FB_POS'])) ? $this->_rootref['FB_POS'] : ''; ?>
						<?php echo (isset($this->_rootref['FB_NEUT'])) ? $this->_rootref['FB_NEUT'] : ''; ?>
						<?php echo (isset($this->_rootref['FB_NEG'])) ? $this->_rootref['FB_NEG'] : ''; ?>
					</td>
					<td valign="top">
						<table width="100%" border="0" cellspacing="2" cellpadding="3">
						<tr>
						   <td colspan="4" class="titTable2"><?php echo ((isset($this->_rootref['L_385'])) ? $this->_rootref['L_385'] : ((isset($MSG['385'])) ? $MSG['385'] : '{ L_385 }')); ?></td>
						</tr>
						<tr>
						   <td width="25%">&nbsp;</td>
						   <td align="center" width="25%"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/positive.png"></td>
						   <td align="center" width="25%"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/neutral.png"></td>
						   <td align="center" width="25%"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/negative.png"></td>
						</tr>
						<tr valign="top">
							<td colspan="4" bgcolor="#eeeeee"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/transparent.gif" width="1" height="5"></td>
						</tr>
						<tr>
						   <td><?php echo ((isset($this->_rootref['L_386'])) ? $this->_rootref['L_386'] : ((isset($MSG['386'])) ? $MSG['386'] : '{ L_386 }')); ?></td>
						   <td align="center" style="color:#009933"><?php echo (isset($this->_rootref['FB_LASTMONTH_POS'])) ? $this->_rootref['FB_LASTMONTH_POS'] : ''; ?></td>
						   <td align="center"><?php echo (isset($this->_rootref['FB_LASTMONTH_NEUT'])) ? $this->_rootref['FB_LASTMONTH_NEUT'] : ''; ?></td>
						   <td align="center" style="color:#FF0000"><?php echo (isset($this->_rootref['FB_LASTMONTH_NEG'])) ? $this->_rootref['FB_LASTMONTH_NEG'] : ''; ?></td>
						</tr>
						<tr>
						   <td><?php echo ((isset($this->_rootref['L_387'])) ? $this->_rootref['L_387'] : ((isset($MSG['387'])) ? $MSG['387'] : '{ L_387 }')); ?></td>
						   <td align="center" style="color:#009933"><?php echo (isset($this->_rootref['FB_LAST3MONTH_POS'])) ? $this->_rootref['FB_LAST3MONTH_POS'] : ''; ?></td>
						   <td align="center"><?php echo (isset($this->_rootref['FB_LAST3MONTH_NEUT'])) ? $this->_rootref['FB_LAST3MONTH_NEUT'] : ''; ?></td>
						   <td align="center" style="color:#FF0000"><?php echo (isset($this->_rootref['FB_LAST3MONTH_NEG'])) ? $this->_rootref['FB_LAST3MONTH_NEG'] : ''; ?></td>
						</tr>
						<tr>
						   <td><?php echo ((isset($this->_rootref['L_388'])) ? $this->_rootref['L_388'] : ((isset($MSG['388'])) ? $MSG['388'] : '{ L_388 }')); ?></td>
						   <td align="center" style="color:#009933"><?php echo (isset($this->_rootref['FB_LASTYEAR_POS'])) ? $this->_rootref['FB_LASTYEAR_POS'] : ''; ?></td>
						   <td align="center"><?php echo (isset($this->_rootref['FB_LASTYEAR_NEUT'])) ? $this->_rootref['FB_LASTYEAR_NEUT'] : ''; ?></td>
						   <td align="center" style="color:#FF0000"><?php echo (isset($this->_rootref['FB_LASTYEAR_NEG'])) ? $this->_rootref['FB_LASTYEAR_NEG'] : ''; ?></td>
						</tr>
						<tr valign="top">
							<td colspan="4" bgcolor="#eeeeee"><img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>images/transparent.gif" width="1" height="5"></td>
						</tr>
						<tr>
						   <td><?php echo ((isset($this->_rootref['L_389'])) ? $this->_rootref['L_389'] : ((isset($MSG['389'])) ? $MSG['389'] : '{ L_389 }')); ?></td>
						   <td align="center" style="color:#009933"><?php echo (isset($this->_rootref['FB_SELLER_POS'])) ? $this->_rootref['FB_SELLER_POS'] : ''; ?></td>
						   <td align="center"><?php echo (isset($this->_rootref['FB_SELLER_NEUT'])) ? $this->_rootref['FB_SELLER_NEUT'] : ''; ?></td>
						   <td align="center" style="color:#FF0000"><?php echo (isset($this->_rootref['FB_SELLER_NEG'])) ? $this->_rootref['FB_SELLER_NEG'] : ''; ?></td>
						</tr>
						<tr>
						   <td><?php echo ((isset($this->_rootref['L_390'])) ? $this->_rootref['L_390'] : ((isset($MSG['390'])) ? $MSG['390'] : '{ L_390 }')); ?></td>
						   <td align="center" style="color:#009933"><?php echo (isset($this->_rootref['FB_BUYER_POS'])) ? $this->_rootref['FB_BUYER_POS'] : ''; ?></td>
						   <td align="center"><?php echo (isset($this->_rootref['FB_BUYER_NEUT'])) ? $this->_rootref['FB_BUYER_NEUT'] : ''; ?></td>
						   <td align="center" style="color:#FF0000"><?php echo (isset($this->_rootref['FB_BUYER_NEG'])) ? $this->_rootref['FB_BUYER_NEG'] : ''; ?></td>
						</tr>
					 </table>
					</td>
				</tr>
			</table>
		</div>
<?php } else { ?>
	<div class="padding">
		<?php echo (isset($this->_rootref['MSG'])) ? $this->_rootref['MSG'] : ''; ?>
<?php } ?>
	</div>
</div>
</div>