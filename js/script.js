$(document).ajaxStart(function() {
    console.log("START");
    $('body *').css('cursor','wait');
}).ajaxStop(function() {
    console.log("END");
    $('body *').css('cursor','');
});

//To reset the modal forms on closing or dismissing
$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).find('.alert-danger').text('');
    $(this).find('form')[0].reset();
});

$("#signuppassword, #newpassword").bind("keyup", function () {
 
	   //Regular Expressions.
	    var regex = [];
	    regex.push("[A-Z]"); //Uppercase Alphabet.
	    regex.push("[a-z]"); //Lowercase Alphabet.
	    regex.push("[0-9]"); //Digit.
	    regex.push("[$@$!%*#?&]"); //Special Character.
	 
	    var passed = 0;
	 
	    //Validate for each Regular Expression.
	    for (var i = 0; i < regex.length; i++) {
	       if (new RegExp(regex[i]).test($(this).val())) {
	             passed++;
	        }
	    }
	 
	 
	    //Validate for length of Password.
	    if (passed > 2 && $(this).val().length > 8) {
	        passed++;
	    }
	 
	     //Display status.
	    var color = "";
	    var strength = "";
		var width = "";

	            switch (passed) {
	                case 0:
	                case 1:
	                    strength = "<p>Weak</p>";
	                    color = "darkorange";
						width = "25%";

	                    break;
	                case 2:
	                    strength = "<p>Good</p>";
	                    color = "darkcyan";
						width = "50%";

	                    break;
	                case 3:
	                case 4:
	                    strength = "<p>Strong</p>";
	                    color = "darkturquoise";
						width = "75%";

	                    break;
	                case 5:
	                    strength = "<p>Very Strong</p>";
	                    color = "#4CAF50";
						width = "100%";

	                    break;
	            }

	$(".progressbar").css("width", width);
	$(".progressbar").css("background", color);
	$(".progressbar").css("color", "white");
	$(".progressbar").css("border-radius", "5px");
	$(".progressbar").css("text-align", "center");
	$(".progressbar").html(strength);

});

var ul = $('#upload ul');
var filesList = [];

$('#drop a').click(function(){
    // Simulate a click on the file input button
    // to show the file browser dialog
    $(this).parent().find('input').click();
});

// Initialize the jQuery File Upload plugin
$('#fileupload').fileupload({

    autoupload: false,

    // This element will accept file drag/drop uploading
    dropZone: $('#drop'),

    // This function is called when a file is added to the queue;
    // either via the browse button, or via drag/drop:
    add: function (e, data) {

        var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
            ' data-fgColor="green" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span>X</span></li>');

        $.each(data.files, function (index, file) {

          filesList.push(data.files[index]);
          // Append the file name and file size
          tpl.find('p').text(data.files[index].name)
                       .append('<i>' + formatFileSize(data.files[index].size) + '</i>');

          // Add the HTML to the UL element
          data.context = tpl.appendTo(ul);

          // Initialize the knob plugin
          tpl.find('input').knob();
        });

        // Listen for clicks on the cancel icon
        tpl.find('span').click(function(){

            if(tpl.hasClass('working')){
               //jqXHR.abort();

               $.each(data.files, function (index, file) {
                 $.each(filesList, function (index1, item) {
                   if(item == file)
                     filesList.splice($.inArray(item,filesList),1);
                 });
               });
            }

            tpl.fadeOut(function(){
                tpl.remove();
            });

        });

        // Automatically upload the file once it is added to the queue
        //var jqXHR = data.submit();
    },

    fail:function(e, data){
        // Something has gone wrong!
        data.context.addClass('error');
    }

});


// Prevent the default action when a file is dropped on the window
$(document).on('drop dragover', function (e) {
    e.preventDefault();
});

// Helper function that formats the file sizes
function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
        return '';
    }

    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }

    return (bytes / 1000).toFixed(2) + ' KB';
}

