<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Job Assignment content value." />
  <meta name="keywords" content="Job,Assignment,File" />
  <meta name="author" content="xxxxxx xxxxx"  />
  <title>Job Assignment 01 - Search Job</title>
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
        <section id="searchJob">
<?php
require_once  'io.php';
require_once  'jobfile.php';
require_once  'job.php';

// List all of the post inputs
$lTitle = $_GET["title"];
$lPositionType = @$_GET["positionType"];
$lContractType = @$_GET["contractType"];
$lContactMethod = @$_GET["contactMethod"];
$lStateAddress = $_GET["stateAddress"];

// Check if main value has been set
if (isset($lTitle))
{
    // Add the input values to a Job Object
    // if no value has been set for the optional parameters 
    // just put in placeholder values to allow for passing of validation check
    // internally of SearchJob the required parameters will be selected
    $lJobSearch = new Job(
        "search_mode_ignore",
        $lTitle,
        "search_mode_ignore",
        date("d-m-Y"),
        isset($lPositionType) ? $lPositionType : "IGNORE", 
        isset($lContractType) ? $lContractType : "IGNORE",
        isset($lContactMethod) ? $lContactMethod : "IGNORE",
        !empty($lStateAddress) ? $lStateAddress : "IGNORE"
    );
    
    // Get database text file and search for given Job object
    $lJobStorage = new JobFile("../../data/jobposts/job.txt");
    $lData = $lJobStorage->SearchJob($lJobSearch); 

    if (is_array($lData))
    {
        // Display data in table (sort by date most furthest)
        usort($lData, "IO::DateSortRecent");

        echo "<h2>Search Job Results</h2>";
        echo "<table>\n <thead>\n";
        echo "<tr>\n"
            ."<th scope=\"col\">ID</th>\n"
            ."<th scope=\"col\">Title</th>\n"
            ."<th scope=\"col\">Description</th>\n"
            ."<th scope=\"col\">Closing Date</th>\n"
            ."<th scope=\"col\">Postion</th>\n"
            ."<th scope=\"col\">Contract</th>\n"
            ."<th scope=\"col\">Application By</th>\n"
            ."<th scope=\"col\">State</th>\n"
            ."</tr>\n </thead> \n <tbody> ";
        foreach($lData as $lJob)
        {
            echo "<tr>\n";
            echo "<td>",$lJob[0],"</td>\n";
            echo "<td>",$lJob[1],"</td>\n";
            echo "<td>",$lJob[2],"</td>\n";
            echo "<td>",$lJob[3],"</td>\n";
            echo "<td>",$lJob[4],"</td>\n";
            echo "<td>",$lJob[5],"</td>\n";
            echo "<td>",$lJob[6]." ".$lJob[7],"</td>\n";
            echo "<td>",$lJob[8],"</td>\n";
            echo "</tr>\n";
        }   
        echo "</tbody></table>\n";
    }
    else
    {
        echo IO::DecodeMsg($lData);  
    }
    
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