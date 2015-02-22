<!DOCTYPE html>
<html dir="<?php echo (isset($this->_rootref['DOCDIR'])) ? $this->_rootref['DOCDIR'] : ''; ?>" lang="<?php echo (isset($this->_rootref['LANGUAGE'])) ? $this->_rootref['LANGUAGE'] : ''; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo (isset($this->_rootref['CHARSET'])) ? $this->_rootref['CHARSET'] : ''; ?>">

<title><?php echo ((isset($this->_rootref['L_1033'])) ? $this->_rootref['L_1033'] : ((isset($MSG['1033'])) ? $MSG['1033'] : '{ L_1033 }')); ?></title>

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
          <b>Seller:</b> <?php echo (isset($this->_rootref['SENDER'])) ? $this->_rootref['SENDER'] : ''; ?>
           </td>
		  
              </tr>
            </tbody></table></td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td><hr></td>
          <td class="pageHeading" valign="middle" width="120" align="center"><em><b><?php echo ((isset($this->_rootref['L_1033'])) ? $this->_rootref['L_1033'] : ((isset($MSG['1033'])) ? $MSG['1033'] : '{ L_1033 }')); ?></b></em></td>
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
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table></td>
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
                   </tbody></table>
          </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1034'])) ? $this->_rootref['L_1034'] : ((isset($MSG['1034'])) ? $MSG['1034'] : '{ L_1034 }')); ?></b><br><?php echo (isset($this->_rootref['AUCTION_ID'])) ? $this->_rootref['AUCTION_ID'] : ''; ?></td>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1036'])) ? $this->_rootref['L_1036'] : ((isset($MSG['1036'])) ? $MSG['1036'] : '{ L_1036 }')); ?></b><br><?php echo (isset($this->_rootref['CLOSING_DATE'])) ? $this->_rootref['CLOSING_DATE'] : ''; ?></td>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1055'])) ? $this->_rootref['L_1055'] : ((isset($MSG['1055'])) ? $MSG['1055'] : '{ L_1055 }')); ?></b><br><?php echo (isset($this->_rootref['PAYMENT_METHOD'])) ? $this->_rootref['PAYMENT_METHOD'] : ''; ?></td>
          <td class="main-payment"><b><?php echo ((isset($this->_rootref['L_1054'])) ? $this->_rootref['L_1054'] : ((isset($MSG['1054'])) ? $MSG['1054'] : '{ L_1054 }')); ?></b><br><?php echo (isset($this->_rootref['SHIPPING_METHOD'])) ? $this->_rootref['SHIPPING_METHOD'] : ''; ?></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tbody><tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent-invoice"><?php echo ((isset($this->_rootref['L_1044'])) ? $this->_rootref['L_1044'] : ((isset($MSG['1044'])) ? $MSG['1044'] : '{ L_1044 }')); ?></td>
      </tr>
      <tr class="dataTableRow">
        <td class="dataTableContent" valign="top">
				<?php echo (isset($this->_rootref['ITEM_QUANTITY'])) ? $this->_rootref['ITEM_QUANTITY'] : ''; ?> x <?php echo (isset($this->_rootref['AUCTION_TITLE'])) ? $this->_rootref['AUCTION_TITLE'] : ''; ?>
		</td>
      </tr>
      </tbody>
	  </table>
	  </td>
  </tr>
</tbody>
</table>

<?php } else { ?>
<div style="position: absolute; top: 15%; left: 40%;">
<h4><?php echo ((isset($this->_rootref['L_1056'])) ? $this->_rootref['L_1056'] : ((isset($MSG['1056'])) ? $MSG['1056'] : '{ L_1056 }')); ?></h4>
</div>
<?php } ?>

</body>
</html>