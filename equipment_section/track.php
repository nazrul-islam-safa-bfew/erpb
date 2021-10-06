<?php
//assigning system date...
$t_date=date("Y-m-d");

$qry="SELECT itm_track_id,year,item_make,item_model,item_identification,item_serial_no,item_type,pm_service_id,item_curr_kilometer,item_base_kilometer,item_base_date,item_status,item_assigned_to,item_purchase_dealer,item_purchase_date,item_purchase_kilometer,item_purchase_price,item_purchase_comment,item_loan_company,item_loan_account,item_loan_start_date,item_loan_end_date,item_loan_payment,item_loan_balance,item_loan_notes,item_insurance_company,item_insurance_policy,item_insurance_start_date,item_insurance_end_date,item_insurance_payment,item_insurance_deductible,item_insurance_notes FROM add_equipment_maintenance WHERE wo_status='0'";
							
							
							$qryexecute = mysqli_query($db, $qry);
											while ($name = mysql_fetch_row($qryexecute)) 
											{
											$itm_track_id=$name[0];
											$year=$name[1];
											$item_make=$name[2];
											$item_model=$name[3];
											$item_identification1=$name[4];
											$item_serial_no=$name[5];
											$item_type=$name[6];
											$item_maintenance_schedule_id=$name[7];
											$item_curr_kilometer=$name[8];
											$item_base_kilometer=$name[9];
											$item_base_date=$name[10];
											$item_status=$name[11];
											$item_assigned_to=$name[12];
											$item_purchase_dealer=$name[13];
											$item_purchase_date=$name[14];
											$item_purchase_kilometer=$name[15];							
											$item_purchase_price=$name[16];
											$item_purchase_comment=$name[17];
											$item_loan_company=$name[18];
											$item_loan_account=$name[19];
											$item_loan_start_date=$name[20];
											$item_loan_end_date=$name[21];
											$item_loan_payment=$name[22];
											$item_loan_balance=$name[23];
											$item_loan_notes=$name[24];
											$item_insurance_company=$name[25];
											$item_insurance_policy=$name[26];
											$item_insurance_start_date=$name[27];
											$item_insurance_end_date=$name[28];
											$item_insurance_payment=$name[29];
											$item_insurance_deductible=$name[30];
											$item_insurance_notes=$name[31];
											
											
											
											//--QUERY FOR RETRIEVING PM SERVICE NAME---//

											$qry2="SELECT pm_service_name FROM add_pm_service WHERE pm_service_id='$item_maintenance_schedule_id'";
											$qryexecute2=mysqli_query($db, $qry2);
											$rs2=mysql_fetch_row($qryexecute2);
											$schedule_name=$rs2[0];
											
											//----------------END-----------------------//
											
							//SELECTS RECORD FROM THE track_equipments TABLE BASED ON THE add_new_equipment table item_id for tracking equipments which are added to schedule...
											$qry_track="SELECT item_curr_kilometer,item_base_kilometer,item_base_date FROM track_equipments WHERE itm_track_id='$itm_track_id'";
											$qryexecute_trck=mysqli_query($db, $qry_track); 
											$rs_track=mysql_fetch_row($qryexecute_trck);
											$item_curr_reading=$rs_track[0];
											$item_base_reading=$rs_track[1];
											$item_base_date1=$rs_track[2];
											
										//Tracking Equipments PM Date Based On Fidxed Date + FIXED DAY...
							$qryfixed="SELECT fixed_date,notify_day_advance,number_of_day,day_period,hour_number,fixed_hour,notify_hour_advance,task_base FROM add_pm_service WHERE pm_service_id='$item_maintenance_schedule_id'";
							$qryexecute_fixed=mysqli_query($db, $qryfixed);
							$rs_fixed=mysql_fetch_row($qryexecute_fixed);
							
								$fixed_date=$rs_fixed[0];
								$notify_day_advance=$rs_fixed[1];
								$number_of_day=$rs_fixed[2];
								$day_period=$rs_fixed[3];
								$hour_number=$rs_fixed[4];
								$fixed_hour=$rs_fixed[5];
								$notify_hour_advance=$rs_fixed[6];
								$task_base=$rs_fixed[7];
								
					//TRACK EQUIPMENT Fixed DATE+DAY BASED...
					
								if($day_period=="")
									{
									//for Fixed Date.....
									$fixed_date1=$fixed_date;
													//calculating difference between 2 dates in days..
													//transforming fixed date & t_date(i.e today's date) to equivalent seconds
													$m=strtotime($fixed_date1);	
													$n=strtotime($t_date);
													//calculating elapsing days between to dates in seconds									
													$diff = $m-$n;
													//make sconds to days
													$diff1 = $diff/86400;
													//echo $diff1; 
													
									}
								else if($day_period=="Day(s)")
									{
										$timeStamp = strtotime("$item_base_date1");
										$timeStamp += 24 * 60 * 60 * $number_of_day; // (add $number_of_day days)
										$fixed_date1 = date("Y-m-d", $timeStamp);
													
													//calculating difference between 2 dates in days..
													//transforming fixed date & t_date(i.e today's date) to equivalent seconds
													$m=strtotime($fixed_date1);	
													$n=strtotime($t_date);
													//calculating elapsing days between to dates in seconds									
													$diff = $m-$n;
													//make sconds to days
													$diff1 = $diff/86400;
													//echo $diff1; 
									}
								else if($day_period=="Week(s)")
									{
										$timeStamp = strtotime("$item_base_date1");
										$timeStamp += 7 * $number_of_day * 24 * 60 * 60;// (add $number_of_day weeks)
										$fixed_date1 = date("Y-m-d", $timeStamp);
										
													//calculating difference between 2 dates in days..
													//transforming fixed date & t_date(i.e today's date) to equivalent seconds
													$m=strtotime($fixed_date1);	
													$n=strtotime($t_date);
													//calculating elapsing days between to dates in seconds									
													$diff = $m-$n;
													//make sconds to days
													$diff1 = $diff/86400;
													//echo $diff1; 
									}
								else if($day_period=="Month(s)")
									{
										$timeStamp = strtotime("$item_base_date1");
										$timeStamp += 30 * $number_of_day * 24 * 60 * 60; // (add $number_of_day Months)
										$fixed_date1 = date("Y-m-d", $timeStamp);
										
													//calculating difference between 2 dates in days..
													//transforming fixed date & t_date(i.e today's date) to equivalent seconds
													$m=strtotime($fixed_date1);	
													$n=strtotime($t_date);
													//calculating elapsing days between to dates in seconds									
													$diff = $m-$n;
													//make sconds to days
													$diff1 = $diff/86400;
													//echo $diff1; 
									}
								else if($day_period=="Year(s)")
									{
										$timeStamp = strtotime("$item_base_date1");
										$timeStamp += 12 * $number_of_day * 30 * 24 * 60 * 60; // (add $number_of_day Years)
										$fixed_date1 = date("Y-m-d", $timeStamp);
										
													//calculating difference between 2 dates in days..
													//transforming fixed date & t_date(i.e today's date) to equivalent seconds
													$m=strtotime($fixed_date1);	
													$n=strtotime($t_date);
													//calculating elapsing days between to dates in seconds									
													$diff = $m-$n;
													//make sconds to days
													$diff1 = $diff/86400;
													//echo $diff1; 
									}
									
					//TRACK EQUIPMENT SPECIFIC+FIXED METER BASED...
								  if($fixed_hour!="")
									{
										//track the equipments planned pm service date...
										$track_in_day=$fixed_hour/$item_curr_reading;
										//converting to seconds...
										$timeStamp = $track_in_day * 86400;
										$today=strtotime($t_date);
										$cal_date=($timeStamp)+($today);
										//converting seconds to date
										$fixed_date1 = date("Y-m-d", $cal_date);
										
													//calculating difference between 2 meter readings(I.e current meter reading & tracking meter reading)....
													$diff1 = ($fixed_hour)-($item_curr_reading);
													/*echo "F : $fixed_hour";
													echo "C : $item_curr_reading"; 
													echo "D : $diffrence"; 
													echo "N : $notify_hour_advance"; */
									}
								//track equipment after a specific meter reading ....
								 else if($hour_number!="")
								 {
										//track the equipments planned pm service date...
										$track_in_day=floor($item_curr_reading/$hour_number);
										//converting to seconds...
										$timeStamp = $track_in_day * 86400;
										$today=strtotime($item_base_date1);
										$cal_date=$timeStamp+$today;
										//converting seconds to date
										$fixed_date1 = date("Y-m-d", $cal_date);
										//echo"$track_in_day";
									}
									
									
									//select teqSpec from the equipment table base on the selected itm_track_id
									$qry_tech="select itemCode,teqSpec from equipment where eqid='$itm_track_id'";
									$qrytech_execute=mysqli_query($db, $qry_tech);
									$rs_tech=mysql_fetch_row($qrytech_execute);
									$item_code=$rs_tech[0];
									$item_identification=$rs_tech[1];
//---------------------------------------------------END---------------------------------------------------------------------------									
									
									

//--------------------------------------------------------------END------------------------------------------------------//
													//planned date of pm service is less than todays date i.e if pm service is due
																	 if($fixed_date1<$t_date)
																		{
																			echo"<tr bgcolor=#FF99CC>
																			<td>$item_identification</td>
																			<td>$fixed_date1</td>
																			<td>$item_code</td>
																			<td>$year</td>
																			<td>$item_serial_no</td>
																			<td>$item_make</td>
																			<td>$item_model</td>
																			<td>$item_curr_kilometer</td>
																			<td>$item_type</td>
																			<td>$item_status</td>
																			<td>$schedule_name</td>
																			<td>$item_base_kilometer</td>
																			<td>$item_base_date</td>
																			<td>$item_assigned_to</td>
																			<td>$item_purchase_dealer</td>
																			<td>$item_purchase_date</td>
																			<td>$item_purchase_kilometer</td>
																			<td>$item_purchase_price</td>
																			<td>$item_purchase_comment</td>
																			<td>$item_loan_company</td>
																			<td>$item_loan_account</td>
																			<td>$item_loan_start_date</td>
																			<td>$item_loan_end_date</td>
																			<td>$item_loan_payment</td>
																			<td>$item_loan_balance</td>
																			<td>$item_loan_notes</td>
																			<td>$item_insurance_company</td>
																			<td>$item_insurance_policy</td>
																			<td>$item_insurance_start_date</td>
																			<td>$item_insurance_end_date</td>
																			<td>$item_insurance_payment Tk.</td>	
																			<td>$item_insurance_deductible Tk.</td>	
																			<td>$item_insurance_notes</td>
															
																				</tr>";
																		}
																else if($diff1<=$notify_day_advance)
																	{
																			echo"<tr bgcolor=#FFFF99>
																			<td>$item_identification</td>
																			<td>$fixed_date1</td>
																			<td>$item_code</td>
																			<td>$year</td>
																			<td>$item_serial_no</td>
																			<td>$item_make</td>
																			<td>$item_model</td>
																			<td>$item_curr_kilometer</td>
																			<td>$item_type</td>
																			<td>$item_status</td>
																			<td>$schedule_name</td>
																			<td>$item_base_kilometer</td>
																			<td>$item_base_date</td>
																			<td>$item_assigned_to</td>
																			<td>$item_purchase_dealer</td>
																			<td>$item_purchase_date</td>
																			<td>$item_purchase_kilometer</td>
																			<td>$item_purchase_price</td>
																			<td>$item_purchase_comment</td>
																			<td>$item_loan_company</td>
																			<td>$item_loan_account</td>
																			<td>$item_loan_start_date</td>
																			<td>$item_loan_end_date</td>
																			<td>$item_loan_payment</td>
																			<td>$item_loan_balance</td>
																			<td>$item_loan_notes</td>
																			<td>$item_insurance_company</td>
																			<td>$item_insurance_policy</td>
																			<td>$item_insurance_start_date</td>
																			<td>$item_insurance_end_date</td>
																			<td>$item_insurance_payment Tk.</td>	
																			<td>$item_insurance_deductible Tk.</td>	
																			<td>$item_insurance_notes</td>
															
																				</tr>";
																		}
																else if($diff1<=$notify_hour_advance)
																	{
																			echo"<tr bgcolor=#FFFF99>
																			<td>$item_identification</td>
																			<td>$fixed_date1</td>
																			<td>$item_code</td>
																			<td>$year</td>
																			<td>$item_serial_no</td>
																			<td>$item_make</td>
																			<td>$item_model</td>
																			<td>$item_curr_kilometer</td>
																			<td>$item_type</td>
																			<td>$item_status</td>
																			<td>$schedule_name</td>
																			<td>$item_base_kilometer</td>
																			<td>$item_base_date</td>
																			<td>$item_assigned_to</td>
																			<td>$item_purchase_dealer</td>
																			<td>$item_purchase_date</td>
																			<td>$item_purchase_kilometer</td>
																			<td>$item_purchase_price</td>
																			<td>$item_purchase_comment</td>
																			<td>$item_loan_company</td>
																			<td>$item_loan_account</td>
																			<td>$item_loan_start_date</td>
																			<td>$item_loan_end_date</td>
																			<td>$item_loan_payment</td>
																			<td>$item_loan_balance</td>
																			<td>$item_loan_notes</td>
																			<td>$item_insurance_company</td>
																			<td>$item_insurance_policy</td>
																			<td>$item_insurance_start_date</td>
																			<td>$item_insurance_end_date</td>
																			<td>$item_insurance_payment Tk.</td>	
																			<td>$item_insurance_deductible Tk.</td>	
																			<td>HI</td>
																				</tr>";
																		}
																																						  																	else if($diff1>$notify_day_advance)
																	{
																			echo"<tr>
																			<td>$item_identification</td>
																			<td>$fixed_date1</td>
																			<td>$item_code</td>
																			<td>$year</td>
																			<td>$item_serial_no</td>
																			<td>$item_make</td>
																			<td>$item_model</td>
																			<td>$item_curr_kilometer</td>
																			<td>$item_type</td>
																			<td>$item_status</td>
																			<td>$schedule_name</td>
																			<td>$item_base_kilometer</td>
																			<td>$item_base_date</td>
																			<td>$item_assigned_to</td>
																			<td>$item_purchase_dealer</td>
																			<td>$item_purchase_date</td>
																			<td>$item_purchase_kilometer</td>
																			<td>$item_purchase_price</td>
																			<td>$item_purchase_comment</td>
																			<td>$item_loan_company</td>
																			<td>$item_loan_account</td>
																			<td>$item_loan_start_date</td>
																			<td>$item_loan_end_date</td>
																			<td>$item_loan_payment</td>
																			<td>$item_loan_balance</td>
																			<td>$item_loan_notes</td>
																			<td>$item_insurance_company</td>
																			<td>$item_insurance_policy</td>
																			<td>$item_insurance_start_date</td>
																			<td>$item_insurance_end_date</td>
																			<td>$item_insurance_payment Tk.</td>	
																			<td>$item_insurance_deductible Tk.</td>	
																			<td>$item_insurance_notes</td>
															
																				</tr>";
																		}


																else if($diff1>$notify_hour_advance)
																	{
																			echo"<tr>
																			<td>$item_identification</td>
																			<td>$fixed_date1</td>
																			<td>$item_code</td>
																			<td>$year</td>
																			<td>$item_serial_no</td>
																			<td>$item_make</td>
																			<td>$item_model</td>
																			<td>$item_curr_kilometer</td>
																			<td>$item_type</td>
																			<td>$item_status</td>
																			<td>$schedule_name</td>
																			<td>$item_base_kilometer</td>
																			<td>$item_base_date</td>
																			<td>$item_assigned_to</td>
																			<td>$item_purchase_dealer</td>
																			<td>$item_purchase_date</td>
																			<td>$item_purchase_kilometer</td>
																			<td>$item_purchase_price</td>
																			<td>$item_purchase_comment</td>
																			<td>$item_loan_company</td>
																			<td>$item_loan_account</td>
																			<td>$item_loan_start_date</td>
																			<td>$item_loan_end_date</td>
																			<td>$item_loan_payment</td>
																			<td>$item_loan_balance</td>
																			<td>$item_loan_notes</td>
																			<td>$item_insurance_company</td>
																			<td>$item_insurance_policy</td>
																			<td>$item_insurance_start_date</td>
																			<td>$item_insurance_end_date</td>
																			<td>$item_insurance_payment Tk.</td>	
																			<td>$item_insurance_deductible Tk.</td>	
																			<td>$item_insurance_notes</td>
																				</tr>";
																		}

									/*else if($fixed_date!=="")
									{
																	echo"<tr>
																<td>$item_identification</td>
																<td>$fixed_date</td>
																<td>$item_id</td>
																<td>$year</td>
																<td>$item_serial_no</td>
																<td>$item_make</td>
																<td>$item_model</td>
																<td>$item_curr_kilometer</td>
																<td>$item_type</td>
																<td>$item_status</td>
																<td>$schedule_name</td>
																<td>$item_base_kilometer</td>
																<td>$item_base_date</td>
																<td>$item_assigned_to</td>
																<td>$item_purchase_dealer</td>
																<td>$item_purchase_date</td>
																<td>$item_purchase_kilometer</td>
																<td>$item_purchase_price</td>
																<td>$item_purchase_comment</td>
																<td>$item_loan_company</td>
																<td>$item_loan_account</td>
																<td>$item_loan_start_date</td>
																<td>$item_loan_end_date</td>
																<td>$item_loan_payment</td>
																<td>$item_loan_balance</td>
																<td>$item_loan_notes</td>
																<td>$item_insurance_company</td>
																<td>$item_insurance_policy</td>
																<td>$item_insurance_start_date</td>
																<td>$item_insurance_end_date</td>
																<td>$item_insurance_payment Tk.</td>	
																<td>$item_insurance_deductible Tk.</td>	
																<td>$item_insurance_notes</td>
												
																	</tr>";
													}
							
							
/*											   	if($fixed_date>$t_date and $notify_day_advance>=($fixed_date-$t_date))
													{
																echo"<tr bgcolor='#CCFF66'>
																<td>$item_identification</td>
																<td>$fixed_date</td>
																<td>$item_id</td>
																<td>$year</td>
																<td>$item_serial_no</td>
																<td>$item_make</td>
																<td>$item_model</td>
																<td>$item_curr_kilometer</td>
																<td>$item_type</td>
																<td>$item_status</td>
																<td>$schedule_name</td>
																<td>$item_base_kilometer</td>
																<td>$item_base_date</td>
																<td>$item_assigned_to</td>
																<td>$item_purchase_dealer</td>
																<td>$item_purchase_date</td>
																<td>$item_purchase_kilometer</td>
																<td>$item_purchase_price</td>
																<td>$item_purchase_comment</td>
																<td>$item_loan_company</td>
																<td>$item_loan_account</td>
																<td>$item_loan_start_date</td>
																<td>$item_loan_end_date</td>
																<td>$item_loan_payment</td>
																<td>$item_loan_balance</td>
																<td>$item_loan_notes</td>
																<td>$item_insurance_company</td>
																<td>$item_insurance_policy</td>
																<td>$item_insurance_start_date</td>
																<td>$item_insurance_end_date</td>
																<td>$item_insurance_payment Tk.</td>	
																<td>$item_insurance_deductible Tk.</td>	
																<td>$item_insurance_notes</td>
																</tr>";
														}
														
													else if($fixed_date<$t_date and $notify_day_advance<($fixed_date-$t_date))
														{
																echo"<tr bgcolor='#FFCCFF'>
																<td>$item_identification</td>
																<td>$fixed_date</td>
																<td>$item_id</td>
																<td>$year</td>
																<td>$item_serial_no</td>
																<td>$item_make</td>
																<td>$item_model</td>
																<td>$item_curr_kilometer</td>
																<td>$item_type</td>
																<td>$item_status</td>
																<td>$schedule_name</td>
																<td>$item_base_kilometer</td>
																<td>$item_base_date</td>
																<td>$item_assigned_to</td>
																<td>$item_purchase_dealer</td>
																<td>$item_purchase_date</td>
																<td>$item_purchase_kilometer</td>
																<td>$item_purchase_price</td>
																<td>$item_purchase_comment</td>
																<td>$item_loan_company</td>
																<td>$item_loan_account</td>
																<td>$item_loan_start_date</td>
																<td>$item_loan_end_date</td>
																<td>$item_loan_payment</td>
																<td>$item_loan_balance</td>
																<td>$item_loan_notes</td>
																<td>$item_insurance_company</td>
																<td>$item_insurance_policy</td>
																<td>$item_insurance_start_date</td>
																<td>$item_insurance_end_date</td>
																<td>$item_insurance_payment Tk.</td>	
																<td>$item_insurance_deductible Tk.</td>	
																<td>$item_insurance_notes</td>
												
																	</tr>";
													}
													else
														{
																	echo"<tr>
																<td>$item_identification</td>
																<td>$fixed_date</td>
																<td>$item_id</td>
																<td>$year</td>
																<td>$item_serial_no</td>
																<td>$item_make</td>
																<td>$item_model</td>
																<td>$item_curr_kilometer</td>
																<td>$item_type</td>
																<td>$item_status</td>
																<td>$schedule_name</td>
																<td>$item_base_kilometer</td>
																<td>$item_base_date</td>
																<td>$item_assigned_to</td>
																<td>$item_purchase_dealer</td>
																<td>$item_purchase_date</td>
																<td>$item_purchase_kilometer</td>
																<td>$item_purchase_price</td>
																<td>$item_purchase_comment</td>
																<td>$item_loan_company</td>
																<td>$item_loan_account</td>
																<td>$item_loan_start_date</td>
																<td>$item_loan_end_date</td>
																<td>$item_loan_payment</td>
																<td>$item_loan_balance</td>
																<td>$item_loan_notes</td>
																<td>$item_insurance_company</td>
																<td>$item_insurance_policy</td>
																<td>$item_insurance_start_date</td>
																<td>$item_insurance_end_date</td>
																<td>$item_insurance_payment Tk.</td>	
																<td>$item_insurance_deductible Tk.</td>	
																<td>$item_insurance_notes</td>
												
																	</tr>";
													}*/
													

											}
					?>
