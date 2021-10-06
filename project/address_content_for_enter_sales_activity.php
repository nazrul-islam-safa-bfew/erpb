<?php
   
   if($type2>0)
        $sqltq=mysqli_query($db, "select cat_id,cat_des from categorie where cat_id=$type2  $compay_id_sql");
   if($type2==0){
       $sqltq=mysqli_query($db, "select cat_id,cat_des from categorie where cat_type=1 and `cat_id` != 186  $compay_id_sql");
	   while($the_type_without_row=mysqli_fetch_array($sqltq))
		{
			$the_type_[]=$the_type_without_row[cat_id];
		}
	   $sqltq=mysqli_query($db, "select cat_id,cat_des from categorie where cat_type=1  $compay_id_sql");
	}
    
	while($rt=mysqli_fetch_array($sqltq))
	{			
		if($type2!=0)
			$type2=$rt[cat_id];
		else
		{
			$type2=null;			
			$alltypeofcat=implode(",",$the_type_);
		}
		
        $sqlp = "SELECT * FROM `project` WHERE project.probability<>'100% Order received'  $compay_id_sql ";
		
		if($_GET['division'])
						$sqlp.=" and project.pdiv='$div_row[div_id]'";
		if($_GET['district'])
						$sqlp.=" and project.pcity='$dis_row[dist_id]'";
		if($_GET['pp_code'])
						$sqlp.=" and project.ppcode like '%$ppcode_row[ppcodes]%'";
		// if($_GET['w']==4)
		// 				$sqlp.=" and project.marketingTarget ='$marketingTarget_row[1]'";
			
        if($type2)
            $sqlp.= " AND (project.type='$type2' or project.type like '%,$type2' or project.type like '%,$type2,%' or project.type like '$type2,%')";
		else
			$sqlp.= " AND project.type in ($alltypeofcat) ";
		
		
		
			if($a_loginDesignation =="Marketing Executive"){
			if($me_agenda[country])
				$sqlp.=" and project.pcoun='$me_agenda[country]' ";
			elseif($me_agenda[division])
				$sqlp.=" and project.pdiv in ($me_agenda[division]) ";
			elseif($me_agenda[district])
				$sqlp.=" and project.pcity in ($me_agenda[district]) ";
			elseif($me_agenda[postal_code])
				$sqlp.=" and project.ppcode in (".explode_ppc($me_agenda[postal_code]).") ";
			}
		
		
		
        $sqlp.=" ORDER by project.pname ASC";
        //echo "$sqlp<br>";
		
        $sqlrunp= mysqli_query($db, $sqlp);
        while($re=mysqli_fetch_array($sqlrunp)){  
            
			$continue=0;
			if($_GET['short']=='short'){          
                if(check_competition($re[id],$all_com))
                    $continue=1;
            }
			elseif($_GET['short']=='short_b'){          
                if(check_behavior($re[id],$all_beh))
                    $continue=1;
            }
			
			elseif($_GET['short']=='short_m'){          
                if(check_management($re[id],$all_man))
                    $continue=1;
            }
			
			
			elseif($_GET['short']=='short_l'){          
                if(check_lifecycle_position($re[id],$all_lp))
                    $continue=1;
            }
            
			
			elseif($_GET['b2b']=='1'){
                if(check_b2b(view_b2b(3,$all_lp,null)[1],$re[id],$agenda_id,$a_loginDesignation))
                    $continue=1;
            }
			elseif($_GET['w']=='4'){
				$agenda_info=unameToAgenda4MEv3($_SESSION["a_loginUname"]);
				$_GET[marketing_target_agenda]=$agenda_info["id"];				

				// echo "test: ".$marketingTarget_row[1]."<br>";
				
				$_me_property_q=get_me_property_query($re[id], $_GET[marketing_target_agenda]);		
				$_me_property_row=mysqli_fetch_array($_me_property_q);
				// print_r($_me_property_row);
				// print_r($marketingTarget_row[1]);
				if($_me_property_row[project_marketingTarget]=='' && $marketingTarget_row[1]=='a')
					$continue=1;
				elseif($_me_property_row[project_marketingTarget]==$marketingTarget_row[1])
					$continue=1;
			}
			
			
			else
                $continue=1;

            if($continue)
			{
				
            $sqlp2 = "SELECT * FROM `repname` WHERE pid='$re[id]'  $compay_id_sql ORDER by buyingRole ASC";
           // echo $sqlp2."<br>";
//            echo "$sqlp<br>";
            $sqlrunp2=mysqli_query($db, $sqlp2);
            ?> 
			<?php
				
				$me_pro_sql="select * from me_property where me_property.pid='$re[id]' and me_property.agenda_id='$agenda_id'  $compay_id_sql";
				$me_pro_q=mysqli_query($db, $me_pro_sql);
				
				if(mysqli_affected_rows($db)){
					$me_proparty_sql="select cbp.*, me_property.*,user.fullName from cbp,me_property,user where cbp.pid='$re[id]' and me_property.pid='$re[id]' and me_property.company_id='$a_company_id' and cbp.company_id='$a_company_id' and user.company_id='$a_company_id' ";
				if($a_loginDesignation=="Marketing Executive"){


/*
									switch($all_lp){
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;
										case 2:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;		
										case 1:
											$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
											break;					

									}*/

									$me_proparty_sql.=" and me_property.agenda_id='$agenda_id' limit 1 ";

								}
				}
				else{
					$me_proparty_sql="select cbp.*, user.fullName from cbp,user where cbp.pid='$re[id]' 
 					and cbp.company_id='$a_company_id' and user.company_id='$a_company_id'
					";
				}
				
				/*
				$me_proparty_sql="select cbp.*, me_property.*,user.fullName from cbp,me_property,user where cbp.pid='$re[id]' and me_property.pid='$re[id]'";
				if($a_loginDesignation=="Marketing Executive")
					$me_proparty_sql.=" and me_property.agenda_id='$agenda_id'";
				*/
					// echo $me_proparty_sql;
			$query_cp=mysqli_query($db, $me_proparty_sql);
			$cp_row=mysqli_fetch_array($query_cp);

		
				
			if(mysqli_affected_rows($db)>0){
				$ag_row[marketing_n]=str_replace(",se001", "", $ag_row[marketing_n]);
				$me_name=$ag_row[marketing_n];
				$me_full_name=$ag_row[marketing_n];
			}else{
				$me_name="";
				$me_full_name="";
			}
			
			if($re[project_marketingTarget]=="")
				$re[project_marketingTarget]="a";
			
			
			
			?>
            <tr class="the_print_option">
                <td>
                    <a name="tt_<? echo $re[id];?>" id="tt_<? echo $re[id];?>"></a>[ <? echo ++$ctype;?>]
                    <b>
						
						
						<?php 
				if(competitor_locker($re[id],$agenda_id)){?>
					<a href="#tt_<? echo $re[id];?>">
						<font color='#f00' style="font-weight: 800;"><? echo $re['pname']; echo $re['project_name'];?></font>
					</a>
				<?php } else{ ?>	
					
					<a>
						<font color='#f00' style="font-weight: 800;"><? echo $re['pname']; echo $re['project_name'];?></font>
							
						</a>
						
				<?php } ?>
						
						
						
						
					
					</b>;
                    <span style="color:#0000FF"><? echo $re[paddress1];?></span>; <span style="color:#0000FF"><? echo $re[paddress2];?></span>;<span style="color:#0000FF"> <? echo view_city($re[pcity]);?></span>-<span style="color:#0000FF"><? echo $re[ppcode];?></span>;<span style="color:#0000FF"><? echo view_country_name($re[pcoun]);?></span>;
					<?php if($comp_lock_row=competitor_locker($re[id],$agenda_id))echo '<img src="./images/Light_Lock.png" title="'.pID2project($comp_lock_row[pid])[pname].'">';  ?>
                    <br>Phone: <span style="color:#0000FF"><? echo $re[pphone];?></span>; Fax: <span style="color:#0000FF"><? echo $re[pfax];?></span>;
                    ;Email: <span style="color:#0000FF"><? echo $re[pemail];?></span>; Url: <span style="color:#0000FF"><? echo $re[purl]; echo "; ";?></span>
									 Geo Location X:<span style="color:#0000FF"><? echo $re[latitude];?></span>; Y:<span style="color:#0000FF"><? echo $re[longitude];?></span>
									;<span style="background:#F9F9F9; color:#666">Other Prospect Type: 
                
                <?php
				$query_other_project=mysqli_query($db, "select cat_des from categorie where cat_id in ($re[type]) and cat_id!='$type2' $compay_id_sql");
				while($query_other_project_row=mysqli_fetch_array($query_other_project))
					echo '<span style="color:#00C">'.$query_other_project_row["cat_des"]." </span>, ";
				
				?>
               
                </span>   
					
					
					<input type="button" value="ORG MAP" class="org_btn" rel="<? echo $re[id];?>">
               
			   </td>
				
            </tr>
            <tr>
            <td>
           
    
Competition:<span style="color:#0000FF"> <?php echo view_cp($cp_row["cp_name"]); ?></span>;   Behavior: <span style="color:#0000FF"> <?php echo view_orgbhv($cp_row["org_behavior"]); ?></span>; Management: <span style="color:#0000FF"> <?php echo view_maneg($cp_row["org_culture"]); ?></span>; Lifecycle: <span style="color:#0000FF"> <?php echo view_lp($cp_row["clp_name"]); ?></span>; 
<!-- Territory: <span style="color:#0000FF"> <?php echo view_terr($cp_row["ter_name"]); ?></span>; -->
 Company type: <span style="color:#0000FF"> <?php echo view_ct($cp_row["c_name"]); ?></span>
 <!-- Annual revenue Tk.<span style="color:#0000FF"><?php echo number_format($cp_row[last_year_amount]); ?></span> -->
 <br />

Company Info: <span style="color:#0000FF">&nbsp;<?php echo $cp_row["arci_p"]; ?></span><br />
Sister Concern:<br> <span style="color:#0000FF">
			<?php
				$collection=null;
				$find_1=find_sister($re["id"]);
	$all_item=implode(",",$collection);

	$sis_sql="select * from project where id in ($all_item) and id!='$re[id]'  $compay_id_sql";
	$sis_q=mysqli_query($db, $sis_sql);
	while($sis_row2=mysqli_fetch_array($sis_q)){	
	?>
			<?php echo trim($sis_row2["pname"],".").", <font color='000'>".view_categories($sis_row2["type"]).";<br> </font>"; ?>
			
	<?php } ?>
				</span>	
<!--Opportunity Profile:<span style="color:#0000FF"><?php echo $cp_row["des"]; ?> ;</span><br>		-->
							
							</td></tr>
<tr><td><div style="width:100%; height:5px;"></div>			<?php
			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			 while($re2=mysqli_fetch_array($sqlrunp2)){
                $contact_no=explode(',',$re2["repphone"]);
				
				$link_person_id=$re2["link_up_other"];				
				if($link_person_id)
				{
					$link_up_sql2="select repname.*,project.pname from repname,project where repname.id='$link_person_id'  and project.id=repname.pid
 					and repname.company_id='$a_company_id' and project.company_id='$a_company_id'
					 order by repname.buyingRole asc";
					$link_up_q2=mysqli_query($db, $link_up_sql2);
					$link_up_row=mysqli_fetch_array($link_up_q2);
					
					//replace with old data				
					$re2["repName"]=$link_up_row["repName"];
					$re2["nationid_no"]=$link_up_row["nationid_no"];
					$re2["bir_date"]=$link_up_row["bir_date"];
					$re2["marriage_date"]=$link_up_row["marriage_date"];
					$re2["personal_details"]=$link_up_row["personal_details"];
				//	$re2[repphone]=$link_up_row[repphone];
				//	$re2[reptelno]=$link_up_row[reptelno];
				//	$re2[repfax]=$link_up_row[repfax];
				//	 $re2[repemail]=$link_up_row[repemail];
					$re2["adpChange"]=$link_up_row["adpChange"];
					$re2["relation"]=$link_up_row["relation"];
					
					$link_up_sql2="select repname.*,project.pname from repname,project where (repname.id='$link_person_id'  or repname.link_up_other='$link_person_id') and project.id=repname.pid and project.id!='$re[id]'
 						and repname.company_id='$a_company_id' and project.company_id='$a_company_id'

					 ";
					$all_other_companie="";
					$link_up_q3=mysqli_query($db, $link_up_sql2);					
					while($link_up_row3=mysqli_fetch_array($link_up_q3))
					{
						$other_companie_name=$link_up_row3["pname"];
						$other_companie_des=$link_up_row3["repdesignation"];
						$all_other_companie.='<tr><td style="padding:0px 5px 0px 25px;"><span style="color:#0000FF">'.$other_companie_des.'; '.$other_companie_name.'</span></td></tr>';
					}
					//end or replace					
					
				}
				else
				{
					$link_up_sql2="select repname.*,project.pname from repname,project where (repname.id='$re2[id]'  or repname.link_up_other='$re2[id]') and project.id=repname.pid and project.id!='$re[id]'
 					and repname.company_id='$a_company_id' and project.company_id='$a_company_id'

					 ";
					$all_other_companie="";
					$link_up_q3=mysqli_query($db, $link_up_sql2);					
					while($link_up_row3=mysqli_fetch_array($link_up_q3))
					{
						$other_companie_name=$link_up_row3["pname"];
						$other_companie_des=$link_up_row3["repdesignation"];
						$all_other_companie.='<tr><td style="padding:0px 5px 0px 25px;"><span style="color:#0000FF">'.$other_companie_des.'; '.$other_companie_name.'</span></td></tr>';
					}
				}
//                echo '<pre>';
//                print_r($contact_no);
                ?>
                
            <tr style="margin:10px 0px;">
                
               
                <td style="padding-left:10px; margin:10px 0px;">
				 <? if($_GET['w']==1)
				{			   
					$sqlcomp="SELECT project.type,cbp.des from cbp,project where cbp.pid='$re[id]' and project.type='".$_GET['type2']."' and cbp.company_id='$a_company_id' and project.company_id='$a_company_id'";
					$sqlqcomp=mysqli_query($db, $sqlcomp);
					$recomp=mysqli_fetch_array($sqlqcomp);
					echo "<strong><font color='#FF0000'>Business Profile:</strong>";
					echo "<i>";
					echo $recomp['des'];
					echo "</i></font>";
					echo "<br>";
				}
				?>

                    <? if($re2[id]){?>
                    <input type="checkbox" name="mcheck<? echo $i;?>" value="<? echo $re2["id"];?>">
                        <? $i++;
                    }

                    echo formated_busines_relationship_person($re2["business_relationship"]);
                    ?>
                    <a href="./<?= $_SESSION["path"] ?>?keyword=selected_address&p=1&id=<? echo $re[id];?>&repid=<? echo $re2[id]; if($link_person_id)echo "&linker_person=1";?>&activities=1" style="text-decoration : none" target="_blank" id="the_repname_link">
                    <? if($re2["repName"])
                        echo /*viewBuyingrole($re2["buyingRole"]).': '.*/$re2["repName"].', '.$re2["repdesignation"];
                    else
                        echo 'Decision Maker';?>;
                    </a>  <? //echo $re2[repaddress1];?> <? //echo $re2[repaddress2];?><? // echo view_city($re2[repcity]);?>
                    <? //echo $re2[reppcode];?>
                    Cell:
                    <? echo $re2['repphone']; ?>; Tel No: <? echo $re2["reptelno"];?>;
                    Email: <? echo $re2["repemail"];?>
					
					<?php
				 	if($re2["visiting_card"]){
						echo '<a href="'.$re2[visiting_card].'" target="_blank"><img width="20" src="./images/vc.png" alt="V.C" Title="Visiting Card"></a>';
					}
				    $updated_at=get_repname_updated_at($re2[id]);
				    if($updated_at[updated_at]){
				    	echo "&nbsp;&nbsp;&nbsp;<small><i>".date("d/m/Y",strtotime($updated_at[updated_at]))."</i></small>";
				    }
				 ?>
                </td>
            </tr>
			<?php if($link_person_id or $all_other_companie) { 
            	echo $all_other_companie;
             }  } ?>
            <tr>
                <td>

                </td>
            </tr>



	</td><td>
							
							

<div style="width:100%; height:5px;"></div>			

ME: <span style="color:#0000FF; font-weight: bold;"><?php echo $me_full_name; ?>,</span>
Customer Segment: <span style="color:#0000FF; font-weight: bold;">
				<?php echo view_b2b($cp_row["cbp_rtb"],"rtb",1); ?>
				<?php echo view_b2b($cp_row["cbp_pros"],"pros",1); ?>
				<?php echo view_b2b($cp_row["cbp_cust"],"cust",1); ?>
				<?php echo view_b2b($cp_row["futb"],"futb",1); ?>
				<?php echo view_b2b($cp_row["cbp_loy_cust"],"loy_cust",1); ?>
				<?php echo view_b2b($cp_row["cbp_pros_part"],"pros_part",1); ?>
				<?php echo view_b2b($cp_row["cbp_dis_c"],"cbp_dis_c",1); ?>
				<?php echo view_b2b($cp_row["cbp_n_b_c"],"cbp_n_b_c",1); ?>
				<?php echo view_b2b($cp_row["cbp_loyal_cust2"],"cbp_loyal_cust2",1); ?>
				<span class="colorRed x2strong"><?php echo view_b2b($cp_row["cbp_exc_part"],"exc_part",1); ?></span>
				
				<?php if($cp_row["com_"]){?>	Our Business associate <?php } ?>
				
				<?php echo view_b2b($cp_row["cbp_ncom_aso"],"ncom_aso",0);



				 ?>;
				
				</span> Marketing target: <span style="color:#0000FF; font-weight: bold;"><?php echo  marketing_target_level($cp_row["project_marketingTarget"]); ?></span>;		
				 <!-- Expected annual purchase Tk.<span style="color:#0000FF; "><?php echo number_format($cp_row["me_offer_amount"]); ?></span> -->
				 <br>	
Opportunity Profile:<span style="color:#0000FF"><?php echo $cp_row["cbp_des"]; ?> ;</span><br>
<!-- Our product/service allows our client organizations to earn profits through: <span style="color:#0000FF"><?php echo clients_profit_multiVal($cp_row["clients_profit"]); ?>;</span> -->
<br>
<div style="width:100%; height:5px;"></div>


            </td>
            </tr>
            <tr>
                
            </tr>
            
            
   
            
            
           

			<tr>
                <? $re2=mysqli_fetch_array($sqlrunp2);?>
                <td style="padding-left:10px;">
                    <!--<? if($re2["id"]){?><input type="checkbox" name="mcheck<? echo $i;?>" value="<? echo $re2["id"];?>"><? $i++; }?>
                    <a href="./index.php?keyword=selected_address&p=1&id=<? echo $re[id];?>&repid=<? echo $re2["id"];?>" style="text-decoration : none" target="_blank">
                    <? if($re2["repName"])echo viewBuyingrole($re2["buyingRole"]).': '.$re2["repName"].', '.$re2["repdesignation"]; else echo 'Decision Maker';?>;</a>
         <? //echo $re2[repaddress1];?><? // echo $re2[repaddress2];?><? //echo view_city($re2[repcity]);?> <? //echo $re2[reppcode];?>
   Cell: <? echo $re2['repphone'];?>; Tel No: <? echo $re2["reptelno"];?>; Email: <? echo $re2["repemail"];?>-->
                <? if($_GET['w']==2)
				{ ?>
			
				<table width="100%" border="1" bordercolor="#999999" style="border-collapse:collapse" align="center">
					
					<tr bgcolor="#CCCCCC">

					<td width="20%" align="center"><strong style="font-size:10px">Agenda</strong></td>
					<td height="16" align="center"><strong style="font-size:10px">Type</strong></td>
					<td width="35%" align="center"><strong style="font-size:10px">
                    <!--<a href="./new_prime_activity.php?pid=<? echo $re[id];?>" target="admin">-->
                    Marketing Activities
                    <!--</a> -->
                    </strong> </td>
					<td width="10%" align="center"><strong style="font-size:10px">Report Date</strong></td>
					<td align="center" width="15%"><strong style="font-size:10px">Activity By</strong></td>
					<td width="10%" align="center"><strong style="font-size:10px">Amount</strong></td>
					</tr>
 
				<? 
				//if($sort=='') $sort='edate';
				//$sql="SELECT *from new_prime_activity where pid='$pid'";
				$sqlpr="SELECT project.pname, new_prime_activity.probability, new_prime_activity.activity, new_prime_activity.agenda_type, new_prime_activity.repname,new_prime_activity.ptype,new_prime_activity.edate, new_prime_activity.fullname,new_prime_activity.amount from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.pid='$re[id]'
 						and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id'
				 order by new_prime_activity.edate DESC";
				 $sqlqpr=mysqli_query($db, $sqlpr);
				while($repr=mysqli_fetch_array($sqlqpr)){?>
				<tr bgcolor="#DDF8FB">
				<!--<td><? echo $repr['pname'];?></td>-->
				<td><? echo $repr['agenda_type'];?></td>
				<td align="center"><? echo view_ptype($repr['ptype']);?></td>
				<td><? echo $repr['activity'];
				
				if($repr['repname'])
							{
								//$sqlp2 = "SELECT repname.repdesignation,repname.buyingRole from repname,new_prime_activity WHERE new_prime_activity.repname=repname.repName and repname.pid=new_prime_activity.pid";
								$sqlp2 = "SELECT repname.repdesignation,repname.buyingRole from repname,new_prime_activity WHERE repname.repName='".$repr['repname']."'
 						and repname.company_id='$a_company_id' and new_prime_activity.company_id='$a_company_id'";
								$sqlrunp2= mysqli_query($db, $sqlp2);
								while($row=mysqli_fetch_array($sqlrunp2))
								{	
									$deg=$row['repdesignation'];
									$buyingRole=viewBuyingrole($row['buyingRole']);
								}
								echo "<br>";
								echo "<font color='#FF0000'>";
								echo $repr['repname'];
								echo ", ";
								echo $deg; echo ", ";
								// echo $buyingRole;
								//echo "; <br> ";
								echo "</font>";
								
							}
				?></td>
				<td align="center"><? echo date("d-m-Y", strtotime($repr['edate']));?></td>
				<td align="center"><?php echo $repr['fullname'];?></td>

				<td><div align="right"><? echo number_format($repr["amount"]);?></div></td>
				<!--<td>&nbsp;</td>-->
				</tr>

				<? } //while re
				$q="select SUM(amount) as total from new_prime_activity where pid='$re[id]' $compay_id_sql";
				$r=mysqli_query($db, $q);
				while($row1=mysqli_fetch_array($r))
				$total=$row1["total"];

				?>
				<tr><td colspan="5"><div align="right"><strong>Total</strong></div></td>
				   <td><div align="right"><?php echo number_format($total);?></div></td>
				  
				  </tr>
				</table><br />

				<? }?>
				</td>
           </tr>
            <tr><td colspan="0" bgcolor="#FFCECE" height="0"></td></tr>
            <?
        }//end of if?> 
        
        
        
        
        <!--organization map!-->
        
        
        
        <?php
		if($org_map=="1" || $org_map_id==$re["id"])
		{
		?>        
	 
     <tr>
            	<td>
              
<table align="center" width="100%">                
    <tr>
        <td height="25" align="center"><font class="englishheadBlack">Position Hierarchy</font></td>
    </tr>   
</table>          
     
     <!-- Opinion Leader-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='0'";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){
	if($org["link_up_other"]){
		$root_person_info=retrive_root_person_info($org["id"]);
		$org['repName']=$root_person_info['repName'];
		$org['image']=$root_person_info['image'];
		$org['adpChange']=$root_person_info['adpChange'];
	} ?>
<div class="user" style="height:205px; width:, 7)px;padding:2px; z-index:0; overflow:hidden;">

<table width="228px">
<tr>
<td align="left">

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#0000FF"><?php if($org["political"])echo viewPolitical($org["political"]);?></span><br>
<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo $info_associates["repName"]."<br>";
									 }
									?></span>
</div>

</td>



<td width="128" align="right">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

</td>
</tr>
</table>


<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span> -->
<!-- <br>Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->

</div>
<div class="blank"></div>
<?php }?>

</td>
</tr></table>   

     
                
<!--    Approver-->            
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center">
<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='1' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>

<div class="opinionleader" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">

<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>

<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span> -->
<!-- <br>Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->

</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
</table>          
                
   
   
    <!--Decision Maker-->            
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center">
<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='2' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div  class="approver" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">

<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#0000FF"><?php if($org["political"])echo viewPolitical($org["political"]);?></span><br>
<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo $info_associates["repName"]."<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span> -->
<!-- <br>Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->

</div>
<div class="blank"></div>
<?php }?>

