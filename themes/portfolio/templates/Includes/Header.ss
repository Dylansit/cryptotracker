<header class="header">
	<nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="$BaseHref" style="margin-top:-30px;">$SiteConfig.Title</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<% loop $Menu(1) %>
					<li class="$LinkingMode"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
				<% end_loop %>

			</ul>
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <% if Member.currentUser %>
              <% if $Member.currentUser.Name %>
                $Member.currentUser.Name
              <% else_if $Member.currentUser.Username %>
                $Member.currentUser.Username
              <% else %>
                Account
              <% end_if %>
            <% else %>
              Account
            <% end_if %>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <% if not Member.currentUser %>
                <a href="{$BaseHref}Security/login">
                  <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
              <!--  <a href="$GetPage(MemberProfilePage).Link">
                  <i class="fa fa-list-alt" aria-hidden="true"></i> Register
                </a>-->
              <% else %>
                <a href="Security/logout">Log out</a>
              <% end_if %>
            </li>
          </ul>
        </li>
      </ul>
			<% if $SearchForm %>
				<div class="search-bar">
					$SearchForm
				</div>
			<% end_if %>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	</div>
</header>
