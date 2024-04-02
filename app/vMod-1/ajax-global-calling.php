<?php
if(!isset($_REQUEST['calling_block'])) {
	
	$_REQUEST['calling_block'] = '';
}

//----------------------------TIMETABLE-----------------------------------//

	/*
	cross_subject_id: 1
	cross_teacher_id: 
	cross_paper: 
	cross_paper_type: 102
	cross_lecture_type: 201
	timetable_room: 1
	datastr: 8~2~1~6~8
	*/
	if($_REQUEST['calling_block'] == 'display_timetable') {

		$return_str  = '';
		$error_message = array();

 
		if(count($error_message) == 0) {
 
			$currentYSData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');

			$ysWorkingDaysData = $toolObj->getDetail('tt_session_working_days_log', " and d.college_id = '".COLLEGE_ID."' and d.day_year = '".$currentYSData[0]['ys_year']."'  and d.day_semester = '".$currentYSData[0]['ys_sememster']."' ", '', ' day_id, day_value ');

			$ysPeriodData = $toolObj->getDetail('tt_session_period_log', " and d.college_id = '".COLLEGE_ID."' and d.period_year = '".$currentYSData[0]['ys_year']."'  and d.period_semester = '".$currentYSData[0]['ys_sememster']."' and d.period_status = '0' ", '', ' period_id, period_value, period_type ');

			$ttMasterData = $toolObj->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_year = '".$currentYSData[0]['ys_year']."'  and d.timetable_semesters = '".$currentYSData[0]['ys_sememster']."' and d.timetable_status='Y' ", '', ' * ');

			if(count($ttMasterData) > 0) {

				foreach ($ttMasterData as $ttmkey => $ttmvalue) {
					$ttMasterArray[] = 1;
				}
			}
 
			ob_start(); 
			?>
            <div class="main-card mb-3 card">
                <div class="card-body">
                	<h5 class="card-title">Table bordered</h5>  
                	<?php 
                	foreach ($lecture_type_array as $ltkey => $ltvalue) {
                		?>
                		<div class="mb-2 mr-1 badge <?php echo $lecture_type_style_array[$ltkey]['badge'];?>"><?php echo $ltvalue;?></div>
                		<?php
                	}
                	?>                   
                    <table class="mb-0 table table-bordered table-hover table-striped">
					  <tr>
					   	<th scope="col"></th>
					   	<?php
					    if(count($ysPeriodData) > 0) {

						  	foreach ($ysPeriodData as $pkey => $pvalue) {
						  		?>
						  		<th scope="col"><?php echo $pvalue['period_value'];?></th>
						  		<?php
						  	}
						}
					    ?>
					  </tr>
					  <?php
					  if(count($ysWorkingDaysData) > 0) {

					  	foreach ($ysWorkingDaysData as $dkey => $dvalue) {
					  		?>
					  		<tr>
							    <th scope="row" style="min-height: 100px;height: 100px;"><?php echo $GLOBALS['session_working_days_array'][$dvalue['day_value']];?></th>
							    <?php
							    if(count($ysPeriodData) > 0) {

								  	foreach ($ysPeriodData as $pkey => $pvalue) {
								  		?>
								  		<td style="position: relative;width:12.5%;">
								  			<div style="margin-bottom: 20px;">	
								  				<div class="tt_items_cls">
										  			<?php
										  			$parameterArray = array();
													$parameterArray['day_id'] = $dvalue['day_value'];
													$parameterArray['period_id'] = $pvalue['period_id'];

													if(!empty($_REQUEST['search_day_id'])) {

														if($dvalue['day_value'] == $_REQUEST['search_day_id']) {

															$parameterArray['day_id'] = $_REQUEST['search_day_id'];
														}
														else {
															$parameterArray['day_id'] = 0;
														}
													}

													if(!empty($_REQUEST['search_period_id'])) {

														if($pvalue['period_id'] == $_REQUEST['search_period_id']) {

															$parameterArray['period_id'] = $_REQUEST['search_period_id'];
														}
														else {
															$parameterArray['period_id'] = 0;
														}
													}

													if(!empty($_REQUEST['search_class_id'])) {

														$parameterArray['class_id'] = $_REQUEST['search_class_id'];
													}

													if(!empty($_REQUEST['search_semester_id'])) {

														$parameterArray['semester_id'] = $_REQUEST['search_semester_id'];
													}

													if(!empty($_REQUEST['search_section_id'])) {

														$parameterArray['section_id'] = $_REQUEST['search_section_id'];
													}

													if(!empty($_REQUEST['search_teacher_id'])) {

														$parameterArray['teacher_id'] = $_REQUEST['search_teacher_id'];
													}

										  			$return_str = $toolObj->getTimetableCellData($parameterArray);

										  			$return_array = json_decode($return_str, true);

										  			if(count( $return_array['small_span']) > 0) {

										  				foreach ( $return_array['small_span'] as $spanKey => $spanValue) {
										  					echo str_replace("edit_timetable_data_cls ", "", $spanValue);
										  				}
										  			}									  			
										  			?>	
									  			</div>							  										  		
										  	</div>
										 </td>
								  		<?php
								  	}
								}
							    ?>
							</tr>
					  		<?php
					  	}
					  }
					  ?>
					</table>
                </div>
            </div>                     
			<?php

			$output = ob_get_clean();

			$error_message['ajax_html']  =  $output;
			$error_message['ajax_status']  =  "success";
			$return_str = json_encode($error_message);
			echo $return_str;
			exit;
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		exit;
	}

	if($_REQUEST['calling_block'] == 'submit_add_timetable_data') {

		$return_str  = '';
		$error_message = array();

		$data_edit_id = 0;

		$css_str = '';
		
		if (empty($_REQUEST['cross_subject_id'])) {
		   $error_message['cross_subject_id'] = 'Please Select Subject';   
		}			 

		if (empty($_REQUEST['cross_paper_type'])) {
		   $error_message['cross_paper_type'] = 'Please Select Paper Type';
		}

		if (empty($_REQUEST['cross_lecture_type'])) {
		   $error_message['cross_lecture_type'] = 'Please Select Lecture Type';
		}

		if (empty($_REQUEST['timetable_room'])) {
		   $error_message['timetable_room'] = 'Please Select Room';
		}

		if(count($error_message) == 0) {

			//datastr: 8~2~1~6~8
			//datastr: class~semester~section~day~period

			if($_REQUEST['datastr'] == 'noadd' && !empty($_REQUEST['editid']) && $_REQUEST['editid'] != 'noedit') {

				//EDIT BLOCK
				$editid_str = base64_decode($_REQUEST['editid']);

				$editid_array = explode("TT@TT", $editid_str);

				$data_edit_id = $editid_array[0];

				if($editid_array[1] == COLLEGE_ID) {

					$getTTCrossData = $toolObj->getDetail('tt_timetable_cross', " and d.college_id = '".COLLEGE_ID."' and d.cross_id = '".$editid_array[0]."' ", "", ' d.* ');

					if(count($getTTCrossData) > 0) {

						$getTTMasterData = $toolObj->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_id = '".$getTTCrossData[0]['cross_timetable_id']."' ", "", ' d.* ');

						$cssdp = array(
							'0' => $getTTCrossData[0]['cross_class'],
							'1' => $getTTCrossData[0]['cross_semester'],
							'2' => $getTTCrossData[0]['cross_section'],
							'3' => $getTTMasterData[0]['timetable_day'],
							'4' => $getTTMasterData[0]['timetable_period']
						);
					}
					else {
						$error_message['ajax_status']  =  "error";
						$error_message['ajax_alert']  =  "Some Error Occur...";
						$return_str = json_encode($error_message);
						echo $return_str;
						exit;
					}
				}
				else {

					$error_message['ajax_status']  =  "error";
					$error_message['ajax_alert']  =  "Some Error Occur...";
					$return_str = json_encode($error_message);
					echo $return_str;
					exit;
				}
			}
			else if($_REQUEST['editid'] == 'noedit' && !empty($_REQUEST['datastr']) && $_REQUEST['datastr'] != 'noadd') {
				$data_edit_id = 0;
				$cssdp = explode("~", $_REQUEST['datastr']);

				$_SESSION['tt_last_input_data']['cross_subject_id'] = $_REQUEST['cross_subject_id'];
				$_SESSION['tt_last_input_data']['cross_teacher_id'] =$_REQUEST['cross_teacher_id'];
				$_SESSION['tt_last_input_data']['cross_paper'] = $_REQUEST['cross_paper'];
				$_SESSION['tt_last_input_data']['cross_paper_type'] = $_REQUEST['cross_paper_type'];
				$_SESSION['tt_last_input_data']['cross_lecture_type'] = $_REQUEST['cross_lecture_type'];
			}

			$currentYSData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');

			$checkData = $toolObj->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_year = '".$currentYSData[0]['ys_year']."'  and d.timetable_semesters = '".$currentYSData[0]['ys_sememster']."' and d.timetable_status='Y' and d.timetable_day = '".$cssdp['3']."' and d.timetable_room = '".$_REQUEST['timetable_room']."' and d.timetable_period = '".$cssdp['4']."' ", '', ' * ');

			if(count($checkData) > 0) {


				$whereArray = array();
				$data_array = array();
 
				if(empty($_REQUEST['cross_teacher_id'])) {
					$_REQUEST['cross_teacher_id'] = 0;
				}

				if(empty($_REQUEST['cross_paper'])) {
					$_REQUEST['cross_paper'] = 0;
				}

				if($data_edit_id > 0) {
					
					$whereArray['cross_id'] = $data_edit_id;
					$whereArray['college_id'] = COLLEGE_ID;
				}
				else {

					$data_array['college_id'] = COLLEGE_ID;
					$data_array['cross_class'] = $cssdp['0'];
					$data_array['cross_semester'] = $cssdp['1'];
					$data_array['cross_section'] = $cssdp['2'];
				}
 
				$data_array['cross_timetable_id'] = $checkData[0]['timetable_id'];
				$data_array['cross_teacher_id'] = $_REQUEST['cross_teacher_id'];
				$data_array['cross_lecture_type'] = $_REQUEST['cross_lecture_type'];
				$data_array['cross_subject_id'] = $_REQUEST['cross_subject_id'];
				$data_array['cross_paper'] =  $_REQUEST['cross_paper'];
				$data_array['cross_paper_type'] = $_REQUEST['cross_paper_type'];

				$data_array['cross_datetime'] = date("Y-m-d H:i:s");
				$data_array['cross_added_by'] = $_SESSION['user_00']['login_id'];

				$cross_id = $toolObj->addUpdateDetail('tt_timetable_cross', $data_array, $whereArray);

				$parameterArray = array();
				$parameterArray['class_id'] = $cssdp['0'];
				$parameterArray['semester_id'] = $cssdp['1'];
				$parameterArray['section_id'] = $cssdp['2'];
				$parameterArray['day_id'] = $cssdp['3'];
				$parameterArray['period_id'] = $cssdp['4'];

	  			$return_str = $toolObj->getTimetableCellData($parameterArray);

	  			$return_array = json_decode($return_str, true);

	  			if(count( $return_array['small_span']) > 0) {

	  				foreach ( $return_array['small_span'] as $spanKey => $spanValue) {
	  					$error_message['ajax_html'] .= $spanValue;
	  				}
	  			}

				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {
				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_timetable_data') {

		$return_str  = '';
		$ysPeriodDataArray = array();
		$autoSelectedArray = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['datastr'] == 'noadd' && !empty($_REQUEST['editid']) && $_REQUEST['editid'] != 'noedit') {

			//EDIT BLOCK
			$editid_str = base64_decode($_REQUEST['editid']);

			$editid_array = explode("TT@TT", $editid_str);

			if($editid_array[1] == COLLEGE_ID) {

				$getTTCrossData = $toolObj->getDetail('tt_timetable_cross', " and d.college_id = '".COLLEGE_ID."' and d.cross_id = '".$editid_array[0]."' ", "", ' d.* ');

				if(count($getTTCrossData) > 0) {

					$getTTMasterData = $toolObj->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_id = '".$getTTCrossData[0]['cross_timetable_id']."' ", "", ' d.* ');

					$datastr_array = array(
						'0' => $getTTCrossData[0]['cross_class'],
						'1' => $getTTCrossData[0]['cross_semester'],
						'2' => $getTTCrossData[0]['cross_section'],
						'3' => $getTTMasterData[0]['timetable_day'],
						'4' => $getTTMasterData[0]['timetable_period']
					);

					$autoSelectedArray['cross_subject_id'] = $getTTCrossData[0]['cross_subject_id'];
					$autoSelectedArray['cross_teacher_id'] = $getTTCrossData[0]['cross_teacher_id'];
					$autoSelectedArray['cross_paper'] = $getTTCrossData[0]['cross_paper'];
					$autoSelectedArray['cross_paper_type'] = $getTTCrossData[0]['cross_paper_type'];
					$autoSelectedArray['cross_lecture_type'] = $getTTCrossData[0]['cross_lecture_type'];
					$autoSelectedArray['timetable_room'] = $getTTMasterData[0]['timetable_room'];
				}
				else {
					$error_message['ajax_status']  =  "error";
					$error_message['ajax_alert']  =  "Some Error Occur...";
					$return_str = json_encode($error_message);
					echo $return_str;
					exit;
				}
			}
			else {

				$error_message['ajax_status']  =  "error";
				$error_message['ajax_alert']  =  "Some Error Occur...";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
		}
		else if($_REQUEST['editid'] == 'noedit' && !empty($_REQUEST['datastr']) && $_REQUEST['datastr'] != 'noadd') {

			$autoSelectedArray = $_SESSION['tt_last_input_data'];
			
			//ADD BLOCK
			$datastr_array = explode("~", $_REQUEST['datastr']);
		}

		$data_array = array(
			'class_id'=>$datastr_array[0],
			'semester_id'=>$datastr_array[1],
			'section_id'=>$datastr_array[2],
			'day_id'=>$datastr_array[3],
			'period_id'=>$datastr_array[4]
		);


		if($autoSelectedArray['cross_subject_id'] > 0 && !empty($autoSelectedArray['cross_subject_id'])) {

			$teacherListData = $toolObj->getDetail('tt_teacher_master', " and d.college_id = '".COLLEGE_ID."' and teacher_subject = '".$autoSelectedArray['cross_subject_id']."' ", '', ' teacher_id, teacher_name ');
		}

		

		$currentYSData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');

		$ysPeriodData = $toolObj->getDetail('tt_session_period_log', " and d.college_id = '".COLLEGE_ID."' and d.period_year = '".$currentYSData[0]['ys_year']."'  and d.period_semester = '".$currentYSData[0]['ys_sememster']."' and d.period_status = '0' ", '', ' period_id, period_value, period_type ');

		foreach ($ysPeriodData as $ypkey => $ypvalue) {
			
			$ysPeriodDataArray[$ypvalue['period_id']] = $ypvalue;
		}

		$classRoomDataArray = array();

		$classRoomData = $toolObj->getDetail('tt_class_room_master', " and d.college_id = '".COLLEGE_ID."' ", '', ' * ');

		foreach ($classRoomData as $crkey => $crvalue) {
			
			$classRoomDataArray[$crvalue['room_id']] = $crvalue;
		}

		ob_start(); 	
		?>
		<form class="" name="add_timetable_data_form"  id="add_timetable_data_form">
		 	<div class="position-relative row form-group">
		 		<label for="cross_subject_id" class="col-sm-3 col-form-label">Subject : </label>
	            <div class="col-sm-9">
	            	<select name="cross_subject_id" id="cross_subject_id" class="form-control">
	                    <option value="">Select Subject</option>
	                    <?php
	                    foreach ($subjectDataArray as $skey => $svalue) {
	                        ?> <option <?php if($svalue['subject_id'] == $autoSelectedArray['cross_subject_id']){ ?>selected="selected"<?php }?> value="<?php echo $svalue['subject_id']?>"><?php echo $svalue['subject_title']?></option><?php
	                    }
	                    ?>
	                </select>
	                <div class="invalid-feedback" id="cross_subject_id_error"></div>
	            </div>
	        </div>

	        <div class="position-relative row form-group">
		 		<label for="cross_teacher_id" class="col-sm-3 col-form-label">Teacher : </label>
	            <div class="col-sm-9">
	            	<select name="cross_teacher_id" id="cross_teacher_id" class="form-control">
	                    <option value="">Select Teacher</option>
	                    <?php
	                    if(count($teacherListData) > 0) {

	                    	foreach ($teacherListData as $tlkey => $tlvalue) {
	                    		?>
	                    		<option <?php if($tlvalue['teacher_id'] == $autoSelectedArray['cross_teacher_id']){ ?>selected="selected"<?php }?> value="<?php echo $tlvalue['teacher_id']?>"><?php echo $tlvalue['teacher_name']?></option>
	                    		<?php
	                    	}
	                    }
	                    ?>
	                    
	                </select>
	                <div class="invalid-feedback" id="cross_teacher_id_error"></div>
	            </div>
	        </div>

	        <div class="position-relative row form-group">
		 		<label for="cross_paper" class="col-sm-3 col-form-label">Paper : </label>
	            <div class="col-sm-9">
	            	<select name="cross_paper" id="cross_paper" class="form-control">
	                    <option value="">Select Paper</option>
	                    <?php
	                    if(count($paperDataArray) > 0) {

	                    	foreach ($paperDataArray as $pdkey => $pdvalue) {
	                    		?>
	                    		<option <?php if($pdvalue['paper_id'] == $autoSelectedArray['cross_paper']){ ?>selected="selected"<?php }?> value="<?php echo $pdvalue['paper_id'];?>"><?php echo $pdvalue['paper_title'];?></option>
	                    		<?php
	                    	}
	                    }
	                    ?>
	                </select>
	                <div class="invalid-feedback" id="cross_paper_error"></div>
	            </div>
	        </div>

	        <div class="position-relative row form-group">
		 		<label for="cross_paper_type" class="col-sm-3 col-form-label">Paper Type : </label>
	            <div class="col-sm-9">
	            	<select name="cross_paper_type" id="cross_paper_type" class="form-control">
	                    <option value="">Select Paper Type</option>
	                    <?php
	                    foreach ($GLOBALS['paper_type_array'] as $ptkey => $ptvalue) {
	                        ?>
	                        <option <?php if($ptkey == $autoSelectedArray['cross_paper_type']){ ?>selected="selected"<?php }?> value="<?php echo $ptkey;?>"><?php echo $ptvalue;?></option>
	                        <?php
	                    }
	                    ?>
	                </select>
	                <div class="invalid-feedback" id="cross_paper_type_error"></div>
	            </div>
	        </div>

	        <div class="position-relative row form-group">
		 		<label for="cross_lecture_type" class="col-sm-3 col-form-label">Lecture Type : </label>
	            <div class="col-sm-9">
	            	<select name="cross_lecture_type" id="cross_lecture_type" class="form-control">
	                    <option value="">Select Lecture Type</option>
	                    <?php
	                    foreach ($GLOBALS['lecture_type_array'] as $ltkey => $ltvalue) {
	                        ?>
	                        <option <?php if($ltkey == $autoSelectedArray['cross_lecture_type']){ ?>selected="selected"<?php }?>  value="<?php echo $ltkey;?>"><?php echo $ltvalue;?></option>
	                        <?php
	                    }
	                    ?>
	                </select>
	                <div class="invalid-feedback" id="cross_lecture_type_error"></div>
	            </div>
	        </div>

	        <div class="position-relative row form-group">
		 		<label for="timetable_room" class="col-sm-3 col-form-label">Room : </label>
	            <div class="col-sm-9">
	            	<select name="timetable_room" id="timetable_room" class="form-control">
	                    <option value="">Select Room</option>
	                    <?php
	                    foreach ($classRoomDataArray as $crKey => $crValue) {
	                        ?> <option <?php if($crValue['room_id'] == $autoSelectedArray['timetable_room']){ ?>selected="selected"<?php }?> value="<?php echo $crValue['room_id']?>"><?php echo $crValue['room_no']?> [ <?php echo $crValue['room_capacity']?> ]</option><?php
	                    }
	                    ?>
	                </select>
	                <div class="invalid-feedback" id="timetable_room_error"></div>
	            </div>
	        </div>
 
            <div class="position-relative form-group text-center">
            	<input type="hidden" name="datastr" value="<?php echo $_REQUEST['datastr'];?>">
            	<input type="hidden" name="editid" value="<?php echo $_REQUEST['editid'];?>">
	            <button id="submit_add_timetable_data" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			
			$error_message['ajax_title']  =  $classDataArray[$data_array['class_id']]['class_title']." ".$semester_master_array[$data_array['semester_id']].", ".$sectionDataArray[$data_array['section_id']]['section_title']." - ".$session_working_days_array[$data_array['day_id']].", ".$ysPeriodDataArray[$data_array['period_id']]['period_value'];
		}
		else {
			
			$error_message['ajax_title']  =  $classDataArray[$data_array['class_id']]['class_title']." ".$semester_master_array[$data_array['semester_id']].", ".$sectionDataArray[$data_array['section_id']]['section_title']." - ".$session_working_days_array[$data_array['day_id']].", ".$ysPeriodDataArray[$data_array['period_id']]['period_value'];					
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}

	if($_REQUEST['calling_block'] == 'submit_create_timetable_by_class') {

		$return_str  = '';
		$error_message = array();

		$css_str = '';
		
		if (empty($_REQUEST['search_class_id'])) {
		   $error_message['search_class_id'] = 'Please Select Class';   
		}			 

		if (empty($_REQUEST['search_semester_id'])) {
		   $error_message['search_semester_id'] = 'Please Select Semester';
		}

		if (empty($_REQUEST['search_section_id'])) {
		   $error_message['search_section_id'] = 'Please Select Section';
		}

		if(count($error_message) == 0) {

			$css_str = $_REQUEST['search_class_id']."~".$_REQUEST['search_semester_id']."~".$_REQUEST['search_section_id'];

			$ttMasterArray = array();

			$currentYSData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');

			$ysWorkingDaysData = $toolObj->getDetail('tt_session_working_days_log', " and d.college_id = '".COLLEGE_ID."' and d.day_year = '".$currentYSData[0]['ys_year']."'  and d.day_semester = '".$currentYSData[0]['ys_sememster']."' ", '', ' day_id, day_value ');

			$ysPeriodData = $toolObj->getDetail('tt_session_period_log', " and d.college_id = '".COLLEGE_ID."' and d.period_year = '".$currentYSData[0]['ys_year']."'  and d.period_semester = '".$currentYSData[0]['ys_sememster']."' and d.period_status = '0' ", '', ' period_id, period_value, period_type ');

			$ttMasterData = $toolObj->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_year = '".$currentYSData[0]['ys_year']."'  and d.timetable_semesters = '".$currentYSData[0]['ys_sememster']."' and d.timetable_status='Y' ", '', ' * ');

			if(count($ttMasterData) > 0) {

				foreach ($ttMasterData as $ttmkey => $ttmvalue) {
					$ttMasterArray[] = 1;
				}
			}
  
			//$currentYSData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');	

			// echo "<pre>";	
			// print_r($ysWorkingDaysData);
			// print_r($ysPeriodData);
			// echo "</pre>";
 
			/*Array ( [0] => Array ( [ys_log_id] => 2 [college_id] => 10 [ys_year] => 2021 [ys_sememster] => ["2","4","6"] [ys_activated] => 1 [ys_datetime] => 2021-09-20 15:34:52 [ys_added_by] => 1 [ys_admin_visible] => 0 ) )*/

			ob_start(); 
			?>
            <div class="main-card mb-3 card">
                <div class="card-body">
                	<h5 class="card-title">Table bordered</h5>  
                	<?php 
                	foreach ($lecture_type_array as $ltkey => $ltvalue) {
                		?>
                		<div class="mb-2 mr-1 badge <?php echo $lecture_type_style_array[$ltkey]['badge'];?>"><?php echo $ltvalue;?></div>
                		<?php
                	}
                	?>                   
                    <table class="mb-0 table table-bordered table-hover table-striped">
					  <tr>
					   	<th scope="col"></th>
					   	<?php
					    if(count($ysPeriodData) > 0) {

						  	foreach ($ysPeriodData as $pkey => $pvalue) {
						  		?>
						  		<th scope="col"><?php echo $pvalue['period_value'];?></th>
						  		<?php
						  	}
						}
					    ?>
					  </tr>
					  <?php
					  if(count($ysWorkingDaysData) > 0) {

					  	foreach ($ysWorkingDaysData as $dkey => $dvalue) {
					  		?>
					  		<tr>
							    <th scope="row" style="min-height: 100px;height: 100px;"><?php echo $GLOBALS['session_working_days_array'][$dvalue['day_value']];?></th>
							    <?php
							    if(count($ysPeriodData) > 0) {

								  	foreach ($ysPeriodData as $pkey => $pvalue) {
								  		?>
								  		<td style="position: relative;width:12.5%;">
								  			<div style="margin-bottom: 20px;">	
								  				<div class="tt_items_cls">
										  			<?php
										  			$parameterArray = array();
													$parameterArray['class_id'] = $_REQUEST['search_class_id'];
													$parameterArray['semester_id'] = $_REQUEST['search_semester_id'];
													$parameterArray['section_id'] = $_REQUEST['search_section_id'];



													$parameterArray['day_id'] = $dvalue['day_value'];
													$parameterArray['period_id'] = $pvalue['period_id'];

										  			$return_str = $toolObj->getTimetableCellData($parameterArray);

										  			$return_array = json_decode($return_str, true);

										  			if(count( $return_array['small_span']) > 0) {

										  				foreach ( $return_array['small_span'] as $spanKey => $spanValue) {
										  					echo $spanValue;
										  				}
										  			}									  			
										  			?>	
									  			</div>							  			
									  			<a class="add_timetable_data_cls" href="javascript:" data-datastr="<?php echo $css_str."~".$dvalue['day_value']."~".$pvalue['period_id'];?>" style=" position: absolute;bottom: 0;right: 0;cursor: pointer"><i class="pe-7s-plus" style="padding: 6px;font-size: 20px"></i>
									  			</a>							  										  		
										  	</div>
										 </td>
								  		<?php
								  	}
								}
							    ?>
							</tr>
					  		<?php
					  	}
					  }
					  ?>
					</table>
                </div>
            </div>                     
			<?php

			$output = ob_get_clean();

			$error_message['ajax_html']  =  $output;
			$error_message['ajax_status']  =  "success";
			$return_str = json_encode($error_message);
			echo $return_str;
			exit;
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_create_tt_form') {

		$return_str  = '';
		$error_message = array();

		if(empty($_REQUEST['createby'])) {

			$error_message['ajax_status']  =  "error";
			$error_message['ajax_alert']  =  "Some Error Occur";
		}
		else {

			$error_message['ajax_status']  =  "success";

			ob_start(); 
			if($_REQUEST['createby'] == 'class') {

				include_once(SITEDIR."/vView-1/create-timetable-by-class-form.php");
			}
			else if($_REQUEST['createby'] == 'teacher') {
				
				include_once(SITEDIR."/vView-1/create-timetable-by-teacher-form.php");
			}
			else if($_REQUEST['createby'] == 'day') {
				
				include_once(SITEDIR."/vView-1/create-timetable-by-day-form.php");
			}
			else {
				$error_message['ajax_status']  =  "error";
				$error_message['ajax_alert']  =  "Some Error Occur";
			}
			
			$output = ob_get_clean();
			$error_message['ajax_html']  =  $output;
		}

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------TIMETABLE-----------------------------------//

//----------------------------TEACHER-----------------------------------//

	if($_REQUEST['calling_block'] == 'get_teacher_data') {

		$return_str  = '';
		$error_message = array();

		$teacherListDataArray = array();

		$cond = "";
		if($_REQUEST['filterid'] > 0 && !empty($_REQUEST['filterby'])) {

			$cond = " and ".$_REQUEST['filterby']."='".$_REQUEST['filterid']."' ";
		}

		$teacherListData = $toolObj->getDetail('tt_teacher_master', " and d.college_id = '".COLLEGE_ID."' ".$cond, '', ' * ');

		if(count($teacherListData) > 0) {
			foreach ($teacherListData as $dkey => $dvalue) {
				$teacherListDataArray[$dvalue['teacher_id']] = $dvalue;
			}
		}

		$error_message['ajax_status']  =  "success";
		$error_message['ajax_data']  =  $teacherListDataArray;  

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
 
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_teacher'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_teacher_master', " and d.teacher_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_teacher_master', " and teacher_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");

		   	$toolObj->deleteDetail('tt_user_login_master', " and login_department_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' and login_group = '44'");
		  	 $error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_teacher') {

		$return_str  = '';
		$error_message = array();
		

		if (empty($_REQUEST['teacher_name'])) {
		   $error_message['teacher_name'] = 'Please Enter Name';   
		}			 

		if (empty($_REQUEST['teacher_sort_name'])) {
		   $error_message['teacher_sort_name'] = 'Please Enter Sort Name';
		}
		 

		if (empty($_REQUEST['teacher_mobile'])) {
		   $error_message['teacher_mobile'] = 'Please Enter Mobile No.';  
		}
		 
		if (empty($_REQUEST['teacher_email'])) {
		    $error_message['teacher_email'] = 'Please Enter E-Mail Id '; 
		}
		else {
			if(!preg_match(EMAIL_CHECK_EXP, $_REQUEST['teacher_email'])) {

				$error_message['teacher_email'] = 'Invalid  E-Mail Id';
			}
		}			 

		if (empty($_REQUEST['teacher_department'])) {
		   $error_message['teacher_department'] = 'Please Select Depatment';  
		}			 

		if (empty($_REQUEST['teacher_subject'])) {
		    $error_message['teacher_subject'] = 'Please Select Subject';
		} 

		 
		if (empty($_REQUEST['teacher_post'])) {
		    $error_message['teacher_post'] = 'Please Enter Post';
		}
	 
		if(count($error_message) == 0) {

			$whereArray = array();
			$data_array = array();

			$data_array['college_id'] = COLLEGE_ID;

			$data_array['teacher_name'] = $_REQUEST['teacher_name'];
			$data_array['teacher_sort_name'] = $_REQUEST['teacher_sort_name'];
			$data_array['teacher_mobile'] = $_REQUEST['teacher_mobile'];
			$data_array['teacher_email'] = $_REQUEST['teacher_email'];
			$data_array['teacher_department'] = $_REQUEST['teacher_department'];
			$data_array['teacher_subject'] = $_REQUEST['teacher_subject'];
			$data_array['teacher_post'] = $_REQUEST['teacher_post'];
			$data_array['teacher_category'] = $_REQUEST['teacher_category'];
			$data_array['teacher_joining_date'] = $_REQUEST['teacher_joining_date'];
			$data_array['teacher_status'] = $_REQUEST['teacher_status'];

			$data_array['teacher_datetime'] = date("Y-m-d H:i:s");
			$data_array['teacher_added_by'] = $_SESSION['user_00']['login_id'];

			if(empty( $data_array['teacher_joining_date'])) {

				$data_array['teacher_joining_date'] = '0000-00-00';
			}
			if(empty( $data_array['teacher_status'])) {

				$data_array['teacher_status'] = '0';
			}

			if($_REQUEST['editid'] > 0) {

				$whereArray['teacher_id'] = $_REQUEST['editid'];
			}
			
			$teacherInsertId = $toolObj->addUpdateDetail('tt_teacher_master', $data_array, $whereArray);

			if($teacherInsertId > 0 && empty($_REQUEST['editid'])) {

				$whereArray = array();
				$data_array = array();

				$randomStr = $toolObj->getRandomString();

				$login_id_str = "tech".$teacherInsertId."@".COLLEGE_ID;

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['login_username'] = $login_id_str;
				$data_array['login_password'] = md5($randomStr);
				$data_array['login_display_name'] = $_REQUEST['teacher_name'];
				$data_array['login_email'] = $_REQUEST['teacher_email'];
				$data_array['login_datetime'] = date("Y-m-d H:i:s");
				//$data_array['login_added_by'] = $_SESSION['user_00']['login_id'];
				$data_array['login_added_by'] = $randomStr;
				$data_array['login_group'] = '44';
				$data_array['login_department_id'] = $teacherInsertId;
				$data_array['login_status'] = 'Y';
				
				$id = $toolObj->addUpdateDetail('tt_user_login_master', $data_array, $whereArray);
			}
			
			$error_message['ajax_status']  =  "success";
			$return_str = json_encode($error_message);
			echo $return_str;
			exit;
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_teacher_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_teacher_master', " and d.teacher_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		<form class="" name="add_edit_teacher_form"  id="add_edit_teacher_form">
		    <div class="form-row">
		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_name" class="">Name</label>
		                <input name="teacher_name" id="teacher_name" placeholder="Name" type="text" class="form-control" value="<?php echo $departmentEditData[0]['teacher_name'];?>">
		                <div class="invalid-feedback" id="teacher_name_error"></div>
		            </div>
		        </div>

		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_sort_name" class="">Sort Name</label>
		                <input name="teacher_sort_name" id="teacher_sort_name" placeholder="Sort Name" type="text" class="form-control" value="<?php echo $departmentEditData[0]['teacher_sort_name'];?>">
		                <div class="invalid-feedback" id="teacher_sort_name_error"></div>
		            </div>
		        </div>
		    </div>

		    <div class="form-row">
		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_mobile" class="">Mobile</label>
		                <input name="teacher_mobile" id="teacher_mobile" placeholder="Mobile" type="text" class="form-control" value="<?php echo $departmentEditData[0]['teacher_mobile'];?>">
		                <div class="invalid-feedback" id="teacher_mobile_error"></div>
		            </div>
		        </div>

		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_email" class="">E-Mail (Used For Password Recovery)</label>
		                <input name="teacher_email" id="teacher_email" placeholder="E-Mail" type="text" class="form-control" value="<?php echo $departmentEditData[0]['teacher_email'];?>">
		                <div class="invalid-feedback" id="teacher_email_error"></div>
		            </div>
		        </div>
		    </div>

		    <div class="form-row">
		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_department" class="">Department</label>
		                <select name="teacher_department" id="teacher_department" class="form-control">
		                    <option value="">Select Department</option>
		                    <?php
		                    foreach ($deparmentDataArray as $key => $value) {
		                        ?> <option <?php if($value['department_id'] == $departmentEditData[0]['teacher_department']){ ?>selected="selected"<?php }?> value="<?php echo $value['department_id']?>"><?php echo $value['department_title']?></option><?php
		                    }
		                    ?>
		                </select>
		                <div class="invalid-feedback" id="teacher_department_error"></div>
		            </div>
		        </div>

		        <div class="col-md-6">
		            <div class="position-relative form-group">
		                <label for="teacher_subject" class="">Subject</label>
		                <select name="teacher_subject" id="teacher_subject" class="form-control">                    
		                    <option value="">Select Subject</option>
		                    <?php
		                    foreach ($subjectDataArray as $key => $value) {
		                        ?> <option <?php if($value['subject_id'] == $departmentEditData[0]['teacher_subject']){ ?>selected="selected"<?php }?> value="<?php echo $value['subject_id']?>"><?php echo $value['subject_title']?></option><?php
		                    }
		                    ?>
		                </select>
		                <div class="invalid-feedback" id="teacher_subject_error"></div>
		            </div>
		        </div>
		    </div>

		    <div class="form-row">
		        <div class="col-md-4">
		            <div class="position-relative form-group">
		                <label for="teacher_category" class="">Category</label>
		                <select name="teacher_category" id="teacher_category" class="form-control">
		                    <option value="">Select Category</option>
		                    <?php
		                    foreach ($teacher_category_array as $key => $value) {
		                        ?> <option <?php if($key == $departmentEditData[0]['teacher_category']){ ?>selected="selected"<?php }?> value="<?php echo $key?>"><?php echo $value?></option><?php
		                    }
		                    ?>
		                </select>
		                <div class="invalid-feedback" id="teacher_department_error"></div>
		            </div>
		        </div>

		        <div class="col-md-4">
		            <div class="position-relative form-group">
		                <label for="teacher_post" class="">Post</label>
		                <input name="teacher_post" id="teacher_post" placeholder="Post" type="text" class="form-control" value="<?php echo $departmentEditData[0]['teacher_post'];?>">
		                <div class="invalid-feedback" id="teacher_name_error"></div>
		            </div>
		        </div>

		        <div class="col-md-4">
		            <div class="position-relative form-group">
		                <label for="teacher_joining_date" class="">Joining Date</label>
		                <input name="teacher_joining_date" id="teacher_joining_date" placeholder="Joining Date" type="text" class="form-control datepicker" value="<?php echo $departmentEditData[0]['teacher_joining_date'];?>">
		                <div class="invalid-feedback" id="teacher_joining_date_error"></div>
		            </div>
		        </div>
		    </div>
		 
		    <div class="position-relative form-group text-center">
		        <input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['teacher_id'];?>">
		        <button id="submit_teacher" type="button" class="mt-2 btn btn-primary">Submit</button>
		    </div>
		</form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Edit Teacher Detail";
		}
		else {
			$error_message['ajax_title']  =  "Add Teacher Detail";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------TEACHER-----------------------------------//

//----------------------------CLASS ROOM MASTER-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_room'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_class_room_master', " and d.room_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_class_room_master', " and room_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");

		   	$parameterArray = array();
			$parameterArray['timetable_year'] = $_SESSION['year_semester_data'][0];
			$parameterArray['timetable_semesters'] = json_encode($_SESSION['year_semester_data'][1]);

			$toolObj->resetTimetableMaster($parameterArray);

		  	$error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_room') {

			$return_str  = '';
			$error_message = array();
			

			if(empty($_REQUEST['room_no'])) {

				$error_message['room_no'] = 'Please Enter Room No';
			}

			if(empty($_REQUEST['room_capacity'])) {

				$error_message['room_capacity'] = 'Please Enter Room Capacity';
			}

			if(empty($_REQUEST['room_seating_capacity'])) {

				$error_message['room_seating_capacity'] = 'Please Enter Room Seating Capacity';
			}

			if(empty($_REQUEST['room_sub_number'])) {

				$_REQUEST['room_sub_number'] = 0;
			}
		 
			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['room_no'] = $_REQUEST['room_no'];
				$data_array['room_capacity'] = $_REQUEST['room_capacity'];
				$data_array['room_sub_number'] = $_REQUEST['room_sub_number'];
				$data_array['room_seating_capacity'] = $_REQUEST['room_seating_capacity'];
				$data_array['room_status'] = $_REQUEST['room_status'];
				$data_array['room_datetime'] = date("Y-m-d H:i:s");
				$data_array['room_added_by'] = $_SESSION['user_00']['login_id'];

				if($_REQUEST['editid'] > 0) {

					$whereArray['room_id'] = $_REQUEST['editid'];
				}
				
				$id = $toolObj->addUpdateDetail('tt_class_room_master', $data_array, $whereArray);

				$parameterArray = array();
				$parameterArray['timetable_year'] = $_SESSION['year_semester_data'][0];
				$parameterArray['timetable_semesters'] = json_encode($_SESSION['year_semester_data'][1]);

				$toolObj->resetTimetableMaster($parameterArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_room_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_class_room_master', " and d.room_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_room_form"  id="add_edit_room_form">
            <div class="position-relative form-group">
            	<label class="">Room No</label>
            	<input name="room_no" id="room_no" placeholder="Room No" type="text" class="form-control" value="<?php echo $departmentEditData[0]['room_no'];?>">
            	<div class="invalid-feedback" id="room_no_error"></div>
            </div>

             <div class="position-relative form-group">
            	<label class="">Sub Room No</label>
            	<input name="room_sub_number" id="room_sub_number" placeholder="Sub Room No" type="text" class="form-control" value="<?php echo $departmentEditData[0]['room_sub_number'];?>">
            	<div class="invalid-feedback" id="room_sub_number_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Room Capacity</label>
            	<input name="room_capacity" id="room_capacity" placeholder="Room Capacity" type="text" class="form-control" value="<?php echo $departmentEditData[0]['room_capacity'];?>">
            	<div class="invalid-feedback" id="room_capacity_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Seating Capacity</label>
            	<input name="room_seating_capacity" id="room_seating_capacity" placeholder="Seating Capacity" type="text" class="form-control" value="<?php echo $departmentEditData[0]['room_seating_capacity'];?>">
            	<div class="invalid-feedback" id="room_seating_capacity_error"></div>
            </div>
 
            <div class="position-relative form-group text-center">
            	<input type="hidden" name="room_status"  id="room_status" value="0">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['room_id'];?>">
	            <button id="submit_room" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Class Room";
		}
		else {
			$error_message['ajax_title']  =  "Add Class Room";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------CLASS ROOM MASTER-----------------------------------//

//----------------------------SUBJECT-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_subject'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_subject_master', " and d.subject_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_subject_master', " and subject_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");
		  	 $error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_subject') {

			$return_str  = '';
			$error_message = array();
			

			if(empty($_REQUEST['subject_title'])) {

				$error_message['subject_title'] = 'Please Enter Subject Title';
			}

			if(empty($_REQUEST['subject_alias'])) {

				$error_message['subject_alias'] = 'Please Enter Subject Alias';
			}
		 
			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['subject_title'] = $_REQUEST['subject_title'];
				$data_array['subject_alias'] = $_REQUEST['subject_alias'];
				$data_array['subject_datetime'] = date("Y-m-d H:i:s");
				$data_array['subject_added_by'] = $_SESSION['user_00']['login_id'];

				if($_REQUEST['editid'] > 0) {

					$whereArray['subject_id'] = $_REQUEST['editid'];
				}
				
				$id = $toolObj->addUpdateDetail('tt_subject_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_subject_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_subject_master', " and d.subject_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_subject_form"  id="add_edit_subject_form">
            <div class="position-relative form-group">
            	<label class="">Subject Title</label>
            	<input name="subject_title" id="subject_title" placeholder="Subject Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['subject_title'];?>">
            	<div class="invalid-feedback" id="subject_title_error"></div>
            </div>

             <div class="position-relative form-group">
            	<label class="">Subject Title</label>
            	<input name="subject_alias" id="subject_alias" placeholder="Subject Alias" type="text" class="form-control" value="<?php echo $departmentEditData[0]['subject_alias'];?>">
            	<div class="invalid-feedback" id="subject_alias_error"></div>
            </div>

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['subject_id'];?>">
	            <button id="submit_subject" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Subject";
		}
		else {
			$error_message['ajax_title']  =  "Add Subject";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------SUBJECT-----------------------------------//


//----------------------------PAPER-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_paper'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_paper_master', " and d.paper_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_paper_master', " and paper_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");
		  	 $error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_paper') {

			$return_str  = '';
			$error_message = array();

			if(empty($_REQUEST['paper_department_id'])) {

				$error_message['paper_department_id'] = 'Please Select Department';
			}

			if(empty($_REQUEST['paper_class_id'])) {

				$error_message['paper_class_id'] = 'Please Select Class';
			}

			if(empty($_REQUEST['paper_subject_id'])) {

				$error_message['paper_subject_id'] = 'Please Select Subject';
			}
			
			if(empty($_REQUEST['paper_title'])) {

				$error_message['paper_title'] = 'Please Enter Paper Title';
			}

			if(empty($_REQUEST['paper_alias'])) {

				$error_message['paper_alias'] = 'Please Enter Department Alias';
			}

			if(empty($_REQUEST['paper_semester_id'])) {

				$error_message['paper_semester_id'] = 'Please Select Semester';
			}
		 
			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;

				$data_array['paper_department_id'] = $_REQUEST['paper_department_id'];
				$data_array['paper_class_id'] = $_REQUEST['paper_class_id'];
				$data_array['paper_subject_id'] = $_REQUEST['paper_subject_id'];
				$data_array['paper_code'] = $_REQUEST['paper_code'];
				$data_array['paper_title'] = $_REQUEST['paper_title'];
				$data_array['paper_alias'] = $_REQUEST['paper_alias'];
				$data_array['paper_semester_id'] = $_REQUEST['paper_semester_id'];
				$data_array['paper_datetime'] = date("Y-m-d H:i:s");
				$data_array['paper_added_by'] = $_SESSION['user_00']['login_id'];

				if($_REQUEST['editid'] > 0) {

					$whereArray['paper_id'] = $_REQUEST['editid'];
				}
				
				$id = $toolObj->addUpdateDetail('tt_paper_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_paper_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_paper_master', " and d.paper_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		<form class="" name="add_edit_paper_form"  id="add_edit_paper_form">
		 	<div class="position-relative form-group">
            	<label class="">Department</label>
            	 <select name="paper_department_id" id="paper_department_id" class="form-control">
                    <option value="">Select Department</option>
                   	<?php
                   	foreach ($deparmentDataArray as $key => $value) {
                   		?> <option <?php if($value['department_id'] == $departmentEditData[0]['paper_department_id']){ ?>selected="selected"<?php }?> value="<?php echo $value['department_id']?>"><?php echo $value['department_title']?></option><?php
                   	}
                   	?>
                </select>
            	<div class="invalid-feedback" id="paper_department_id_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Class</label>
            	 <select name="paper_class_id" id="paper_class_id" class="form-control">
                    <option value="">Select Class</option>
                   	<?php
                   	foreach ($classDataArray as $key => $value) {
                   		?> <option <?php if($value['class_id'] == $departmentEditData[0]['paper_class_id']){ ?>selected="selected"<?php }?> value="<?php echo $value['class_id']?>"><?php echo $value['class_title']?></option><?php
                   	}
                   	?>
                </select>
            	<div class="invalid-feedback" id="paper_class_id_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Subject</label>
            	 <select name="paper_subject_id" id="paper_subject_id" class="form-control">                    
                    <option value="">Select Subject</option>
                   	<?php
                   	foreach ($subjectDataArray as $key => $value) {
                   		?> <option <?php if($value['subject_id'] == $departmentEditData[0]['paper_subject_id']){ ?>selected="selected"<?php }?> value="<?php echo $value['subject_id']?>"><?php echo $value['subject_title']?></option><?php
                   	}
                   	?>
                </select>
                </select>
            	<div class="invalid-feedback" id="paper_subject_id_error"></div>
            </div>


            <div class="position-relative form-group">
            	<label class="">Paper Title</label>
            	<input name="paper_title" id="paper_title" placeholder="Paper Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['paper_title'];?>">
            	<div class="invalid-feedback" id="paper_title_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Paper Title</label>
            	<input name="paper_alias" id="paper_alias" placeholder="Paper Alias" type="text" class="form-control" value="<?php echo $departmentEditData[0]['paper_alias'];?>">
            	<div class="invalid-feedback" id="paper_alias_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Paper Code</label>
            	<input name="paper_code" id="paper_code" placeholder="Paper Code" type="text" class="form-control" value="<?php echo $departmentEditData[0]['paper_code'];?>">
            	<div class="invalid-feedback" id="paper_code_error"></div>
            </div>

            <div class="position-relative form-group">
            	<label class="">Semester</label>
            	 <select name="paper_semester_id" id="paper_semester_id" class="form-control">                    
                    <option value="">Select Semester</option>
                   	<?php
                   	foreach ($GLOBALS['semester_master_array'] as $key => $value) {
                   		?> <option <?php if($key == $departmentEditData[0]['paper_semester_id']){ ?>selected="selected"<?php }?> value="<?php echo $key?>"><?php echo $value?></option><?php
                   	}
                   	?>
                </select>
                </select>
            	<div class="invalid-feedback" id="paper_semester_id_error"></div>
            </div>

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['paper_id'];?>">
	            <button id="submit_paper" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Paper";
		}
		else {
			$error_message['ajax_title']  =  "Add Paper";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------PAPER-----------------------------------//

//----------------------------CLASS-----------------------------------//
	if($_REQUEST['calling_block'] == 'submit_class') {
		$return_str  = '';
		$error_message = array();
		

		if(empty($_REQUEST['class_title'])) {

			$error_message['class_title'] = 'Please Enter Class Title';
		}

		if(empty($_REQUEST['class_alias'])) {

			$error_message['class_alias'] = 'Please Enter Class Alias';
		}
	 
		if(count($error_message) == 0) {

			$whereArray = array();
			$data_array = array();

			$data_array['college_id'] = COLLEGE_ID;
			$data_array['class_title'] = $_REQUEST['class_title'];
			$data_array['class_alias'] = $_REQUEST['class_alias'];
			$data_array['class_datetime'] = date("Y-m-d H:i:s");
			$data_array['class_added_by'] = $_SESSION['user_00']['login_id'];

			if($_REQUEST['editid'] > 0) {

				$whereArray['class_id'] = $_REQUEST['editid'];
			}
			
			$id = $toolObj->addUpdateDetail('tt_class_master', $data_array, $whereArray);
			
			$error_message['ajax_status']  =  "success";
			$return_str = json_encode($error_message);
			echo $return_str;
			exit;
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_class_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_class_master', " and d.class_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_class_form"  id="add_edit_class_form">
            <div class="position-relative form-group">
            	<label class="">Class Title</label>
            	<input name="class_title" id="class_title" placeholder="Class Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['class_title'];?>">
            	<div class="invalid-feedback" id="class_title_error"></div>
            </div>

             <div class="position-relative form-group">
            	<label class="">Class Title</label>
            	<input name="class_alias" id="class_alias" placeholder="Class Alias" type="text" class="form-control" value="<?php echo $departmentEditData[0]['class_alias'];?>">
            	<div class="invalid-feedback" id="class_alias_error"></div>
            </div>

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['class_id'];?>">
	            <button id="submit_class" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Class";
		}
		else {
			$error_message['ajax_title']  =  "Add Class";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------CLASS-----------------------------------//

//----------------------------SECTION-----------------------------------//
	if($_REQUEST['calling_block'] == 'submit_section') {
		$return_str  = '';
		$error_message = array();
		

		if(empty($_REQUEST['section_title'])) {

			$error_message['section_title'] = 'Please Enter Section Title';
		}
 
	 
		if(count($error_message) == 0) {

			$whereArray = array();
			$data_array = array();

			$data_array['college_id'] = COLLEGE_ID;
			$data_array['section_title'] = $_REQUEST['section_title'];
			$data_array['section_alias'] = $_REQUEST['section_alias'];
			$data_array['section_datetime'] = date("Y-m-d H:i:s");
			$data_array['section_added_by'] = $_SESSION['user_00']['login_id'];

			if($_REQUEST['editid'] > 0) {

				$whereArray['section_id'] = $_REQUEST['editid'];
			}
			
			$id = $toolObj->addUpdateDetail('tt_section_master', $data_array, $whereArray);
			
			$error_message['ajax_status']  =  "success";
			$return_str = json_encode($error_message);
			echo $return_str;
			exit;
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_section_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_section_master', " and d.section_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_section_form"  id="add_edit_section_form">
            <div class="position-relative form-group">
            	<label class="">Section Title</label>
            	<input name="section_title" id="section_title" placeholder="Section Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['section_title'];?>">
            	<div class="invalid-feedback" id="section_title_error"></div>
            </div>
 

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['section_id'];?>">
	            <button id="submit_section" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Section";
		}
		else {
			$error_message['ajax_title']  =  "Add Section";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------SECTION-----------------------------------//
	
//----------------------------SUBJECT-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_subject'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_subject_master', " and d.subject_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_subject_master', " and subject_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");
		  	 $error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_subject') {

			$return_str  = '';
			$error_message = array();
			

			if(empty($_REQUEST['subject_title'])) {

				$error_message['subject_title'] = 'Please Enter Subject Title';
			}

			if(empty($_REQUEST['subject_alias'])) {

				$error_message['subject_alias'] = 'Please Enter Subject Alias';
			}
		 
			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['subject_title'] = $_REQUEST['subject_title'];
				$data_array['subject_alias'] = $_REQUEST['subject_alias'];
				$data_array['subject_datetime'] = date("Y-m-d H:i:s");
				$data_array['subject_added_by'] = $_SESSION['user_00']['login_id'];

				if($_REQUEST['editid'] > 0) {

					$whereArray['subject_id'] = $_REQUEST['editid'];
				}
				
				$id = $toolObj->addUpdateDetail('tt_subject_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_subject_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_subject_master', " and d.subject_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_subject_form"  id="add_edit_subject_form">
            <div class="position-relative form-group">
            	<label class="">Subject Title</label>
            	<input name="subject_title" id="subject_title" placeholder="Subject Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['subject_title'];?>">
            	<div class="invalid-feedback" id="subject_title_error"></div>
            </div>

             <div class="position-relative form-group">
            	<label class="">Subject Title</label>
            	<input name="subject_alias" id="subject_alias" placeholder="Subject Alias" type="text" class="form-control" value="<?php echo $departmentEditData[0]['subject_alias'];?>">
            	<div class="invalid-feedback" id="subject_alias_error"></div>
            </div>

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['subject_id'];?>">
	            <button id="submit_subject" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Subject";
		}
		else {
			$error_message['ajax_title']  =  "Add Subject";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
//----------------------------SUBJECT-----------------------------------//

//----------------------------LOGIN-----------------------------------//
	if($_REQUEST['calling_block'] == 'reset_login_password') {

		$return_str  = '';
		$error_message = array();

		$_REQUEST['editid'] = base64_decode($_REQUEST['editid']);
	

		if($_REQUEST['editid'] > 0) {

			$loginData = $toolObj->getDetail('tt_user_login_master', " and d.login_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

			if(count($loginData) > 0) {

				$whereArray = array();
				$data_array = array();

				$whereArray['login_id'] = $_REQUEST['editid'];				
				$data_array['login_password'] = md5('123456');

				$toolObj->addUpdateDetail('tt_user_login_master', $data_array, $whereArray);

				$error_message['ajax_status']  =  "success";
				$error_message['ajax_title']  =  "Reset Password";	
				$error_message['ajax_html']  =  '<div class="alert alert-block alert-success"><p><strong><i class="ace-icon fa fa-check"></i>Success!</strong> Password Reset successfully...</p></div>';

				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "success";
				$error_message['ajax_title']  =  "Reset Password";	
				$error_message['ajax_html']  =  '<div class="alert alert-block alert-danger"><p><strong><i class="ace-icon fa fa-times"></i>Failed! </strong> Password Reset Failed...</p></div>';
				$return_str = json_encode($error_message);

				echo $return_str;
				exit;
			}
		}
		else {

			$error_message['ajax_alert']  =  "Some Error Occur...";
			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);

			echo $return_str;
			exit;
		}

		 

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Class";
		}
		else {
			$error_message['ajax_title']  =  "Add Class";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
	
	if($_REQUEST['calling_block'] == 'submit_change_password_form'){
		$return_str  = '';

		$error_message = array();

		if(count($error_message) == 0) {

			$whereArray = array();
			$whereArray['login_id'] = $_SESSION['user_00']['login_id'];

			$data_array = array();
			$data_array['login_password'] = md5(trim($_REQUEST['new_login_password']));
 
			$dataArray = $toolObj->getDetail('tt_user_login_master', " and d.login_password='".md5(trim($_REQUEST['login_password']))."' and d.login_id = '".$_SESSION['user_00']['login_id']."' ", '', '*');

			if(count($dataArray)>0){

				$id = $toolObj->addUpdateDetail('tt_user_login_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;	
			}
			else{
				$error_message['ajax_status']  =  "unmatched";
				$return_str = json_encode($error_message);

				echo $return_str;
				exit;
			}	
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);

			echo $return_str;
			exit;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'ajax_login') {

		$return_str  = '';

		$error_message = array();
		
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/';

		

		if(!isset($_REQUEST['user_email']) || empty($_REQUEST['user_email'])) {

			$error_message['user_email'] = 'Please Enter Email.';
		}
		else {

			if(!preg_match($email_exp, $_REQUEST['user_email'])) {

				$error_message['user_email'] = 'Please Vald E-Mail ID';
			}
		}
		
		if(!isset($_REQUEST['user_password']) || empty($_REQUEST['user_password'])) {

			$error_message['user_password'] = 'Please Enter Password.';
		}

		if(count($error_message) == 0) {

			//$data = $toolObj->getDetail('inv_user_master', $where_str, $join_cond='', $cols='');

			$checkData = $toolObj->getDetail('members_details', " and   d.Email='".$_REQUEST['user_email']."'    ", '', ' * ');

			if(count($checkData) > 0) {

				if($checkData[0]['password'] == $_REQUEST['user_password']) {

					$toolObj->setLoginSession($checkData[0]);
 
					$error_message['ajax_status']  =  "success";
 
					$return_str = json_encode($error_message);

					echo $return_str;
					exit;
				}
				else {
					$error_message['user_password'] = 'Incorrect Password.';
				}
			}
			else {
				$error_message['user_mobile'] = 'This User is not Registerd With Us';
			}
		}
		
		if(count($error_message) > 0) {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);

			echo $return_str;
			exit;
		}
		

		// echo "<pre>";
		// print_r($checkData);
		// print_r($_REQUEST);
		// echo "<pre>";
		exit;
	}
//----------------------------LOGIN-----------------------------------//

//----------------------------DAPARTMENT-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'delete_department'){

		$return_str  = '';

		$error_msg_array = array();

		$checkData = $toolObj->getDetail('tt_department_master', " and d.department_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

		if(count($checkData) == 0) {

			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}
		else {
 
		   	$toolObj->deleteDetail('tt_department_master', " and department_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' ");

		   	$toolObj->deleteDetail('tt_user_login_master', " and login_department_id = '".addslashes($_REQUEST['editid'])."'    and college_id = '".COLLEGE_ID."' and login_group = '33'");
		  	 $error_msg_array['ajax_status']  =  "success";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_department') {

			$return_str  = '';
			$error_message = array();
			

			if(empty($_REQUEST['department_title'])) {

				$error_message['department_title'] = 'Please Enter Department Title';
			}

			if(empty($_REQUEST['department_alias'])) {

				$error_message['department_alias'] = 'Please Enter Department Alias';
			}
		 
			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['department_title'] = $_REQUEST['department_title'];
				$data_array['department_alias'] = $_REQUEST['department_alias'];
				$data_array['department_datetime'] = date("Y-m-d H:i:s");
				$data_array['department_added_by'] = $_SESSION['user_00']['login_id'];

				if($_REQUEST['editid'] > 0) {

					$whereArray['department_id'] = $_REQUEST['editid'];
				}
				
				$id = $toolObj->addUpdateDetail('tt_department_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_department_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();

		$error_message['ajax_status']  =  "success";

		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_department_master', " and d.department_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
		}

		ob_start(); 	
		?>
		 <form class="" name="add_edit_department_form"  id="add_edit_department_form">
            <div class="position-relative form-group">
            	<label class="">Department Title</label>
            	<input name="department_title" id="department_title" placeholder="Department Title" type="text" class="form-control" value="<?php echo $departmentEditData[0]['department_title'];?>">
            	<div class="invalid-feedback" id="department_title_error"></div>
            </div>

             <div class="position-relative form-group">
            	<label class="">Department Title</label>
            	<input name="department_alias" id="department_alias" placeholder="Department Alias" type="text" class="form-control" value="<?php echo $departmentEditData[0]['department_alias'];?>">
            	<div class="invalid-feedback" id="department_alias_error"></div>
            </div>

            <div class="position-relative form-group text-center">
            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['department_id'];?>">
	            <button id="submit_department" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Department";
		}
		else {
			$error_message['ajax_title']  =  "Add Department";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_department_login_form') {

		$return_str  = '';
		$departmentEditData = array();

		$error_message = array();
 
		if($_REQUEST['editid'] > 0) {

			$departmentEditData = $toolObj->getDetail('tt_department_master', " and d.department_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');

			$dLoginEditData = $toolObj->getDetail('tt_user_login_master', " and d.login_department_id = '".addslashes($_REQUEST['editid'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

			if(count($departmentEditData) > 0)  {
		 

				ob_start(); 	
				?>
				<form class="" name="add_edit_department_login_form"  id="add_edit_department_login_form">
		            <div class="position-relative form-group">
		            	<label class="">Department Login Username</label>
		            	<input name="login_username" id="login_username" placeholder="Department Login Username" type="text" class="form-control" value="<?php echo $dLoginEditData[0]['login_username'];?>">
		            	<div class="invalid-feedback" id="login_username_error"></div>
		            </div>

		            <div class="position-relative form-group">
		            	<label class="">Recovery E-Mail</label>
		            	<input name="login_email" id="login_email" placeholder="Recovery E-Mail" type="text" class="form-control" value="<?php echo $dLoginEditData[0]['login_email'];?>">
		            	<div class="invalid-feedback" id="login_email_error"></div>
		            </div>

		            <div class="position-relative form-group text-center">
		            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['department_id'];?>">
			            <button id="submit_department_login" type="button" class="mt-2 btn btn-primary">Submit</button>
			        </div>
		        </form>
				<?php
				$output = ob_get_clean();

				$error_message['ajax_status']  =  "success";
				$error_message['ajax_title']  =  "Create Login For ".$departmentEditData['0']['department_title']." Department";
				$error_message['ajax_html']  =  $output;
			}
			else {
				$error_message['ajax_status']  =  "success";
				$error_message['ajax_title']  = "Create Login Department";
				$error_message['ajax_html']  =  '<p>Department Not Exist... </p>';
			}			 
		}
		else {
			$error_message['ajax_status']  =  "error";
				$error_message['ajax_alert']  =  "Some Error Occur...";
		}
		

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}

	if($_REQUEST['calling_block'] == 'submit_department_login') {

			$return_str  = '';
			$error_message = array();

			if(empty($_REQUEST['login_username'])) {

				$error_message['login_username'] = 'Please Enter Department Login Name';
			}

			if(empty($_REQUEST['login_email'])) {

				$error_message['login_email'] = 'Please Enter Recovery E-Mail';
			}
			else {
				if(!preg_match(EMAIL_CHECK_EXP, $_REQUEST['login_email'])) {

					$error_message['login_email'] = 'Invalid Recovery E-Mail';
				}
			}

			$checkData = $toolObj->getDetail('tt_user_login_master', " and d.login_username = '".addslashes($_REQUEST['login_username'])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

			if(count($checkData) > 0) {

				$error_message['login_username'] = 'Username "'.$_REQUEST['login_username'].'" Already Exist...';
			}

			if($_REQUEST['editid'] >0) {

				$checkData1 = $toolObj->getDetail('tt_user_login_master', " and d.login_department_id = '".addslashes($_REQUEST['editid'])."' and d.login_group = '33' and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

				if(count($checkData1) > 0) {

					$error_message['login_username'] = 'Department Login Already Exist...';
				}
			}

			if(count($error_message) == 0) {

				$whereArray = array();
				$data_array = array();

				$randomStr = $toolObj->getRandomString();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['login_username'] = $_REQUEST['login_username'];
				$data_array['login_password'] = md5($randomStr);
				$data_array['login_display_name'] = $_REQUEST['login_username'];
				$data_array['login_email'] = $_REQUEST['login_email'];
				$data_array['login_datetime'] = date("Y-m-d H:i:s");
				//$data_array['login_added_by'] = $_SESSION['user_00']['login_id'];
				$data_array['login_added_by'] = $randomStr;
				$data_array['login_group'] = '33';
				$data_array['login_department_id'] = $_REQUEST['editid'];
				$data_array['login_status'] = 'Y';
				
				$id = $toolObj->addUpdateDetail('tt_user_login_master', $data_array, $whereArray);
				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}
//----------------------------DAPARTMENT-----------------------------------//

//----------------------------SETUP YEAR SEMESTER-----------------------------------//
	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'set_ys_working_days'){

		$return_str  = '';

		$error_msg_array = array();

		$edit_id_array = explode("TT@TT", base64_decode($_REQUEST['editid']));
 
		if($edit_id_array[0] > 0 && $edit_id_array[1] == COLLEGE_ID && $edit_id_array[2] > 0 && $edit_id_array[2] < 8) {

			$checkData = $toolObj->getDetail('tt_year_semester_log', " and d.ys_log_id = '".addslashes($edit_id_array[0])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

			if(count($checkData) == 0) {

				$error_msg_array['ajax_status']  =  "error";
				$error_msg_array['ajax_alert']  =  "some error occur";
			}
			else {

				$checkData1 = $toolObj->getDetail('tt_session_working_days_log', " and d.day_year = '".addslashes($checkData[0]['ys_year'])."'   and d.day_semester = '".addslashes($checkData[0]['ys_sememster'])."' and d.day_value = '".$edit_id_array[2]."'  and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

				if(count($checkData1) == 0)  {

					$whereArray = array();
					$data_array = array();

					$data_array['college_id'] = COLLEGE_ID;
					$data_array['day_year'] = $checkData[0]['ys_year'];
					$data_array['day_semester'] = $checkData[0]['ys_sememster'];
					$data_array['day_value'] = $edit_id_array[2];
					$data_array['day_datetime'] = date("Y-m-d H:i:s");
					$data_array['day_addedby'] = $_SESSION['user_00']['login_id'];

					$id = $toolObj->addUpdateDetail('tt_session_working_days_log', $data_array, $whereArray);

					$parameterArray = array();
					$parameterArray['timetable_year'] = $checkData[0]['ys_year'];
					$parameterArray['timetable_semesters'] = $checkData[0]['ys_sememster'];

					$toolObj->resetTimetableMaster($parameterArray);

					$error_msg_array['ajax_status']  =  "success";
				}
				else {
					$error_msg_array['ajax_status']  =  "error";
					$error_msg_array['ajax_alert']  =  "Already Added...";
				}
			}
		}
		else {
			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}

		 

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if(isset($_REQUEST['calling_block']) && ($_REQUEST['calling_block'] == 'year_semester_display_pause' || $_REQUEST['calling_block'] == 'year_semester_display_resume')){

		$return_str  = '';

		$error_msg_array = array();

		$edit_id_array = explode("TT@TT", base64_decode($_REQUEST['editid']));

		if($edit_id_array[0] > 0 && $edit_id_array[1] == COLLEGE_ID) {

			$checkData = $toolObj->getDetail('tt_year_semester_log', " and d.ys_log_id = '".addslashes($edit_id_array[0])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

			if(count($checkData) == 0) {

				$error_msg_array['ajax_status']  =  "error";
				$error_msg_array['ajax_alert']  =  "some error occur";
			}
			else {

				$whereArray = array();
				$data_array = array();

				$whereArray['college_id'] = COLLEGE_ID;
				$whereArray['ys_log_id'] = $edit_id_array[0];

				if($_REQUEST['calling_block'] == 'year_semester_display_pause') {

					$data_array['ys_added_status'] = 1;
				} 
				else if($_REQUEST['calling_block'] == 'year_semester_display_resume'){

					$data_array['ys_added_status'] = 0;
				}
				else {
					$data_array['ys_added_status'] = 0;
				}
			 

				$id = $toolObj->addUpdateDetail('tt_year_semester_log', $data_array, $whereArray);

				$error_msg_array['ajax_status']  =  "success";
			}
		}
		else {
			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if(isset($_REQUEST['calling_block']) && $_REQUEST['calling_block'] == 'activate_year_semester'){

		$return_str  = '';

		$error_msg_array = array();

		$edit_id_array = explode("TT@TT", base64_decode($_REQUEST['editid']));

		if($edit_id_array[0] > 0 && $edit_id_array[1] == COLLEGE_ID) {

			$checkData = $toolObj->getDetail('tt_year_semester_log', " and d.ys_log_id = '".addslashes($edit_id_array[0])."'    and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 

			if(count($checkData) == 0) {

				$error_msg_array['ajax_status']  =  "error";
				$error_msg_array['ajax_alert']  =  "some error occur";
			}
			else {

				$parameterArray = array();
				$parameterArray['ys_log_id'] = $edit_id_array[0];				

				if(isset($edit_id_array[2]) && $edit_id_array[2] == 'admin_view') {

					$toolObj->enableAdminViewYearSemester($parameterArray);
				}
				else {
					$toolObj->resetCurrentYearSemester($parameterArray);
				}

				$error_msg_array['ajax_status']  =  "success";
			}
		}
		else {
			$error_msg_array['ajax_status']  =  "error";
			$error_msg_array['ajax_alert']  =  "some error occur";
		}

		$return_str = json_encode($error_msg_array);

		echo $return_str;
		exit; 				
	}

	if($_REQUEST['calling_block'] == 'submit_ys') {

		$return_str  = '';
		$error_message = array();

		$sem_array = array();

		if(!empty($_REQUEST['ys_sememster'])) {

			$sem_array = json_decode(urldecode($_REQUEST['ys_sememster']), true);
		}

		if(empty($_REQUEST['ys_year'])) {

			$error_message['ys_year'] = 'Please Select Year';
		}

		if(count($sem_array) == 0) {

			$error_message['ys_sememster'] = 'Please Select Semester';
		}
	 
		if(count($error_message) == 0) {

			$checkData = $toolObj->getDetail('tt_year_semester_log', " and d.ys_year = '".addslashes($_REQUEST['ys_year'])."' and d.ys_sememster = '".json_encode($sem_array)."' and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

			if(count($checkData) == 0)  {

				$whereArray = array();
				$data_array = array();

				$data_array['college_id'] = COLLEGE_ID;
				$data_array['ys_year'] = $_REQUEST['ys_year'];
				$data_array['ys_sememster'] = json_encode($sem_array);
				$data_array['ys_datetime'] = date("Y-m-d H:i:s");
				$data_array['ys_added_by'] = $_SESSION['user_00']['login_id'];

				$id = $toolObj->addUpdateDetail('tt_year_semester_log', $data_array, $whereArray);

				$parameterArray = array();

				$toolObj->resetCurrentYearSemester($parameterArray);

				$parameterArray = array();
				$parameterArray['timetable_year'] = $_REQUEST['ys_year'];
				$parameterArray['timetable_semesters'] = json_encode($sem_array);

				$toolObj->resetTimetableMaster($parameterArray);

				
				$error_message['ajax_status']  =  "success";
				$return_str = json_encode($error_message);
				echo $return_str;
				exit;
			}
			else {

				$error_message['ajax_status']  =  "error";
				$error_message['ys_year'] = "Year - Semester Already Added...";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
		}
		else {

			$error_message['ajax_status']  =  "error";
			$return_str = json_encode($error_message);
			echo $return_str;
		}
		
		exit;
	}

	if($_REQUEST['calling_block'] == 'get_add_edit_ys_form') {

		$return_str  = '';
		$error_message = array();
		$error_message['ajax_status']  =  "success";
 
		ob_start(); 	
		?>
		 <form class="" name="add_edit_ys_form"  id="add_edit_ys_form">
            <div class="position-relative form-group">
            	<label class="">Year</label>
            	<select name="ys_year" id="ys_year" class="form-control">
                   	<option value="">Select Year</option>
                   	<?php
                   	for ($ix=-3;$ix<=3;$ix++) {
                   		?> <option <?php if($ix == 0){ ?>selected="selected"<?php }?> value="<?php echo (date("Y")+$ix);?>"><?php echo (date("Y")+$ix);?></option><?php
                   	}
                   	?>
                </select>
            	<div class="invalid-feedback" id="ys_year_error"></div>
            </div>


            <div class="main-card mb-3 card">
            	<div class="invalid-feedback" id="ys_sememster_error"></div>

                <div class="card-body">
                    <h5 class="card-title"><label><input type="radio" name="ys_sememster" value="<?php echo urlencode('["1","3","5"]');?>"> Odd Semester</label></h5>
                    <div class="position-relative form-group">
                        <div>
                            <div >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - I</label>
                            </div>
                            <div >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - III</label>
                            </div>
                            <div  >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - V</label>
                             </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title"><label><input type="radio" name="ys_sememster" value="<?php echo urlencode('["2","4","6"]');?>"> Even Semester</label></h5>
                    <div class="position-relative form-group">
                        <div>
                            <div >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - II</label>
                            </div>
                            <div >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - IV</label>
                            </div>
                            <div  >                                    
                                <label class="custom-control-labe1l"  ><i class=" fa fa-check  "></i> Semester - VI</label>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
 

            <div class="position-relative form-group text-center">
	            <button id="submit_ys" type="button" class="mt-2 btn btn-primary">Submit</button>
	        </div>
        </form>
		<?php
		$output = ob_get_clean();

		if($_REQUEST['editid'] > 0) {
			$error_message['ajax_title']  =  "Update Class";
		}
		else {
			$error_message['ajax_title']  =  "Add Class";						
		}

		$error_message['ajax_html']  =  $output;

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}
 
	if($_REQUEST['calling_block'] == 'get_add_edit_ys_period_form') {

		$return_str  = '';
		$error_message = array();

		$ysData = $toolObj->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' order by d.ys_year desc, d.ys_sememster desc ", '', ' * ');


		if(count($ysData) == 0) {

			$error_message['ajax_status']  =  "success";
			$error_message['ajax_title']  =  "Error !!!";
			$error_message['ajax_html']  =  '<p>Year Semester not Added.......</p>';
		}
		else {

			$_REQUEST['editid'] = base64_decode($_REQUEST['editid']);

			if($_REQUEST['editid'] > 0) {

				$departmentEditData = $toolObj->getDetail('tt_session_period_log', " and d.period_id = '".addslashes($_REQUEST['editid'])."'  and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	 
			}
 
			$error_message['ajax_status']  =  "success";
	 
			ob_start(); 	
			?>
			<form class="" name="add_edit_ys_period_form"  id="add_edit_ys_period_form">
	            <div class="position-relative form-group">
	            	<label class="">Year-Semester</label>
	            	<select name="period_year_semester" id="period_year_semester" class="form-control">
	                   	<option value="">Select Year-Semester</option>
	                   	<?php
	                   	foreach ($ysData as $yskey => $ysvalue) {
	                   		?><option title="<?php echo $ysvalue['ys_log_id'];?>" <?php if($ysvalue['ys_year']."~".$ysvalue['ys_sememster'] == $departmentEditData[0]['period_year']."~".$departmentEditData[0]['period_semester']){ ?>selected="selected"<?php }?> value="<?php echo $ysvalue['ys_year']."~".urlencode($ysvalue['ys_sememster']);?>">
	                   			<?php 
	                   			echo $ysvalue['ys_year']." ";

	                   			$sem_array_val = json_decode($ysvalue['ys_sememster'], true);

                                $comma = '';
                                foreach($sem_array_val as $ayk=>$ayb) {

                                    echo $comma.$GLOBALS['semester_master_array'][$ayb];

                                    $comma = ", ";
                                }
                                ?>
                                </option><?php
	                   	}
	                   	?>
	                </select>
	            	<div class="invalid-feedback" id="period_year_semester_error"></div>
	            </div>

	            <div class="position-relative form-group">
	            	<label class="">Period Detail</label>
	            	<input name="period_value" id="period_value" placeholder="Period Detail" type="text" class="form-control" value="<?php echo $departmentEditData[0]['period_value'];?>">
	            	<div class="invalid-feedback" id="period_value_error"></div>
	            </div>		              

	            <div class="position-relative form-group">
	            	<label class="">Type</label>
	            	 <select name="period_type" id="period_type" class="form-control">
	                   	<option value="0">Select Type</option>
	                   	<?php
	                   	foreach ($GLOBALS['period_type_array'] as $key => $value) {
	                   		?> <option <?php if($key == $departmentEditData[0]['period_type']){ ?>selected="selected"<?php }?> value="<?php echo $key?>"><?php echo $value?></option><?php
	                   	}
	                   	?>
	                </select>
	            	<div class="invalid-feedback" id="period_type_error"></div>
	            </div> 
	          
	            <div class="position-relative form-group">
	            	<label class="">Status</label>
	            	 <select name="period_status" id="period_status" class="form-control">
	            	 	<option <?php if("0" == $departmentEditData[0]['period_status']){ ?>selected="selected"<?php }?> value="0">Active</option> 
	                   	<option <?php if("1" == $departmentEditData[0]['period_status']){ ?>selected="selected"<?php }?> value="1">Disable</option> 
	                </select>		            	 
	            </div>			       

	            <div class="position-relative form-group text-center">
	            	<input type="hidden" name="editid" value="<?php echo $departmentEditData[0]['period_id'];?>">
		            <button id="submit_ys_period" type="button" class="mt-2 btn btn-primary">Submit</button>
		        </div>			    
	        </form>
			<?php
			$output = ob_get_clean();

			if($_REQUEST['editid'] > 0) {
				$error_message['ajax_title']  =  "Update Period Detail";
			}
			else {
				$error_message['ajax_title']  =  "Add Period Detail";						
			}

			$error_message['ajax_html']  =  $output;
		}

		$return_str = json_encode($error_message);
		echo $return_str;
		exit;
	}

	if($_REQUEST['calling_block'] == 'submit_ys_period') {

			$return_str  = '';
			$error_message = array();
			

			if(empty($_REQUEST['period_year_semester'])) {

				$error_message['period_year_semester'] = 'Please Select Year-Semester';
			}

			if(empty($_REQUEST['period_value'])) {

				$error_message['period_value'] = 'Please Enter Period Detail';
			}

			if($_REQUEST['period_type'] == '') {

				$error_message['period_type'] = 'Please Select Type';
			}
		 
			if(count($error_message) == 0) {

				$ys_log_array = explode("~", $_REQUEST['period_year_semester']);

				$ys_log_array['1'] = urldecode($ys_log_array['1']);

				$checkData = $toolObj->getDetail('tt_year_semester_log', " and d.ys_year = '".addslashes($ys_log_array['0'])."' and d.ys_sememster = '".addslashes($ys_log_array['1'])."' and d.college_id = '".COLLEGE_ID."' ", '', ' * ');	

				if(count($checkData) > 0)  {

					$whereArray = array();
					$data_array = array();

					$data_array['college_id'] = COLLEGE_ID;
					$data_array['period_year'] = $ys_log_array['0'];
					$data_array['period_semester'] = $ys_log_array['1'];
					$data_array['period_value'] = $_REQUEST['period_value'];
					$data_array['period_type'] = $_REQUEST['period_type'];
					$data_array['period_status'] = $_REQUEST['period_status'];
					$data_array['period_datetime'] = date("Y-m-d H:i:s");
					$data_array['period_addedby'] = $_SESSION['user_00']['login_id'];

					if($_REQUEST['editid'] > 0) {

						$whereArray['period_id'] = $_REQUEST['editid'];
					}

					$id = $toolObj->addUpdateDetail('tt_session_period_log', $data_array, $whereArray);

					$parameterArray = array();
					$parameterArray['timetable_year'] = $ys_log_array['0'];
					$parameterArray['timetable_semesters'] = $ys_log_array['1'];

					$toolObj->resetTimetableMaster($parameterArray);

 
					$error_message['ajax_status']  =  "success";
					$return_str = json_encode($error_message);
					echo $return_str;
					exit;
					 
				}
				else {

					$error_message['ajax_status']  =  "error";
					$error_message['ys_year'] = "Year - Semester Not Added...";
					$return_str = json_encode($error_message);
					echo $return_str;
				}
			}
			else {

				$error_message['ajax_status']  =  "error";
				$return_str = json_encode($error_message);
				echo $return_str;
			}
			
			exit;
	}
//----------------------------SETUP YEAR SEMESTER-----------------------------------//
exit;
?>