<?php
require_once("env.php");
?>

<link rel="stylesheet" href="form.css">

<form action="present.php">

  <header>
    <h2><img src="/img/lumerit.png" width="175px" />&nbsp;&nbsp; Central Academic Research Database&nbsp;(C.A.R.D.)</h2>
    <div>Note:  This is a proof of concept stage product.</div>
  </header>

    <div>
        <label class="desc" id="uid" for="uid">Student's UID</label>
        <div>
            <input id="uid" name="uid" type="text" class="field text fn" value="" size="8" tabindex="1">
        </div>
    </div>

  <div>
    <label class="desc" id="name" for="name">Student's Full Name</label>
    <div>
      <input id="name" name="name" type="text" class="field text fn" value="" size="8" tabindex="2">
    </div>
  </div>

  <div>
    <label class="desc" id="email" for="email">Student's Email
    </label>
    <div>
      <input id="email" name="email" type="email" spellcheck="false" value="" maxlength="255" tabindex="3">
   </div>
  </div>

    <div>
        <label class="desc" id="state" for="state">Student's State of Residence
        </label>
        <div>
            <input id="state" name="state" type="state" spellcheck="false" value="" maxlength="255" tabindex="4">
        </div>
    </div>

    <div>
        <label class="desc" id="counselor" for="counselor">Counselor's Full Name</label>
        <div>
            <input id="name" name="counselor" type="text" class="field text fn" value="" size="8" tabindex="5">
        </div>
    </div>

  <div>
    <label class="desc" id="message" for="message">Custom Message</label>
    <div>
      <textarea id="message" name="message" spellcheck="true" rows="10" cols="50" tabindex="6"></textarea>
    </div>
  </div>

    <div>
        <label class="desc" id="tuition_assist" for="tuition_assist">Potential Tuition Assistance</label>
        <div>
            <input id="name" name="tuition_assist" type="number" class="field text fn" value="" size="8" tabindex="7">
        </div>
    </div>

    <div><hr><sgrong>Degree Options:</sgrong><br></div>


<hr>
    <div>
        <label class="desc" id="credits1" for="credits1">Transfer Credits
        </label>
        <div>
            <input id="credits" name="credits1" type="number" spellcheck="false" value="" size="5" maxlength="8" tabindex="8">
        </div>
    </div>

    <div>
        <label class="desc" id="gdc_tuition1" for="gdc_tuition1">GDC Tuition
        </label>
        <div>
            <input id="gdc_tuition1" name="gdc_tuition1" type="number" spellcheck="false" value="225" size="5" maxlength="8" tabindex="9">
        </div>
    </div>

    <div>
    <label class="desc" id="modality1" for="modality1"></label>
    <div>
    <select id="modality1" name="modality1" class="field select medium" tabindex="10">
      <option value="">--Modality--</option>
      <option value="online">Online</option>
      <option value="oncampus">On Campus</option>
    </select>
    </div>
    </div>

    <div>
        <label class="desc" id="degree1" for="degree1"></label>
        <div>
            <select id="degree1" name="degree1" class="field select medium" tabindex="11">
                <option value="">-- Degree --</option>
                <?php
                    $sql1 = "SELECT DISTINCT degree_type
                             FROM directory 
                             WHERE degree_type <> ''
                             ORDER BY degree_type";
                    $res1 = mysql_query($sql1,$link);
                    //echo $sql1;
                    if(mysql_num_rows($res1))
                    {
                        while($row1=mysql_fetch_array($res1))
                        {
                            $degree_type = $row1['degree_type'];
                            echo "<option value='$degree_type'>".$degree_type."</option>";
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div>
        <label class="desc" id="major1" for="major1"></label>
        <div>
            <select id="major1" name="major1" class="field select medium" tabindex="12">
                <option value="">-- Major + Concentration --</option>
                <?php
                $sql1 = "SELECT DISTINCT degree_major, concentration
                             FROM directory 
                             WHERE degree_major <> '' 
                             ORDER BY degree_major, concentration";
                $res1 = mysql_query($sql1,$link);
                //echo $sql1;
                if(mysql_num_rows($res1))
                {
                    while($row1=mysql_fetch_array($res1))
                    {
                        $degree_major = $row1['degree_major'];
                        $concentration = $row1['concentration'];
                        $value = $degree_major." | ".$concentration;
                        echo "<option value='$value'>".$value."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div>
        <label class="desc" id="school1" for="school1"></label>
        <div>
            <select id="school1" name="school1" class="field select medium" tabindex="13">
                <option value="">-- Institution Name --</option>
                <?php
                $sql1 = "SELECT DISTINCT id, institution_name
                         FROM directory WHERE institution_name <> '' 
                         ORDER BY institution_name";
                $res1 = mysql_query($sql1,$link);
                //echo $sql1;
                if(mysql_num_rows($res1))
                {
                    while($row1=mysql_fetch_array($res1))
                    {
                        $institution_name = $row1['institution_name'];
                        $ins_id = $row1['id'];
                        echo "<option value='$ins_id'>".$institution_name."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    TODO: Make the Modality, Degree, Major/Concentration, Institution filter each other based on choices<br>
    TODO:  Need to put in a loop to create area to input 3 to 6 options.
<hr>

    <div>
  		<input id="saveForm" name="saveForm" type="submit" value="Submit">
    </div>
    </div>

</form>





