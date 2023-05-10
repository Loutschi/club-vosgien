<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<?php
    $header = array(
    'created'=>'date',
    'product_id'=>'integer',
    'quantity'=>'#,##0',
    'amount'=>'price',
    'description'=>'string',
    'tax'=>'[$-1009]#,##0.00;[RED]-[$-1009]#,##0.00',
    );
    $data = array(
    array('2015-01-01',873,1,'44.00','misc','=D2*0.05'),
    array('2015-01-12',324,2,'88.00','none','=D3*0.05'),
    );

    $writer = new XLSXWriter();
    $writer->writeSheetHeader('Sheet1', $header );
    foreach($data as $row)
    $writer->writeSheetRow('Sheet1', $row );
    $writer->writeToFile('example.xlsx');
?>

</body>

</html>