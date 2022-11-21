


<?php 
require_once('../constant/initialize.php');
session_start();

//echo $_SESSION['userId'];

if(!$_SESSION['userId']) {
	header('location:./login.php');	
} 



?>
 



  
  <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">QR-Code Builders</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">QR-Code Builders</li>
                    </ol>
                </div>
            </div>
            
    <div class="container py-4">
    <div class="row">
    <div class="col-lg-8">
    
    
    <?php
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'easymenu.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 8;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    $getu=mysqli_query($connect, "SELECT userId FROM payuser WHERE userId='$_SESSION[userId]'");
    $qr=mysqli_fetch_array($getu);
    $userId=$qr['userId'];
    
        //default data
       
        QRcode::png("http://www.localhost/vxi6/shopping/home.php?userId=$userId", $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; 
    echo '<a href="'.$PNG_WEB_DIR.basename($filename).'" download="'.$PNG_WEB_DIR.basename($filename).'" class="btn btn-success">Download</a>'; 
    
    //config form
    echo '<form action="scann.php" method="post">
    <div class="py-3">
        <input name="data" class="form-control" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'http://aboveloungemenu.com.ng').'" readonly type="hidden" />&nbsp;
        </div>
       
            ECC:&nbsp;<select name="level" class="form-control">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
            
            </select>&nbsp;
            <div class="py-3">
        Size:&nbsp;<select name="size" class="form-control">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>&nbsp; </div><div class="py-2">
        <input type="submit" value="GENERATE" class="btn btn-primary></form><hr/>';
        
    // benchmark
    echo'</div> <div class="py-5">';
   
    echo'</div>';  
    ?>
    </div>
    </div> 
    </div> 
    </div> 
    </div> 
    </div> 


    <style>
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #3a4651;
  color: white;
  text-align: center;
}

</style>
             <?php
             include('../constant/layout/footer.php');
             include './social_link.php'; 
             ?>
            
<script>
function alphaOnly(event) {
  var key = event.keyCode;
  return ((key >= 65 && key <= 90) || key == 8);
};
                                        </script>
                                        <script>
    // WRITE THE VALIDATION SCRIPT.
    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
    }    
</script>







    