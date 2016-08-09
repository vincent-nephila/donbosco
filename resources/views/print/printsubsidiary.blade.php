<html>
    <head>
        <style type='text/css'>
            .logo,.school{
                width:60%
            }
            .logo{
                width:40%;
                text-align: right;
            }
            .info,.list{
                width:80%;
            }
        </style>
        <style type='text/css' media='print'>
            .logo,.school{
                width:70%
            }
            .logo{
                width:30%;
                text-align: right;
            }
            
            .info,.list{
                width:100%;
            }
        </style>
    </head>
    <body>
        <table style="width: 100%;" cellpadding="10">
            <thead>
                <tr>
                    <td class="logo"><img src="{{asset('images/logo.png')}}" style="display: inline-block"></td>
                    <td class="school"><h3 style="display: inline-block;">Don Bosco Technical Institute, Makati</h3></td>
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="info" style="margin-left: auto; margin-right: auto;">
                            <p>Individual Account Summary </br>
                                Account Title : {{$request->accountname}}<br>
                            Date Covered : {{Date('M d,Y', strtotime($request->from))}} To {{Date('M d,Y',strtotime($request->to))}}
                            </p>
                        </div>
                        <table align="center" cellspacing="0" border="1" class="list">
                            <thead>
                                <tr><td><b>Tran Date</b></td><td><b>OR No</b></td><td><b>Name</b></td><td><b>Amount</b></td></tr>
                            </thead>
                            <tbody>
                            @foreach($dblist as $dbl)
                            <tr><td>{{$dbl->transactiondate}}</td><td>{{$dbl->receiptno}}</td><td>
                                {{$dbl->lastname}}, {{$dbl->firstname}} {{$dbl->middlename}}
                                </td><td>{{$dbl->amount}}</td></tr>
                            @endforeach
                            </tbody>
                        </table>                            
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
