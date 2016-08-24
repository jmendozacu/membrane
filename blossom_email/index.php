<?php

ini_set('display_errors', true);

$row = 1;
$emailArray = array();
if (($handle = fopen("csv.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c = 0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            $emailArray[] = $data[$c];
            $to = $data[$c];
            $subject = 'INVITATION ENDO-ART 2016';
            $message = "<html>
                <head>
                   <title>Test</title>
                </head>
                <body>
                    <img style='width:100%' src='http://vishawebsolutions.com/blossom_email/blossom_newsletter.jpg'/>
                    <p style='text-align:center;'>Bulk Email By <a href='http://vishawebsolutions.com/'>Visha Web Solutions</a> Marketed By <span style='color:#a3398f;'> Media Concept</span></p>
                </body>
                </html>";
//$message  = '<img src="http://127.0.0.1:81/pintu/blossom newsletter.jpg">';
            $headers = "From: info@blossomivfindia.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";
            if (mail($to, $subject, $message, $headers))
                echo "Email sent: $data[$c] <br>";
            else
                echo "Email sending failed: $data[$c] <br>";
        }
    }
    fclose($handle);
}
echo "<pre>";
print_r($emailArray);

die;
?>