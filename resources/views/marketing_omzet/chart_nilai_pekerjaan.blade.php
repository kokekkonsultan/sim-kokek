<script type="text/javascript">
    FusionCharts.ready(function(){
        var chartObj = new FusionCharts({
type: 'line',
renderAt: 'chart-container',
"width": "100%",
"height": "500",
dataFormat: 'json',
dataSource: {
    "chart": {
        "theme": "zune",
        "caption": "Grafik berdasarkan nilai Nett Omzet",
        "subCaption": "Per Tahun",
        "xAxisName": "Tahun Pekerjaan",
        "yAxisName": "Nilai Nett Omzet",
        "lineThickness": "2",
        "formatNumberScale": "2",
        "numberPrefix": "Rp. "
    },
    "data": <?php echo json_encode($arr_1); ?>,
    "trendlines": [{
        "line": [{
            "startvalue": "<?php echo $rata_rata_nilai_pekerjaan; ?>",
            "color": "#29C3BE",
            "displayvalue": "Rata-rata{br}Nilai{br}Nett Omzet",
            "valueOnRight": "1",
            "thickness": "2"
        }]
    }]
}
});
        chartObj.render();
    });
</script>

<div class="mt-5 shadow-lg" id="chart-container">FusionCharts XT will load here!</div>
