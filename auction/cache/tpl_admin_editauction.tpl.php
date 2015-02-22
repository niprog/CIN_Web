<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_239'])) ? $this->_rootref['L_239'] : ((isset($MSG['239'])) ? $MSG['239'] : '{ L_239 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_512'])) ? $this->_rootref['L_512'] : ((isset($MSG['512'])) ? $MSG['512'] : '{ L_512 }')); ?></h4>
				<form name="editauction" action="" method="post">
<?php if ($this->_rootref['ERROR'] != ('')) {  ?>
					<div class="error-box"><b><?php echo (isset($this->_rootref['ERROR'])) ? $this->_rootref['ERROR'] : ''; ?></b></div>
<?php } ?>
					<table width="98%" cellpadding="0" cellspacing="0" class="blank">
                    <tr>
                        <td width="25%" align="right"><?php echo ((isset($this->_rootref['L_313'])) ? $this->_rootref['L_313'] : ((isset($MSG['313'])) ? $MSG['313'] : '{ L_313 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['USER'])) ? $this->_rootref['USER'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_017'])) ? $this->_rootref['L_017'] : ((isset($MSG['017'])) ? $MSG['017'] : '{ L_017 }')); ?></td>
                        <td><input type="text" name="title" size="40" maxlength="255" value="<?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_806'])) ? $this->_rootref['L_806'] : ((isset($MSG['806'])) ? $MSG['806'] : '{ L_806 }')); ?></td>
                        <td><input type="text" name="subtitle" size="40" maxlength="255" value="<?php echo (isset($this->_rootref['SUBTITLE'])) ? $this->_rootref['SUBTITLE'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_287'])) ? $this->_rootref['L_287'] : ((isset($MSG['287'])) ? $MSG['287'] : '{ L_287 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['CATLIST1'])) ? $this->_rootref['CATLIST1'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_814'])) ? $this->_rootref['L_814'] : ((isset($MSG['814'])) ? $MSG['814'] : '{ L_814 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['CATLIST2'])) ? $this->_rootref['CATLIST2'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_018'])) ? $this->_rootref['L_018'] : ((isset($MSG['018'])) ? $MSG['018'] : '{ L_018 }')); ?></td>
                        <td><textarea name="description" cols="40" rows="8"><?php echo (isset($this->_rootref['DESC'])) ? $this->_rootref['DESC'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_258'])) ? $this->_rootref['L_258'] : ((isset($MSG['258'])) ? $MSG['258'] : '{ L_258 }')); ?></td>
                        <td><input type="text" name="quantity" size="40" maxlength="40" value="<?php echo (isset($this->_rootref['QTY'])) ? $this->_rootref['QTY'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_022'])) ? $this->_rootref['L_022'] : ((isset($MSG['022'])) ? $MSG['022'] : '{ L_022 }')); ?></td>
                        <td>
                            <select name="duration">
                                <option value=""> </option>
                                <?php echo (isset($this->_rootref['DURLIST'])) ? $this->_rootref['DURLIST'] : ''; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
                            <b><?php echo ((isset($this->_rootref['L_816'])) ? $this->_rootref['L_816'] : ((isset($MSG['816'])) ? $MSG['816'] : '{ L_816 }')); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
							<div><?php echo ((isset($this->_rootref['L_1105'])) ? $this->_rootref['L_1105'] : ((isset($MSG['1105'])) ? $MSG['1105'] : '{ L_1105 }')); ?></div>
<?php $_gallery_count = (isset($this->_tpldata['gallery'])) ? sizeof($this->_tpldata['gallery']) : 0;if ($_gallery_count) {for ($_gallery_i = 0; $_gallery_i < $_gallery_count; ++$_gallery_i){$_gallery_val = &$this->_tpldata['gallery'][$_gallery_i]; ?>
							<div style="width:50px; float: left;">
								<a href="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>/<?php echo $_gallery_val['V']; ?>" title="<?php echo $_gallery_val['V']; ?>" target="_blank">
									<img src="<?php echo (isset($this->_rootref['SITEURL'])) ? $this->_rootref['SITEURL'] : ''; ?>getthumb.php?fromfile=<?php echo $_gallery_val['V']; ?>" border="0" hspace="10">
								</a>
								<input type="checkbox" name="gallery[]" value="<?php echo $_gallery_val['V']; ?>">
							</div>
<?php }} ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
                            <b><?php echo ((isset($this->_rootref['L_817'])) ? $this->_rootref['L_817'] : ((isset($MSG['817'])) ? $MSG['817'] : '{ L_817 }')); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_257'])) ? $this->_rootref['L_257'] : ((isset($MSG['257'])) ? $MSG['257'] : '{ L_257 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['ATYPE'])) ? $this->_rootref['ATYPE'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_116'])) ? $this->_rootref['L_116'] : ((isset($MSG['116'])) ? $MSG['116'] : '{ L_116 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['CURRENT_BID'])) ? $this->_rootref['CURRENT_BID'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_124'])) ? $this->_rootref['L_124'] : ((isset($MSG['124'])) ? $MSG['124'] : '{ L_124 }')); ?></td>
                        <td><input type="text" name="min_bid" size="40" maxlength="40" value="<?php echo (isset($this->_rootref['MIN_BID'])) ? $this->_rootref['MIN_BID'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_023'])) ? $this->_rootref['L_023'] : ((isset($MSG['023'])) ? $MSG['023'] : '{ L_023 }')); ?></td>
                        <td><input type="text" name="shipping_cost" size="40" maxlength="40" value="<?php echo (isset($this->_rootref['SHIPPING_COST'])) ? $this->_rootref['SHIPPING_COST'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_021'])) ? $this->_rootref['L_021'] : ((isset($MSG['021'])) ? $MSG['021'] : '{ L_021 }')); ?></td>
                        <td><input type="text" name="reserve_price" size="40" maxlength="40" value="<?php echo (isset($this->_rootref['RESERVE'])) ? $this->_rootref['RESERVE'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_30_0063'])) ? $this->_rootref['L_30_0063'] : ((isset($MSG['30_0063'])) ? $MSG['30_0063'] : '{ L_30_0063 }')); ?></td>
                        <td>
                            <input type="radio" name="buy_now_only" value="n" <?php echo (isset($this->_rootref['BN_ONLY_N'])) ? $this->_rootref['BN_ONLY_N'] : ''; ?>> <?php echo ((isset($this->_rootref['L_029'])) ? $this->_rootref['L_029'] : ((isset($MSG['029'])) ? $MSG['029'] : '{ L_029 }')); ?>
                            <input type="radio" name="buy_now_only" value="y" <?php echo (isset($this->_rootref['BN_ONLY_Y'])) ? $this->_rootref['BN_ONLY_Y'] : ''; ?>> <?php echo ((isset($this->_rootref['L_030'])) ? $this->_rootref['L_030'] : ((isset($MSG['030'])) ? $MSG['030'] : '{ L_030 }')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_497'])) ? $this->_rootref['L_497'] : ((isset($MSG['497'])) ? $MSG['497'] : '{ L_497 }')); ?></td>
                        <td><input type="text" name="buy_now" size="40" maxlength="40" value="<?php echo (isset($this->_rootref['BN_PRICE'])) ? $this->_rootref['BN_PRICE'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_120'])) ? $this->_rootref['L_120'] : ((isset($MSG['120'])) ? $MSG['120'] : '{ L_120 }')); ?></td>
                        <td>
                            <input type="text" name="customincrement" size="10" value="<?php echo (isset($this->_rootref['CUSTOM_INC'])) ? $this->_rootref['CUSTOM_INC'] : ''; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
                            <b><?php echo ((isset($this->_rootref['L_319'])) ? $this->_rootref['L_319'] : ((isset($MSG['319'])) ? $MSG['319'] : '{ L_319 }')); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><?php echo ((isset($this->_rootref['L_025'])) ? $this->_rootref['L_025'] : ((isset($MSG['025'])) ? $MSG['025'] : '{ L_025 }')); ?></td>
                        <td>
                            <input type="radio" name="shipping" value="1" <?php echo (isset($this->_rootref['SHIPPING1'])) ? $this->_rootref['SHIPPING1'] : ''; ?>>	<?php echo ((isset($this->_rootref['L_031'])) ? $this->_rootref['L_031'] : ((isset($MSG['031'])) ? $MSG['031'] : '{ L_031 }')); ?><br>
                            <input type="radio" name="shipping" value="2" <?php echo (isset($this->_rootref['SHIPPING2'])) ? $this->_rootref['SHIPPING2'] : ''; ?>>	<?php echo ((isset($this->_rootref['L_032'])) ? $this->_rootref['L_032'] : ((isset($MSG['032'])) ? $MSG['032'] : '{ L_032 }')); ?><br>
                            <input type="checkbox" name="international" value="1" <?php echo (isset($this->_rootref['INTERNATIONAL'])) ? $this->_rootref['INTERNATIONAL'] : ''; ?>> <?php echo ((isset($this->_rootref['L_033'])) ? $this->_rootref['L_033'] : ((isset($MSG['033'])) ? $MSG['033'] : '{ L_033 }')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><?php echo ((isset($this->_rootref['L_25_0215'])) ? $this->_rootref['L_25_0215'] : ((isset($MSG['25_0215'])) ? $MSG['25_0215'] : '{ L_25_0215 }')); ?></td>
                        <td><textarea name="shipping_terms" rows="3" cols="34"><?php echo (isset($this->_rootref['SHIPPING_TERMS'])) ? $this->_rootref['SHIPPING_TERMS'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:3px; border-top:#0083D7 1px solid; background:#ECECEC;">
                            <b><?php echo ((isset($this->_rootref['L_5233'])) ? $this->_rootref['L_5233'] : ((isset($MSG['5233'])) ? $MSG['5233'] : '{ L_5233 }')); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><?php echo ((isset($this->_rootref['L_026'])) ? $this->_rootref['L_026'] : ((isset($MSG['026'])) ? $MSG['026'] : '{ L_026 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['PAYMENTS'])) ? $this->_rootref['PAYMENTS'] : ''; ?></td>
                    </tr>
	<?php if ($this->_rootref['B_MKFEATURED'] || $this->_rootref['B_MKBOLD'] || $this->_rootref['B_MKHIGHLIGHT']) {  ?>
                    <tr>
                        <td align="right" valign="top"><?php echo ((isset($this->_rootref['L_268'])) ? $this->_rootref['L_268'] : ((isset($MSG['268'])) ? $MSG['268'] : '{ L_268 }')); ?></td>
                        <td>
        <?php if ($this->_rootref['B_MKFEATURED']) {  ?>
							<p><input type="checkbox" name="is_featured" <?php echo (isset($this->_rootref['IS_FEATURED'])) ? $this->_rootref['IS_FEATURED'] : ''; ?>> <?php echo ((isset($this->_rootref['L_273'])) ? $this->_rootref['L_273'] : ((isset($MSG['273'])) ? $MSG['273'] : '{ L_273 }')); ?></p>
        <?php } if ($this->_rootref['B_MKBOLD']) {  ?>
        					<p><input type="checkbox" name="is_bold" <?php echo (isset($this->_rootref['IS_BOLD'])) ? $this->_rootref['IS_BOLD'] : ''; ?>> <?php echo ((isset($this->_rootref['L_274'])) ? $this->_rootref['L_274'] : ((isset($MSG['274'])) ? $MSG['274'] : '{ L_274 }')); ?></p>
        <?php } if ($this->_rootref['B_MKHIGHLIGHT']) {  ?>
        					<p><input type="checkbox" name="is_highlighted" <?php echo (isset($this->_rootref['IS_HIGHLIGHTED'])) ? $this->_rootref['IS_HIGHLIGHTED'] : ''; ?>> <?php echo ((isset($this->_rootref['L_292'])) ? $this->_rootref['L_292'] : ((isset($MSG['292'])) ? $MSG['292'] : '{ L_292 }')); ?></p>
        <?php } ?>
                        </td>
                    </tr>
	<?php } ?>
                    <tr>
                        <td align="right"><?php echo ((isset($this->_rootref['L_300'])) ? $this->_rootref['L_300'] : ((isset($MSG['300'])) ? $MSG['300'] : '{ L_300 }')); ?></td>
                        <td><?php echo (isset($this->_rootref['SUSPENDED'])) ? $this->_rootref['SUSPENDED'] : ''; ?></td>
                    </tr>
                    </table>
                    <input type="hidden" name="id" value="<?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="csrftoken" value="<?php echo (isset($this->_rootref['_CSRFTOKEN'])) ? $this->_rootref['_CSRFTOKEN'] : ''; ?>">
                    <input type="submit" name="act" class="centre" value="<?php echo ((isset($this->_rootref['L_089'])) ? $this->_rootref['L_089'] : ((isset($MSG['089'])) ? $MSG['089'] : '{ L_089 }')); ?>">
				</form>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>