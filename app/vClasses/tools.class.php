<?php
class commonTools {

	public function getTimetableCellData($parameterArray) {

		$return_array = array();

		/*$parameterArray['class_id']
		$parameterArray['semester_id']
		$parameterArray['section_id']
		$parameterArray['day_id']
		$parameterArray['period_id']*/

		//$parameterArray['teacher_id']

		$currentYSData = $this->getDetail('tt_year_semester_log', " and d.college_id = '".COLLEGE_ID."' and d.ys_activated = '1' ", '', ' * ');

		$checkData = $this->getDetail('tt_timetable_master', " and d.college_id = '".COLLEGE_ID."' and d.timetable_year = '".$currentYSData[0]['ys_year']."'  and d.timetable_semesters = '".$currentYSData[0]['ys_sememster']."' and d.timetable_status='Y' and d.timetable_day = '".$parameterArray['day_id']."' and d.timetable_period = '".$parameterArray['period_id']."' ", " inner join tt_class_room_master rm on rm.room_id = d.timetable_room", ' d.timetable_id, d.timetable_room, rm.room_no ');

		if(count($checkData) > 0) {

			$ix=1;

			foreach($checkData as $chkkey => $chkval){

				$teache_cond = '';

				if($parameterArray['class_id'] > 0) {

					$teache_cond .= " and cross_class = '".$parameterArray['class_id']."' ";
				}

				if($parameterArray['semester_id'] > 0) {

					$teache_cond .= " and cross_semester = '".$parameterArray['semester_id']."' ";
				}

				if($parameterArray['section_id'] > 0) {

					$teache_cond .= " and cross_section = '".$parameterArray['section_id']."' ";
				}

				if($parameterArray['teacher_id'] > 0) {

					$teache_cond .= " and cross_teacher_id = '".$parameterArray['teacher_id']."' ";
				}

				$checkCrossData = $this->getDetail('tt_timetable_cross', " and d.college_id = '".COLLEGE_ID."' and d.cross_timetable_id = '".$chkval['timetable_id']."' ".$teache_cond, " left join tt_paper_master pm on pm.paper_id = d.cross_paper left join tt_teacher_master tm on tm.teacher_id = d.cross_teacher_id ", ' d.*, pm.paper_code, pm.paper_alias, pm.paper_title, tm.teacher_name, tm.teacher_sort_name');

				if(count($checkCrossData) > 0) {

					$ccvalue = $checkCrossData[0];

					$return_array['small_span'][$chkval['timetable_id']] = '	
					<a data-editid="'.base64_encode($ccvalue['cross_id']."TT@TT".COLLEGE_ID).'" href="javascript:" class="edit_timetable_data_cls mb-1 mr-1 badge '.$GLOBALS['lecture_type_style_array'][$ccvalue['cross_lecture_type']]['badge'].'" ><i>'.$ix.'. '.$GLOBALS['classDataArray'][$ccvalue['cross_class']]['class_alias'].'-'.$chkval['room_no'].'-'.$ccvalue['paper_alias'].'-'.$ccvalue['teacher_sort_name'].'</i></a>';

					$ix++;
				}
			}
		}

		return json_encode($return_array);
	}

