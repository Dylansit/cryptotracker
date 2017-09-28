		
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
			<div>
				<a href="$Link?days=1">24 hours</a> |
				<a href="$Link?days=7">7 Days</a> |
				<a href="$Link?days=30">30 Days</a>
			</div>
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">
	      google.charts.load('current', {'packages':['corechart']});
	      google.charts.setOnLoadCallback(drawChart);

	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	          ['Year', '$Title'],
	          <% loop Prices %>
							
	          	['$Created.Nice',  $InvertedPrice]<% if Not Last %>,<% end_if %>
								
						<% end_loop %>
	        ]);

	        var options = {
	          title: '$Title',
	          curveType: 'function',
	          legend: { position: 'bottom' },
		        axes: {
		          // Adds labels to each axis; they don't have to match the axis names.
		          y: {
		            0: {label: 'USD'}
		          },
		          x: {
		            0: {label: 'Date'}
		          }
		        }
	        };

	        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

	        chart.draw(data, options);
	      }
	    </script>
    	<div id="curve_chart" style="width: 100%; height: 600px"></div>
  
			
		</article>
			$Form
			$CommentsForm
	</div>