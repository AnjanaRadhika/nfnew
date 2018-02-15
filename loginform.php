<div id="signindiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="signindiv" aria-hidden="true">
	<div class="modal-dialog popup" role="document">
	<div class="modal-content">
		 <div class="modal-header">
			 <h2 class="modal-title">Sign In</h2>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">X</span>
			 </button>
		 </div>
		  <div class="modal-body">
				<form class="form" action="home.php" id="login" method="post">
					<?php
					if(isset($loginerror)){
						echo $loginerror;
					}
					?>
					<div class="input-group">
						<span class="input-group-prepend">
				    	<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
				    <input id="username" type="text" class="form-control" name="username" placeholder="Enter Email Address" required>
				  </div>
					<br/>
					<div class="input-group">
						<span class="input-group-prepend">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
						<input type="password" class="form-control" name="password" id="password" placeholder="************" required /><br/>
					</div>
					<br/>
					<input type="submit" class="btn" id="loginbtn" name="login" value="Login"/>
					<input type="button" class="btn cancel" data-dismiss="modal" value="Cancel"/>
					<br/></br/>
					<span id="forgot" data-toggle="modal" data-target="#forgotpassworddiv" data-dismiss="modal">Forgot Password?</span>
					<hr/>
					<div align="center"><span id="signupclick" data-toggle="modal" data-target="#signupdiv" data-dismiss="modal">Sign up</span> if you are not a member</div>

				</form>
			</div>
		</div>
	</div>
</div>