	public function resetTimetableMaster($parameterArray) {

		if($parameterArray['timetable_year'] > 0 && !empty($parameterArray['timetable_semesters'])) {

			$checkLogData = $this->getDetail("tt_year_semester_log", " and d.college_id='".COLLEGE_ID."' and d.ys_year = '".$parameterArray['timetable_year']."' and d.ys_sememster = '".$parameterArray['timetable_semesters']."'", "", 'd.ys_log_id');

			if(count($checkLogData) > 0) {

				$classRoomData = $this->getDetail("tt_class_room_master", " and d.college_id='".COLLEGE_ID."' ", "", 'd.*');


				$workingDayData = $this->getDetail("tt_session_working_days_log", " and d.college_id='".COLLEGE_ID."' and d.day_year = '".$parameterArray['timetable_year']."' and d.day_semester = '".$parameterArray['timetable_semesters']."'", "", 'd.*');

				$periodData = $this->getDetail("tt_session_period_log", " and d.college_id='".COLLEGE_ID."' and d.period_year = '".$parameterArray['timetable_year']."' and d.period_semester = '".$parameterArray['timetable_semesters']."'", "", 'd.*');

				if(count($classRoomData) > 0 && count($workingDayData) > 0 && count($periodData) > 0) {

					$dataArray = array();
		            $whereArray = array();
		            
		            $whereArray['college_id'] = COLLEGE_ID;
		            $whereArray['timetable_year'] = $parameterArray['timetable_year'];
		            $whereArray['timetable_semesters'] = $parameterArray['timetable_semesters'];

		            $dataArray['timetable_status'] = 'N';

		            $this->addUpdateDetail('tt_timetable_master', $dataArray, $whereArray);

					foreach ($classRoomData as $crkey => $crvalue) {						 

						if(count($workingDayData) > 0) {

							foreach ($workingDayData as $wdkey => $wdvalue) {
								
								if(count($periodData) > 0) {

									foreach ($periodData as $pkey => $pvalue) {
										
										$checkRow = $this->getDetail("tt_timetable_master", " and d.college_id='".COLLEGE_ID."' and d.timetable_year = '".$parameterArray['timetable_year']."' and d.timetable_semesters = '".$parameterArray['timetable_semesters']."' and d.timetable_day = '".$wdvalue['day_id']."' and d.timetable_period = '".$pvalue['period_id']."' and d.timetable_room = '".$crvalue['room_id']."' ", "", 'd.timetable_id');

										$dataArray = array();
							            $whereArray = array();
							            
							             
							            if(count($checkRow) > 0) {

							            	$dataArray['timetable_status'] = 'Y';
							            	$whereArray['timetable_id'] = $checkRow[0]['timetable_id'];
							            	$whereArray['college_id'] = COLLEGE_ID;

							            }
							            else {
							            	$dataArray['college_id'] = COLLEGE_ID;
							            	$dataArray['timetable_year'] = $parameterArray['timetable_year'];
							            	$dataArray['timetable_semesters'] = $parameterArray['timetable_semesters'];
							            	$dataArray['timetable_day'] = $wdvalue['day_id'];
							            	$dataArray['timetable_period'] = $pvalue['period_id'];
							            	$dataArray['timetable_room'] = $crvalue['room_id'];
							            	$dataArray['timetable_status'] = 'Y';
							            }

							            $this->addUpdateDetail('tt_timetable_master', $dataArray, $whereArray);
									}
								}
							}
						}
					}

					$this->deleteDetail('tt_timetable_master',  " and college_id='".COLLEGE_ID."' and timetable_year = '".$parameterArray['timetable_year']."' and timetable_semesters = '".$parameterArray['timetable_semesters']."' and  timetable_status = 'N' ");
				}
			}
		}
	}

