<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<% if ViewMember %>
		<h1>$ViewMember.Username's Portfolio</h1>
		<table class="table">
			<thead>
				<tr>
					<th>Currency</th>
					<th>Currency</th>
					<th>Amount</th>
					<th>Cost (each)</th>
					<th>Total Cost</th>
					<th>Current Price</th>
					<th>Current Value</th>
					<th>Profit / Loss</th>
					<th>%</th>
					<th>24Hr</th>
					<th>7 day</th>
					<th>30 Day</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<% loop ViewMember.CurrencyTrades %>
					<tr>
						<td>$Currency.Logo</td>
						<td>$Currency.Name ($Currency.TLA)</td>
						<td>$Amount</td>
						<td>$CostMyCurrency.Nice</td>
						<td>$TotalCost.Nice</td>
						<td>$PricePerUnitMyCurrency.Nice</td>
						<td>$CurrentValue.Nice</td>
						<td class="<% if $Profit.getAmount > 0 %>success<% else %>danger<% end_if %>">$Profit.Nice</td>
						<td class="<% if $Profit.getAmount > 0 %>success<% else %>danger<% end_if %>">$ProfitPercent%</td>
						<td>$Currency.PercentageChangeNiceSince(1)</td>
						<td>$Currency.PercentageChangeNiceSince(7)</td>
						<td>$Currency.PercentageChangeNiceSince(30)</td>
					</tr>
				<% end_loop %>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>$ViewMember.TotalCost.Nice</td>
					<td></td>
					<td>$ViewMember.TotalCurrentValue.Nice</td>
					<td>$ViewMember.TotalProfit.Nice</td>
					

				</tr>
			</tbody>
		</table>
		<% end_if %>

	</article>
		$Form
		$CommentsForm
</div>