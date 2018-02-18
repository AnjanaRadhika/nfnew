<div class="col-md-12">
	<div class="message centered">
		<div class="container">
			<?php echo $logout_success;?>
		</div>
	</div>
	<div class="jumbotron content">
		<br /><br />
		<h2>FRESH FROM FARMERS</h2><br />
		<form class="navbar-form navbar-left" role="search" method="post" action="home.php?action=search">
			<div class="form-group-sm">
				<div class="input-group">
					<input type="text" name="location" class="form-control form-element" placeholder="Search Location">
					<input type="text" name="itemsearch" class="form-control form-element" placeholder="Search Item">
					<span class="input-group-btn">
						<button class="btn btn-success btn-sm form-element" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
					</span>
				</div>
			</div>

		</form>		<br>

			<div>
				<table class="table table-responsive" id="picturetable">
				<tr><td class="cells"><img class="cellimg"src="images/cell1.jpg"></td>
				<td class="cells"><img class="cellimg" src="images/cell2.jpg"></td>
				<td class="cells hide-col"><img class="cellimg" src="images/cell3.jpg"></td></tr>
				<tr><td class="cells"><img class="cellimg" src="images/cell4.jpg"></td>
				<td class="cells"><img class="cellimg" src="images/cell5.jpg"></td>
				<td class="cells hide-col"><img class="cellimg" src="images/cell6.jpg"></td></tr>
				<tr class="hide-row"><td class="cells"><img class="cellimg" src="images/cell3.jpg"></td>
				<td class="cells"><img class="cellimg" src="images/cell6.jpg"></td>
				<td class="cells hide-col"><img class="cellimg" src="images/cell6.jpg"></td></tr>
				</table>
			</div><br /><br />
		<p class="text-justify">Quisque condimentum nibh porttitor sapien facilisis, semper auctor urna ultricies. Vivamus molestie in enim at volutpat. Praesent molestie consectetur tincidunt. Donec vitae commodo dolor. Aenean bibendum, ante vel cursus blandit, nulla elit porta orci, vitae varius lacus velit at mauris. Nunc molestie molestie magna, eget laoreet justo mollis eu. Nam feugiat sit amet dui a venenatis. Nullam bibendum, mauris a egestas sollicitudin, enim ante aliquam orci, a eleifend augue dolor non libero. Morbi pellentesque quis lectus ac blandit.</p>
	</div>

</div>
