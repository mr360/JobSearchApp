<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Job Assignment content value." />
  <meta name="keywords" content="Job,Assignment,File" />
  <meta name="author" content="xxxxxx xxxxx"  />
  <title>Job Assignment 01 - About</title>
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
        <!-- Section Introduction-->
        <section id="aboutSection">
            <h2>About</h2>
            <p>List of Answers: </p>
            <ul>
                <?php
                echo "<li> Current PHP version: ".phpversion()."</li>"
                ?>
                <li>All tasks completed and all pages HTML5 validated </li>
                <li>Special Features : Used OO design and some CSS styling </li>
                <li>Discussion Points : The questions were already answered. I didn't want to put up an answer that was out-of-date/incorrect/bad-practice as that would not have been ethically right. So I decided to not participate.</li>          
            </ul>
        </section>
    </article>    
    <!-- Footer section --> 
    <footer>
        <?php include ("footer.inc");?>
    </footer>
</body>
</html>