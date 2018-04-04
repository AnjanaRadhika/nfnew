<div id="signupdiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="signupdiv" aria-hidden="true">
	<div class="modal-dialog popup" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Sign Up</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">X</span>
			 	</button>
			</div>
			<div class="modal-body">
					<form class="form" id="contact" action="#" method="post">
						<?php
						if(isset($error)){
							echo $error;
						}
						?>
						<div class="input-group">
							<input type="text" class="form-control" name="name" id="name" placeholder="Enter Full Name  *" required />
						</div>
						<br/>
						<div class="input-group">
							<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address  *" required />
						</div>
						<br/>
						<div class="input-group">
							<input type="password" class="form-control" name="password" id="signuppassword" placeholder="************" required />
						</div>
						<br />
						<div class="bar" style="width:100%;height:22px;background:lightgrey;border:solid 0.5px;border-radius:5px;">
							<div class="progressbar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<br/>
						By registering, I accept the NeighbourhoodFarmers.com
						<a href="home.php?action=terms"><span id="termsofuseclick">Terms Of Use</span></a><br/>
						<input type="submit" name="signup-submit" class="btn" value="Sign Up" />
						<input type="button" class="btn cancel" data-dismiss="modal" value="Cancel" />
						<hr/>
						<div align="center"><span class="signinclick" data-toggle="modal" data-target="#signindiv" data-dismiss="modal">Sign in</span> if you are already a member</div>
					</form>
				</div>
		</div>
	</div>
</div>