function getState(val) {
	$('#country').val($('#country-list').val());
	$.ajax({
	type: "POST",
	url: "getstate.php",
	data:'country_id='+val,
	success: function(res){
		$("#state-list").html(res);
	}
	});
}

function sendVerificationCode(val) {
	$.ajax({
	type: "POST",
	url: "getverificationcode.php",
	data:'mob_number='+val,
	dataType: json}).done(function(response){

	});
}


//post item form ready
$(function() {

    var itemForm = $('#itemForm');

    itemForm.submit(function (e) {
    		e.preventDefault();
    		resetErrors();
    		postForm(this);
    });

    $("input[type='tel']").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(this).next("input[type='tel']").focus();
        }
    });
});


function resetErrors() {
    $('.itemForm input').removeClass('is-invalid');
    $('.itemForm input').removeClass('is-valid');
}

function postForm(itemForm) {

    var formdata = new FormData(itemForm);

    if (filesList.length > 0) {
			console.log("multi file submit" + filesList.length);
      for (var i = 0; i < filesList.length; i++) {
          formdata.append('files[]', filesList[i]);
      }

		} else {
			console.log("plain default form submit");
		}

    $.ajax({
        type: "POST",
        data: formdata,
        url: 'itemsubmit.php',
        contentType: false,
        processData: false,
  			success: function (response) {
        var successbool = "true";
				var invalidfields = [];

        $('#sqlerror').html("");
        $('#sqlerror').removeClass("alert alert-danger");

        try {
    				var jsonObj = $.parseJSON(response);

            for (var i = 0; i < jsonObj.length; i++) {
               var status = jsonObj[i].status;
               var field = jsonObj[i].field;

               if (status == "error") {
    								$('#successmessage').removeClass("alert alert-danger");
     								$('#successmessage').removeClass("alert alert-success");
     								$('#fileerror').removeClass("alert alert-danger");
    						 if(field == "category" || field == "measurements" || field == "country" || field == "state") {
    							 $('.itemForm select[id="' + field + '-list"]').addClass('is-invalid');
    						 } else if(field == "phone") {
    							 $('.itemForm input[id="tel1"]').addClass('is-invalid');
    							 $('.itemForm input[id="tel2"]').addClass('is-invalid');
    							 $('.itemForm input[id="tel3"]').addClass('is-invalid');
    						 } else if(field == "imagesextn") {
    									$('#fileerror').html("<p>Sorry, only JPG, JPEG, JFIF, PNG, GIF & ZIP files are allowed!</p>");
    									$('#fileerror').addClass("alert alert-danger");
    						 } else if(field == "images") {
    							 $('#fileerror').html("<p>Sorry, your file was not uploaded!</p>");
    							 $('#fileerror').addClass("alert alert-danger");
    						 } else if(field == "itemForm") {
    								$('#successmessage').html("<p>Some problem occured. Please try again later!</p>");
    								$('#successmessage').addClass("alert alert-danger");
    						 } else {
                 		$('.itemForm input[name="' + field + '"]').addClass('is-invalid');
    					 		}
    						 invalidfields[i] = field;
                 successbool = "false";
               }
            }
        } catch(e) {
            successbool = "false";
  					$('#sqlerror').html(response);
            $('#sqlerror').addClass("alert alert-danger");
        }
				$('#successmessage').removeClass("alert alert-danger");
				$('#successmessage').removeClass("alert alert-success");
				$('#fileerror').removeClass("alert alert-danger");
        if (successbool=="true") {
            $('.itemForm')[0].reset();
            $("#fileupload").find(".files").empty();
						$('#successmessage').html("<p>Post Adv completed successfully!</p>");
						$('#successmessage').addClass("alert alert-success");
        } else {
						if(invalidfields[0] == "category" || invalidfields[0] == "measurements" || invalidfields[0] == "country" || invalidfields[0] == "state") {
							 $('.itemForm select[id="' + invalidfields[0] + '-list"]').focus();
						} else if(invalidfields[0] == "phone") {
							 $('.itemForm input[id="tel1"]').focus();
						} else {
								$('.itemForm input[name="' + invalidfields[0] + '"]').focus();
						}
				}
    },
		complete:function(){
      $('body, html').animate({scrollTop:$('.itemForm').parent().parent().offset().top - 200}, 'slow');
   	},
		error: function(err) {
			alert("error " + err.status + " " + err.statusText);
		}
	});
}

