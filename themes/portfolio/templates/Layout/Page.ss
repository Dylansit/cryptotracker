		
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
		</article>
			$Form
			$CommentsForm
	</div>