window.addEventListener("load", loadChardData);

function loadChardData() {

    var selectYear = document.getElementById("selectYear").value;
    var year;
    if(selectYear==null ||selectYear==''){
        var date = new Date();
        year = date.getFullYear();
    }else{
        year = selectYear;
    }

    var form=new FormData();
    form.append("year",year);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {

            var jsonTestResponse = request.responseText;
            var response = JSON.parse(jsonTestResponse);

            var response_length = response.length;


            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                // var data = google.visualization.arrayToDataTable(
                //     [
                //         ['Month', 'Active Users', 'Basic Subscription', 'Pro Subscription', 'Primium Subscription', 'Monthly Income', 'Total Movies', 'Total Tv-Series'],
                //     ]
                // );

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Month');
                data.addColumn('number', 'Active Users');
                data.addColumn('number', 'Basic Subscription');
                data.addColumn('number', 'Pro Subscription');
                data.addColumn('number', 'Premium Subscription');
                data.addColumn('number', 'Monthly Income');
                data.addColumn('number', 'Total Movies');
                data.addColumn('number', 'Total TV-Series');


                for (var x = 0; x < response_length; x++) {
                    var month = response[x].month;
                    var active_users = parseInt(response[x].active_users);
                    var basic_subscription = parseInt(response[x].basic_subscription_count);
                    var pro_subscription = parseInt(response[x].pro_subscription_count);
                    var premium_subscription = parseInt(response[x].premium_subscription_count);
                    var monthly_income = parseInt(response[x].monthly_income);
                    var movie_count = parseInt(response[x].movie_count);
                    var tv_series_count = parseInt(response[x].tv_series_count);

                    data.addRow([month, active_users, basic_subscription, pro_subscription, premium_subscription, monthly_income, movie_count, tv_series_count]);
                }


                // for (var x = 0; x < response_length; x++) {
                //     var currentObject = response[x];
                //     data.push([currentObject.month, currentObject.active_users, currentObject.basic_subscription_count, currentObject.pro_subscription_count, currentObject.primium_subscription_count, currentObject.monthly_income, currentObject.movie_count, currentObject.tv_series_count]);
                // }


                // var data = google.visualization.arrayToDataTable(
                // [
                //     ['Month', 'Active Users', 'Basic Subscription', 'Pro Subscription', 'Primium Subscription', 'Monthly Income', 'Total Movies', 'Total Tv-Series'],
                //     [response.month, 1000, 400, 100, 100, 1000, 400, 100],
                //     ['February', 1170, 460, 100, 100, 1000, 400, 100],
                //     ['March', 660, 1120, 100, 100, 1000, 400, 100],
                //     ['April', 1030, 540, 100, 100, 1000, 400, 100]
                // ]
                // );

                var options = {
                    // title: 'CineVault Performance',
                    // curveType: 'function',
                    legend: { position: 'right' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
            }


        }
    }
    request.open("POST", "loadChatData.php", true);
    request.send(form);

}