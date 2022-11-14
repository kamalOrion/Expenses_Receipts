var barData = {
    labels: [],
    datasets: [{
            label: "Montant en FCFA",
            backgroundColor: 'rgba(26,179,148,0.5)',
            borderColor: "rgba(26,179,148,0.7)",
            pointBackgroundColor: "rgba(26,179,148,1)",
            pointBorderColor: "#fff",
            data: []
        }]
},

barOptions = {
    responsive: true
},

ctx2 = document.getElementById("barChart");
if(ctx2){
    ctx2.getContext("2d");
    var dashboardChars = new Chart(ctx2, {
        type: 'bar', 
        data: barData, 
        options:barOptions
    });
}

$('#bar_chart_month .input-group.date').datepicker({
    format: "dd/mm/yyyy",
    language: 'fr',
    minViewMode: 1,
    keyboardNavigation: false,
    forceParse: false,
    forceParse: false,
    autoclose: true,
    todayHighlight: true
}).on('changeDate', function(e) {
    relaod_chart(english_data_format($('#chart_date').val()))
});

function relaod_chart(month){
    let promesse = request(general_data.site_url + '/dashboard/get_bar_chart_data', 'json', true, 'POST', month ? {date: month} : null); 
    promesse.then(function(response) {
        barData.labels = response.dates;
        barData.datasets[0].data = response.montant;
        dashboardChars.update();
    });
}

$('#chart_date').val((new Date).toLocaleDateString("fr-FR")).trigger('changeDate')

 

 
