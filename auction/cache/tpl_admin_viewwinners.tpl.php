<?php $this->_tpl_include('header.tpl'); ?>
    	<div style="width:25%; float:left;">
            <div style="margin-left:auto; margin-right:auto;">
            	<?php $this->_tpl_include('sidebar-' . ((isset($this->_rootref['CURRENT_PAGE'])) ? $this->_rootref['CURRENT_PAGE'] : '') . '.tpl'); ?>
            </div>
        </div>
    	<div style="width:75%; float:right;">
            <div class="main-box">
            	<h4 class="rounded-top rounded-bottom"><?php echo ((isset($this->_rootref['L_239'])) ? $this->_rootref['L_239'] : ((isset($MSG['239'])) ? $MSG['239'] : '{ L_239 }')); ?>&nbsp;&gt;&gt;&nbsp;<?php echo ((isset($this->_rootref['L_30_0176'])) ? $this->_rootref['L_30_0176'] : ((isset($MSG['30_0176'])) ? $MSG['30_0176'] : '{ L_30_0176 }')); ?></h4>
                <p><b><?php echo ((isset($this->_rootref['L_113'])) ? $this->_rootref['L_113'] : ((isset($MSG['113'])) ? $MSG['113'] : '{ L_113 }')); ?>: </b> <?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?></p>
                <p><b><?php echo ((isset($this->_rootref['L_197'])) ? $this->_rootref['L_197'] : ((isset($MSG['197'])) ? $MSG['197'] : '{ L_197 }')); ?>: </b> <?php echo (isset($this->_rootref['TITLE'])) ? $this->_rootref['TITLE'] : ''; ?></p>
                <p><b><?php echo ((isset($this->_rootref['L_125'])) ? $this->_rootref['L_125'] : ((isset($MSG['125'])) ? $MSG['125'] : '{ L_125 }')); ?>: </b> <?php echo (isset($this->_rootref['S_NICK'])) ? $this->_rootref['S_NICK'] : ''; ?> (<?php echo (isset($this->_rootref['S_NAME'])) ? $this->_rootref['S_NAME'] : ''; ?>)</p>
                <p><b><?php echo ((isset($this->_rootref['L_127'])) ? $this->_rootref['L_127'] : ((isset($MSG['127'])) ? $MSG['127'] : '{ L_127 }')); ?>: </b> <?php echo (isset($this->_rootref['MIN_BID'])) ? $this->_rootref['MIN_BID'] : ''; ?></p>
                <p><b><?php echo ((isset($this->_rootref['L_111'])) ? $this->_rootref['L_111'] : ((isset($MSG['111'])) ? $MSG['111'] : '{ L_111 }')); ?>: </b> <?php echo (isset($this->_rootref['STARTS'])) ? $this->_rootref['STARTS'] : ''; ?></p>
                <p><b><?php echo ((isset($this->_rootref['L_30_0177'])) ? $this->_rootref['L_30_0177'] : ((isset($MSG['30_0177'])) ? $MSG['30_0177'] : '{ L_30_0177 }')); ?>: </b> <?php echo (isset($this->_rootref['ENDS'])) ? $this->_rootref['ENDS'] : ''; ?></p>
                <p><b><?php echo ((isset($this->_rootref['L_257'])) ? $this->_rootref['L_257'] : ((isset($MSG['257'])) ? $MSG['257'] : '{ L_257 }')); ?>: </b> <?php echo (isset($this->_rootref['AUCTION_TYPE'])) ? $this->_rootref['AUCTION_TYPE'] : ''; ?></p>
                <h4 class="rounded-top rounded-bottom" style="width: 98%;"><?php echo ((isset($this->_rootref['L_453'])) ? $this->_rootref['L_453'] : ((isset($MSG['453'])) ? $MSG['453'] : '{ L_453 }')); ?></h4>
