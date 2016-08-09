<html>
    <head>
        <style type='text/css' media='prints'>
            .printer{
                align-content:center;
            }
        </style>
    </head>
    <body>
        <div class='printer'>
        <img src="{{asset('images/logo.png')}}">
        <h3>Don Bosco Technical Institute, Makati</h3>
        <p>Individual Account Summary </br>
            Account Title : {{$request->accountname}}<br>
        Date Covered : {{Date('M d,Y', strtotime($request->from))}} To {{Date('M d,Y',strtotime($request->to))}}
        <table align="center"><tr><td>Tran Date</td><td>OR No</td><td>Name</td><td>Amount</td></tr>
            @foreach($dblist as $dbl)
            <tr><td>{{$dbl->transactiondate}}</td><td>{{$dbl->receiptno}}</td><td>
                {{$dbl->lastname}}, {{$dbl->firstname}} {{$dbl->middlename}}
                </td><td>{{$dbl->amount}}</td></tr>
            @endforeach
        </table>    
        </div>
    </body>
</html>
