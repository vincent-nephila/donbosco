<html>
    <head>
        <style>
            table tr td{font-size: 9pt;}
            table.list tr td{border-width: .05px}
            table.footer tr td{border-width: .05px; font-size: 7pt;}
        </style>    
    </head>
    <body>
        <table border="0" cellspacing="0" cellpadding ="0" width="100%">
            <tr><td rowspan="3" width="50" align="center"><img src="{{url('/images/logo.png')}}" width="50"></td>
                <td><span style="font-size: 12pt; font-weight: bold">Don Bosco Technical Institute of Makati, Inc.</span></td>
                <td rowspan="5" valign="top" width="40%">
                <table border ="0" celspacing="0" cellpadding="0">
                <tr><td width="45">Subject:</td><td>____________</td></tr>
                <tr><td>Teacher:</td><td>___________</td></tr>
                <tr><td>Adviser:</td><td>{{$adviser}}</td></tr>
                <tr><td>Grade:</td> <td>{{$level}} 
                    @if(isset($strand))    
                        ({{$strand}})
                    @endif
                    </td></tr>
                <tr><td>Section:</td><td> {{$section}}</td></tr>
                </table>
                </td></tr>
            <tr><td>Chino Roces Avenue Brgy. Pio Del Pilar, Makati City</td></tr>    
            <tr><td>Tel Nos. 892-0101 to 08</td></tr>
            <tr><td colspan="2">School Year : {{$schoolyear}} - {{$schoolyear + 1}}</td></tr>
            <tr><td colspan="2">Grading period: ________</td></tr>
        </table>  
        <br>
        </table>
        
        <table width="100%" border="1" cellspacing = "0" class="list"><tr>
                <td width="10%" align="center">Student No</td><td width="5%" align="center">CN</td><td width="37%">Name</td><td width="8%"></td><td width="8%"></td><td width="8%"></td><td width="8%"></td><td width="8%"></td><td width="8%"></td></tr>
        <?php
        $cnt = 0;
        ?>
        @foreach($studentnames as $studentname)
        <tr><td align="center">{{$studentname->idno}}</td><td align="center">
        <?php if($cnt++ <= 9){echo "0".$cnt;} else {echo $cnt;}?>    
        </td><td>{{$studentname->lastname}}, {{$studentname->firstname}} {{$studentname->middlename}}</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        @endforeach
        </table>   
        <p>&nbsp;</p>
        <table border = "0" width="100%" class="footer">
            <tr align="center"><td>Prepared By:<br><br></td><td>Checked By:<br><br></td><td></td><td>Noted By:<br><br></td><td></tr>
            <tr align="center"><td>Subject Teacher</td><td>Subject Area Head</td><td>Date Submitted</td><td>Asst. Principal</td><td>Due Date</td></tr>
            </table>
    </body>
</html>

