
<?php

// pass by input form
function check($domain,$server,$findText){
  // make anothe function to checkDomain
  if (checkDomain($domain,$server,$findText)){
    print "<h1 class='display-5'>$domain.  Domain is available</h>";
  }else {
    //If not available redirect after 2 sec
    sleep(2);
    header('Location: https://www.whois.com/whois/'.$domain);
  }
}

// data is transferred from the check() fun
function checkDomain($domain,$server,$findText){

//Open Internet or Unix domain socket connection
  $connection = fsockopen($server, 43);
  if (!$connection)
   {return false;}

  fwrite($connection, $domain."\r\n");
  $response = ':';

//Tests for end-of-file on a file pointer.
    while(!feof($connection)) {
      $response .= fgets($connection,128);
    }
//The file pointed to by handle is closed.
  fclose($connection);
// "The string '$findText' was /not/ found in the string '$response'"
  if (strpos($response, $findText)){
    return true;
  }else {
    return false;
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- <link rel="stylesheet" href="master.css"> -->
    <!-- Bootstrap CND -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  </head>
  <body>
    <style media="screen">
    /* element{
      --main-color:#DDD;
    } */
    body{
      align:center;
      background-color: #DDD;
      /* background-color: var(--main-color); */
    }
    form {
    margin:auto;
    width:50vw;
    text-align: center;
    }
    .jumbotron{
      background-color: #DDD;
      /* background-color: var(--main-color); */
      padding-top: 15vh;
      margin: auto;
      min-width: 30vw;
    }
    .form-control{
      min-width: 30vw;
    }

    </style>
    <div class="sectiona">
  <div class="jumbotron">
    <h1 class='display-3' align="center">Domain Check Test</h1>
    <!-- variable that returns the current script being executed
          avoid the PHP_SELF exploits using  htmlentities() function -->
    <form action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="post" name="domain" id="form">
          <div class="input-group mb-3">
      <input name="name" type="text" class="form-control" placeholder="Domain" aria-label="Recipient's username" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" name="button" value="Check domain" >Button</button>
      </div>
      </div>
      <input type="checkbox" class="form-check-input" id="dropdownCheck2" name="dot" checked>
      <label class="form-check-label" for="dropdownCheck2">
        .com
      </label>
</div>

<div class="jumbotron">
  <div class="container" align="center">
    <!-- one part of the script is located here for easier manipulation -->
    <?php
    //by pressing the button in input if statament checks to see if the name is not empty string then pass a value to $domainbase
        if (isset($_POST['button'])){
          if (isset($_POST['name'])) {
            $domainbase = $_POST['name'];
          } else {
            $domainbase = '';
          }
    // if statament checks if the box is checked
          if ((isset($_POST['dot']))) {
            $d_dot = 'com';
          }else{
            $d_dot = '';
          }
    // string has to be min length of one
        if (strlen($domainbase)>1){
        print '<table>';
        if ($d_dot !='')
    // function pasing parameters
        check($domainbase.".com",'whois.crsnic.net','No match for');
          print '</table>';
          }
        } ?>
  </div>
</div>
  </div>
  </body>
</html>