</td>
</tr></table>          
                



<!--Evaluator-->                
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php
$sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='3' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="decisionMaker" style="height:205px; width:, 7)px;padding:2px; z-index:0; overflow:hidden;">


<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span> -->
<!-- <br>Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->

</div>
<div class="blank"></div>
<?php }?>

</td>
</tr></table>          
                
<!-- User-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='4' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){
	if($org["link_up_other"]){
		$root_person_info=retrive_root_person_info($org["id"]);
		$org['repName']=$root_person_info['repName'];
		$org['image']=$root_person_info['image'];
		$org['adpChange']=$root_person_info['adpChange'];
	} ?>
<div class="evaluator" style="height:205px; width:, 7)px;padding:2px; z-index:0; overflow:hidden;">


<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span> -->
<!-- <br>Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->

</div>
<div class="blank"></div>
<?php }?>

</td>
</tr></table>          
                

    
                
<!-- 5-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='5' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">


<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>       
                

    
                
<!-- 6-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='6' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">


<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>       
                

    
                
<!-- 7-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='7' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">


<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>       
                

    
                
<!-- 8-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='8' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">

<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>       
                

    
                
<!-- 9-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='9' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">

<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>

  
                
<!-- 10-->               
<table align="center" class="center_org_map" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
<tr><td align="center" >

