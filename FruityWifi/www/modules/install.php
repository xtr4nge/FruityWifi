<?
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["moduke"], "../msg.php", $regex_extra);
}

$module = $_GET['module'];
?>
<meta http-equiv="refresh" content="1; url=install.php?module=<?=$module?>">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="../style.css" />

<div class="rounded-top" align="left"> &nbsp; <b>Installing...</b> </div>

    <textarea id="inject" name="newdata" class="module-content" style="font-family: courier;">
    <?

    $filename = "../logs/install.txt";

    $data = open_file($filename);

    $data_array = explode("\n", $data);
    $data = array_reverse($data_array);
    //$data = implode("<br>",array_reverse($data_array));

    //echo htmlentities($data);

    for ($i=0; $i < count($data); $i++) {
        echo $data[$i] . "\n";
        if ($data[$i] == "..DONE..") {
            $go_to_module = "True";
        }
    }
    ?>

    </textarea>

    <?
    if ($go_to_module == "True") echo "<script>window.location = './$module';</script>";
    ?>
    
</div>