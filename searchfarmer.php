<div class="col-md-12">
	<div class="jumbotron content"><br />
		<h2 class="text-center">FRESH FROM FARMERS</h2><br />
		<form class="navbar-form navbar-center" role="search" method="post" action="home.php?action=search" autocomplete="off">
			<input autocomplete="false" name="hidden" type="text" style="display:none;">
			<div class="form-group">
				<div class="input-group searchdiv">
					<div class="col-md-1"></div>
					<input type="text" id="location" name="location" class="form-control col-md-5 ui-autocomplete-input" placeholder="Search Neighbourhood">
					<input type="text" name="itemsearch" class="form-control col-md-5" placeholder="Search Item by Name or Code">
					<span class="input-group-btn">
						<button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
					</span>
					<div class="col-md-1"></div>
				</div>
			</div>

		</form>

			<div>
				<table class="table table-responsive" id="picturetable">
				<tr><td class="cells"><img class="cellimg"src="images/cell1.jpg"></td>
				<td class="cells"><img class="cellimg" src="images/cell2.jpg"></td>
				<td class="cells hide-col"><img class="cellimg" src="images/cell3.jpg"></td></tr>
				<tr><td class="cells"><img class="cellimg" src="images/cell4.jpg"></td>
				<td class="cells"><img class="cellimg" src="images/cell5.jpg"></td>
				<td class="cells hide-col"><img class="cellimg" src="images/cell6.jpg"></td></tr>
			</table>
		</div><br />
	</div>

</div>
