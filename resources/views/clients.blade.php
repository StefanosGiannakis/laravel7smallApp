<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> Latest Payments </title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
</head>
<body>
<div class="container-fluid">
    <div class="flex-center position-ref">
        <div class="content">
            <div class="title m-b-md">
                Latest Payments
            </div>
            <label><strong>Between Dates<strong></label>
            <div class="alert alert-danger" role="alert" style="display:none"></div>
            <input type="text" name="dates" class="form-control pull-right">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Latest Payment At</th>
                    </tr>
                </thead>
                <tbody id="latestPayments">
                    @foreach($clients as $client)
                    <tr>
                        <th scope="row">{{$client->id}}</th>
                        <td>{{$client->name}}</td>
                        <td>{{$client->surname}}</td>
                        <td>{{$client->amount}}</td>
                        <td>{{$client->latest_payment!=null ? date('Y-m-d H:i:s', strtotime($client->latest_payment)) : 'No Payment Yet'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function(){

    var datePicker = $('input[name="dates"]')

    datePicker.daterangepicker({
        timePicker: true,
        timePickerIncrement: 15,
        startDate: moment().startOf('hour').add(1,'hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'Y/M/D hh:mm A'
        }
    });

    datePicker.on('apply.daterangepicker', function(ev, picker) {
        let startDate = picker.startDate.format('Y/M/D hh:mm A')
        let endDate = picker.endDate.format('Y/M/D hh:mm A')
        $('.alert-danger').fadeOut()
        getPaymentsBetweenDate(startDate,endDate)
    });

    function getPaymentsBetweenDate(startDate,endDate){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: "{{route('search')}}",
            dataType: 'json',
            data: {
                'startDate':startDate,
                'endDate':endDate
            },
            success: function(response) {
                buildTable(response)
            },
            error: function(error) {
                errors=error.responseJSON.errors
                $('.alert-danger').fadeIn().text(JSON.stringify(errors))
            }
        });          
    }

    function buildTable(response){
        let table = $('#latestPayments') 
        let tr = ""
        table.empty()
        $.each(response, function(i, item) {
            let date=item.updated_at!=null?item.updated_at:'No Payment'
            let amount=item.amount!=null?item.amount:''
            tr += '<tr><th scope="row">'+item.id+'</th>'
            tr += '<td>'+item.name+'</td>'
            tr += '<td>'+item.surname+'</td>'
            tr += '<td>'+amount+'</td>'
            tr += '<td>'+date+'</td></tr>'
        });
        table.html(tr)
    }
})
</script>
</body>
</html>