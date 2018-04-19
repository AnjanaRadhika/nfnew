<div id="msgdiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="msgdiv" aria-hidden="true">
  <div class="modal-dialog popup" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <?php
          if(array_key_exists('action',$_GET)) {
            if($_GET['action'] == 'search') {
                echo "Add Wishlist";
            } else if($_GET['action'] == 'mywishlist') {
                echo "My Wishlist";
            } else if($_GET['action'] == 'site') {
                echo "Site Maintenance";
            }
          }
          ?>
        </h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="msgmodal" class="centered" action="home.php">
          <div id="msg">

          </div>
          <div align="center">
            <input type="button" class="btn cancel" data-dismiss="modal" value="OK"/>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
