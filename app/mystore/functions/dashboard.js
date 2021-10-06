function getStats() {

    $.ajax({
        method: "post",
        url: "api/dashboard/sales.php"
    }).done(function (res) {

        console.log(res);

        var obj = [];
        var color;

        for (let i = 0; i < res.types.length; i++) {
            color = '#'+Math.floor(Math.random()*16777215).toString(16);
            obj.push({
                label: res.types[i]['pt_name'],
                backgroundColor: color,
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: res.data[i],
            });
        }

        console.log(obj);

        var areaChartData = {
            labels: res.months,
            datasets: obj
        }


        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });




}



