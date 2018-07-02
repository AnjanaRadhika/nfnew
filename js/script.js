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

  /*  progress: function(e, data){

        // Calculate the completion percentage of the upload
        var progress = parseInt(data.loaded / data.total * 100, 10);

        // Update the hidden input field and trigger a change
        // so that the jQuery knob plugin knows to update the dial
        data.context.find('input').val(progress).change();

        if(progress == 100){
            data.context.removeClass('working');
        }
    },*/

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

/*post item state dropdown change */
function changeState(val, district) {
  $('#state').val(val);
  getDistrict(val,'#district-list');
}

function getDistrict(val, district) {
	$.ajax({
	type: "POST",
	url: "getdistricts.php",
	data:'state_id='+val,
	success: function(res){
    $(district).html(res);
	}
	});
}

function getTown(val, town) {
	$.ajax({
	type: "POST",
	url: "gettowns.php",
	data:'district_id='+val,
	success: function(res){
    $(town).html(res);
	}
	});
}

function getNeighbourhoods(val, neighbourhood) {
	$.ajax({
	type: "POST",
	url: "getlocalities.php",
	data:'district_id='+val,
	success: function(res){
    $(neighbourhood).html(res);
	}
	});
}

function getCity(val) {
  $('#district').val($('#district-list').val());
}

function setCategory() {
  $('#category').val($('#category-list').val());
  $('#categorytext').val($("#category-list option:selected").text());
}