<?php if ($this->_rootref['B_WINNERS']) {  ?>
                <table width="98%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <th><b><?php echo ((isset($this->_rootref['L_176'])) ? $this->_rootref['L_176'] : ((isset($MSG['176'])) ? $MSG['176'] : '{ L_176 }')); ?></b></td>
                    <th><b><?php echo ((isset($this->_rootref['L_30_0179'])) ? $this->_rootref['L_30_0179'] : ((isset($MSG['30_0179'])) ? $MSG['30_0179'] : '{ L_30_0179 }')); ?></b></td>
                    <th><b><?php echo ((isset($this->_rootref['L_284'])) ? $this->_rootref['L_284'] : ((isset($MSG['284'])) ? $MSG['284'] : '{ L_284 }')); ?></b></td>
                </tr>
    <?php $_winners_count = (isset($this->_tpldata['winners'])) ? sizeof($this->_tpldata['winners']) : 0;if ($_winners_count) {for ($_winners_i = 0; $_winners_i < $_winners_count; ++$_winners_i){$_winners_val = &$this->_tpldata['winners'][$_winners_i]; ?>
                <tr>
                    <td><?php echo $_winners_val['W_NICK']; ?> (<?php echo $_winners_val['W_NAME']; ?>)</td>
                    <td><?php echo $_winners_val['BID']; ?></td>
                    <td align="center"><?php echo $_winners_val['QTY']; ?></td>
                </tr>
    <?php }} ?>
                </table>
<?php } else { ?>
                <?php echo ((isset($this->_rootref['L_30_0178'])) ? $this->_rootref['L_30_0178'] : ((isset($MSG['30_0178'])) ? $MSG['30_0178'] : '{ L_30_0178 }')); ?>
<?php } ?>
                <h4 class="rounded-top rounded-bottom" style="width: 98%;"><?php echo ((isset($this->_rootref['L_30_0180'])) ? $this->_rootref['L_30_0180'] : ((isset($MSG['30_0180'])) ? $MSG['30_0180'] : '{ L_30_0180 }')); ?></h4>
<?php if ($this->_rootref['B_BIDS']) {  ?>
                <table width="98%" cellpadding="0" cellspacing="0">
                <tr>
                    <th><b><?php echo ((isset($this->_rootref['L_176'])) ? $this->_rootref['L_176'] : ((isset($MSG['176'])) ? $MSG['176'] : '{ L_176 }')); ?></b></td>
                    <th><b><?php echo ((isset($this->_rootref['L_30_0179'])) ? $this->_rootref['L_30_0179'] : ((isset($MSG['30_0179'])) ? $MSG['30_0179'] : '{ L_30_0179 }')); ?></b></td>
                    <th><b><?php echo ((isset($this->_rootref['L_284'])) ? $this->_rootref['L_284'] : ((isset($MSG['284'])) ? $MSG['284'] : '{ L_284 }')); ?></b></td>
                </tr>
    <?php $_bids_count = (isset($this->_tpldata['bids'])) ? sizeof($this->_tpldata['bids']) : 0;if ($_bids_count) {for ($_bids_i = 0; $_bids_i < $_bids_count; ++$_bids_i){$_bids_val = &$this->_tpldata['bids'][$_bids_i]; ?>
                <tr>
                    <td><?php echo $_bids_val['W_NICK']; ?> (<?php echo $_bids_val['W_NAME']; ?>)</td>
                    <td><?php echo $_bids_val['BID']; ?></td>
                    <td align="center"><?php echo $_bids_val['QTY']; ?></td>
                </tr>
    <?php }} ?>
                </table>
<?php } else { ?>
                <?php echo ((isset($this->_rootref['L_30_0178'])) ? $this->_rootref['L_30_0178'] : ((isset($MSG['30_0178'])) ? $MSG['30_0178'] : '{ L_30_0178 }')); ?>
<?php } ?>
            </div>
        </div>
<?php $this->_tpl_include('footer.tpl'); ?>