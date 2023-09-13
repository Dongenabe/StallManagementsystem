$.ajax({
    url: "includes/authsurvey.php",
    type: "GET",
    success: function(data){
        var len = data.length;

        for(var i = 0; i < len; i++){
            var status = data[i].status;
            var sec = 'section' + status + i;
            var ctx = document.getElementById(sec).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [data[i].concerns],
                    datasets: [{
                        label: 'pending',
                        data: [data[i].vsatisfied],
                        backgroundColor: ['#0d6efd'],
                        borderColor: ['#0d6efd'],
                        borderWidth: 1,
                        barThickness: 25
                    },
                    {
                        label: 'addressed',
                        data: [data[i].satisfied],
                        backgroundColor: ['#ffc107'],
                        borderColor: ['#ffc107'],
                        borderWidth: 1,
                        barThickness: 25
                    },
                    {
                        label: 'closed',
                        data: [data[i].neutral],
                        backgroundColor: ['#adb5bd'],
                        borderColor: ['#adb5bd'],
                        borderWidth: 1,
                        barThickness: 25
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    },
    error: function(data){
        console.log(data);
    }
});
