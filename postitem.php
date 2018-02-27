<?php
//include('db_connection.php');
if($link = OpenCon()) {
  $query ="SELECT * FROM itemcategory";
  $results = runQuery($link,$query);
  $query ="SELECT * FROM measurements";
  $results1 = runQuery($link,$query);
  $query ="SELECT * FROM countries";
  $results2 = runQuery($link,$query);
  CloseCon($link);
}
?>
    <div class="col-lg-7 col-md-7 col-sm-7">
      <div class="content-box">
    		<h3>Post Advertisement</h3><br />
        <div id="successmessage">

        </div>
        <div id="sqlerror">

        </div>
        <hr />
          <form method="post" enctype="multipart/form-data" class="itemForm" id="itemForm">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="item_name">Item Name *</label>
                <input type="text" class="form-control form-element " name="item_name" id="item_name" placeholder="Item Name" required>
                <div class="invalid-feedback">
                  Please enter the Item Name.
                </div>
              </div>
              <div class="form-group col-md-8">
                <label for="category-list">Item Category *</label>
                <input type="hidden" name="category" id="category" value="" />
                <select id="category-list" class="form-control form-element custom-select" onChange="$('#category').val($('#category-list').val());">
                    <option value="">Select Category</option>
                    <?php
                    foreach($results as $category) {
                    ?>
                    <option value="<?php echo $category["categoryid"]; ?>"><?php echo $category["categoryname"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="invalid-feedback">
                  Please choose a category.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="itemdesc">Item Description</label>
                    <textarea class="form-control" name="itemdesc" id="itemdesc" placeholder="Item Description"></textarea>
                </div>
            </div>
            <div class="form-row" style="display:inline">
              <div class="form-group">
                    <label for="quantity">Quantity *</label>
                    <div class="input-group">
                    <input type="Number" class="form-control form-element col-md-4" name="quantity" id="quantity" required>
                    <!--<div class="invalid-feedback col-md-4">
                      Please enter the quantity
                    </div>-->
                    <input type="hidden" id="measurements" name="measurements" value="" />
                    <select form="itemForm" id="measurements-list" class="form-control form-element custom-select col-md-4" onChange="$('#measurements').val($('#measurements-list').val());">
                        <option value=""></option>
                        <?php
                        foreach($results1 as $measurements) {
                        ?>
                        <option value="<?php echo $measurements["measurementid"]; ?>">
                          <?php echo $measurements["measurementname"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <!--<div class="invalid-feedback col-md-4">
                      Please enter the measurement.
                    </div>-->
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="amount">Price range:</label>
                    <input type="text" name="amount" id="amount" readonly style="border:0; background-color:#daeee3; color:#f6931f; font-weight:bold;">
                    <div class="input-group">
                      <div class="form-control col-md-8" id="slider-range" style="position:relative;top:10px;left:8px;"></div>
              </div>
            </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="country-list">Country *</label>
                <input type="hidden" name="country" id="country" value="" />
                <select id="country-list" class="form-control form-element custom-select" onChange="getState(this.value);">
                    <option value="">Select Country</option>
                    <?php
                    foreach($results2 as $country) {
                    ?>
                    <option value="<?php echo $country["countryid"]; ?>"><?php echo $country["countryname"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="invalid-feedback col-md-6">
                  Please choose the Country.
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="state-list">State *</label>
                <input type="hidden" id="state" name="state" value="" />
                <select form="itemForm" id="state-list" class="form-control form-element custom-select" onChange="$('#state').val($('#state-list').val());">
                    <option value="">Select State</option>
                </select>
                <div class="invalid-feedback col-md-6">
                  Please choose the State.
                </div>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-9">
                   <label>Phone *</label>
                   <input type="hidden" id="phone" name="phone" value="" />
                   <div class="input-group" onKeyDown="$('#phone').val($('#tel1').val() + $('#tel2').val() + $('#tel3').val())">
                           <input type="tel" id="tel1" class="form-control form-element" value="" size="3" maxlength="3" required="required" title="" >-
                           <input type="tel" id="tel2" class="form-control form-element" value="" size="3" maxlength="3" required="required" title="" >-
                           <input type="tel" id="tel3" class="form-control form-element" value="" size="4" maxlength="4" required="required" title="" >
                           &nbsp;
                           <span class="input-group-btn">
                             <button class="btn btn-success btn-sm form-element"><i class="fa fa-phone" aria-hidden="true"></i> SMS Verification Code</button>
                           </span>
                   </div>
                   <div class="invalid-feedback col-md-9">
                     Please enter the phone number.
                   </div>
                </div>
                <div class="form-group col-md-3">

                </div>
                <div class="form-group col-md-3">
                  <label for="code">Verification Code</label>
                  <input type="Number" class="form-control form-element" name="code" id="code" placeholder="Enter OTP">
                  <div class="invalid-feedback col-md-3">
                    Verification failed!
                  </div>
                </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="contact_person">Contact Person *</label>
              <input type="text" class="form-control form-element" name="contact_person" id="contact_person" placeholder="Contact Person" required>

            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Address </label>
              <input type="text" class="form-control form-element" name="address1" placeholder="Address"><br />
              <input type="text" class="form-control form-element" name="address2" placeholder="Address">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="city">City *</label>
              <input type="text" class="form-control form-element" name="city" id="city" placeholder="City" required>
              <div class="invalid-feedback col-md-6">
                Please enter the city.
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="zipcode">Zipcode *</label>
              <input type="Number" class="form-control form-element" name="zipcode" id="zipcode" placeholder="Zipcode" required>
              <div class="invalid-feedback col-md-6">
                Please enter the zipcode.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12" id="upload">
                <div id="drop">
          				Browse or Drop images here to upload

          				<a class="btn btn-success btn-sm form-element">Browse</a>
          				<input id="fileupload" type="file" name="upl[]" multiple />
          			</div>

          			<ul>
          				<!-- The file uploads will be shown here -->
          			</ul>
          	</div>
            <div id="fileerror">

            </div>
          </div>

          <button class="btn btn-success button-submit form-element" type="submit">Post Adv</button>

          </form>
        </div>
</div>
