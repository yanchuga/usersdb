<?
$db = new PDO('mysql:host=localhost;dbname=users_db', 'root', 'root');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>table user list - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    	body{
    background:#eee;    
}
.main-box.no-header {
    padding: 20px;
}
.main-box {
    background: #FFFFFF;
    -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
    -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
    -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
    -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
    box-shadow: 1px 1px 2px 0 #CCCCCC;
    margin-bottom: 16px;
    -webikt-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
.table a.table-link.danger {
    color: #e74c3c;
}
.label {
    border-radius: 3px;
    font-size: 0.875em;
    font-weight: 600;
}
.user-list tbody td .user-subhead {
    font-size: 0.875em;
    font-style: italic;
}
.user-list tbody td .user-link {
    display: block;
    font-size: 1.25em;
    padding-top: 3px;
    margin-left: 60px;
}
a {
    color: #3498db;
    outline: none!important;
}
.user-list tbody td>img {
    position: relative;
    max-width: 50px;
    float: left;
    margin-right: 15px;
}

.table thead tr th {
    text-transform: uppercase;
    font-size: 0.875em;
}
.table thead tr th {
    border-bottom: 2px solid #e7ebee;
}
.table tbody tr td:first-child {
    font-size: 1.125em;
    font-weight: 300;
}
.table tbody tr td {
    font-size: 0.875em;
    vertical-align: middle;
    border-top: 1px solid #e7ebee;
    padding: 12px 8px;
}
/* for table active dots */
.dot-act {
  height: 11px;
  width: 11px;
  background-color: #54d02b;
  border-radius: 50%;
  display: inline-block;
}
.dot-dis {
  height: 11px;
  width: 11px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}
/* for main modal  window*/
.modmandtext
{
	display:none;
}
input#mod_checker {
    display: none;
}

input[type="checkbox"] + label {
  position: relative;
  display: inline-block;
  width: 132px;
  height: 40px;
  background-color: #b62222;
  border-radius: 30px;
  cursor: pointer;
  transition: all 0.3s ease-out;
}

input[type="checkbox"] + label::before {
  content: '';
  display: inline-block;
  width: 34px;
  height: 34px;
  border-radius: 100%;
  background-color: white;
  position: absolute;
  top: 3px;
  right: 4px;
  transition: all 0.3s ease-out;
}

input[type="checkbox"] + label::after {
  content: attr(data-deny);
  color: white;
  position: absolute;
  top: 6px;
  left: 18px;
  font-size: 20px;
  font-weight: 300;
  transition: all 0.3s ease-out;
}

input[type="checkbox"]:checked + label {
  background-color: #519b00;
}

input[type="checkbox"]:checked + label::before {
  right: 94px;
}

input[type="checkbox"]:checked + label::after {
  content: attr(data-permit);
  left: 56px;
}
/* errModal window */
#errModal {
  display:none;
  position: fixed; /* Stay in place */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
#modclosebtn {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  
}

#modclosebtn:hover,
#modclosebtn:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
#errmodal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 30%;
}
   </style>
</head>
<body>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
<div class="pull-right">
<form class="form-inline">
<div class="form-group">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add</button>
<select id="grselectopt" class="form-control">
  <option selected>Please select</option>
  <option value="setact">Set active</option>
  <option value="setnotact">Set not active</option>
  <option value="deluser">Delete</option>
</select>
</div>
  <button type="submit" class="btn btn-primary mb-2" id="grselectbtn">Ok</button>
</form>								
							</div>
						</div>
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                <th><span><input type="checkbox" id="selectall"/></span></th>
                                <th class="text-center"><span>Name</span></th>
                                <th class="text-center"><span>Status</span></th>
                                <th><span>Role</span></th>
                                <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
							<?
							$stmt = $db->prepare("SELECT * FROM usersinfo");
							$stmt->execute();
							$allusers = $stmt->fetchAll(PDO::FETCH_ASSOC);
							foreach ($allusers as $k => $v){
							  echo '<tr><td style="width: 5%;"><input type="checkbox" uid="'.$v["id"].'" class="singlechkbox" name="username" value="1"/></td><td style="width: 35%;"><span class="user-link">'.$v["name"].' '.$v["surname"].'</span></td><td style="width: 20%;" class="text-center">', ($v["status"] == "1" ? "<span class='dot-act'></span></td>" : "<span class='dot-dis'></span></td>"),'<td style="width: 20%;">',($v["role"] == "1" ? "<span value='1'>admin</span></td>" : "<span value='0'>user</span></td>"),'<td style="width: 20%;"> <a href="#" class="table-link edit"  id="'.$v["id"].'"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-pencil fa-stack-1x fa-inverse"></i> </span> </a> <a href="#" class="table-link danger"  id="'.$v["id"].'"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i> </span> </a> </td></tr>';
							}
							?>
                            </tbody>
                        </table>
                    </div>
					<div class="pull-right">
