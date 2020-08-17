<!Doctype html>
<html>
<?php
    if(isset($_POST["usrInp"])){
        $filename = fopen("tstText.txt","w")  or die("Unable to open file!");
        $outputstring = $_POST["usrInp"];
        fwrite($filename, $outputstring);
        fclose($filename);
        exec("python txtSummary.py");

        $outfilename = fopen("output.txt", "r") or die("Unable to open file!");
        $res = fread($outfilename, filesize('output.txt'));
        fclose($outfilename);
    }  
?>
<head>
    <title>Auto Text Summarization Tool</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.muicss.com/mui-0.10.2/css/mui.min.css" rel="stylesheet" type="text/css" />
    <script src="//cdn.muicss.com/mui-0.10.2/js/mui.min.js"></script>
    <style>
        .about{
            border: 1px solid #007190 !important;
            box-shadow: 0px 0px 0px 2px #007190;
            background-color: transparent !important;
            width: 125px;
            border-radius: 25px;
            color: #007190;
            font-family: system-ui;
            font-weight: 550;
        }
        .about:hover{
            background-color: #007190 !important;
            color: white;
            transition: all ease 0.3s;
        }
        .topnav {
            margin-left: 30px;
            margin-top: 30px;
            background-color: #F3FEFF;
            overflow: hidden;
        }
        .topnav-right {
            margin-right: 50px;
            float: right;
        }
        .submitCSS{
            font-weight: 550;
            font-size: 17px;
            font-family: cursive;
            background-color: #007190;
            border-radius: 8px;
        }
        .developer{
            opacity: 0;
            background-color: #007190;
            color: white;
            padding: 10px;
            width: 110px;
            font-size:15px;
            text-align: center;
        }
        .topnav-right:hover .developer{
            opacity: 0.8;
            transition: all ease-in-out 0.5s;
        }
        textarea{
            outline: none;
            border: 0px solid #007190;
            border-radius: 5px;
            box-shadow: 0px 0px 1px 0px #007190;
            resize: none;
            color: #78909c;
        }
        textarea::placeholder{
            font-size: 20px;
            color: #78909c;
            text-align: center;
            padding-top: 200px;
        }
        .container {
            text-align: center;
            font-family: system-ui;
        }
        h2{
            font-family: cursive;
            font-weight: 550;
            font-size: 30px;
            padding-bottom: 7px;
            color: #007190;
        }
        .bg{
            background-color: #F3FEFF;
            background-image: url('back.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="bg">
    <div class="topnav">
        <a href="."><img src="logo.png" width="20%" height="20%"></a>
        <div class="topnav-right">
            <button class="mui-btn mui-btn--primary about">About us</button>
            <div class="developer">Developed by Sujan Mitra</div>
        </div>
    </div>
    <div class="container">
        <h2>Auto Text Summarization Tool</h2>
        <textarea rows="28" cols="125"  id="output" name="usrInp" form="inputFrm" placeholder="Enter your text here .."><?php if(isset($res)){echo $res;} ?></textarea>
        <form action="index.php" method="POST" id="inputFrm">
            <input class="mui-btn mui-btn--raised mui-btn--large mui-btn--primary submitCSS" type="submit" value="SUMMARIZE"> 
        </form>
    </div>
</body>
</html>