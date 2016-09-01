<?php

namespace App\Http\Controllers;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class ExportController extends Controller
{
    	public function importGrade()

	{

		return view('registrar.importgrade');

	}

	public function downloadExcel($type)

	{

		$data = Item::get()->toArray();

		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download($type);

	}

	public function importExcelGrade()

	{

		if(Input::hasFile('import_file')){
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {
                                    /*
					$insert[] = ['idno' => $value->idno, 'subjectcode' => $value->subjectcode,
                                            'level'=> $value->level, 'section'=> $value->section, 'grade'=> $value->grade,
                                            'qtrperiod'=> $value->qtrperiod,'schoolyear'=> $value->schoolyear];
                                      */  
                                        $insert[] = ['idno' => $value->idno, 'subjectcode' => $value->subjectcode,
                                            'grade'=> $value->grade,
                                            'qtrperiod'=> $value->qtrperiod,'schoolyear'=> $sy];
                                        
                                 $this->upgradegrade($value->idno, $value->subjectcode, $value->qtrperiod,$value->grade,$sy);     
				
                                 
                                }

				if(!empty($insert)){

					DB::table('subject_repos')->insert($insert);

					//dd('Insert Record successfully.');

				}

			}

		}
                //return $insert;
		return redirect(url('/importGrade'));

	}
        public function importExcelConduct()

	{

		if(Input::hasFile('import_file1')){
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file1')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                   
                                    $insert[] = ['idno'=>$value->idno, 'qtrperiod'=>$value->qtrperiod, 
                                        'schoolyear'=>$value->schoolyear,
                                        'GC'=>$value->gc, 'SR'=>$value->sr,'PE'=>$value->pe, 'SYN'=>$value->syn,
                                        'JO'=>$value->jo,'TS'=>$value->ts,'OSR'=>$value->osr,'DPT'=>$value->dpt,'PTY'=>$value->pty,
                                        'DI'=>$value->di,'PG'=>$value->pg,'SIS'=>$value->sis];
                                    
                                   $this->updateconduct($value->idno, 'GC', $value->gc, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SR', $value->sr, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PE', $value->pe, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SYN', $value->syn, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'JO', $value->jo, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'TS', $value->ts, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'OSR', $value->osr, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'DPT', $value->dpt, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PTY', $value->pty, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'DI', $value->di, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PG', $value->pg, $value->qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SIS', $value->sis, $value->qtrperiod, $sy);
				}

				if(!empty($insert)){

					DB::table('conduct_repos')->insert($insert);

					

				}

			}

		}
                //return $insert;
		return redirect(url('/importGrade'));

	}
        
        public function upgradegrade($idno,$subjectcode,$qtrperiod,$grade,$sy){
        $qtrname = "";
        switch($qtrperiod){
            case 1:
                $qtrname = "first_grading";
                break;
            case 2:
                $qtrname="second_grading";
                break;
            case 3:
                $qtrname="third_grading";
                break;
            case 4:
                $qtrname="fourth_grading";
        }
        $ug = \App\Grade::where('idno',$idno)->where('subjectcode',$subjectcode)->where('schoolyear',$sy)->first();
        if(count($ug)>0){
        $ug->$qtrname = $grade;
        $ug->update();    
        }}
        
        public function updateattendance($idno,$daya,$dayp,$dayt,$qtrperiod,$sy){
        $qtrname = "";
        switch($qtrperiod){
            case 1:
                $qtrname = "first_grading";
                break;
            case 2:
                $qtrname="second_grading";
                break;
            case 3:
                $qtrname="third_grading";
                break;
            case 4:
                $qtrname="fourth_grading";
        }
        $ug = \App\Grade::where('idno',$idno)->where('schoolyear',$sy)->where('subjectcode','DAYP')->first();
        if(count($ug)>0){
        $ug->$qtrname = $dayp;
        $ug->update(); 
        }
        
        $ug = \App\Grade::where('idno',$idno)->where('schoolyear',$sy)->where('subjectcode','DAYA')->first();
        if(count($ug)>0){
        $ug->$qtrname = $daya;
        $ug->update(); 
        }
        $ug = \App\Grade::where('idno',$idno)->where('schoolyear',$sy)->where('subjectcode','DAYT')->first();
        if(count($ug)>0){
        $ug->$qtrname = $dayt;
        $ug->update(); 
        }
        }
        
        public function updateconduct($idno,$ctype,$cvalue,$qtrperiod,$schoolyear){
          if(!is_null($cvalue) || $cvalue!=""){  
            switch($qtrperiod){
            case 1:
                $qtrname = "first_grading";
                break;
            case 2:
                $qtrname="second_grading";
                break;
            case 3:
                $qtrname="third_grading";
                break;
            case 4:
                $qtrname="fourth_grading";
        }
        
        $cupate = \App\Grade::where('idno',$idno)->where('subjectcode',$ctype)->where('schoolyear',$schoolyear)->first();
        if(count($cupate)>0){
        $cupate->$qtrname=$cvalue;
        $cupate->update();
        }
          }
        }
        
        public function importExcelAttendance()

	{

		if(Input::hasFile('import_file2')){
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file2')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                   
                                   $dya=$this->noneNull($value->daya);
                                   $dyp=$this->noneNull($value->dayp);
                                   $dyt=$this->noneNull($value->dayt);
                                   
                                    $insert[] = ['idno'=>$value->idno, 'qtrperiod'=>$value->qtrperiod, 
                                        'schoolyear'=>$sy,
                                        'DAYA'=>$dya, 'DAYP'=>$dyp,'DAYT'=>$dyt];
                                   
                                 $this->updateattendance($value->idno, $value->daya, $value->dayp, $value->dayt, $value->qtrperiod, $sy);
				}

				if(!empty($insert)){

					DB::table('attendance_repos')->insert($insert);

					

				}

			}

		}

		return redirect(url('/importGrade'));

	}
        
        function noneNull($value){
            if($value="" || is_null($value)){
                $value="0";
            }
            return $value;
        }
}