//contact Form

var formdata = {};

$('#characterLeft').text('140 characters left');
$('#message,#description').keydown(function () {
		$('#characterLeft').css("color","red");
		var max = 140;
		var len = $(this).val().length;
		if (len >= max) {
				$('#characterLeft').text('You have reached the limit');
		}
		else {
				var ch = max - len;
				$('#characterLeft').text(ch + ' characters left');
		}
});

$('#contactForm').submit(function(e){
	e.preventDefault();
	$('#contactsubmit').addClass('disabled');
	$.each($('.contactForm input'), function(i, v) {
			if (v.type !== 'submit') {
					formdata[v.name] = v.value;
			}
	});
	formdata.message = $('#message').val();

	$.ajax({
		type: "POST",
		data: formdata,
		url: 'contactsubmit.php',
		success: function (response) {
			/*if(response) {
				$('#res').html(response);
			}*/
				var jsonObj = $.parseJSON(response);
				for (var i = 0; i < jsonObj.length; i++) {
					 var status = jsonObj[i].status;
					 var message = jsonObj[i].message;
					 $('#contactsuccess').removeClass("alert alert-danger");
	 				 $('#contactsuccess').removeClass("alert alert-success");
					 $('#contactsuccess').html("<p>" + message +"</p>");
					 if(status == 'error') {
					 		$('#contactsuccess').addClass("alert alert-danger");
					 } else {
						 $('.contactForm')[0].reset();
						 	$('#contactsuccess').addClass("alert alert-success");
					 }
				 }
		},
		complete:function(){
      $('body, html').animate({scrollTop:$('.contactForm').parent().parent().offset().top - 200}, 'slow');
   	},
		error: function(err) {
			alert("error " + err.status + " " + err.statusText);
		}
	});
	$('#contactsubmit').removeClass('disabled');
});

$('#wishForm').submit(function(e){
	e.preventDefault();
	$('#addwish').addClass('disabled');
	$.each($('.wishForm input'), function(i, v) {
			if (v.type !== 'submit') {
					formdata[v.name] = v.value;
			}
	});
	formdata.description = $('#description').val();

// New Wish
	$.ajax({
		type: "POST",
		data: formdata,
		url: 'addwish.php',
    dataType: 'HTML' ,
		success: function (response) {
					 $('#addwishmsg').html(response);
		},
		complete:function(){
      $('.wishForm')[0].reset();
      $('body, html').animate({scrollTop:$('.wishForm').parent().parent().offset().top - 200}, 'slow');
   	},
		error: function(err) {
			alert("error " + err.status + " " + err.statusText);
		}
	});
	$('#addwish').removeClass('disabled');
});


