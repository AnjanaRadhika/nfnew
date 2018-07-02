<div class="col-md-6">
  <div class="content-box">
        <form id="contactForm" class="contactForm" method="post" role="form">
          <h3>Contact Us</h3><br />
          <div id="contactsuccess">

          </div><hr />
    			<div class="form-row">
            <div class="form-group col-md-12">
						        <input type="text" class="form-control " name="name" placeholder="Name" maxlength="40" required>
            </div>
					</div>
          <div class="form-row">
            <div class="form-group input-group col-md-12">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">+91</span>
                    </div>
						        <input type="tel" class="form-control " name="phone" placeholder="Phone" maxlength="10" required autocomplete="nope" />
            </div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-12">
						        <input type="text" class="form-control " name="email" placeholder="Email" data-validation="email" data-validation-error-msg="You did not enter a valid e-mail" maxlength="40" required autocomplete="nope" />
            </div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-12">
						        <input type="text" class="form-control " name="subject" placeholder="Subject" maxlength="75" required autocomplete="nope" />
            </div>
					</div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <textarea class="form-control" type="textarea" id="message" name="message" placeholder="Message" maxlength="140" rows="7"></textarea>
                <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>
            </div>
          </div>
          <div id="res">

          </div>
        <button id="contactsubmit" class="btn btn-success " type="submit">Submit</button>
        </form>
  </div>
</div>