//search screen autocomplete
$("#location").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "suggestplaces.php",
          data: { term: $('#location').val()},
          dataType: "json",
          type: "GET",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1,
      select: function(event, ui){
        $('#location').val(ui.item.value);
      }
});

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

    //autocomplete invalidfields
    $("#town").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "suggesttowns.php",
              data: { term: $('#town').val(), search: $('#district').val()},
              dataType: "json",
              type: "GET",
              success: function(data) {
                response(data);
              }
            });
          },
          minLength: 1,
          select: function(event, ui){
            $('#town').val(ui.item.value);
          }
    });

    $("#nhood").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "suggestlocalities.php",
          data: { term: $('#nhood').val(), search: $('#district').val()},
          dataType: "json",
          type: "GET",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1,
      select: function(event, ui){
        $('#nhood').val(ui.item.value);
      }
    });

    $("#zipcode").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "suggestpincodes.php",
          data: { term: $('#zipcode').val(), search: $('#district').val()},
          dataType: "json",
          type: "GET",
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 1,
      select: function(event, ui){
        $('#zipcode').val(ui.item.value);
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
        var itmid = "", itmcode = "";
        $('#sqlerror').html("");
        $('#sqlerror').removeClass("alert alert-danger");

        try {
    				var jsonObj = $.parseJSON(response);

            for (var i = 0; i < jsonObj.length; i++) {
               var status = jsonObj[i].status;
               var field = jsonObj[i].field;
               if(status == "itemid") {
                 itmid = field;
               }
               if(status == "itemcode") {
                 itmcode = field;
               }
               if (status == "error") {
    								$('#successmessage').removeClass("alert alert-danger");
     								$('#successmessage').removeClass("alert alert-success");
     								$('#fileerror').removeClass("alert alert-danger");
    						 if(field == "category" || field == "measurements" || field == "district" || field == "state") {
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
            var toemail = $('#contact_email').val();
            var name = $('#contact_person').val();
            var sentmsg = "";
            $('.itemForm')[0].reset();
            $("#fileupload").find(".files").empty();
            $.ajax({
            type: "GET",
            url: 'postsuccessemail.php?toemail='+toemail+'&name='+name+'&ref='+itmcode+'&itemid='+itmid,
            success: function(response){
              sentmsg = "Email sent to " + name + ".";
            }});
						$('#successmessage').html("<p>Post Adv completed successfully! " + sentmsg + "</p>");
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
         $('#characterLeft').text('140 characters left');
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
    var pagenextlinkid, pageprevlinkid, pagenextid,  pageprevid;

    if($(this).attr('id')==='next') {
        nextpage = parseInt($('#curpage').val()) + 1;
        prevpage = parseInt($('#curpage').val());
        pagenextlinkid = '#pagelink'+nextpage;
        pageprevlinkid = '#pagelink'+prevpage;
        pagenextid =  '#page'+nextpage;
        pageprevid =  '#page'+prevpage;
        $(pagenextlinkid).addClass('active');
        $(pageprevlinkid).removeClass('active');
        $('#curpage').val(nextpage);
        $(pageprevid).hide();
        $(pagenextid).show();
    } else if($(this).attr('id')==='prev') {
        prevpage = parseInt($('#curpage').val());
        nextpage = parseInt($('#curpage').val()) - 1;
        pagenextlinkid = '#pagelink'+nextpage;
        pageprevlinkid = '#pagelink'+prevpage;
        pagenextid =  '#page'+nextpage;
        pageprevid =  '#page'+prevpage;
        $(pagenextlinkid).addClass('active');
        $(pageprevlinkid).removeClass('active');
        $('#curpage').val(nextpage);
        $(pageprevid).hide();
        $(pagenextid).show();
    } else {
        $('#curpage').val($(this).text());
        var showpageid = '#page'+parseInt($(this).text());
        var showpagelinkid = '#pagelink'+parseInt($(this).text());
        var numpages = parseInt($('#numpages').val());
        for(var i = 1;i<numpages + 1; i++) {
          if(i === parseInt($(this).text())){
            $(showpageid).show();
            $(showpagelinkid).addClass('active');
          } else {
            $('#page'+i).hide();
            $('#pagelink'+i).removeClass('active');
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
  e.preventDefault();
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
        $('.btnaddwish').addClass('disabled');
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
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');
  if(txtField.val()=="") {
    alert('Enter the value for ' + txtField.attr('placeholder'));
    txtField.focus();
    return;
  }
  $.ajax({
    url: 'addvalues.php',
    data: { newValue: txtField.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//with additional select option field(s) - add new
$('.btnaddnew').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');
  var optField = $(this).parents('form:first').find('select option:selected');
  if(optField.val()=="") {
    if(hdnField.val() == "District") {
      alert('Select the State');
      return;
    }
  }
  if(txtField.val()=="") {
    alert('Enter the value for ' + txtField.attr('placeholder'));
    txtField.focus();
    return;
  }
  $.ajax({
    url: 'addvalues.php',
    data: { newValue: txtField.val(), optValue: optField.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//with additional select option field(s) - add new town
$('.btnaddtown').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');
  var optField1 = $(this).parents('form:first').find('select:first');
  var optField2 = $(this).parents('form:first').find('select:nth-child(2)');

  if(hdnField.val() == "Town") {
    if(optField1.val()=="") {
      alert('Select the State');
      return;
    }
    if(optField2.val()=="") {
      alert('Select the District');
      return;
    }
  }
  if(txtField.val()=="") {
    alert('Enter the value for ' + txtField.attr('placeholder'));
    txtField.focus();
    return;
  }
  $.ajax({
    url: 'addvalues.php',
    data: { newValue: txtField.val(), optValue1: optField1.val(), optValue2: optField2.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//with additional select option field(s) - add new neighbourhood
$('.btnaddnhood').click(function(e){
  e.preventDefault();
  var txtField1 = $(this).parents('form:first').find('input[type=text]:first');
  var txtField2 = $(this).parents('form:first').find('input[type=text]:nth-child(2)');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');
  var optField1 = $(this).parents('form:first').find('select:first');
  var optField2 = $(this).parents('form:first').find('select:nth-child(2)');

  if(hdnField.val() == "Neighbourhood") {
    if(optField1.val()=="") {
      alert('Select the State');
      return;
    }
    if(optField2.val()=="") {
      alert('Select the District');
      return;
    }
  }
  if(txtField1.val()=="") {
    alert('Enter the value for ' + txtField1.attr('placeholder'));
    txtField1.focus();
    return;
  }
  if(txtField2.val()=="") {
    alert('Enter the value for ' + txtField2.attr('placeholder'));
    txtField2.focus();
    return;
  }
  $.ajax({
    url: 'addvalues.php',
    data: { newValue: txtField1.val(), newValue1: txtField2.val(), optValue1: optField1.val(), optValue2: optField2.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField1.val("");
    txtField2.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//update policy
$('.btnupdatepolicy').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]:first');
  var txtField1 = $(this).parents('form:first').find('input[type=text]#version');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');

  if(txtField.val()=="") {
    alert('Enter the value for ' + txtField.attr('placeholder'));
    txtField.focus();
    return;
  }
  if(txtField1.val()=="") {
    alert('Enter the value for ' + txtField1.attr('placeholder'));
    txtField1.focus();
    return;
  }

  $.ajax({
    url: 'addvalues.php',
    data: { newValue: txtField.val(), newValue1: txtField1.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    txtField.val("");
    txtField1.val("");
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//Remove item
$('.btnremove').click(function(e){
  e.preventDefault();
  var optField = $(this).parents('form:first').find('select');
  var txtField = $(this).parents('form:first').find('input[type=text]');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');

  if(optField.val()=="") {
    alert('Select the value for ' + txtField.attr('placeholder') + ' to remove');
    optField.focus();
    return;
  }
  $.ajax({
    url: 'removevalues.php',
    data:{ delValue: optField.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//remove expired items
$('.btnremoveitems').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]#expirydate1');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');

  if(txtField.val()=="") {
    alert('Select the value for ' + txtField.attr('placeholder') + ' to remove');
    txtField.focus();
    return;
  }
  hdnField.val('ClearItem');
  $.ajax({
    url: 'removevalues.php',
    data:{ delValue: txtField.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//clear wishlist
$('.btnremovewishlist').click(function(e){
  e.preventDefault();
  var txtField = $(this).parents('form:first').find('input[type=text]#expirydate');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');

  if(txtField.val()=="") {
    alert('Select the value for ' + txtField.attr('placeholder') + ' to remove');
    txtField.focus();
    return;
  }
  hdnField.val('ClearFav');
  $.ajax({
    url: 'removevalues.php',
    data:{ delValue: txtField.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//with additional select option field(s) - remove
$('.btnremovedistrict').click(function(e){
  e.preventDefault();
  var optField2 = $(this).parents('form:first').find('select:nth-child(2)');
  var optField3 = $(this).parents('form:first').find('select:nth-child(3)');
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');

  if(optField2.val()=="") {
    if(hdnField.val() == "District") {
      alert('Select State');
      return;
    }
  }
  if(optField3.val()=="") {
    if(hdnField.val() == "District") {
      alert('Select District(s) to be removed');
      return;
    }
  }

  $.ajax({
    url: 'removevalues.php',
    data:{ delValue: optField3.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//with additional select option field(s) - remove town, neighbourhood
$('.btnremovevalues').click(function(e){
  e.preventDefault();
  var hdnField = $(this).parents('form:first').find('input[type=hidden]');
  var optField3 = $(this).parents('form:first').find('select#t-state-list');
  var optField4 = $(this).parents('form:first').find('select#t-district-list');
  var optField5;
  if(hdnField.val() == "Town") {
    optField5 = $(this).parents('form:first').find('select#t-town-list');
  }
  if(hdnField.val() == "Neighbourhood") {
    optField5 = $(this).parents('form:first').find('select#n-neighbourhood-list');
  }
  if(optField3.val()=="") {
      alert('Select State');
      return;
    }
  if(optField4.val()=="") {
      alert('Select District');
      return;
  }

  if(hdnField.val() == "Town") {
    if(optField5.val()=="") {
        alert('Select Town(s) to be removed');
        return;
    }
  }

  if(hdnField.val() == "Neighbourhood") {
    if(optField5.val()=="") {
        alert('Select Neighbourhood(s) to be removed');
        return;
    }
  }

  $.ajax({
    url: 'removevalues.php',
    data:{ delValue: optField5.val(), type: hdnField.val()},
    type: 'POST',
    dataType: 'HTML'
  }).done(function(res){
    $('#msgdiv').find('#msg').html(res);
    $('#msgdiv').modal('show');
  });
});

//datePicker
$('#expirydate')
    .datepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        orientation: "top auto",
        autoclose: true

    })
    .on('changeDate', function(e) {
        $('#expirydate').datepicker('hide');

    });

$('#cal').click( function(e){
  $('#expirydate')
      .datepicker('show');
});

$('#expirydate1')
    .datepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        orientation: "top auto",
        autoclose: true

    })
    .on('changeDate', function(e) {
        $('#expirydate1').datepicker('hide');

    });

$('#cal2').click( function(e){
  $('#expirydate1')
      .datepicker('show');
});

$('#cal1').click( function(e){
  $('#effectivedate')
      .datepicker('show');
});

$('#effectivedate')
    .datepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        dateFormat: 'dd/mm/yy',
        todayHighlight: true,
        orientation: "top auto",
        autoclose: true

    })
    .on('changeDate', function(e) {
        $('#effectivedate').datepicker('hide');

    });

//Resend OTP
$("#resendotp").on('click', function(){
  phone = $('#hdnmobno').val();
  sendVerificationCode(phone);
});

// Send SMS Verification code
$('#showdiv').click(function(e) {
  e.preventDefault();
  phone = $('#phone').val();
  if(phone=='') {
    $('#tel1').addClass('is-invalid');
    $('#tel2').addClass('is-invalid');
    $('#tel3').addClass('is-invalid');
    $('#tel1').focus();
    return false;
  }
  $('#verifyphone').html(phone);
  $('#hdnmobno').val(phone);
  sendVerificationCode(phone);
});

function sendVerificationCode(phone) {
  $.ajax({
     type: 'POST',
     url: 'getverificationcode.php',
     data:'mob_number='+phone,
     success: function(response) {
       var jsonObj = $.parseJSON(response);
       status = jsonObj.Status;
       if(status=="Success") {
         $('#msgsuccess').html("<p class='alert alert-success'>OTP Code Send!</p>");
       } else {
         $('#msgsuccess').html("<p class='alert alert-danger'>OTP Code sending failed!</p>");
       }

     },
     failure: function(err) {
        $('#msgsuccess').html("<p class='alert alert-danger'>"+err+"</p>");
     }
 });
}

$('#btnvalidate').click(function(e){
  e.preventDefault();
  otp = $('#code').val();
  $.ajax({
     type: 'POST',
     url: 'verifycode.php',
     data:'otp_value='+otp,
     success: function(data) {
       if(data=='Matched') {
        $('#verifydiv .close').click();
        $('#tel1').addClass('is-valid');
        $('#tel2').addClass('is-valid');
        $('#tel3').addClass('is-valid');
        $('#phonevalid').val("1");
       } else {
         $('#code').addClass('is-invalid');
         $('#phonevalid').val("0");
       }
       $('#code').val("");
       $('#code').focus();
       $(this).addClass('disabled');
     },
     failure: function(err) {
       $('#msgsuccess').html(err);
     }
 });
});

//fiter for Sale or to Buy
$('#tobuy,#forsale,#all').on('click', function(){
  $('#sellorbuy').val($(this).val());
  $('.searchItemForm').submit();
});

//Change Items per page
$('#selitemsperpage').on('change', function(){
  $('#itemsperpage').val($(this).val());
  $('.searchItemForm').submit();
});

//Filter Items
$('#selfilterby').on('change', function(){
  $('#filterby').val($(this).val());
  $('.searchItemForm').submit();
});

//Sidenav
function openNav() {
  $("#canNav").css("width","250px");
  $("#canNav").show();
  $("#main").css("marginLeft","250px");
}

function closeNav() {
    $("#canNav").css("width","0px");
    $("#canNav").hide();
    $("#main").css("marginLeft","0px");
}
