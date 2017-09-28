<footer class="footer" role="contentinfo">
	<div class="container">
		<a href="$BaseHref" class="navbar-brand" rel="home">$SiteConfig.Title</a>
		<div class="pull-right">
			<p></p>
			<p>Last Price Update: $LastPrice.Created.Ago<br />
			(Prices in 
			<% if ViewMember %>
				$ViewMember.ShowPricesIn.TLA
			<% else_if $Member.CurrentUser %>
				<% if Member.CurrentUser.ShowPricesIn %>
					$Member.CurrentUser.ShowPricesIn.TLA
				<% else %>
					USD
				<% end_if %>
			<% else %>
				USD
			<% end_if %>)</p> 
		</div>

	</div>
</footer>