$Content
<table class="table tablesorter" id="coin-value">
	<thead>
	<tr>
		<th>
			Logo
		</th>
		<th>
			Coin
		</th>
		<!-- <th>Available Supply</th> -->
		<th>Total Supply</th>
		<th>Price</th>
		<th colspan="4">Coin Value</th>
		
		<!-- <th>Available Cap</th>
		<th>Total Cap</th> -->
	</tr>
	</thead>
	<tbody>
	<% loop GetAllCrypto %>
		<tr>
			<td>
				$Logo
			</td>
			<td>
				$Name ($TLA)
			</td>
			<!-- <td>$AvailableSupply.Nice</td> -->
			<td>$TotalSupply.Nice</td>
			<td>$PricePerUnit.Nice</td>
			<td class="hidden">$ActualValuePerUnit</td>
			<td class="text-right">$ActualValueWholeNumber</td>
			<td class="decimal">.</td>
			<td class="text-left">$ActualValueWholeDecimals</td>
			<!-- <td>$AvailableMarketCap</td>
			<td>$TotalMarketCap</td> -->
		</tr>
	<% end_loop %>
	</tbody>

</table>