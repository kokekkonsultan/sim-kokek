<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik Pengalaman Perusahaan</title>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.candy.js"></script>
    <style>
        body{
            padding: 0;
            margin: 0;
            background-color: #262A33;
        }
    </style>
</head>
<body>

@php
    include(public_path()."/vendor/fusioncharts/fusioncharts.php");
    // include("vendor/fusioncharts/fusioncharts.php");

    $arrChartConfig = array(
        "chart" => array(
            "caption" => "Pengalaman Perusahaan",
            "subCaption" => "",
            "xAxisName" => "Tahun",
            "yAxisName" => "Nilai",
            "numberPrefix"=> "Rp.",
            "formatNumberScale"=> "2",
            "theme" => "candy"
        )
    );

    $tinggi_chart = $jumlah_data * 50;
    $tinggi_chart = strval($tinggi_chart);

    $arrChartData = $arr_data;

    $arrLabelValueData = array();

    for($i = 0; $i < count($arrChartData); $i++) {
        array_push($arrLabelValueData, array(
            "label" => $arrChartData[$i][0], "value" => $arrChartData[$i][1]
        ));
    }
    $arrChartConfig["data"] = $arrLabelValueData;

    $jsonEncodedData = json_encode($arrChartConfig);

    $Chart = new FusionCharts("bar2d", "MyFirstChart" , "100%", $tinggi_chart, "chart-container", "json", $jsonEncodedData);

    $Chart->render();

@endphp

<center>
    <div id="chart-container">Chart will render here!</div>
</center>


</body>
</html>
