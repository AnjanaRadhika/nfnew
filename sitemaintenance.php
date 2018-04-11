<?php
//include('db_connection.php');
if($link = OpenCon()) {
  $query ="SELECT * FROM itemcategory";
  $results = runQuery($link,$query);
  $query ="SELECT * FROM measurements";
  $results1 = runQuery($link,$query);
  $query ="SELECT * FROM countries";
  $results2 = runQuery($link,$query);
  $query ="SELECT * FROM itemstatus";
  $results3 = runQuery($link,$query);
  CloseCon($link);
}
?>
<div class="col-md-6"><br />
  <div>
    <h3>Site Settings</h3><hr />
    <div class="block">
      <span class="pull-left"><strong>Item Category</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newitemcat" role="button"
        aria-expanded="false" aria-controls="newitemcat" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newitemcat">
        <div class="card card-body content-box">
          <form id="newItmCatForm" class="newItmCatForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">
                   <input type="hidden" id="hdnItmCat" name="hdnItmCat" value="" />
                   <div class="input-group">
                        <input type="text" id="txtItmCat" class="form-control" name="txtItmCat" value="" placeholder="Item Category"/>&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selItemCategory">
                           <?php
                           foreach($results as $category) {
                           ?>
                           <option value="<?php echo $category["categoryid"]; ?>"><?php echo $category["categoryname"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnremove"> Remove</button>
                         </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>Unit of Measurement</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newuom" role="button"
        aria-expanded="false" aria-controls="uom" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newuom">
        <div class="card card-body content-box">
          <form id="newUomForm" class="newUomForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">
                   <input type="hidden" id="hdnUom" name="hdnUom" value="" />
                   <div class="input-group">
                        <input type="text" id="newUom" class="form-control" name="newUom" value="" placeholder="Unit of Measurement"/>&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selUOM">
                           <?php
                           foreach($results1 as $measurements) {
                           ?>
                           <option value="<?php echo $measurements["measurementid"]; ?>">
                             <?php echo $measurements["measurementname"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                         <span class="input-group-btn ">
                           <button class="btn btn-success btnremove"> Remove</button>
                         </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>Country</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newcountry" role="button"
        aria-expanded="false" aria-controls="uom" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newcountry">
        <div class="card card-body content-box">
          <form id="newCountryForm" class="newCountryForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">
                   <div class="successmsg"></div>
                   <input type="hidden" id="hdnCountry" name="hdnCountry" value="" />
                   <div class="input-group">
                        <input type="text" id="txtCountry" class="form-control" name="txtCountry" value="" placeholder="Country Name" />&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selCountry">
                           <?php
                           foreach($results2 as $country) {
                           ?>
                           <option value="<?php echo $country["countryid"]; ?>"><?php echo $country["countryname"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnremove"> Remove</button>
                         </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>State</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newstate" role="button"
        aria-expanded="false" aria-controls="uom" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newstate">
        <div class="card card-body content-box">
          <form id="newStateForm" class="newStateForm" method="post" role="form">
            <div class="successmsg"></div>
            <div class="form-row">
                <div class="form-group col-md-12">

                   <input type="hidden" id="hdnItmCat" name="hdnItmCat" value="" />
                   <div class="input-group">
                        <input type="text" id="txtItmCat" class="form-control" name="txtItmCat" value="" required />&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <input type="hidden" name="country" id="country" value="" />
                         <select class="form-control" id="country-list" onChange="getState(this.value);">
                           <option value="">Select Country</option>
                           <?php
                           foreach($results2 as $country) {
                           ?>
                           <option value="<?php echo $country["countryid"]; ?>"><?php echo $country["countryname"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                           <select multiple class="form-control" id="state-list">
                              <option value=""> Select State</option>
                           </select>
                   </div><br />
                   <div class="form-group">
                     <span class="pull-right">
                       <button class="btn btn-success"> Remove</button>
                     </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>Item Status</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newitemstatus" role="button"
        aria-expanded="false" aria-controls="newitemcat" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newitemstatus">
        <div class="card card-body content-box">
          <form id="newItmCatForm" class="newItmCatForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">
                   <div class="successmsg"></div>
                   <input type="hidden" id="hdnItmCat" name="hdnItmCat" value="" />
                   <div class="input-group">
                        <input type="text" id="txtItmCat" class="form-control" name="txtItmCat" value="" placeholder="Item Status"/>&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selItemCategory">
                           <?php
                           foreach($results3 as $status) {
                           ?>
                           <option value="<?php echo $status["statusid"]; ?>"><?php echo $status["statusdesc"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnremove"> Remove</button>
                         </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>Clear History</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#clearhistory" role="button"
        aria-expanded="false" aria-controls="newitemcat" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="clearhistory">
        <div class="card card-body content-box">
          <form id="newItmCatForm" class="newItmCatForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">
                   <div class="successmsg"></div>
                   <input type="hidden" id="hdnItmCat" name="hdnItmCat" value="" />
                   <div class="input-group">
                         <span class="input-group-btn">
                           <button class="btn btn-success btnremoveitems"> Clear Expired Items</button> &nbsp;
                           <button class="btn btn-success btnremovewishlist"> Clear Expired Wishlist</button> &nbsp;
                         </span>
                    </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
  </div>
</div>
