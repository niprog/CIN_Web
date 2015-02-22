<!DOCTYPE html>
<html dir="<?php echo (isset($this->_rootref['DOCDIR'])) ? $this->_rootref['DOCDIR'] : ''; ?>" lang="<?php echo (isset($this->_rootref['LANGUAGE'])) ? $this->_rootref['LANGUAGE'] : ''; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo (isset($this->_rootref['CHARSET'])) ? $this->_rootref['CHARSET'] : ''; ?>">

<title><?php echo ((isset($this->_rootref['L_1042'])) ? $this->_rootref['L_1042'] : ((isset($MSG['1042'])) ? $MSG['1042'] : '{ L_1042 }')); ?> <?php echo (isset($this->_rootref['SALE_ID'])) ? $this->_rootref['SALE_ID'] : ''; ?></title>

<style type="text/css">
.pageHeading { font-family: Verdana, Arial, sans-serif; font-size: 18px; color: #727272; font-weight: bold; }
.pageHeading-invoice { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-weight: normal; padding: 3px; }
.main { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
.main-payment { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #F0F1F1; border: 1px ridge #000000; }
.dataTableHeadingRow { background-color: #C9C9C9; }
.dataTableHeadingContent-invoice { font-family: Verdana, Arial, sans-serif;	font-size: 10px; color: #000000; font-weight: bold; border: 1px ridge #000000;}
.dataTableRow { background-color: #F0F1F1; }
.dataTableContent { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #000000; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.main-payment2 { font-family: Verdana, Arial, sans-serif; font-size: 12px; background-color: #FFFF99; border: 1px ridge #000000; }
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0">
<?php if ($this->_rootref['B_INVOICE']) {  ?> 

<table width="830px" border="0">
  <tbody><tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td width="350">
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
              <tbody><tr>
                <td valign="top" align="center"><img src="<?php echo (isset($this->_rootref['LOGO'])) ? $this->_rootref['LOGO'] : ''; ?>" alt="" border="0"></td>
              </tr>
              <tr>
                <td class="pageHeading-invoice" valign="top" align="left">
<?php if ($this->_rootref['SENDER'] != ('')) {  ?>
          <b><?php if ($this->_rootref['B_IS_AUCTION']) {  echo ((isset($this->_rootref['L_125'])) ? $this->_rootref['L_125'] : ((isset($MSG['125'])) ? $MSG['125'] : '{ L_125 }')); } else { echo ((isset($this->_rootref['L_313'])) ? $this->_rootref['L_313'] : ((isset($MSG['313'])) ? $MSG['313'] : '{ L_313 }')); } ?>:</b> <?php echo (isset($this->_rootref['SENDER'])) ? $this->_rootref['SENDER'] : ''; ?>
<?php } else { ?>
			&nbsp;
<?php } ?>
           </td>
		  
              </tr>
            </tbody></table></td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            <table class="pageHeading-invoice2" width="200" border="0">
              <tbody><tr>
                <td><b><?php echo ((isset($this->_rootref['L_1041'])) ? $this->_rootref['L_1041'] : ((isset($MSG['1041'])) ? $MSG['1041'] : '{ L_1041 }')); ?>: <?php echo (isset($this->_rootref['SALE_ID'])) ? $this->_rootref['SALE_ID'] : ''; ?></b></td>
              </tr>
              <tr>
                <td><b><?php echo ((isset($this->_rootref['L_1043'])) ? $this->_rootref['L_1043'] : ((isset($MSG['1043'])) ? $MSG['1043'] : '{ L_1043 }')); ?></b>&nbsp;<?php echo (isset($this->_rootref['INVOICE_DATE'])) ? $this->_rootref['INVOICE_DATE'] : ''; ?></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td><hr></td>
          <td class="pageHeading" valign="middle" width="120" align="center"><em><b><?php echo ((isset($this->_rootref['L_1035'])) ? $this->_rootref['L_1035'] : ((isset($MSG['1035'])) ? $MSG['1035'] : '{ L_1035 }')); ?></b></em></td>
          <td width="10%"> <hr></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td valign="top" width="350" align="left">
            <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b><?php echo ((isset($this->_rootref['L_1037'])) ? $this->_rootref['L_1037'] : ((isset($MSG['1037'])) ? $MSG['1037'] : '{ L_1037 }')); ?></b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td><?php echo (isset($this->_rootref['WINNER_NICK'])) ? $this->_rootref['WINNER_NICK'] : ''; ?><br><?php echo (isset($this->_rootref['WINNER_ADDRESS'])) ? $this->_rootref['WINNER_ADDRESS'] : ''; ?></td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table>
			</td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b><?php echo ((isset($this->_rootref['L_1038'])) ? $this->_rootref['L_1038'] : ((isset($MSG['1038'])) ? $MSG['1038'] : '{ L_1038 }')); ?></b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left"><?php echo (isset($this->_rootref['WINNER_NICK'])) ? $this->_rootref['WINNER_NICK'] : ''; ?><br><?php echo (isset($this->_rootref['WINNER_ADDRESS'])) ? $this->_rootref['WINNER_ADDRESS'] : ''; ?></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                   </tbody>
				   </table>
          </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1042'])) ? $this->_rootref['L_1042'] : ((isset($MSG['1042'])) ? $MSG['1042'] : '{ L_1042 }')); ?></b><br><?php echo ((isset($this->_rootref['L_113'])) ? $this->_rootref['L_113'] : ((isset($MSG['113'])) ? $MSG['113'] : '{ L_113 }')); ?>: <?php echo (isset($this->_rootref['AUCTION_ID'])) ? $this->_rootref['AUCTION_ID'] : ''; ?>/ <?php echo ((isset($this->_rootref['L_1041'])) ? $this->_rootref['L_1041'] : ((isset($MSG['1041'])) ? $MSG['1041'] : '{ L_1041 }')); ?>: <?php echo (isset($this->_rootref['SALE_ID'])) ? $this->_rootref['SALE_ID'] : ''; ?></td>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1036'])) ? $this->_rootref['L_1036'] : ((isset($MSG['1036'])) ? $MSG['1036'] : '{ L_1036 }')); ?></b><br><?php echo (isset($this->_rootref['INVOICE_DATE'])) ? $this->_rootref['INVOICE_DATE'] : ''; ?></td>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1054'])) ? $this->_rootref['L_1054'] : ((isset($MSG['1054'])) ? $MSG['1054'] : '{ L_1054 }')); ?></b><br><?php echo (isset($this->_rootref['SHIPPING_METHOD'])) ? $this->_rootref['SHIPPING_METHOD'] : ''; ?></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tbody><tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent-invoice"><?php echo ((isset($this->_rootref['L_1044'])) ? $this->_rootref['L_1044'] : ((isset($MSG['1044'])) ? $MSG['1044'] : '{ L_1044 }')); ?></td>
        <td class="dataTableHeadingContent-invoice" align="right"><?php echo ((isset($this->_rootref['L_1046'])) ? $this->_rootref['L_1046'] : ((isset($MSG['1046'])) ? $MSG['1046'] : '{ L_1046 }')); ?></td>
        <td class="dataTableHeadingContent-invoice" align="right"><?php echo ((isset($this->_rootref['L_1047'])) ? $this->_rootref['L_1047'] : ((isset($MSG['1047'])) ? $MSG['1047'] : '{ L_1047 }')); ?></td>
        <td class="dataTableHeadingContent-invoice" align="right"><?php echo ((isset($this->_rootref['L_1048'])) ? $this->_rootref['L_1048'] : ((isset($MSG['1048'])) ? $MSG['1048'] : '{ L_1048 }')); ?></td>
        <td class="dataTableHeadingContent-invoice" align="right"><?php echo ((isset($this->_rootref['L_1049'])) ? $this->_rootref['L_1049'] : ((isset($MSG['1049'])) ? $MSG['1049'] : '{ L_1049 }')); ?></td>
      </tr>
	<?php if ($this->_rootref['B_IS_AUCTION']) {  ?>
		<tr class="dataTableRow">
			<td class="dataTableContent" valign="top">
				<?php echo (isset($this->_rootref['ITEM_QUANTITY'])) ? $this->_rootref['ITEM_QUANTITY'] : ''; ?> x <?php echo (isset($this->_rootref['AUCTION_TITLE'])) ? $this->_rootref['AUCTION_TITLE'] : ''; ?>
			</td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo (isset($this->_rootref['UNIT_PRICE'])) ? $this->_rootref['UNIT_PRICE'] : ''; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo (isset($this->_rootref['UNIT_PRICE_WITH_TAX'])) ? $this->_rootref['UNIT_PRICE_WITH_TAX'] : ''; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo (isset($this->_rootref['TOTAL'])) ? $this->_rootref['TOTAL'] : ''; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo (isset($this->_rootref['TOTAL_WITH_TAX'])) ? $this->_rootref['TOTAL_WITH_TAX'] : ''; ?></b></td>
		</tr>
	<?php } else { $_fees_count = (isset($this->_tpldata['fees'])) ? sizeof($this->_tpldata['fees']) : 0;if ($_fees_count) {for ($_fees_i = 0; $_fees_i < $_fees_count; ++$_fees_i){$_fees_val = &$this->_tpldata['fees'][$_fees_i]; ?>
		<tr class="dataTableRow">
			<td class="dataTableContent" valign="top">
				<?php echo $_fees_val['FEE']; ?>
			</td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo $_fees_val['UNIT_PRICE']; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo $_fees_val['UNIT_PRICE_WITH_TAX']; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo $_fees_val['TOTAL']; ?></b></td>
			<td class="dataTableContent" valign="top" align="right"><b><?php echo $_fees_val['TOTAL_WITH_TAX']; ?></b></td>
		</tr>
	<?php }} } ?>
     <tr>
        <td colspan="5" align="right"><br> <table border="0" cellpadding="2" cellspacing="0">
          <tbody>
          <tr>
		    <td class="smallText" align="right"><?php echo ((isset($this->_rootref['L_1050'])) ? $this->_rootref['L_1050'] : ((isset($MSG['1050'])) ? $MSG['1050'] : '{ L_1050 }')); ?></td>
			<td class="smallText" align="right"><?php echo (isset($this->_rootref['TOTAL'])) ? $this->_rootref['TOTAL'] : ''; ?></td>
			</tr>
			<tr>
            <td class="smallText" align="right"><?php echo ((isset($this->_rootref['L_1051'])) ? $this->_rootref['L_1051'] : ((isset($MSG['1051'])) ? $MSG['1051'] : '{ L_1051 }')); ?></td>
			<td class="smallText" align="right"><?php echo (isset($this->_rootref['SHIPPING_COST'])) ? $this->_rootref['SHIPPING_COST'] : ''; ?></td>
			</tr>
			<tr>
            <td class="smallText" align="right"><?php echo ((isset($this->_rootref['L_1052'])) ? $this->_rootref['L_1052'] : ((isset($MSG['1052'])) ? $MSG['1052'] : '{ L_1052 }')); ?></td>
			<td class="smallText" align="right"><?php echo (isset($this->_rootref['VAT_TOTAL'])) ? $this->_rootref['VAT_TOTAL'] : ''; ?></td>
			</tr>
			<tr>
            <td class="smallText" align="right"><?php echo ((isset($this->_rootref['L_1053'])) ? $this->_rootref['L_1053'] : ((isset($MSG['1053'])) ? $MSG['1053'] : '{ L_1053 }')); ?></td>
			<td class="smallText" align="right"><?php echo (isset($this->_rootref['TOTAL_SUM'])) ? $this->_rootref['TOTAL_SUM'] : ''; ?></td>
			
          </tr>
</tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
<?php if ($this->_rootref['YELLOW_LINE'] != ('')) {  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment2"><?php echo (isset($this->_rootref['YELLOW_LINE'])) ? $this->_rootref['YELLOW_LINE'] : ''; ?></td>
        </tr>
      </tbody></table></td>
  </tr>
<?php } if ($this->_rootref['THANKYOU'] != ('')) {  ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="main" align="center"><b><?php echo (isset($this->_rootref['THANKYOU'])) ? $this->_rootref['THANKYOU'] : ''; ?></b></td>
  </tr>
<?php } ?>
</tbody>
</table>

<?php } else { ?>
<div style="position: absolute; top: 15%; left: 40%;">
<h4><?php echo ((isset($this->_rootref['L_1060'])) ? $this->_rootref['L_1060'] : ((isset($MSG['1060'])) ? $MSG['1060'] : '{ L_1060 }')); ?></h4>
</div>
<?php } ?>

</body>
</html>