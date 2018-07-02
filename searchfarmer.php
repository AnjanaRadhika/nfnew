<div class="col-md-12">
	<div class="jumbotron content"><br />
		<h2 class="text-center">FRESH FROM FARMERS</h2>
		<form class="navbar-form navbar-center" role="search" method="post" action="home.php?action=search" autocomplete="off">
			<div class="form-group">
				<div class="input-group searchdiv">
					<div class="col-md-1"></div>
					<input type="text" id="location" name="location" class="form-control col-md-5 ui-autocomplete-input" placeholder="Search Neighbourhood" autofocus>
					<input type="text" name="itemsearch" class="form-control col-md-5" placeholder="Search Item">
					<span class="input-group-btn">
						<button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
					</span>
					<div class="col-md-1"></div>
				</div>
			</div>

          <div>
				<table class="table table-responsive" id="picturetable">

				<tr>
					<td class="cells"> <input type="image" class="cellimg" src="images/cell1.jpg" title="Vegetables" name="itemsearch" value="Vegetables"></td>
				  <td class="cells"> <input type="image" class="cellimg" src="images/cell2.jpg" title="Diary" name="itemsearch" value="Dairy"></td>
				  <td class="cells hide-col"> <input type="image" class="cellimg" src="images/cell3.jpg" title="Banana" name="itemsearch" value="Banana"></td>
				</tr>

				<tr>
					<td class="cells"> <input type="image" class="cellimg" src="images/cell4.jpg" title="Oil" name="itemsearch" value="Oil"></td>
				  <td class="cells"> <input type="image" class="cellimg" src="images/cell5.jpg" title="Fruits" name="itemsearch" value="Fruits"></td>
				  <td class="cells hide-col"> <input type="image" class="cellimg" src="images/cell6.jpg" title="Diary" name="itemsearch" value="Diary"></td>
				</tr>

				<tr class="hide-row">
					<td class="cells"> <input type="image" class="cellimg" src="images/cell3.jpg" title="Banana" name="itemsearch" value="Banana"></td>
					<td class="cells"> <input type="image" class="cellimg" src="images/cell6.jpg" title="Diary" name="itemsearch" value="Diary"></td>
					<td class="cells hide-col"> <input type="image" class="cellimg" src="images/cell6.jpg" title="Diary" name="itemsearch" value="Diary"></td>
				</tr>
			</table>
		</div><br/>

		</form>
	</div>

</div>