<form class="form-inline">
<div class="form-group">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add</button>

<select id="grselectopt" class="form-control">
  <option selected>Please select</option>
  <option value="setact">Set active</option>
  <option value="setnotact">Set not active</option>
  <option value="deluser">Delete</option>
</select>
</div>
  <button type="submit" class="btn btn-primary mb-2" id="grselectbtn">Ok</button>
</form>
							</div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Main modal window</h4>
      </div>
      <div class="modal-body">
<div class="form-group">
  <label for="fname">First Name:</label>
  <input type="text" class="form-control" id="fname">
  <small class="text-muted modmandtext">Name is mandatory. Type your name please</small>
</div>
<div class="form-group">
  <label for="lname">Last Name:</label>
  <input type="text" class="form-control" id="lname">
  <small class="text-muted modmandtext">Last Name is mandatory. Type your last name please</small>
</div>

<div class="form-group">
<label for="role">Role:</label>
<select id="role" class="form-control">
  <option selected>Please select</option>
  <option value="1">admin</option>
  <option value="0">user</option>
</select>
  <small class="text-muted modmandtext">Role is mandatory. Choose your role please</small>
</div>
<div class="form-group">

  <input type="checkbox" id="mod_checker" name="mod-checker" checked value="1">
  <label class="ios-checkbox" for="mod_checker" data-permit="Active" data-deny="Not active"></label>

</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="addtodb" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="errModal" tabindex="-1" role="dialog" data-target=".bs-example-modal-sm" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="mySmallModalLabel">Info modal window</h4>
      </div>
      <div class="modal-body">
		123
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="deluserbtn" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
//for checkbox select all
$('body').on('click', '#selectall', function() {
	  $('.singlechkbox').prop('checked', this.checked);
});

$('body').on('click', '.singlechkbox', function() {
	if($(".singlechkbox").length == $(".singlechkbox:checked").length) {
		$("#selectall").prop("checked", "checked");
	} else {
		$("#selectall").removeAttr("checked");
	}
});
	
//for single add to db
$('#addtodb').on('click', function (a) {
a.preventDefault();
var fname = $("#fname").val();
var lname = $("#lname").val();
var role = $("#role option:selected").attr("value");
var mod_checker = $("#mod_checker").is(':checked') ? '1' : '0';
console.log('mod_checker is ' + mod_checker);
if(fname == '' || lname == '' || !role){
	$(".modmandtext").show();
}
else {
	$(".modmandtext").hide();
	$.ajax({
		type:'POST',
		url:'scripts/crud-scripts.php',
		data:{typepost:"addtodbmod",fname:fname,lname:lname,role:role,mod_checker:mod_checker},
		success:function(html){
			$('#myModal').modal('hide');
			setInterval('location.reload()', 500);
			console.log(html);
		},
		error: function (html) {
			console.log('An error occurred.');
			console.log(html);
		},		
		}); 
	}
});
//for single delete modal
	var userid;
$('.table-link.danger').on('click', function (e) {
	e.preventDefault();
	userid = $(this).attr('id'); // table row ID 
	console.log('dang');
	console.log(userid);
	if(userid)
	{
	console.log('dang2');
	console.log(userid);
	$("#errModal .modal-body").text('Do you really want to delete it?');
	$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" id="deleteuser" class="btn btn-primary">Yes, please</button>');
	$('#errModal').modal('show');
	$('#deleteuser').on('click', function (e) {
	$.ajax({
		type:'POST',
		url:'scripts/crud-scripts.php',
		data:{typepost:"deleteuserdb", uid:userid},
		success:function(html){
			$('#errModal').modal('hide');
			setInterval('location.reload()', 500);
			console.log(html);
		},
		error: function (html) {
			console.log('An error occurred.');
			console.log(html);
		},		
		}); 
		console.log("modal delete");
	}); 
	}
});
//for single edit modal
	var edituserid;
