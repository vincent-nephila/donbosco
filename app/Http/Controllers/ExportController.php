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

	public function importExcelGrade(){
		if(Input::hasFile('import_file')){
                        $qtrperiod = \App\CtrQuarter::first()->qtrperiod;
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
                                    $idnof = $value->idno;
                                    if(strlen($idnof)==5){
                                        $idnof = "0".$idnof;
                                    }
                                        $insert[] = ['idno' => $idnof, 'subjectcode' => $value->subjectcode,
                                            'grade'=> $value->grade,
                                            'qtrperiod'=> $qtrperiod,'schoolyear'=> $sy];
                                        
                                 $this->upgradegrade($value->idno, $value->subjectcode, $qtrperiod,$value->grade,$sy);     
				
                                 
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
                        $qtrperiod = \App\CtrQuarter::first()->qtrperiod;
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file1')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                    $idnof = $value->idno;
                                    if(strlen($idnof)==5){
                                        $idnof = "0".$idnof;
                                    }
                                    
                                    $insert[] = ['idno'=>$idnof, 'qtrperiod'=>$qtrperiod, 
                                        'schoolyear'=>$value->schoolyear,
                                        'GC'=>$value->gc, 'SR'=>$value->sr,'PE'=>$value->pe, 'SYN'=>$value->syn,
                                        'JO'=>$value->jo,'TS'=>$value->ts,'OSR'=>$value->osr,'DPT'=>$value->dpt,'PTY'=>$value->pty,
                                        'DI'=>$value->di,'PG'=>$value->pg,'SIS'=>$value->sis];
                                    
                                   $this->updateconduct($value->idno, 'GC', $value->gc, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SR', $value->sr, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PE', $value->pe, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SYN', $value->syn, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'JO', $value->jo, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'TS', $value->ts, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'OSR', $value->osr, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'DPT', $value->dpt, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PTY', $value->pty, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'DI', $value->di, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'PG', $value->pg, $qtrperiod, $sy);
                                   $this->updateconduct($value->idno, 'SIS', $value->sis, $qtrperiod, $sy);
				}

				if(!empty($insert)){

					DB::table('conduct_repos')->insert($insert);

					

				}

			}

		}
                //return $insert;
		return redirect(url('/importGrade'));
		

	}
        
        public function importExcelCompetence()

	{

		if(Input::hasFile('import_file3')){
                        $qtrperiod = \App\CtrQuarter::first()->qtrperiod;
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file3')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                    $idnof = $value->idno;
                                    if(strlen($idnof)==5){
                                        $idnof = "0".$idnof;
                                    }
                                    
                                    $insert[] = ['idno'=>$idnof, 
                                        'qtrperiod'=>$value->qtrperiod, 
                                        'schoolyear'=>$value->schoolyear,
                                        'CL12'=>$value->cl12,
                                        'CL22'=>$value->cl22,
                                        'CL32'=>$value->cl32,
                                        'CL42'=>$value->cl42,
                                        'CL52'=>$value->cl52,
                                        'CL62'=>$value->cl62,
                                        'CL72'=>$value->cl72,
                                        'CL82'=>$value->cl82,
                                        'ENGL12'=>$value->engl12,
                                        'ENGL22'=>$value->engl22,  
                                        'ENGL32'=>$value->engl32,
                                        'ENGL42'=>$value->engl42,
                                        'ENGL52'=>$value->engl52,
                                        'ENGL62'=>$value->engl62,
                                        'ENGL72'=>$value->engl72,
                                        'MATH12'=>$value->math12,
                                        'MATH22'=>$value->math22,
                                        'MATH32'=>$value->math32,
                                        'MATH42'=>$value->math42,
                                        'MATH52'=>$value->math52,
                                        'MATH62'=>$value->math62,
                                        'MATH72'=>$value->math72,
                                        'MATH82'=>$value->math82,
                                        'MATH92'=>$value->math92,
                                        'MATH102'=>$value->math102,
                                        'FIL12'=>$value->fil12,
                                        'FIL22'=>$value->fil22,
                                        'FIL32'=>$value->fil32,
                                        'FIL42'=>$value->fil42,
                                        'FIL52'=>$value->fil52,
                                        'FIL62'=>$value->fil62,
                                        'FIL72'=>$value->fil72,
                                        'FIL82'=>$value->fil82
                                        ];
                                    
                                   $this->upgradecompetence($idnof,'CL12',$value->qtrperiod, $value->cl12,$sy);
                                   $this->upgradecompetence($idnof,'CL22',$value->qtrperiod, $value->cl22,$sy);
                                   $this->upgradecompetence($idnof,'CL32',$value->qtrperiod, $value->cl32,$sy);
                                   $this->upgradecompetence($idnof,'CL42',$value->qtrperiod, $value->cl42,$sy);
                                   $this->upgradecompetence($idnof,'CL52',$value->qtrperiod, $value->cl52,$sy);
                                   $this->upgradecompetence($idnof,'CL62',$value->qtrperiod, $value->cl62,$sy);
                                   $this->upgradecompetence($idnof,'CL72',$value->qtrperiod, $value->cl72,$sy);
                                   $this->upgradecompetence($idnof,'CL82',$value->qtrperiod, $value->cl82,$sy);                                   
                                   $this->upgradecompetence($idnof,'ENGL12',$value->qtrperiod, $value->engl12,$sy);
                                   $this->upgradecompetence($idnof,'ENGL22',$value->qtrperiod, $value->engl22,$sy);
                                   $this->upgradecompetence($idnof,'ENGL32',$value->qtrperiod, $value->engl32,$sy);
                                   $this->upgradecompetence($idnof,'ENGL42',$value->qtrperiod, $value->engl42,$sy);
                                   $this->upgradecompetence($idnof,'ENGL52',$value->qtrperiod, $value->engl52,$sy);
                                   $this->upgradecompetence($idnof,'ENGL62',$value->qtrperiod, $value->engl62,$sy);
                                   $this->upgradecompetence($idnof,'ENGL72',$value->qtrperiod, $value->engl72,$sy);
                                   $this->upgradecompetence($idnof,'MATH12',$value->qtrperiod, $value->math12,$sy);
                                   $this->upgradecompetence($idnof,'MATH22',$value->qtrperiod, $value->math22,$sy);
                                   $this->upgradecompetence($idnof,'MATH32',$value->qtrperiod, $value->math32,$sy);
                                   $this->upgradecompetence($idnof,'MATH42',$value->qtrperiod, $value->math42,$sy);
                                   $this->upgradecompetence($idnof,'MATH52',$value->qtrperiod, $value->math52,$sy);
                                   $this->upgradecompetence($idnof,'MATH62',$value->qtrperiod, $value->math62,$sy);
                                   $this->upgradecompetence($idnof,'MATH72',$value->qtrperiod, $value->math72,$sy);
                                   $this->upgradecompetence($idnof,'MATH82',$value->qtrperiod, $value->math82,$sy);
                                   $this->upgradecompetence($idnof,'MATH92',$value->qtrperiod, $value->math92,$sy);
                                   $this->upgradecompetence($idnof,'MATH102',$value->qtrperiod, $value->math102,$sy);
                                   $this->upgradecompetence($idnof,'FIL12',$value->qtrperiod, $value->fil12,$sy);
                                   $this->upgradecompetence($idnof,'FIL22',$value->qtrperiod, $value->fil22,$sy);
                                   $this->upgradecompetence($idnof,'FIL32',$value->qtrperiod, $value->fil32,$sy);
                                   $this->upgradecompetence($idnof,'FIL42',$value->qtrperiod, $value->fil42,$sy);
                                   $this->upgradecompetence($idnof,'FIL52',$value->qtrperiod, $value->fil52,$sy);
                                   $this->upgradecompetence($idnof,'FIL62',$value->qtrperiod, $value->fil62,$sy);
                                   $this->upgradecompetence($idnof,'FIL72',$value->qtrperiod, $value->fil72,$sy);
                                   $this->upgradecompetence($idnof,'FIL82',$value->qtrperiod, $value->fil82,$sy);
				
                              }
                             

				if(!empty($insert)){

					DB::table('competency_repos')->insert($insert);

				//return $insert;	

				}

			}

		}
                //return $insert;
		return redirect(url('/importGrade'));

	}
        
        public function upgradegrade($idno,$subjectcode,$qtrperiod,$grade,$sy){
        if(strlen($idno)==5){
            $idno = "0".$idno;
        }     
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
        if(strlen($idno)==5){
            $idno = "0".$idno;
        }    
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
          if(strlen($idno)==5){
            $idno = "0".$idno;
        }   
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
        public function updatecompetency($idno, $qtr, $schoolyear, $competencycode, $value, $sy){
            $updatecom =  \App\Competency::where('idno',$idno)->where('competencycode',$competencycode)->where('quarter',$qtr)->where('schoolyear',$sy)->first();
            $updatecom->value=$value;
            $updatecom->save();
        }
        public function importExcelAttendance()

	{

		if(Input::hasFile('import_file2')){
                        $schoolyear = \App\ctrSchoolYear::first();
                        $sy = $schoolyear->schoolyear;
			$path = Input::file('import_file2')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
                            $reader->skip(11);
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                    $idnof = $value->idno;
                                    if(strlen($idnof)==5){
                                        $idnof = "0".$idnof;
                                    }
                                   $dya=$this->noneNull($value->daya);
                                   $dyp=$this->noneNull($value->dayp);
                                   $dyt=$this->noneNull($value->dayt);
                                   
                                    $insert[] = ['idno'=>$idnof, 'qtrperiod'=>$value->qtrperiod, 
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
        public function upgradecompetence($idno,$competencycode,$quarter,$value,$sy){
        if(strlen($idno)==5){
            $idno = "0".$idno;
        }     
        
        $ug = \App\Competency::where('idno',$idno)->where('competencycode',$competencycode)->where('schoolyear',$sy)->first();
        if(count($ug)>0){
        $ug->value = $value;
        $ug->update();    
        }}
        
}
