$Content
<div class="clearfix"></div>
<h2 class="center-text">Top Cryptocurrencies</h2>
<table class="table center-text large-line-height">
	<thead>
		<tr>
			<th>Crypto Currency</th>
			<th>Current Price (USD)</th>
			<th>Your stash</th>
			<th>Profit / Loss</th>
		</tr>
	</thead>
	<tbody>
		<% with GetCurrency('BTC') %>
			<tr>
				<td class="currency-logo">
					$Logo
					$Name ($TLA)
				</td>
				<td class="lg-text">$PricePerUnit.Nice</td>
				<td class="lg-text">?</td>
				<td class="lg-text">?</td>
			</tr>
		<% end_with %>
		<% with GetCurrency('ETH') %>
			<tr>
				<td class="currency-logo">
					$Logo
					$Name ($TLA)
				</td>
				<td class="lg-text">$PricePerUnit.Nice</td>
				<td class="lg-text">?</td>
				<td class="lg-text">?</td>
			</tr>
		<% end_with %>
		<% with GetCurrency('DASH') %>
			<tr>
				<td class="currency-logo">
					$Logo
					$Name ($TLA)
				</td>
				<td class="lg-text">$PricePerUnit.Nice</td>
				<td class="lg-text">?</td>
				<td class="lg-text">?</td>
			</tr>
		<% end_with %>
		<% with GetCurrency('XRP') %>
			<tr>
				<td class="currency-logo">
					$Logo
					$Name ($TLA)
				</td>
				<td class="lg-text">$PricePerUnit.Nice</td>
				<td class="lg-text">?</td>
				<td class="lg-text">?</td>
			</tr>
		<% end_with %>
		<% with GetCurrency('XMR') %>
			<tr>
				<td class="currency-logo">
					$Logo
					$Name ($TLA)
				</td>
				<td class="lg-text">$PricePerUnit.Nice</td>
				<td class="lg-text">?</td>
				<td class="lg-text">?</td>
			</tr>
		<% end_with %>
	</tbody>
</table>

<h2 class="center-text">All $GetAllCrypto.count Supported Cryptocurrencies</h2>
<br />
<div class="crypto-list">
	<% loop GetAllCrypto %>
		<div class="col-md-1 col-sm-2 col-xs-3">
			<div class="currency-item">
				$Logo <br />
				$Name ($TLA)
			</div>
		</div>
		<% if MultipleOf(6) %>
			<div class="clearfix visible-sm"></div>
		<% end_if %>
		<% if MultipleOf(12) %>
			<div class="clearfix visible-lg visible-md"></div>
		<% end_if %>
	<% end_loop %>
</div>