$('.table-link.edit').on('click', function (e) {
	e.preventDefault();
	edituserid = $(this).attr('id'); // table row ID 
	console.log('edit dang');
	console.log(edituserid);
	if(edituserid)
	{
	console.log('edit dang2');
	console.log(edituserid);
	$.ajax({
		type:'POST',
		url:'scripts/crud-scripts.php',
		data:{typepost:"edituserdbget", uid:edituserid},
		success:function(html){
			console.log(html);
			var objectdata = jQuery.parseJSON(html);
			$.each(objectdata, function(key, item) {
				if (key == 'name')
				{
				$("#myModal .modal-body #fname").val(item);
				}
				if (key == 'surname')
				{
				$("#myModal .modal-body #lname").val(item);
				}
				if (key == 'role')
				{
				console.log(key);
				$("#myModal .modal-body #role").val(item);
				}
				if (key == 'status')
				{
				console.log(item);
				if (item == 0)
				{
				$("#myModal .modal-body #mod_checker").prop("checked", 0);
				}
				else
				{
				$("#myModal .modal-body #mod_checker").prop("checked", 1);
				}
				}
			});
		$("#myModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" id="updateuser" class="btn btn-primary">Update, please</button>');
		$('#myModal').modal('show');
		$('#updateuser').on('click', function (e) {
			var fname = $("#fname").val();
			var lname = $("#lname").val();
			var role = $("#role option:selected").attr("value");
			var mod_checker = $("#mod_checker").is(':checked') ? '1' : '0';
			console.log('clicked update');
			$.ajax({
				type:'POST',
				url:'scripts/crud-scripts.php',
				data:{typepost:"edituserdbupdate", uid:edituserid,fname:fname,lname:lname,role:role,mod_checker:mod_checker},
				success:function(html){
					$('#myModal').modal('hide');
					setInterval('location.reload()', 500);
					console.log(html);
				},
				error: function (html) {
					console.log('An error occurred.');
					console.log(html);
				},		
				}); 
				// console.log("modal update");
			});
		},
		error: function (html) {
			console.log('An error occurred.');
			console.log(html);
		},		
		}); 
		console.log("modal edit");
	}
});

//for select group options
var seloption;
var chkboxarr = [];
$('#grselectbtn').on('click', function(e){
	e.preventDefault();
	chkboxarr = [];
$('.singlechkbox').each(function( index ){
	if($(this).is(":checked")){
		var uid = $(this).attr('uid');
		chkboxarr.push(uid);
	}
});
	if (chkboxarr.length > 0)
	{
			console.log(chkboxarr);
			seloption = $( "#grselectopt option:selected" ).text();
			if (seloption == "Please select")
			{
				$("#errModal .modal-body").text('Select some option, please');
				$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
				$('#errModal').modal('show');
				console.log("modal select smth");
			}
			else if (seloption == "Set active")
			{
				$("#errModal .modal-body").text('Do you really want to set them active?');
				$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" id="setactivebtn" class="btn btn-primary">Yes, please</button>');
				$('#errModal').modal('show');
				$('#setactivebtn').on('click', function (e) {
				$.ajax({
					type:'POST',
					url:'scripts/crud-scripts.php',
					data:{typepost:"selectopt", uids:chkboxarr,seloption:"Set active"},
					success:function(html){
						$('#errModal').modal('hide');
						setInterval('location.reload()', 500);
						console.log(html);
					},
					error: function (html) {
						console.log('An error occurred.');
						console.log(html);
					},		
					}); 
					console.log("modal set act");
				}); 
			}
			else if (seloption == "Set not active")
			{
				$("#errModal .modal-body").text('Do you really want to set them NOT active?');
				$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" id="setnotactivebtn" class="btn btn-primary">Yes, please</button>');
				$('#errModal').modal('show');
				$('#setnotactivebtn').on('click', function (e) {
				$.ajax({
					type:'POST',
					url:'scripts/crud-scripts.php',
					data:{typepost:"selectopt", uids:chkboxarr,seloption:"Set not active"},
					success:function(html){
						$('#errModal').modal('hide');
						setInterval('location.reload()', 500);
						console.log(html);
					},
					error: function (html) {
						console.log('An error occurred.');
						console.log(html);
					},		
					}); 
					console.log("modal set not act");
				}); 
			}
			else if (seloption == "Delete")
			{
				$("#errModal .modal-body").text('Do you really want to delete them?');
				$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" id="deletebtn" class="btn btn-primary">Yes, please</button>');
				$('#errModal').modal('show');
				$('#deletebtn').on('click', function (e) {
				$.ajax({
					type:'POST',
					url:'scripts/crud-scripts.php',
					data:{typepost:"selectopt", uids:chkboxarr,seloption:"Delete"},
					success:function(html){
						$('#errModal').modal('hide');
						setInterval('location.reload()', 500);
						console.log(html);
					},
					error: function (html) {
						console.log('An error occurred.');
						console.log(html);
					},		
					}); 
					console.log("modal delete");
				}); 
			}
			else {
				//do nothing
			}
	}
	else
	{
		$("#errModal .modal-body").text('Check some checkbox, please');
		$("#errModal .modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
		$('#errModal').modal('show');
		console.log("modal check some chkbox");
	}

	});
});
</script>

</body>
</html>