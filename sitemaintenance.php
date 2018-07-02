<?php
//include('db_connection.php');
if($link = OpenCon()) {
  $query ="SELECT * FROM itemcategory";
  $results = runQuery($link,$query);
  $query ="SELECT * FROM measurements";
  $results1 = runQuery($link,$query);
  $query ="SELECT * FROM states where countryid = '101'";
  $results2 = runQuery($link,$query);
  $query ="SELECT * FROM itemstatus";
  $results3 = runQuery($link,$query);
  $query ="SELECT * FROM policy";
  $results4 = runQuery($link,$query);
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
                   <input type="hidden" id="hdnCat" name="hdnCat" value="Category" />
                   <div class="input-group">
                        <input type="text" class="form-control" name="txtItmCat" value="" placeholder="Item Category" autocomplete="off" />&nbsp;
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
                   <input type="hidden" id="hdnUom" name="hdnUom" value="Uom" />
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
      <span class="pull-left"><strong>State</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newstate" role="button"
        aria-expanded="false" aria-controls="state" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newstate">
        <div class="card card-body content-box">
          <form id="newstateForm" class="newstateForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">

                   <input type="hidden" id="hdnstate" name="hdnstate" value="State" />
                   <div class="input-group">
                        <input type="text" id="newstate" class="form-control" name="newState" value="" placeholder="State Name" autocomplete="off" />&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selState">
                           <?php
                           foreach($results2 as $state) {
                           ?>
                           <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
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
      <span class="pull-left"><strong>District</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newdistrict" role="button"
        aria-expanded="false" aria-controls="district" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newdistrict">
        <div class="card card-body content-box">
          <form id="newDistrictForm" class="newDistrictForm" method="post" role="form">

            <input type="hidden" id="hdndistrict" name="hdndistrict" value="District" />
            <div class="form-row">
                <div class="form-group col-md-12">
                   <div class="input-group">
                     <select class="form-control" id="d-state-list1" onChange="">
                       <option value="">Select State</option>
                       <?php
                       foreach($results2 as $state) {
                       ?>
                       <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                       <?php
                       }
                       ?>
                     </select>
                       &nbsp;
                        <input type="text" class="form-control" name="txtItmCat" placeholder="District Name" value="" required autocomplete="off" />&nbsp;
                    </div><br />
                    <div class="form-group">
                      <span class="pull-right">
                        <button class="btn btn-success btnaddnew"> Add New</button>
                      </span>
                    </div><br />
                    <div class="input-group">
                         <select class="form-control" id="d-state-list" onChange="getDistrict(this.value, '#d-district-list');">
                           <option value="">Select State</option>
                           <?php
                           foreach($results2 as $state) {
                           ?>
                           <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                           <select multiple class="form-control" id="d-district-list">
                              <option value=""> Select District</option>
                           </select>
                   </div><br />
                   <div class="form-group">
                     <span class="pull-right">
                       <button class="btn btn-success btnremovedistrict"> Remove</button>
                     </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <div class="block">
      <span class="pull-left"><strong>Town</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newtown" role="button"
        aria-expanded="false" aria-controls="town" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newtown">
        <div class="card card-body content-box">
          <form id="newTownForm" class="newTownForm" method="post" role="form">

            <div class="form-row">
                <div class="form-group col-md-12">
                   <input type="hidden" id="hdnTown" name="hdnTown" value="Town" />
                   <div class="input-group">
                        <select class="form-control" id="t-state-list1" onChange="getDistrict(this.value, '#t-district-list1');">
                          <option value="">Select State</option>
                          <?php
                          foreach($results2 as $state) {
                          ?>
                          <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                          &nbsp;
                          <select class="form-control" id="t-district-list1" onChange="">
                             <option value=""> Select District</option>
                          </select>
                  </div><br />
                   <div class="input-group">
                        <input type="text" class="form-control" name="txtItmCat" placeholder="Town Name" required autocomplete="nope" />&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnaddtown"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select class="form-control" id="t-state-list" onChange="getDistrict(this.value, '#t-district-list');">
                           <option value="">Select State</option>
                           <?php
                           foreach($results2 as $state) {
                           ?>
                           <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                           &nbsp;
                           <select class="form-control" id="t-district-list" onChange="getTown(this.value, '#t-town-list');">
                              <option value=""> Select District</option>
                           </select>
                   </div><br />
                   <div class="input-group">
                     <select multiple class="form-control" id="t-town-list">
                        <option value=""> Select Town</option>
                     </select>
                   </div><br />
                   <div class="form-group">
                     <span class="pull-right">
                       <button class="btn btn-success btnremovevalues"> Remove</button>
                     </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <!-- Neighbourhood -->
    <div class="block">
      <span class="pull-left"><strong>Neighbourhood</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#newneighbourhood" role="button"
        aria-expanded="false" aria-controls="neighbourhood" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="newneighbourhood">
        <div class="card card-body content-box">
          <form id="newNeighbourhoodForm" class="newNeighbourhoodForm" method="post" role="form">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="hidden" id="hdnneighbourhood" name="hdnneighbourhood" value="Neighbourhood" />
                    <div class="input-group">
                         <select class="form-control" id="n-state-list1" onChange="getDistrict(this.value, '#n-district-list1');">
                           <option value="">Select State</option>
                           <?php
                           foreach($results2 as $state) {
                           ?>
                           <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                         &nbsp;
                         <select class="form-control" id="n-district-list1" onChange="">
                            <option value=""> Select District</option>
                         </select>
                 </div><br />
                   <div class="input-group">
                        <input type="text" class="form-control col-md-6" name="txtItmCat" placeholder="Neighbourhood" value="" required autocomplete="off" />&nbsp;
                        <input type="text" class="form-control col-md-3" name="txtItmCat1" placeholder="Zipcode" value="" required autocomplete="nope" />&nbsp;
                         <span class="input-group-btn col-md-3">
                           <button class="btn btn-success btnaddnhood"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select class="form-control" id="n-state-list" onChange="getDistrict(this.value, '#n-district-list');">
                           <option value="">Select State</option>
                           <?php
                           foreach($results2 as $state) {
                           ?>
                           <option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
                           <?php
                           }
                           ?>
                         </select>
                         &nbsp;
                         <select class="form-control" id="n-district-list" onChange="getNeighbourhoods(this.value, '#n-neighbourhood-list');">
                            <option value=""> Select District</option>
                         </select>
                 </div><br />
                 <div class="input-group">
                   <select multiple class="form-control" id="n-neighbourhood-list">
                      <option value=""> Select Neighbourhood</option>
                   </select>
                 </div><br />
                   <div class="form-group">
                     <span class="pull-right">
                       <button class="btn btn-success btnremovevalues"> Remove</button>
                     </span>
                   </div>
                </div>
              </div>
          </form>
        </div><hr />
      </div>
    </div><br />
    <!-- Item Status -->
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
          <form id="newItmStatusForm" class="newItmStatusForm" method="post" role="form">
            <div class="form-row">
                <div class="form-group col-md-12">

                   <input type="hidden" id="hdnItmStatus" name="hdnItmStatus" value="ItemStatus" />
                   <div class="input-group">
                        <input type="text" class="form-control" name="txtItmCat" value="" placeholder="Item Status" autocomplete="off" />&nbsp;
                         <span class="input-group-btn">
                           <button class="btn btn-success btnadd"> Add New</button>
                         </span>
                    </div><br />
                    <div class="input-group">
                         <select multiple class="form-control" id="selItemStatus">
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
    <!-- Policy update -->
    <div class="block">
      <span class="pull-left"><strong>Terms & Policy Update</strong></span>
      <span class="pull-right">
        <a class="btn btn-success" data-toggle="collapse" href="#policyupdate" role="button"
        aria-expanded="false" aria-controls="policyupdate" onclick="if($(this).text()=='-') $(this).text('+'); else $(this).text('-');">
          +
        </a>
      </span>
      <div style='clear:both'></div>
      <div class="collapse" id="policyupdate">
        <div class="card card-body content-box">
          <form id="newPolicyForm" class="newPolicyForm" method="post" role="form">

            <input type="hidden" id="hdnpolicy" name="hdnpolicy" value="Policy" />
            <div class="form-row">
                <div class="form-group col-md-12">
                   <div class="input-group">
                         <input type="text" class="form-control" name="effectivedate" id="effectivedate" placeholder="Policy Update On" autocomplete="off" />
                         <div class="input-group-addon dateicon"><span id="cal1"><i class="fa fa-calendar"></i></span>&nbsp;</div><br />
                         <input type="text" class="form-control" name="version" id="version" placeholder="Policy Version" />
                         <span class="input-group-btn">
                           <button class="btn btn-success btnupdatepolicy"> Update</button>
                         </span>
                    </div><br />
                    <strong>
                    Policy Version History
                  </strong><br /><br />
                    <div class="input-group">
                      <table id="policytable" class="table table-bordred table-striped">
                        <thead>
                          <th>Version</th>
                          <th>Date</th>
                          <?php foreach($results4 as $pver) { ?>
                              <tr>
                                <td>
                                  <?php echo date_format(date_create($pver['updatedate']), 'd/m/Y'); ?>
                                </td>
                                <td>
                                  <?php echo $pver['version'];?>
                                </td>
                              </tr>
                          <?php } ?>
                        </thead>
                      </table>
                   </div><br />
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
          <form id="newExpiredItmForm" class="newExpiredItmForm" method="post" role="form">
            <div class="form-row">
              <input type="hidden" id="hdnclear" name="hdnclear" value="" />
                <div class="form-group col-md-12">
                  <div class="input-group">
                        <input type="text" class="form-control" name="effectivedate" id="expirydate1" placeholder="Expired Before" autocomplete="off" />
                        <div class="input-group-addon dateicon"><span id="cal2"><i class="fa fa-calendar"></i></span>&nbsp;</div><br />
                        <span class="input-group-btn">
                          <button class="btn btn-success btnremoveitems"> Clear Expired Items</button>
                        </span>
                   </div><br />
                   <div class="input-group">
                       <input type="text" class="form-control" name="effectivedate" id="expirydate" placeholder="Expired Before" autocomplete="off" />
                       <div class="input-group-addon dateicon"><span id="cal"><i class="fa fa-calendar"></i></span>&nbsp;</div><br />
                       <span class="input-group-btn">
                         <button class="btn btn-success btnremovewishlist"> Clear Expired Favorites</button>
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
