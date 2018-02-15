<div id="forgotpassworddiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="forgotpassworddiv" aria-hidden="true">
	<div class="modal-dialog forgotpopup" role="document">
		<div class="modal-content">
			 <div class="modal-header">
					<h2>Forgot Password</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 				 <span aria-hidden="true">X</span>
	 			 </button>
			 </div>
			 <div class="modal-body">
						<form class="form" id="frmforgotpassword" action="#" method="post">
							<?php
							if(isset($forgotpwderror)){
								echo $forgotpwderror;
							}
							?>
							<label>To reset your password, please enter the email address you used to sign up </label>
							<br/>
							<div id="forgotemaildiv">
								<div class="input-group">
							    <span class="input-group-prepend"><i class="fa fa-envelope" aria-hidden="true"></i></span>
							    <input id="forgotemail" type="email" class="form-control" name="forgotemail" placeholder="Email" required>
							  </div><br/><br/>
							<input type="submit" name="forgotpwd-submit" value="Send"/></div><br/>
							<br>
							<span class="backtosignin" data-toggle="modal" data-target="#signindiv" data-dismiss="modal">Back to Sign In</span>
						</form>
				</div>
			</div>
		</div>
</div>