//pagination item search results
$('#myPager>li>a.page').click(function(e) {
    var nextpage, prevpage;
    var pagelinkid, pagenextid,  pageprevid;

    if($(this).attr('id')==='next') {
        nextpage = parseInt($('#curpage').val()) + 1;
        prevpage = parseInt($('#curpage').val());
        pagelinkid = '#pagelink'+nextpage;
        pagenextid =  '#page'+nextpage;
        pageprevid =  '#page'+prevpage;
        $(pagelinkid).addClass('active');
        $(this).removeClass('active');
        $('#curpage').val(nextpage);
        $(pageprevid).hide();
        $(pagenextid).show();
    } else if($(this).attr('id')==='prev') {
        prevpage = parseInt($('#curpage').val());
        nextpage = parseInt($('#curpage').val()) - 1;
        pagelinkid = '#pagelink'+nextpage;
        pagenextid =  '#page'+nextpage;
        pageprevid =  '#page'+prevpage;
        $(pagelinkid).addClass('active');
        $(this).removeClass('active');
        $('#curpage').val(nextpage);
        $(pageprevid).hide();
        $(pagenextid).show();
    } else {
        $('#curpage').val($(this).text());
        var showpageid = '#page'+parseInt($(this).text());
        var numpages = parseInt($('#numpages').val());
        for(var i = 1;i<numpages + 1; i++) {
          if(i === parseInt($(this).text())){
            $(showpageid).show();
          } else {
            $('#page'+i).hide();
          }
        }
    }
    var lastpage = parseInt($('#numpages').val());

    if(parseInt($('#curpage').val()) > 1) {
        $('#prev').removeClass('disabled');
    } else if(parseInt($('#curpage').val()) == 1) {
        $('#prev').addClass('disabled');
    }
    if(parseInt($('#curpage').val()) == lastpage) {
        $('#next').addClass('disabled');
    } else if(parseInt($('#curpage').val()) == lastpage - 1) {
        $('#next').removeClass('disabled');
    }
    $('body, html').animate({scrollTop:$('.searchItemForm').parent().parent().offset().top - 200}, 'slow');
});

//item status update
$('#itemdetailform').submit(function(e) {
  if($('#itemstatus').val()==="") {
    $('#status-list').addClass('is-invalid');
    return false;
  }
});

//edit user Detail
$('.edituserbtn').click(function(e){
  e.preventDefault();
  var userid = $(this).data('userid');
  $.ajax({
    url: 'userlistsubmit.php',
    data: {userid: userid, action: 'edituser'},
    type: 'GET',
    dataType: 'HTML'
  }).done(function(res){
    $('#userlist').find('.usersearch').hide();
    $('#userlist').find('.content-box').html(res);
  });
});

$('.deleteuserbtn').click(function(e){
  $('#hdnuserid').val($(this).data('userid'));
});

//Add to Wishlist
$('.btnaddwish').click(function(e){
      e.preventDefault();
      var itemid = $(this).data('item');
      $.ajax({
        url: 'addtowishlist.php?itemid='+itemid,
        type: 'GET',
        dataType: 'HTML'
      }).done(function(res){
        $('#msgdiv').find('#msg').html(res);
        $('#msgdiv').modal('show');
      });
});

//Remove Wishlist
$('.btndelwish').click(function(e){
      e.preventDefault();
      var wishid = $(this).data('wish');
      $.ajax({
        url: 'delwishlist.php?wishid='+wishid,
        type: 'GET',
        dataType: 'HTML'
      }).done(function(res){
        $('#msgdiv').find('#msg').html(res);
        $('#msgdiv').modal('show');
      });
});

//Hide wish message modal hidden.bs.modal
$('#msgdiv').on('hidden.bs.modal', function(e){
    window.location.href = window.location.href;
});

//Add item
$('.btnadd').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]');
  if(txtField.val()=="") {
    alert('Enter the value for ' + txtField.attr('placeholder'));
    txtField.focus();
    return;
  }
  $.ajax({
    url: 'addvalues.php',
    data:'newcategory='+txtField.val(),
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//Remove item
$('.btnremove').click(function(e){
  e.preventDefault();
  var optField = $(this).parents('form:first').find('select');
  var txtField = $(this).parents('form:first').find('input[type=text]');
  if(optField.val()=="") {
    alert('Select the value for ' + txtField.attr('placeholder') + ' to remove');
    optField.focus();
    return;
  }
  $.ajax({
    url: 'removevalues.php',
    data:'categories='+optField.val(),
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    optField.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//datePicker
$('#expirydate')
    .datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        orientation: "top auto",
        autoclose: true

    })
    .on('changeDate', function(e) {
        $('#expirydate').datepicker('hide');

    });