<?php $sql="SELECT  * from repname where pid='$re[id]' AND buyingRole='10' $compay_id_sql";
$sqlq=mysqli_query($db, $sql);
while($org=mysqli_fetch_array($sqlq)){?>
<div class="lobbyist" style="height:205px; width:128px;padding:2px; z-index:0; overflow:hidden;">

<table width="128px">
<tr>



<td width="128" align="center">

<div style="width:107px; height:131px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$org['image'] .'" width="107"  height="125" style=" border:3px #fff solid;"  />'; ?>
</div>

<div style="width:120px; height:136px">
<span style="color:#0000FF; font-size:10px"><b><?php echo $org['repName'];?></b></span><br>
<b style="font-size:10px"><?php echo $org['repdesignation'];?></b>

	<div style="height: 8px;"></div>

<span style="color:#000000"><?php 									 
									 $assoca_arr=explode(",",$org["associates"]);
									 foreach($assoca_arr as $assoca){
										$info_associates=viewPolitical_associates($assoca);
										echo "<br>";
									 }
									?></span>
</div>
</td>
</tr>
</table>
<br />

<!-- Buying Role:&nbsp;<span style="color:#0000FF"><?php echo viewBuyingrole($org["buyingRole"]);?></span><br> -->
<!-- Personality:&nbsp;<span style="color:#0000FF"><?php echo exploder_personality($org["adpChange"]);?></span> -->
<!--<br><b>Coverage:</b> <?php echo viewCoverage($org["coverage"]);?>-->
<!-- <br>Relation:&nbsp;<span style="color:#0000FF"><?php echo viewRelation($org["relation"]);?></span> -->
</div>
<div class="blank"></div>
<?php }?>

</td>
</tr>
<tr bgcolor="#CCCCCC"><td height="5"></td></tr>
</table>



<table align="center" width="100%" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">  
	<tr bgcolor="#CCCCCC"><td height="15"></td></tr>
</table>




</td>
            </tr>
  <!--end of organization map-->    
     
     <?
		}//end of org condition
	 
	 }//while
    if(!$type2)
		break;
	}//while type ?>
    