    public function enableAdminViewYearSemester($parameterArray) {

        if($parameterArray['ys_log_id'] > 0) {

             $checkLogData = $this->getDetail("tt_year_semester_log", " and d.college_id='".COLLEGE_ID."' and d.ys_log_id = '".$parameterArray['ys_log_id']."'", "", 'd.ys_log_id');

             if(count( $checkLogData) > 0) {

                $dataArray = array();
                $whereArray = array();
                
                $whereArray['college_id'] = COLLEGE_ID;
                $dataArray['ys_admin_visible'] = '0';

                $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);
     
               
                $dataArray = array();
                $whereArray = array();
                
                $whereArray['college_id'] = COLLEGE_ID;
                $whereArray['ys_log_id'] = $parameterArray['ys_log_id'];
                $dataArray['ys_admin_visible'] = '1';

                $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);

                return "success";
             }
             else {
                return "error";
             }
        }
        else {

            $dataArray = array();
            $whereArray = array();
            
            $whereArray['college_id'] = COLLEGE_ID;
            $dataArray['ys_activated'] = '0';

            $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);
 
            $checkMaxData = $this->getDetail("tt_year_semester_log", " and d.college_id='".COLLEGE_ID."' order by d.ys_year desc, d.ys_sememster desc limit 0,1", "", 'd.ys_log_id');

            $dataArray = array();
            $whereArray = array();
            
            $whereArray['college_id'] = COLLEGE_ID;
            $whereArray['ys_log_id'] = $checkMaxData[0]['ys_log_id'];
            $dataArray['ys_activated'] = '1';

            $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);

            return "success";
        }  
    }

	public function resetCurrentYearSemester($parameterArray) {

	    if($parameterArray['ys_log_id'] > 0) {

	         $checkLogData = $this->getDetail("tt_year_semester_log", " and d.college_id='".COLLEGE_ID."' and d.ys_log_id = '".$parameterArray['ys_log_id']."'", "", 'd.ys_log_id');

	         if(count( $checkLogData) > 0) {

	            $dataArray = array();
	            $whereArray = array();
	            
	            $whereArray['college_id'] = COLLEGE_ID;
	            $dataArray['ys_activated'] = '0';

	            $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);
	 
	           
	            $dataArray = array();
	            $whereArray = array();
	            
	            $whereArray['college_id'] = COLLEGE_ID;
	            $whereArray['ys_log_id'] = $parameterArray['ys_log_id'];
	            $dataArray['ys_activated'] = '1';

	            $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);

	            return "success";
	         }
	         else {
	            return "error";
	         }
	    }
	    else {

	        $dataArray = array();
	        $whereArray = array();
	        
	        $whereArray['college_id'] = COLLEGE_ID;
	        $dataArray['ys_activated'] = '0';

	        $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);

	        $checkMaxData = $this->getDetail("tt_year_semester_log", " and d.college_id='".COLLEGE_ID."' order by d.ys_year desc, d.ys_sememster desc limit 0,1", "", 'd.ys_log_id');

	        $dataArray = array();
	        $whereArray = array();
	        
	        $whereArray['college_id'] = COLLEGE_ID;
	        $whereArray['ys_log_id'] = $checkMaxData[0]['ys_log_id'];
	        $dataArray['ys_activated'] = '1';

	        $this->addUpdateDetail('tt_year_semester_log', $dataArray, $whereArray);

	        return "success";
	    }  
	}
	
    public function returnCalenderArray($Y_m_d='') {

        $return_array= array(
            '0' => array(),
            '1' => array(
                '0' => array(
                    '0'=>'Sun',
                    '1'=>'Mon',
                    '2'=>'Tue',
                    '3'=>'Wed',
                    '4'=>'Thu',
                    '5'=>'Fri',
                    '6'=>'Sat',
                )
            )
        );

        if(!$Y_m_d) {
            $time_stamp = date("Y-m-d");
        }
        else {
            $time_stamp = $Y_m_d;
        }

        //$time_stamp = "2024-02-10";

        $time_stamp = strtotime($time_stamp);

        $today = getdate($time_stamp);

        $mon = $today['mon']; //month
        $year = $today['year']; //this year
        $day = $today['mday']; //this day

        $monnn = $today['month']; //month as string

        $day1 = $day-1;

        $my_time= mktime(0,0,0,$mon,1,$year);
        $start_mon = date('d', $my_time); //Month starting date
        $start_day = date('D', $my_time); //Month starting Day
        //echo $start_mon;
        //echo $start_day;
        $start_daynum = date('w', $my_time);

        $stt =  strtotime($year."-".$monnn);

        $year_month = date("Y-m", $stt);

        $daysIM = $this->DayInMonth($mon,$year); //Number of days in this month

        $date_first = 1;
                    
        $loop_days = $daysIM+$start_daynum;
        
        $x = ($loop_days%7);            
         
        if($x !=0) {
            
            $more = 7-$x;
        }
        else {
            $more = 0;
        }
        
        $loop_days = $loop_days+$more;
        
        $date_start = 1;

        $jx=1;

        $return_array['0']['0'] = $year_month;
          
        for($i=1;$i<=$loop_days;$i++) {
                
            if($day == $date_start) {
                
                $td_css = "whitebg border1px";
            }
            else {
                $td_css = '';
            }
 
            if($i > $start_daynum && $date_start <= $daysIM) {
                
               $tstamp = mktime(0,0,0,$mon,(0+$date_start),$year);

               $return_array['1'][$jx][]=$date_start;
               
                 
                $date_start++;
            }
            else {
                $return_array['1'][$jx][]='';
            }
             
            if($i%7==0) {
                 
                $jx++;
            }
        }

        return $return_array;
    }

    public function DayInMonth($month, $year) {
    
       $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
       
       if ($month != 2) {
           
            return $daysInMonth[$month - 1];
        }
        else  {
            return (checkdate($month, 29, $year)) ? 29 : 28;
        }
    }
    public function sendEmailFunction($parameterArray) {

        if(!empty($parameterArray['mail_to'])) {

            // $parameterArray['mail_to'];
            // $parameterArray['mail_from']
            // $parameterArray['mail_subject'];
            // $parameterArray['mail_message'];

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= "From: <".$parameterArray['mail_from'].">" . "\r\n";
            //$headers .= 'Cc: myboss@example.com' . "\r\n";

            if(mail($parameterArray['mail_to'], $parameterArray['mail_subject'], $parameterArray['mail_message'], $headers)){
                return true;

                $_SESSION['forwarded_mail'][] = array($parameterArray['mail_to'], $parameterArray['mail_subject'], $parameterArray['mail_message'], $headers);
            }
            else{
                return false;
            }   
        }
         else{
            return false;
        } 
    }

	public function sendSmsFunction($smsData) {

		$whereArray = array();
		$data_array = array();

		$data_array['send_api_url'] = '';

		$gateway_url = "http://sms4power.com/api/swsendSingle.asp";
		$gateway_userid = "t1STINGO";
		$gateway_password = "92946411";
		$gateway_senderid = "Stingo";
		

		$sms_to = $smsData['mobile'];
		$sms_msg = $smsData['msg'];

		$data_array['send_by'] = 'ST';

		$smsGatetwayData = $this->getDetail("st_sms_gateway_setting", " and d.company_id='".$_SESSION['user_00']['company_id']."'", "", '*');

				

		if(count($smsGatetwayData) > 0 && $smsGatetwayData[0]['gateway_sendby'] == 'UD' && !empty($smsGatetwayData[0]['gateway_url']) && !empty($smsGatetwayData[0]['gateway_userid']) && !empty($smsGatetwayData[0]['gateway_password']) && !empty($smsGatetwayData[0]['gateway_senderid'])) {

			$gateway_url = $smsGatetwayData[0]['gateway_url'];
			$gateway_userid = $smsGatetwayData[0]['gateway_userid'];
			$gateway_password = $smsGatetwayData[0]['gateway_password'];
			$gateway_senderid = $smsGatetwayData[0]['gateway_senderid'];

			$data_array['send_by'] = $smsGatetwayData[0]['gateway_sendby'];

			$data_array['send_api_url'] = $smsGatetwayData[0]['gateway_url'];
		}

		$curl_call_url = $gateway_url."?username=".$gateway_userid."&password=".$gateway_password."&sender=".$gateway_senderid."http://sms4power.com/api/swsendSingle.asp?username=xxxx&password=xxxx&sender=senderId&sendto=919xxxx&message=hello&entityID=1701160716830593466&sendto=".$sms_to."&message=".urlencode($sms_msg);
		
		$ch = curl_init();  
    	curl_setopt($ch,CURLOPT_URL,$curl_call_url);
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	  	$retval = curl_exec($ch);
	  	curl_close($ch);

        $_SESSION['forwarded_sms'][] = array($sms_to,  urlencode($sms_msg));

		$data_array['company_id'] = $_SESSION['user_00']['company_id'];
		$data_array['send_customer_id'] = $smsData['customer_id'];
		$data_array['send_message'] = urlencode($sms_msg);
		$data_array['send_date'] = date("Y-m-d");
		$data_array['send_time'] = date("H:i:s");
		$data_array['send_sender_id'] = $gateway_senderid;
		$data_array['send_gateway_response'] = json_encode($retval);

		$send_id = $this->addUpdateDetail('st_sms_send_history', $data_array, $whereArray);

	  	return $retval;
	}

	public function getDetail($tableName, $where_str, $join_cond='', $cols='') {
		
		global $dbo;
		
		if(!empty($cols)) {
			
			$table_columns = $cols;
		}
		else {
			$table_columns = ' * ';
		}
	
		$_SESSION['select_q'][] =  "@@"."SELECT ".$table_columns." FROM  ".$tableName." d ".$join_cond." where 1=1 ".$where_str."@@<br>";

		$rs = $dbo->query ("SELECT ".$table_columns." FROM  ".$tableName." d ".$join_cond." where 1=1 ".$where_str );
		
		$rows = $rs->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($rows) > 0) {
			
			return $rows;
		}
		else {
			return null;
		}
	}

	public function deleteDetail($tableName, $where_cond) {
		
		global $dbo;

		$return_array = array();
		
		if(!empty($where_cond) && !empty($tableName)) {

			$_SESSION['delete_q'][] =  "@@"."delete from ".$tableName." where 1 ".$where_cond."@@<br>";
		
			$rowcount = $dbo->exec("delete from ".$tableName." where 1 ".$where_cond);
		}
		
		return $rowcount;
	}
	
	public function getColumns($tableName) {
		global $dbo;

		$return_array = array();
		
		if(!empty($tableName)) {

			$rs = $dbo->query ("SHOW COLUMNS FROM ".$tableName);
		
			$rows = $rs->fetchAll(PDO::FETCH_ASSOC);

			if(count($rows)) {

				foreach ($rows as $key => $value) {
					
					$return_array[] = $value['Field'];
				}
			}
		}

		return $return_array;
	}	

	public function addUpdateDetail($tableName, $detailData, $whereArray) {
		
		global $dbo;

		$dataStr = '';
		$whereStr = '';
		$update_id = 0;

		$clmn = $this->getColumns($tableName);

		if(count($whereArray) > 0) {

			$sep = "";
			foreach($whereArray as $ck=>$cv) {
				if(in_array($ck, $clmn)) {

					$whereStr .= $sep." ".$ck."='".addslashes($cv)."' ";
					$sep = " AND ";
				}
			}
		}

		if(count($detailData) > 0) {

			$sep = "";
			foreach($detailData as $ck=>$cv) {
				if(in_array($ck, $clmn)) {

					$dataStr .= $sep." ".$ck." = '".addslashes($cv)."' ";
					$sep = ", ";
				}
			}
		}
		
		if(!empty($dataStr) && empty($whereStr)) { 
		
			$sql = "INSERT INTO ".$tableName." set ".$dataStr;

			$_SESSION['insert_q'][] =  "@@"."INSERT INTO ".$tableName." set ".$dataStr."@@<br>";
			
			$rowcount = $dbo->exec($sql);
			
			$update_id = $dbo->lastInsertId();
		}
		else {

			$_SESSION['update_q'][] =  "@@"."UPDATE ".$tableName." SET ".$dataStr." WHERE ".$whereStr."@@<br>";

			$sql = "UPDATE ".$tableName." SET ".$dataStr." WHERE ".$whereStr;
			
			$update_id = $dbo->exec($sql);

			$update_id = 1;

		}

		return $update_id;
	}

	public function deleteMember($tableName, $where_cond) {
		global $dbo;

		$return_array = array();
		
		if(!empty($where_cond) && !empty($tableName)) {
		
			$rowcount = $dbo->exec("delete from ".$tableName." where 1 ".$where_cond);
		}
		
		return $rowcount;
	}
	
	public function returnOptionList($dataArray, $selectedValue='') {

		if(count($dataArray) > 0) {

			foreach ($dataArray as $key => $value) {
				?>
				<option value="<?php echo $key;?>" <?php if($selectedValue == $key){?>selected="selected"<?php }?>><?php echo $value;?></option>
				<?php
			}
		}
	}

	public function salogout($url='') {

		session_destroy();	
		
		if(!empty($url)) {
			$this->relocation($url);
		}
		else {
			$this->relocation(ROOTURL);
		}
	}

	public function logout($url='') {
		
		if(1==2 && isset($_SESSION['user_11']) && $_SESSION['user_11']['user_id'] > 0) {

			$_SESSION['user_00'] = $_SESSION['user_11'];

			$this->relocation(SUPERADMINURL."/".ADMINFILENAME);
		}
		else {

			// $whereArray = array();
			// $data_array = array();
			// $data_array['auth_expires'] = date("Y-m-d H:i:s");
	 	// 	$whereArray['auth_user_id'] = $_SESSION['user_00']['user_id'];
	 	// 	$whereArray['company_id'] = $_SESSION['user_00']['company_id'];
			// $id = $this->addUpdateDetail('st_user_auth_tokens', $data_array, $whereArray);
		 
		 
			session_destroy();	
			
			if(!empty($url)) {
				$this->relocation($url);
			}
			else {
				$this->relocation(ROOTURL);
			}
		}
	}

	public function setAdminLoginSession($data) {

		$_SESSION['user_00'] = $data;	 
	}

	public function setLoginSession($data) {

		$_SESSION['user_00'] = $data;

		/*if($data['user_group'] > '11') {

			$whereArray = array();
			$data_array = array();

			$selector = $this->getRandomString();

			$data_array['auth_user_id'] = $data['user_id'];
			$data_array['company_id'] 	= $data['company_id'];
			$data_array['auth_selector'] = base64_encode($selector."~#~".substr($data['user_password'], 0,10));
			$data_array['auth_hash'] = md5($selector."~#~".$data['company_id']."~#~".$data['user_id']);
			$data_array['auth_expires'] = date("Y-m-d H:i:s", mktime(0,0,0,(date("m")+1),(date("d")+0),date("Y")));

			$authData = $this->getDetail('st_user_auth_tokens', " and d.company_id = '".$data['company_id']."' and  d.auth_user_id='".$data['user_id']."'", '', ' * ');

			if(count($authData) > 0) {

				$whereArray['auth_id'] = $authData[0]['auth_id'];
			}

			$id = $this->addUpdateDetail('st_user_auth_tokens', $data_array, $whereArray);

			if($id > 0) {

				setcookie("RememberMe",$data_array['auth_hash'], time() + (30 * 24 * 60 * 60), '/');
			}

			setcookie("compid",$data['company_id'], time() + (1 * 365 * 24 * 60 * 60), '/');
			setcookie("userid",$data['user_id'], time() + (1 * 365 * 24 * 60 * 60), '/');
		}*/
	}

	public function getRandomString() {

		$rand_no = mt_rand(111111,999999);

		return $rand_no;
	}

	public function correctIndianMobileNo($mobile_no1) {
		$mobile_no = $mobile_no1;
		$mobile_no = trim($mobile_no);
		$mobile_no = str_replace("-", "", $mobile_no);
		$mobile_no = str_replace(" ", "", $mobile_no);
		$mobile_no = str_replace(",", "", $mobile_no);
		$mobile_no = str_replace("_", "", $mobile_no);
		$mobile_no = str_replace("_", "", $mobile_no);
		$mobile_no = str_replace('"', "", $mobile_no);
		$mobile_no = str_replace('*', "", $mobile_no);
		$mobile_no = str_replace('#', "", $mobile_no);
		$mobile_no = str_replace('=', "", $mobile_no);
		$mobile_no = str_replace('.', "", $mobile_no);
		$mobile_no = str_replace('?', "", $mobile_no);

		$mobile_no = str_replace('(', "", $mobile_no);
		$mobile_no = str_replace(')', "", $mobile_no);

		$mobile_no = str_replace('[', "", $mobile_no);
		$mobile_no = str_replace(']', "", $mobile_no);


		$return_array = array();

		if(strlen($mobile_no) < 10) {

			$return_array['status'] = 'error';
			$return_array['alert'] = 'Invalid Mobile No.';
			$return_array['mobile'] = $mobile_no1;
		}
		else {

			$mobile_no = substr($mobile_no,-10,10);

			$return_array['status'] = 'success';
			$return_array['alert'] = 'success';
			$return_array['mobile'] = "91".$mobile_no;
		}

		return $return_array;
	}
	
	public function relocation($url) {
	
		if(empty($url)) {
			
			$url = SITEURL;
		}
		
		?>
		<META http-equiv="refresh" content="0;URL=<?php echo $url;?>">
		<?php 
	}

	public function getPaging($total, $link, $curret_page, $record_page=20) {
		
		$dispPage = 10;
		
		
		if($total > $record_page) {
			
			$totalPages = ceil($total/$record_page);
			
			$PREVIOUS = $curret_page-1;
			$NEXT = $curret_page+1;
			
			if($PREVIOUS <= 0) {
				$PREVIOUS = 1;
			}
			
			if($NEXT > $totalPages) {
				$NEXT = $totalPages;
			}
			
			if($curret_page <= 0) {
				
				$curret_page = 1;
			}
			?>
            <div class="row col-md-offset-0 ">
     <ul class="pagination">
      <li class="paginate_button previous" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="<?php echo $link."&paging=1";?>"><i class=" glyphicon glyphicon-fast-backward"></i></a></li>
      <li class="paginate_button previous" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="<?php echo $link."&paging=".$PREVIOUS;?>"><i class=" glyphicon glyphicon-backward"></i></a></li>
     <?php
			for($i=1;$i<=$totalPages;$i++) {
				
				$cls = '';
				
				if($i == $curret_page) {
					
					$cls = " active ";
				}
				?>
				
            
             
             <li class="paginate_button <?php echo $cls;?> " aria-controls="dataTables-example" tabindex="0"><a href="<?php echo $link."&paging=".$i;?>"><?php echo $i;?></a></li>
             <?php
            
             
    
			}
			?>
            <li class="paginate_button next " aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a href="<?php echo $link."&paging=".$NEXT;?>"><i class=" glyphicon glyphicon-forward"></i></a></li> 
            <li class="paginate_button next" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a href="<?php echo $link."&paging=".$totalPages;?>"><i class=" glyphicon glyphicon-fast-forward"></i></a></li>
             </ul>
     </div>
     <?php
			//if($totalPages > $dispPage) {
				
				
			//}
		}		
	}
	
	function smsapi($url,$data){

	  	$ch = curl_init();  
    	curl_setopt($ch,CURLOPT_URL,$url.$data);
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	  	$retval = curl_exec($ch);
	  	curl_close($ch);
	  	return $retval;
	}

	function loginemail($lead,$sale){

		$mail_str = '';
		if(count($lead)>0){
			$mail_str .= '<table>
				<caption>Leads of Todays Follow-up</caption>
				<thead>
					<tr>
						<th>Company Name</th>
						<th>Customer Name</th>
						<th>Mobile</th>
						<th>Area</th>
						<th>Allocated to</th>
						<th>Category</th>
						<th>Lead Status</th>
						<th>Lead By</th>
					</tr>
				</thead>
				<tbody>';
				 
					foreach ($lead as $key => $value) {
						 
						$mail_str .= '<tr>
							<td>'.$value['customer_company'].'</td>
							<td>'.$value['customer_firstname'].' '.$value['customer_lastname'].'</td>
							<td>'.$value['customer_mobile'].'</td>
							<td>'.$value['customer_area'].'</td>
							<td>'.$value['lead_allocated_to'].'</td>
							<td>'.$value['lead_category'].'</td>
							<td>'.$value['lead_status'].'</td>
							<td>'.$value['lead_source'].'</td>
						</tr>';
					} 
			$mail_str .= '</tbody>
			</table>';
		}

		if(count($sale)>0){
			$mail_str .= '
			<table>
				<caption>Sales Due Amount Follow-up</caption>
					<thead>
						<tr>
							<th>Company Name</th>
							<th>Customer Name</th>
							<th>Mobile</th>
							<th>Allocated to</th>
							<th>Total Sale</th>
						</tr>
					</thead>
					<tbody>';

					foreach ($sale as $key => $value) {
					 
						$mail_str .= '<tr>
							<td>'.$value['customer_company'].'</td>
							<td>'.$value['customer_firstname'].' '.$value['customer_lastname'].'</td>
							<td>'.$value['customer_mobile'].'</td>
							<td>'.$value['lead_allocated_to'].'</td>
							<td>'.($value['dr_amount']+$value['additional_cr_cost']).'</td>
						</tr>';
						 
					}
					
				$mail_str .= '</tbody>
				</table>';
		 	  
		 }

		return $mail_str;	
	}
}

?>