<?php
if($link = OpenCon()) {
  $query ="SELECT * FROM itemcategory";
  $results = runQuery($link,$query);
  CloseCon($link);
}
 ?>
<div class="col-md-6">
  <div class="content-box">
        <form id="wishForm" class="wishForm" method="post" role="form">
          <h3>New Item Tag</h3><br />
          <div id="addwishmsg">

          </div><hr />
    			<div class="form-row">
            <div class="form-group col-md-12">
						        <input type="text" class="form-control form-element" name="wishtitle" placeholder="Item Name" required>
            </div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-12">
              <input type="hidden" name="category" id="category" value="" />
              <select id="category-list" class="form-control form-element custom-select" onChange="$('#category').val($('#category-list').val());">
                  <option value="">Select Item Category</option>
                  <?php
                  foreach($results as $category) {
                  ?>
                  <option value="<?php echo $category["categoryid"]; ?>"><?php echo $category["categoryname"]; ?></option>
                  <?php
                  }
                  ?>
              </select>
            </div>
					</div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <textarea class="form-control" type="textarea" id="description" name="description" placeholder="More Details" maxlength="140" rows="7"></textarea>
                <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>
            </div>
          </div>
          <div id="res">

          </div>
        <button id="addwish" class="btn btn-success" type="submit">Save</button>
        </form>
  </div>
</div>
