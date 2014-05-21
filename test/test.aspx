<%@ Page language="VB" masterpagefile="../default.master" title="Untitled 1" %>
<asp:Content id="Content1" runat="Server" contentplaceholderid="ContentPlaceHolder1">

<!-- Begin Container -->
<div id="container">
	<!-- Begin Masthead -->
	<div id="masthead">
		<img alt="" height="134" src="../images/CIN_Logo_no%20email_No_title.png" width="150" /><img alt="CIN" height="134" src="../images/CIN_Title.png" width="676" /></div>
	<!-- End Masthead -->
	<!-- Begin Page Content -->
	<div id="page_content">
		<!-- Begin Sidebar -->
		<div id="sidebar">
			<ul>
				<li><a href="../default.html">Home</a></li>
				<li><a href="../about/default.html">About</a></li>
				<li><a href="../news/default.html">News</a></li>
				<li><a href="../HowToHelp/default.html">How to Help</a></li>
				<li><a href="../services/default.html">Services</a></li>
				<li><a href="../calendar/default.html">Calendar</a></li>
				<li><a href="../contact/default.html">Contact</a></li>
			</ul>
		</div>
		<!-- End Sidebar -->
		<!-- Begin Content -->
		<div id="content">
			<h2>Headline</h2>
			<p>Menu</p>
			<asp:Menu id="Menu1" runat="server" BackColor="#F7F6F3" DynamicHorizontalOffset="2" Font-Names="Verdana" Font-Size="0.8em" ForeColor="#7C6F57" StaticSubMenuIndent="10px">
				<DynamicHoverStyle BackColor="#7C6F57" ForeColor="White" />
				<DynamicMenuItemStyle HorizontalPadding="5px" VerticalPadding="2px" />
				<DynamicMenuStyle BackColor="#F7F6F3" />
				<DynamicSelectedStyle BackColor="#5D7B9D" />
				<Items>
					<asp:MenuItem Text="New Item" Value="New Item">
						<asp:MenuItem Text="New Item" Value="New Item">
						</asp:MenuItem>
					</asp:MenuItem>
					<asp:MenuItem Text="New Item" Value="New Item">
						<asp:MenuItem Text="New Item" Value="New Item">
							<asp:MenuItem Text="New Item" Value="New Item">
							</asp:MenuItem>
						</asp:MenuItem>
					</asp:MenuItem>
				</Items>
				<StaticHoverStyle BackColor="#7C6F57" ForeColor="White" />
				<StaticMenuItemStyle HorizontalPadding="5px" VerticalPadding="2px" />
				<StaticSelectedStyle BackColor="#5D7B9D" />
			</asp:Menu>
			<p>insert content here</p>
			</div>
		<!-- End Content --></div>
	<!-- End Page Content -->
	<!-- Begin Footer -->
	<div id="footer">
		<p>
		<img height="46" src="../images/facebook.gif" style="float: left" width="47" /><a href="../default.html">Home</a> | 
		<a href="../about/default.html">About</a> 
		| <a href="../calendar/default.html">Calendar</a> |
		<a href="../contact/default.html">Contact</a> |
		<a href="../employees/default.html">Employees</a> |
		<a href="../employment/default.html">Employment</a> |
		<a href="../faq/default.html">FAQ</a> |
		<a href="../information_links/default.html">Information Links</a><br />
		<a href="../news/default.html">News</a> |
		<a href="../photo_gallery/default.html">Photo Gallery</a> |
		<a href="../press/default.html">Press</a> | 
		<a href="../HowToHelp/default.html">
		Products</a> | <a href="../promotions/default.html">Promotions</a> |
		<a href="../services/default.html">Services</a> |
		<a href="../site_map/default.html">Site Map</a><br />
		Copyright &copy; 2014 Cavaliers In Need. All Rights Reserved.</p>
	</div>
	<!-- End Footer --></div>
<!-- End Container -->

</asp:Content>
<asp:Content id="Content2" runat="server" contentplaceholderid="head">


<link href="../styles/style1.css" media="screen" rel="stylesheet" title="CSS" type="text/css" />
</asp:Content>
