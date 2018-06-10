<?php
//include('db_connection.php');
if($link = OpenCon()) {
  $query ="SELECT * FROM itemcategory";
  $results = runQuery($link,$query);
  $query ="SELECT * FROM measurements";
  $results1 = runQuery($link,$query);
/*  $query ="SELECT * FROM countries";
  $results2 = runQuery($link,$query);*/
  $query ="SELECT * FROM states WHERE countryid = '101'";
  $results2 = runQuery($link, $query);
  CloseCon($link);
}
?>
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="content-box">
    		<h3>Submit Advertisement</h3><br />
        <div id="successmessage">

        </div>
        <div id="sqlerror">

        </div>
        <hr />
          <form method="post" enctype="multipart/form-data" class="itemForm" id="itemForm" autocomplete="off">
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="item_name">Item Name *</label>
                <input type="text" class="form-control  " name="item_name" id="item_name" placeholder="Item Name" required>
                <div class="invalid-feedback">
                  Please enter the Item Name.
                </div>
              </div>
              <div class="form-group col-md-8">
                <label for="category-list">Item Category *</label>
                <input type="hidden" name="category" id="category" value="" />
                <input type="hidden" name="categorytext" id="categorytext" value="" />
                <select id="category-list" class="form-control  custom-select" onChange="setCategory();" required>
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
                    <input type="Number" class="form-control  col-md-4" name="quantity" id="quantity" required>
                    <!--<div class="invalid-feedback col-md-4">
                      Please enter the quantity
                    </div>-->
                    <input type="hidden" id="measurements" name="measurements" value="" />
                    <select form="itemForm" id="measurements-list" class="form-control  custom-select col-md-4" onChange="$('#measurements').val($('#measurements-list').val());" required>
                        <option value="">Select Unit</option>
                        <?php
                        foreach($results1 as $measurements) {
                        ?>
                        <option value="<?php echo $measurements["measurementid"]; ?>">
                          <?php echo $measurements["measurementname"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <input type="hidden" id="sellorbuy" name="sellorbuy" value="For Sale" />
          					<select  form="itemForm" id="sellorbuy-list" class="form-control  custom-select col-md-3" onChange="$('#sellorbuy').val($('#sellorbuy-list').val());">
          						<option value="For Sale" selected> For Sale</option>
          						<option value="To Buy"> To Buy</option>
          					</select>
                    </div>
                  </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="amount">Price per Unit (&#8377):</label>
                <input type="hidden" name="amount" id="amount">
                <div class="input-group">
                  <select id="pricerange-list" class="form-control  custom-select" onChange="$('#amount').val($('#pricerange-list').val());">
                      <option value="">Select Price Range </option>
                      <option value="0 - 100">&#8377 0 - 100</option>
                      <option value="100 - 250">&#8377 100 - 250</option>
                      <option value="250 - 1000">&#8377 250 - 1000</option>
                      <option value="1000 - 2000">&#8377 1000 - 2000</option>
                      <option value="> 2000">> &#8377 2000</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label for="expiry">Effective Date</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="effectivedate" id="effectivedate"/>
                  <div class="input-group-addon dateicon"><span id="cal1"><i class="fa fa-calendar"></i></span>&nbsp;</div>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label for="expiry">Expiry Date *</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="expirydate" id="expirydate" required />
                  <div class="input-group-addon dateicon"><span id="cal"><i class="fa fa-calendar"></i></span>&nbsp;</div>
                </div>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                   <label>Phone *</label>
                   <input id="phonevalid"  name="phonevalid" type="hidden" value="1"/>
                   <input type="hidden" id="phone" name="phone" value="" />
                   <div class="input-group" onKeyUp="$('#phone').val($('#tel1').val() + $('#tel2').val() + $('#tel3').val())">
                           <input type="tel" id="tel1" class="form-control" value="" size="3" maxlength="3" required="required" title="" >-
                           <input type="tel" id="tel2" class="form-control" value="" size="3" maxlength="3" required="required" title="" >-
                           <input type="tel" id="tel3" class="form-control" value="" size="4" maxlength="4" required="required" title="" >
                           <div class="invalid-feedback">
                             The phone number needs to be verified.
                           </div>
                           <div class="valid-feedback">
                             Number Verified!
                           </div>
                           &nbsp;
                           <span class="input-group-btn">
                             <button id="showdiv" class="btn btn-success" data-toggle="modal" data-target="#verifydiv"><i class="fa fa-phone" aria-hidden="true"></i> Verify Phone</button>
                           </span>
                   </div>
                </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="contact_person">Contact Person *</label>
              <input type="text" class="form-control " name="contact_person" id="contact_person" placeholder="Contact Person" required>

            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="contact_email">Email *</label>
              <input type="text" class="form-control " name="contact_email" id="contact_email" placeholder="Contact Email" data-validation="email" data-validation-error-msg="You did not enter a valid e-mail" maxlength="40" required>

            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="hno">Flat No/Door No/House No </label>
              <input type="text" class="form-control " name="hno" id="hno" placeholder="Flat No/Door No/House No">
            </div>
            <div class="form-group col-md-6">
              <label for="hname">Flat/Villa/House Name </label>
              <input type="text" class="form-control " name="hname" id="hname" placeholder="Flat/Villa/House Name">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="bname">Building No </label>
              <input type="text" class="form-control " name="bno" id="bno" placeholder="Building No">
            </div>
            <div class="form-group col-md-4">
              <label for="bname">Building Name </label>
              <input type="text" class="form-control " name="bname" id="bname" placeholder="Building Name">
            </div>
            <div class="form-group col-md-5">
              <label for="street">Street </label>
              <input type="text" class="form-control " name="street" id="street" placeholder="Street">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <input type="text" class="form-control " name="address1" placeholder="Address">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="state-list">State *</label>
              <input type="hidden" id="state" name="state" value="" />
              <select form="itemForm" id="state-list" class="form-control  custom-select" onChange="getDistrict(this.value);" required>
                  <option value="">Select State</option>
                  <?php
                  foreach($results2 as $state) {
                  ?>
                  <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                  <?php
                  }
                  ?>
              </select>
              <div class="invalid-feedback col-md-6">
                Please choose the State.
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="district-list">District *</label>
              <input type="hidden" id="district" name="district" value="" />
              <select form="itemForm" id="district-list" class="form-control  custom-select" onChange="getCity(this.value);" required>
              </select>
              <div class="invalid-feedback col-md-6">
                Please enter the district.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="town">Town / Village * </label>
              <input type="text" class="form-control ui-autocomplete-input" name="town" id="town" placeholder="Town / Village" required>
              <div class="invalid-feedback col-md-6">
                Please enter the Town / Village.
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="nhood">Neighbourhood </label>
              <input type="text" class="form-control ui-autocomplete-input" name="nhood" id="nhood" placeholder="Neighbourhood" autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="zipcode">Zipcode *</label>
              <input type="Number" class="form-control ui-autocomplete-input" name="zipcode" id="zipcode" placeholder="Zipcode" autocomplete="off" required>
              <div class="invalid-feedback col-md-6">
                Please enter the zipcode.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12" id="upload">
                <div id="drop">
          				Browse or Drop images here to upload

          				<a class="btn btn-success btn-sm ">Browse</a>
          				<input id="fileupload" type="file" name="upl[]" multiple />
          			</div>

          			<ul>
          				<!-- The file uploads will be shown here -->
          			</ul>
          	</div>
            <div id="fileerror">

            </div>
          </div>
          <p>
            By clicking 'Submit' you agree to our <span id="termsofuseclick1" data-toggle="modal" data-target="#termsofusediv" style="color:blue;cursor:pointer;">Terms of Use</span> & <span id="termsofuseclick1" data-toggle="modal" data-target="#termsofusediv" style="color:blue;cursor:pointer;">Posting Rules</span>
          </p>
          <button class="btn btn-success button-submit " type="submit">Submit</button>

          </form>
        </div>
        <!-- Verify Phone Number -->
        <div id="verifydiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="msgdiv" aria-hidden="true">
          <div class="modal-dialog popup" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">
                  Verify Mobile
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">X</span>
                </button>
              </div>
              <div class="modal-body">
                <form name="verifymodal" id="verifymodal" class="centered" action="getverificationcode.php">
                  <div class="form-group col-md-12">
                    <div id="msgsuccess">

                    </div>
                    <input type="hidden" id="hdnmobno" name="mob_number" value="" />
                    <label for="code">Enter the 6 digit OTP send to <span id="verifyphone"></span> </label>
                    <input type="tel" class="form-control" name="code" id="code" maxlength="6" placeholder="Enter OTP Code" required>
                    <div class="invalid-feedback col-md-12">
                      Verification failed!
                    </div>
                  </div>
                  <div align="center">
                    <input id="btnvalidate" type="button" class="btn cancel" value="Validate"/><br /><br />
                    <strong><a id="resendotp" href="#">Resend One-Time Password</a></strong><br />
                    Entered a wrong number?
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal -->

</div>
