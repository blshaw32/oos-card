<?php
require_once("env.php");

$uid = $_REQUEST['uid'];
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$student_state = $_REQUEST['state'];
$counselor = $_REQUEST['counselor'];
$message = $_REQUEST['message'];
$tuition_assist = $_REQUEST['tuition_assist'];

//TODO need to put form fields in array so 3 to 6 degree options can be chosen at same time
$credits1 = $_REQUEST['credits1'];
$gdc_tuition1 = $_REQUEST['gdc_tuition1'];
$modality1 = $_REQUEST['modality1'];
$degree1 = $_REQUEST['degree1'];
$major1 = $_REQUEST['major1'];
$school1 = $_REQUEST['school1'];

/*
echo $uid."<BR>";
echo $name."<BR>";
echo $email."<BR>";
echo $student_state."<BR>";
echo $counselor."<BR>";
echo $message."<BR>";
echo $tuition_assist."<BR>";

echo $credits1."<BR>";
echo $gdc_tuition1."<BR>";
echo $modality1."<BR>";
echo $degree1."<BR>";
echo $major1."<BR>";
echo $school1."<BR>";
*/

$row_begin = "<table>\n";
$row0 = "<tr><td>&nbsp;</td>\n";
$row1 = "<tr><td>Degree Program:</td>\n";
$row2 = "<tr><td>Tuition Per Credit:</td>\n";
$row3 = "<tr><td>Book Costs & Fees Per Credit:</td>\n";
$row4 = "<tr><td>Cost Per Credit:</td>\n";
$row5 = "<tr><td>Transfer Credit Accepted:</td>\n";
$row6 = "<tr><td>Online/Campus/Hybrid:</td>\n";
$row7 = "<tr><td>Total Cost of Degree:<br><span style='font-size: smaller;'>(without Lumerit)</span></td>\n";
$row8 = "<tr><td>Potential Savings Through<br>Global Digital Classroom:</td>\n";
$row9 = "<tr><td>Total Cost of Degree<br><span style='font-size: smaller;'>(with Lumerit)</span></td>\n";
if($tuition_assist) { $row10 = "<tr><td>Potential Tuition Assistance<br><span style='font-size: smaller;'>".number_format($tuition_assist,0,'.',',')."</span></td>\n"; } else { $row10 = ''; }
$row11 = "<tr><td>Time to Completion in Years<br><span style='font-size: smaller;'>(at 30 credits per year/full-time pace)</span></td>\n";
$row_end = "</table>\n";


