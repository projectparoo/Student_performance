<?php
	include 'includes/dbh.inc.php';
	include_once 'includes/checksession.inc.php';
	include_once 'includes/checkIfStudent.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Student Profile</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Language" content="en">
		<meta name="google" content="notranslate">
		<link rel="stylesheet" href="External/bootstrap-3.3.7-dist/bootstrap-3.3.7-dist/css/bootstrap.min.css">
		<script src="External/jquery-3.2.1.min.js"></script>
		<script src="External/bootstrap-3.3.7-dist/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "style_sheets/studentInfo.css">
		<script>
			$(document).ready(function(){
				$.ajaxSetup({ cache: false });
				loadremarks();
				loadinternships();
				loadskilldiv();
				loadinterestsdiv();
			});

			function savedata(formname) {
				  $.post($(formname).attr("action"), $(formname).serializeArray(), function(info) {
				alert(info);
				if(info == 'Added !')
					clearInput(formname);
			  });
			  $(formname).submit(function() {
				return false;
			  });
			  loadinternships();
			}

			function loadinternships()
			{
				$("#loadinternships").load("includes/internship_div.inc.php", {roll:<?php echo "'".$_SESSION['id']."'";?>});
			}

			function clearInput(formname) {
			  $(formname + " :input").each(function() {
				$(this).val('');
			  });
			}

			function loadskilldiv()
			{
				$("#allskills").load("includes/loadskillfile.inc.php");
			}

			function loadremarks()
			{
				$("#loadrem").load("includes/remark_div.inc.php", {roll:<?php echo "'".$_SESSION['id']."'";?>});
			}

			function addskill(formname){
				$.post($(formname).attr("action"), $(formname+" :input").serializeArray());
				$(document).ready(function(){loadskilldiv()});

				$(formname).submit(function(){
					return false;
				});
			}

			function removeskill(formname){
				$.post($(formname).attr("action"), $(formname+" :input").serializeArray());
				$(document).ready(function(){loadskilldiv()});

				$(formname).submit(function(){
					return false;
				});
			}

			function loadinterestsdiv()
			{
				$("#allinterests").load("includes/loadinterestsfile.inc.php");
			}

			function addinterest(formname){
				$.post($(formname).attr("action"), $(formname+" :input").serializeArray());
				$(document).ready(function(){loadinterestsdiv()});

				$(formname).submit(function(){
					return false;
				});
			}

			function removeinterest(formname){
				$.post($(formname).attr("action"), $(formname+" :input").serializeArray());
				$(document).ready(function(){loadinterestsdiv()});

				$(formname).submit(function(){
					return false;
				});
			}

		</script>
	</head>

	<body background="Images/back.jpg" spellcheck="false">
	<?php include 'includes/dbh.inc.php';?>
	<?php
		include 'includes/menuStudent.inc.php';
		$roll=$_SESSION['id'];
		$sql="SELECT * FROM student WHERE rollNumber='$roll';";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) == 0){
			echo "<div style='width:240px;margin:250px auto;background:rgba(255, 0, 0, 0.2);text-align:center; padding: 20px; border-radius:10px;'><b>No Student with Roll Number $roll</b></div>";
			exit();
		}
		$row = mysqli_fetch_assoc($result);
	?>
	<div class="container" style="margin-top:60px;">
		<div class="row profile ">
			<!-- LEFT MENU -->
			<div class="col-md-3">
				<div class="profile-sidebar">
					<!-- SIDEBAR USERPIC -->
					<div id="profile-userpic">
						<img id="imga" src="<?php if($row['gender']== 'MALE' || $row['gender']== 'male') echo 'Images/samplemale.jpg'; else echo 'Images/samplefemale.jpg';?>" alt="Student Photo">
					</div>
					<!-- END SIDEBAR USERPIC -->

					<!-- SIDEBAR USER TITLE -->
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							<?php echo $row['studentsName'];?>
						</div>
						<div class="profile-usertitle-roll">
							<?php echo $row['rollNumber'];?>
						</div>
						<div class="profile-usertitle-roll">
							DIV <?php echo $row["division"];?> - Batch <?php echo $row["batch"];?>
						</div>
						<div class="profile-usertitle-roll">
							Mentor: <?php echo $row["mentor"];?>
						</div>
					</div>
					<!-- END SIDEBAR USER TITLE -->

					<!-- USER MENU -->
					<div class="profile-usermenu">
						<ul class="nav">
							<li class="active">
								<a data-toggle="tab" href="">                  <!--add timeline     create php structure-->
								<i class="glyphicon glyphicon-tasks"></i>
								TimeLine </a>
							</li>
							<li>
								<a data-toggle="tab" href="#personalinfo">
								<i class="glyphicon glyphicon-user"></i>
								Personal Information </a>
							</li>
							<li>
								<a data-toggle="tab" href="#acaddet">
								<i class="glyphicon glyphicon-education"></i>
								Academic Details </a>
							</li>
							<li>
								<a data-toggle="tab" href="#acaddet">                  <!--create test   php structure-->
								<i class="glyphicon glyphicon-list-alt"></i>
								Tests </a>
							</li>

							<li>
								<a data-toggle="tab" href="#remarks">
								<i class="glyphicon glyphicon-pencil"></i>
								Remarks </a>
							</li>
							<li>
								<a data-toggle="tab" href="#internships">
								<i class="glyphicon glyphicon-briefcase"></i>
								Internship </a>
							</li>
							<li>
								<a data-toggle="tab" href="#skin">
								<i class="glyphicon glyphicon-wrench"></i>
								Skills & Intersts </a>
							</li>
						</ul>
					</div>
					<!-- END USER MENU -->
				</div>
			</div>
			<!-- END LEFT MENU -->

			<!-- RIGHT PANE -->
			<div class="tab-content">
				<div class="col-md-9 tab-pane fade in active" id="personalinfo">
					<div class="profile-content">
						<div class="form-group">
							<label for="fn" class="control-label col-sm-1" >Name:</label>
							<div class="col-sm-8">
								<input disabled type="text" value="<?php echo $row["studentsName"];?>" class="form-control" name="fn" id="fn" placeholder="First Name">
							</div>
							<label class="control-label col-sm-1">Gender:</label>
							<div class="col-sm-2">
								<input disabled type="text" value="<?php echo $row["gender"];?>" class="form-control" name="gen" id="gen" placeholder="Last Name">
							</div>
						</div>
						<br/><br/>
						<div  class="form-group">
							<label for="phn" class="control-label col-sm-1" >Mobile: </label>
							<div class="col-sm-3">
							  <input disabled type="tel" value="<?php echo $row["mobileNo"];?>" class="form-control" name="phn" id="phn">
							</div>
							<label for="email" class="control-label col-sm-1" >Email: </label>
							<div class="col-sm-7">
							  <input disabled type="email" value="<?php echo $row["emailId"];?>" class="form-control" name="email" id="email">
							</div>
						</div>
						<br/><br/>
						<div class="form-group">
							<label for="address" class="control-label col-sm-1" >Address: </label>
							<div class="col-sm-11">
								<textarea disabled name="address" id="address" class="form-control disabled" rows="2"></textarea>
							</div>
						</div>
						<br/><br/><br/>
						<div class="form-group">
							<label for="pmob" class="control-label col-sm-1" >Parent Mobile: </label>
							<div class="col-sm-3">
							  <input disabled type="text" value="<?php echo $row["fatherMobile"];?>" class="form-control" name="pmob" id="pmob">
							</div>
							<label for="dob" class="control-label col-sm-1" >DOB: </label>
							<div class="col-sm-3">
							  <input disabled type="text" value="<?php echo $row["dob"];?>" class="form-control" name="dob" id="dob">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-9 tab-pane fade" id="acaddet">
					<div class="profile-content">
						   <div class="col-sm-2">
								<div class="profile-usermenu">
									<ul class="nav">
										<li class="active">
											<a data-toggle="tab" href="#sem1">
											SEM 1 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem2">
											SEM 2 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem3">
											SEM 3 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem4">
											Sem 4 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem5">
											Sem 5 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem6">
											Sem 6 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem7">
											Sem 7 </a>
										</li>
										<li>
											<a data-toggle="tab" href="#sem8">
											Sem 8 </a>
										</li>
									</ul>
								</div>
							</div>
							<div class="tab-content col-sm-10">
								<div class="tab-pane fade in active" id="sem1">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 1 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem2">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 2 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem3">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 3 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem4">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 4 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem5">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 5 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem6">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 6 Details to be displayed to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem7">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 7 Details to be displayed
									</div>
								</div>
								<div class="tab-pane fade" id="sem8">
									<div class="profile-content" style="background:#ffffff;height:400px;">
									Sem 8 Details to be displayed
									</div>
								</div>
							</div>
					</div>
					<br/>
					<br/>
					<div class="profile-content">
						<div class="col-sm-4" style="padding:10px;background:rgb(255,255,255);border-radius:5px">
							Number of dead Kt's: <?php echo $row['deadKts'];?>
						</div>
						<div class="col-sm-offset-1 col-sm-4" style="padding:10px;background:rgb(255,255,255);border-radius:5px">
							Number of live Kt's: <?php echo $row['liveKts'];?>
						</div>
					</div>
				</div>
				<div class="col-md-9 tab-pane fade" id="remarks">
					<div id="loadrem">

					</div>
				</div>
				<div class="col-md-9 tab-pane fade" id="internships">
					<div id="loadinternships">

					</div>
					<div class="profile-content">
						<!-- Form for remark -->
						<form method = "post" action = "Includes/addInternship.inc.php" id="internForm">
							<div  class="form-group">
								<label for="at" class="control-label col-sm-2" >Interned At: </label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="at" id="at" placeholder="Name of the Organization"/>
								</div>
							</div>
							<br/><br/><br/>
							<div  class="form-group">
								<label for="from" class="control-label col-sm-2" >Duration: </label>
								<div class="col-sm-2">
								  <input type="text" name="from" id="from" class="form-control" placeholder="Start Date"/>
								</div>
								<p style="float:left;width:5px;display:inline-block;">-</p>
								<div class="col-sm-2">
								  <input type="text" name="to" id="to" class="form-control" placeholder="End Date"/>
								</div>
							</div>
							<br/><br/>
							<div  class="form-group">
								<label for="desc" class="control-label col-sm-2" >Description: </label>
								<div class="col-sm-10">
								  <textarea name="desc" id="desc" class="form-control" rows="3" placeholder="Describe your job at the internship!"></textarea>
								</div>
							</div>
							<br/><br/><br/><br/>
							<div class="col-sm-offset-5  col-sm-2">
								<button class="btn btn-primary col-sm-12" onclick="savedata('#internForm');" name="addIn">ADD</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-9 tab-pane fade" id="skin">
					<div class="profile-content">
							<form class="form-horizontal col-sm-offset-1 col-sm-10" id="allskillsform" action="includes/addskill.inc.php" method="POST">
								<div class="form-group">
								<label for="os" class="control-label col-sm-3" >Skills: </label>
								<div class="col-sm-5">
									<select class="form-control" name="os">
										<option disabled selected>SELECT SKILL</option>
										<option value="Algorithms">Algorithms</option>
										<option value="Android Studio">Android Studio</option>
										<option value="Autodesk 3ds Max">Autodesk 3ds Max</option>
										<option value="Autodesk Maya">Autodesk Maya</option>
										<option value="Blender">Blender</option>
										<option value="C programming">C</option>
										<option value="C#">C#</option>
										<option value="C++">C++</option>
										<option value="Cinema 4D">Cinema 4D</option>
										<option value="Cloud Computing">Cloud Computing</option>
										<option value="CryEngine">CryEngine</option>
										<option value="Data Structures">Data Structures</option>
										<option value="DBMS">DBMS</option>
										<option value="Embeded Systems">Embeded Systems</option>
										<option value="Maximo">Maximo</option>
										<option value="DirectX">DirectX</option>
										<option value="Docker">Docker</option>
										<option value="Flash">Flash</option>
										<option value="Game Maker">Game Maker</option>
										<option value="HTML">HTML</option>
										<option value="iClone">iClone</option>
										<option value="Java">Java</option>
										<option value="JavaScript">JavaScript</option>
										<option value="Lua">Lua</option>
										<option value="MakeHuman">MakeHuman</option>
										<option value="Maximo">Maximo</option>
										<option value="MongoDB">MongoDB</option>
										<option value="Node.js">Node.js</option>
										<option value="OpenGL">OpenGL</option>
										<option value="PHP">PHP</option>
										<option value="Python">Python</option>
										<option value="React.js">React.js</option>
										<option value="Ruby">Ruby</option>
										<option value="Unity 3D">Unity 3D</option>
										<option value="Unreal Engine">Unreal Engine</option>
										<option value="Visual Basic">Visual Basic</option>
										<option value="Vue.js">Vue.js</option>
										<option value="XML">XML</option>
									</select>
								</div>
								<div class="col-sm-3">
									<button type="button" class="btn btn-primary" onclick="addskill('#allskillsform')">Add Skill</button>
								</div>
								</div>
							</form>
							<div class="col-sm-offset-1 col-sm-10">
							<div class="col-sm-offset-3" id="allskills">

							</div>
							</div>
					   </div>
						 <br/><br/>
						 <div class="profile-content">
	 							<form class="form-horizontal col-sm-offset-1 col-sm-10" id="allinterestsform" action="includes/addinterest.inc.php" method="POST">
	 								<div class="form-group">
	 								<label for="int" class="control-label col-sm-3" >Interests: </label>
	 								<div class="col-sm-5">
										<select class="form-control" name="int">
											<option disabled selected>SELECT SKILL</option>
											<option value="Algorithms">Algorithms</option>
											<option value="Android Studio">Android Studio</option>
											<option value="Autodesk 3ds Max">Autodesk 3ds Max</option>
											<option value="Autodesk Maya">Autodesk Maya</option>
											<option value="Blender">Blender</option>
											<option value="C programming">C</option>
											<option value="C#">C#</option>
											<option value="C++">C++</option>
											<option value="Cinema 4D">Cinema 4D</option>
											<option value="Cloud Computing">Cloud Computing</option>
											<option value="CryEngine">CryEngine</option>
											<option value="Data Structures">Data Structures</option>
											<option value="DBMS">DBMS</option>
											<option value="Embeded Systems">Embeded Systems</option>
											<option value="Maximo">Maximo</option>
											<option value="DirectX">DirectX</option>
											<option value="Docker">Docker</option>
											<option value="Flash">Flash</option>
											<option value="Game Maker">Game Maker</option>
											<option value="HTML">HTML</option>
											<option value="iClone">iClone</option>
											<option value="Java">Java</option>
											<option value="JavaScript">JavaScript</option>
											<option value="Lua">Lua</option>
											<option value="MakeHuman">MakeHuman</option>
											<option value="Maximo">Maximo</option>
											<option value="MongoDB">MongoDB</option>
											<option value="Node.js">Node.js</option>
											<option value="OpenGL">OpenGL</option>
											<option value="PHP">PHP</option>
											<option value="Python">Python</option>
											<option value="React.js">React.js</option>
											<option value="Ruby">Ruby</option>
											<option value="Unity 3D">Unity 3D</option>
											<option value="Unreal Engine">Unreal Engine</option>
											<option value="Visual Basic">Visual Basic</option>
											<option value="Vue.js">Vue.js</option>
											<option value="XML">XML</option>
										</select>
	 								</div>
	 								<div class="col-sm-3">
	 									<button type="button" class="btn btn-primary" onclick="addinterest('#allinterestsform')">Add Skill</button>
	 								</div>
	 								</div>
	 							</form>
	 							<div class="col-sm-offset-1 col-sm-10">
	 							<div class="col-sm-offset-3" id="allinterests">
	 							</div>
	 							</div>
	 					   </div>
				</div>
			</div>
			<!-- END RIGHT PANE -->
		</div>
	</div>
</body>
</html>
