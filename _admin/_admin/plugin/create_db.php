<!DOCTYPE html>

<html>

<head>
  <title>Admin Create Databases</title>

<style>
  <!--
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');

*
  {
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  }

.container
  {
  width: 100%;
  max-width: 1200px;
  margin: 1rem auto;
  }

SPAN
  {
  background: yellow;
  color: hotpink;
  font-weight: bold;
  }

I
  {
  font-style: normal;
  font-weight: bold;
  color: rgba(25, 148, 58, 1);
  }

.errorpanel
  {
  position: fixed;
  top: 0;
  right: 2rem;
  padding: 0.25rem 1rem;
  border: 1px solid rgba(0, 0, 0, 0.3);
  border-top: none;
  }

  -->
</style>
</head>

<body>
  <div class="container">
<?php
$errors = 0;

  // Datenbank öffnen
  include_once("../../_cd/config.php");
  $database = "admintest";
  ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

include_once("_sections.php");

foreach($arr_adminsections AS $this_section)
  {
  $parts_section = explode("|", $this_section);
  $this_sectionname = $parts_section[0];
  $this_sectionfile = "_plugin_" . $parts_section[1] . ".php";

  echo "<br><b>Section: " . $this_sectionname . " (Includefile: " . $this_sectionfile . ")</b>";

  $pop_sql = "";
  @include_once($this_sectionfile);

  if($pop_sql != "")
    {
    echo "<br>SQL: <i>OK</i><br>";
    }
  else
    {
    $errors++;
    echo "<br><span>No SQL provided</span><br>";
    }

// set no execution
$foo = mysqli_query($GLOBALS["___mysqli_ston"], "set noexec on") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    if ($result = mysqli_query($GLOBALS["___mysqli_ston"], prepare($pop_sql)))
      {
      echo "Query: <i>successful</i><br><br>";
      }
    else
      {
      echo "<br><span>Error executing query - " . mysqli_error($GLOBALS["___mysqli_ston"]) . "</span><br><br>";
      $errors++;
      }

  }
// turn execution back on
$foo = mysqli_query($GLOBALS["___mysqli_ston"], "set noexec off") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
?>
  </div>
<div class="errorpanel"><?php echo $errors; ?> Error(s)</div>
</body>
</html>