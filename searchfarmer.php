<div class="col-md-12">
	<div class="jumbotron content">
		<h2 class="text-center">FRESH FROM FARMERS</h2><br />
		<form class="navbar-form navbar-left" role="search" method="post" action="home.php?action=search">
			<div class="form-group">
				<div class="input-group searchdiv">
					<input type="text" name="location" class="form-control col-md-4" placeholder="Search Location">
					<input type="text" name="itemsearch" class="form-control col-md-4" placeholder="Search Item">
					<input type="hidden" id="sellorbuy" name="sellorbuy" value="Both" />
					<select id="sellorbuy-list" class="form-control  custom-select col-md-2" onChange="$('#sellorbuy').val($('#sellorbuy-list').val());">
						<option value="Both"> Select All</option>
						<option value="For Sale"> For Sale</option>
						<option value="For Buy"> For Buy</option>
					</select>
					<span class="input-group-btn">
						<button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
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
			</table>
			</div>
	</div>

</div>
