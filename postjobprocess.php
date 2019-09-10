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
        <!-- Section Post Job Message Process-->
        <section id="postJobCompleteMsg">
<?php
require_once  'io.php';
require_once  'jobfile.php';
require_once  'job.php';

// List all of the post inputs
$lPositionId = $_POST["positionId"];
$lTitle = $_POST["title"];
$lDescription = $_POST["description"];
$lCloseDate = $_POST["closeDate"];
$lContractType = @$_POST["contractType"];
$lPositionType = @$_POST["positionType"];
$lContactMethod = @$_POST["contactMethod"];
$lStateAddress = $_POST["stateAddress"];

// Check if any of them have been set
if (isset($lPositionId,$lTitle,$lDescription,$lCloseDate,$lPositionType,$lContractType,$lContactMethod,$lStateAddress))
{
    // Add the input values to a Job Object
    $lJobPost = new Job(
        $lPositionId,
        $lTitle,
        $lDescription,
        $lCloseDate,
        $lPositionType, 
        $lContractType,
        $lContactMethod,
        $lStateAddress
    );

    // Create a JobFile and add a job, validate the Job Object
    // If job object good, add the job object to the file   
    $lJobStorage = new JobFile("../../data/jobposts/job.txt");
    $lStatus = $lJobStorage->AddJob($lJobPost); 

    echo IO::DecodeMsg($lStatus);  
}
else 
{
    echo IO::DecodeMsg(REQUIRED_INPUT_VALUE_NOT_SET);
}
?>

</section>
    </article>    
    <!-- Footer section --> 
    <footer>
        <?php include ("footer.inc");?>
    </footer>
</body>
</html>