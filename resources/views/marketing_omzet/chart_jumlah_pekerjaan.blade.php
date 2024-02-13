<script type="text/javascript">
    FusionCharts.ready(function(){
        var chartObj = new FusionCharts({
type: 'area2d',
renderAt: 'chart-container-jumlah',
"width": "100%",
"height": "500",
dataFormat: 'json',
dataSource: {
    "chart": {
        "theme": "carbon",
        "caption": "Grafik berdasarkan jumlah pekerjaan",
        "subCaption": "Per Tahun",
        "xAxisName": "Tahun Pekerjaan",
        "yAxisName": "Jumlah Pekerjaan",
        "numberSuffix": " Pekerjaan"
    },
    "data": <?php echo json_encode($arr_2); ?>
}
});
        chartObj.render();
    });
</script>


<div class="mt-5 shadow-lg" id="chart-container-jumlah">FusionCharts XT will load here!</div>
