<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Job Assignment content value." />
  <meta name="keywords" content="Job,Assignment,File" />
  <meta name="author" content="xxxxxx xxxxx"  />
  <title>Job Assignment 01 - Post Job</title>
  <!-- Stylesheets  -->
  <link href="styles/style.css" rel="stylesheet"/>
</head>
<body>
    <!-- Page Title & Navigation links-->
    <header>
        <?php include ("header.inc");?>
        <nav>
            <?php include ("menu.inc");?>
        </nav>
    </header>
    <hr/>
    <article>
    <h2>
                Post Job
        </h2>
        <!-- Section Form-->
        <section id="formSection">
            <!-- Start of form submission system -->
            <form method="post" action="postjobprocess.php">
                <!-- Client Details -->        
                <fieldset id="fieldDetail"> 
                    <legend>Details</legend>
                    <p class="row">
                        <label for="positionId">Position ID:</label>
                        <input type="text" name="positionId" id="positionId" pattern="^P{1}\d{4}$"  required="required"/>
                    </p>
                    <p class="row">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" pattern="^[A-Za-z0-9 .,!]{1,20}$"  required="required"/>
                    </p>
                    <p class="row">
                        <label for="description">Description:</label>
                        <input type="text" name="description" id="description" required="required"/>
                    </p>
                    <p class="row">
                        <label for="closeDate">Closing Date:</label>
                        <input type="text" value="<?php echo date("d/m/Y")?>" name="closeDate" id="closeDate" pattern="^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$"  required="required"/>
                    </p>              
                </fieldset>
                <!-- Option detail-->
                <fieldset id="fieldOption">
                    <legend>Options</legend>
                    <p class="row"> 
                        Position:
                        <input type="radio" name="positionType" id="positionFullTime" value="FullTime" required="required"/>
                        <label for="positionFullTime">Full Time</label>
                        <input type="radio" name="positionType" id="positionPartTime" value="PartTime" />
                        <label for="positionPartTime">Part Time</label>
                    </p>
                    <p class="row"> 
                        Contract:
                        <input type="radio" name="contractType" id="contractOnGoing" value="Ongoing" required="required"/>
                        <label for="contractOnGoing">On-going</label>
                        <input type="radio" name="contractType" id="contractFixed" value="Fixed"/>
                        <label for="contractFixed">Fixed Term</label>
                    </p>
                    <p class="row"> 
                        Application By:
                        <label><input type="checkbox" name="contactMethod[]"  value="Post" checked="checked"/>Post</label>
                        <label><input type="checkbox" name="contactMethod[]"  value="Mail"/>Mail</label>
                    </p>
                    <p class="row">  
                        <label for="stateAddress">Location:</label>
                        <select name="stateAddress" id="stateAddress" required="required">
                            <option value="" selected="selected">---</option> 
                            <option value="VIC">VIC</option>
                            <option value="NSW">NSW</option>
                            <option value="QLD">QLD</option>
                            <option value="NT">NT</option>
                            <option value="WA">WA</option>
                            <option value="SA">SA</option>
                            <option value="TAS">TAS</option>
                            <option value="ACT">ACT</option>
                        </select>
                    </p>     
                </fieldset>
                <!-- Submit & Reset buttons-->
                <input type="submit" value="Post"/>
                <input type="reset" value="Reset" />
            </form>  
        </section>
    </article>    
    <!-- Footer section --> 
    <footer>
        <?php include ("footer.inc");?>
    </footer>
</body>
</html>