$columns = 0;  //should run through the loop 1 time until all arrays are setup properly.
for($i=0;$i<=$columns;$i++)
{

    $sql = "SELECT DISTINCT id, ipeds_id, institution_name, state, home_page, degree_type, degree_major, concentration,
              credits_in_degree, possible_gdc_credits, calendar_type, 
              campus_major, books_per_credit, reputation, 
              first_time_ft_credit_in_state_campus as oncampus_in_state, first_time_ft_credit_out_state_campus as oncampus_out_state, 
              first_time_ft_credit_fees_in_state_campus as oncampus_fee_in_state, first_time_ft_credit_fees_out_state_campus as oncampus_fee_out_state,
              first_time_ft_credit_in_state_online as online_in_state, first_time_ft_credit_out_state_online as online_out_state,
              first_time_ft_credit_fees_in_state_online as online_fee_in_state, first_time_ft_credit_fees_out_state_online as online_fee_out_state
            FROM directory 
            WHERE id = $school1";
    $res = mysql_query($sql);
    //echo $sql;
    if(mysql_num_rows($res))
    {
        $r = mysql_fetch_array($res);
        $ipeds_id = $r['ipeds_id'];
        $institution_name = $r['institution_name'];
        $ins_state = $r['state'];
        $home_page = $r['home_page'];
        $degree_type = $r['degree_type'];
        $degree_major = $r['degree_major'];
        $concentration = $r['concentration'];
        $credits_in_degree = $r['credits_in_degree'];
        $possible_gdc_credits = $r['possible_gdc_credits'];
        $calendar_type = $r['calendar_type'];
        $campus_major = $r['campus_major'];
        $book_fee = str_replace("$","",$r['books_per_credit']);
        $reputation = $r['reputation'];
        $oncampus_in_state = str_replace("$","",$r['oncampus_in_state']);
        $oncampus_out_state = str_replace("$","",$r['oncampus_out_state']);
        $oncampus_fee_in_state = str_replace("$","",$r['oncampus_fee_in_state']);
        $oncampus_fee_out_state = str_replace("$","",$r['oncampus_fee_out_state']);
        $online_in_state = str_replace("$","",$r['online_in_state']);
        $online_out_state = str_replace("$","",$r['online_out_state']);
        $online_fee_in_state = str_replace("$","",$r['online_fee_in_state']);
        $online_fee_out_state = str_replace("$","",$r['online_fee_out_state']);

        //check if student state matches college state for in/out of state rates
               switch($modality1)
                {
                   case "online":
                       if($student_state==$ins_state)
                       {
                           $fees = $online_fee_in_state;
                           $tuition = $online_in_state;
                       } else {
                           $fees = $oncampus_fee_out_state;
                           $tuition = $oncampus_out_state;
                       }
                        break;
                   case "oncampus":
                       if($student_state==$ins_state)
                       {
                           $fees = $oncampus_fee_in_state;
                           $tuition = $oncampus_in_state;
                       } else {
                           $fees = $oncampus_fee_out_state;
                           $tuition = $oncampus_out_state;
                       }
                        break;
                }

        $row0 .= "<td><img src='//logo.clearbit.com/".$home_page."?size=120'><br>".$institution_name."</td></tr>\n";
        //degree program
            $row1 .= "<td>".$degree_major."</td><\n";
        //Tuition Per Credit:
            $row2 .= "<td>".$tuition."</td>\n";
        //Book Costs & Fees Per Credit:
            $tot_fees = $book_fee+$fees;
            $row3 .= "<td>".$tot_fees."</td>\n";
        //Cost Per Credit:
            $tot_cost_credit = $tot_fees+$tuition;
            $row4 .= "<td>".$tot_cost_credit."</td>\n";
        //Transfer Credit Accepted:
            $row5 .= "<td>".$credits1."</td>n";
        //Online/Campus/Hybrid:
            $row6 .= "<td>".$modality1."</td>\n";
        //Total Cost of Degree:
            $credits_left = $credits_in_degree-$credits1;
            $tot_cost_no_lumerit = $tot_cost_credit*$credits_left;
            $row7 .= "<td>".number_format($tot_cost_no_lumerit,0,".",",")."</td>\n";
        //Potential Savings Through GDC
            $gdc_cost = ($possible_gdc_credits-$credits1)*$gdc_tuition1;
            $new_tot_cost = ($credits_left-$possible_gdc_credits)*$tot_cost_credit;
            $gdc_savings = $tot_cost_no_lumerit - ($gdc_cost+$new_tot_cost);
            $row8 .= "<td>".number_format($gdc_savings,0,'.',',')."</td>\n";
        //Total Cost of Degree
            $tot_cost_of_degree_with_lumerit = $tot_cost_no_lumerit - $gdc_savings;
            $row9 .= "<td>".number_format($tot_cost_of_degree_with_lumerit,0,'.',',')."</td>\n";
        //Tuition Assistance
            if($tuition_assist)
            {
                $overall_cost_with_tuition_assist = $tot_cost_of_degree_with_lumerit - $tuition_assist;
                $row10 .= "<td>".number_format($overall_cost_with_tuition_assist,0,'.',',')."</td>\n";

            }
        //Time to Completion in Years
            $row11 .= "<td>4 years</td>\n";


    }
}

echo "<link rel='stylesheet' href='form.css'>";

echo "<header>";
echo "<h2>Hello ".$name."</h2>";
echo "<div>".$message."</div>";
echo "<div>".$counselor."</div>";
echo "</header>\n";

echo $row_begin."\n";
echo $row0."</tr>\n";
echo $row1."</tr>\n";
echo $row2."</tr>\n";
echo $row3."</tr>\n";
echo $row4."</tr>\n";
echo $row5."</tr>\n";
echo $row6."</tr>\n";
echo $row7."</tr>\n";
echo $row8."</tr>\n";
echo $row9."</tr>\n";
echo $row10."</tr>\n";
echo $row11."</tr>\n";
echo $row_end."\n";


?>









