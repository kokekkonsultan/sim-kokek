<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik Omzet</title>
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

    $arrChartConfig = array(
        "chart" => array(
            "caption" => "Omzet",
            "subCaption" => "",
            "xAxisName" => "Tahun",
            "yAxisName" => "Nilai",
            "numberPrefix"=> "Rp.",
            "formatNumberScale"=> "2",
            "theme" => "candy"
        )
    );

    // An array of hash objects which stores data
    // $arrChartData = array(
    // ["Venezuela", "290"],
    // ["Saudi", "260"],
    // ["Canada", "180"],
    // ["Iran", "140"],
    // ["Russia", "115"],
    // ["UAE", "100"],
    // ["US", "30"],
    // ["China", "30"]
    // );

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
