<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<div class="content">
			<% if not Member.currentUser %>
				<% include HomeDefault %>
			<% end_if %>

		<% if Member.currentUser %>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#summary">Summary</a></li>
			<li><a data-toggle="tab" href="#raw">Raw Data</a></li>
		</ul>

		<div class="tab-content">
			<div id="summary" class="tab-pane fade in active">
		    	<div class="jumbotron">
		    		<h1 class="center-text">Portfolio: $Member.currentUser.TotalCurrentValue.Nice</h1>
		    		<div class="col-sm-push-3 col-sm-6 center-text">
			    		<table class="table table-bordered">
			    			<tbody>
				    			<tr>
				    				<th>Total Cost</th>
				    				<td><h2>$Member.currentUser.TotalCost.Nice</h2></td>
				    			</tr>
								<tr>
				    				<th>Profit / Loss</th>
									<td><h2>$Member.currentUser.TotalProfit.Nice</h2></td>
				    			</tr>
								<tr>
				    				<th>Percent</th>
									<td><h2>$Member.currentUser.TotalProfitPercent%</h2></td>
				    			</tr>
				    		</tbody>
			    		</table>
		    		</div>
		    		<div class="clearfix"></div>
		    	</div>
			</div>
			<div id="raw" class="tab-pane fade">
				<div class="pull-right"><a class="btn btn-primary" href="add-trade">+ Add a Coin to My Portfolio</a></div>
				<table class="table tablesorter" id="raw-data">
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
						<% loop Member.currentUser.CurrencyTrades %>
							<tr>
								<td>$Currency.Logo</td>
								<td><a href="currency/view/$Currency.TLA">$Currency.Name ($Currency.TLA)</a></td>
								<td>$Amount1DP</td>
								<td>$CostMyCurrency.Nice</td>
								<td>$TotalCost.Nice</td>
								<td>$PricePerUnitMyCurrency.Nice</td>
								<td>$CurrentValue.Nice</td>
								<td class="<% if $Profit.getAmount > 0 %>success<% else %>danger<% end_if %>">$Profit.Nice</td>
								<td class="<% if $Profit.getAmount > 0 %>success<% else %>danger<% end_if %>">$ProfitPercent%</td>
								<td>$Currency.PercentageChangeNiceSince(1)</td>
								<td>$Currency.PercentageChangeNiceSince(7)</td>
								<td>$Currency.PercentageChangeNiceSince(30)</td>
								<td>
									<a class="btn btn-default btn-xs" href="add-trade/woops/$ID">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</a>
									<a class="btn btn-danger btn-xs" href="add-trade/delete/$ID">
										<i class="fa fa-times" aria-hidden="true"></i>
									</a>
								</td>
							</tr>
						<% end_loop %>
					</tbody>
					<thead>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>$Member.currentUser.TotalCost.Nice</td>
							<td></td>
							<td>$Member.currentUser.TotalCurrentValue.Nice</td>
							<td>$Member.currentUser.TotalProfit.Nice</td>
							<td>$Member.currentUser.TotalProfitPercent%</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</thead>
				</table>
			</div>
		</div>


		<% end_if %>

	</article>
		$Form
		$CommentsForm
	</div>
</div>
