		
<% if $Menu(2) %>
	<aside class="col-xs-3">
		<nav class="secondary">
			<% with $Level(1) %>
				<h3>
					$MenuTitle
				</h3>
				<ul>
					<% include SidebarMenu %>
				</ul>
			<% end_with %>
		</nav>
	</aside>
	<div class="col-xs-9">
<% else %>
	<div class="col-xs-12">
<% end_if %>

		<article>
			<h1>$Title</h1>
			<div class="content">$Content</div>
			<table class="table">
			<thead>
				<th>Username</th>
				<th>Cost</th>
				<th>Value</th>
				<th>Profit</th>
			</thead>
			<tbody>
			<% loop PublicMembers %>
				<tr>
					<td><a href="$PortfolioPublicLink">$Username</a></td>
					<td>$TotalCost.Nice</td>
					<td>$TotalCurrentValue.Nice</td>
					<td>$TotalProfit.Nice</td>
					<td><% loop CurrencyTrades %>$Currency.Logo<% end_loop %></td>
				</tr>
			<% end_loop %>
			</tbody>
			</table>

			<% if $PublicMembers.MoreThanOnePage %>
		    <div id="PageNumbers">
		        <div class="pagination">
		            <% if $PublicMembers.NotFirstPage %>
		            <a class="prev" href="$PublicMembers.PrevLink" title="View the previous page">&larr;</a>
		            <% end_if %>
		            <span>
		                <% loop $PublicMembers.Pages %>
		                    <% if $CurrentBool %>
		                    $PageNum
		                    <% else %>
		                    <a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
		                    <% end_if %>
		                <% end_loop %>
		            </span>
		            <% if $PublicMembers.NotLastPage %>
		            <a class="next" href="$Results.NextLink" title="View the next page">&rarr;</a>
		            <% end_if %>
		        </div>
		        <p>Page $PublicMembers.CurrentPage of $PublicMembers.TotalPages</p>
		    </div>
		    <% end_if %>
		</article>
			$Form
			$CommentsForm
	</div>