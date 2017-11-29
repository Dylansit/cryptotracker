
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
			<% if Member.CurrentUser %>
			$AddEditTradeForm
			<% else %>
			<p>You must first register and login to add your trades</p>
			<p><a href="/Security/login">
        <i class="fa fa-sign-in" aria-hidden="true"></i> Regular Login
      </a>
      </p>
    <!--  <p><a href="$FacebookLoginLink"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook Login (quickest)</a>
      </p>
      <p><a href="$GetPage(MemberProfilePage).Link">
        <i class="fa fa-list-alt" aria-hidden="true"></i> Email Registration (slowest)
      </a>
      </p>-->

			<% end_if %>
			$CommentsForm
	</div>
