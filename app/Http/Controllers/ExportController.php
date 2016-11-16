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
                                        'qtrperiod'=>$qtrperiod->qtrperiod, 
                                        'schoolyear'=>$value->schoolyear,
                                        'CL11'=>$value->cl11,
                                        'CL21'=>$value->cl21,
                                        'CL31'=>$value->cl31,
                                        'CL41'=>$value->cl41,
                                        'CL51'=>$value->cl51,
                                        'CL61'=>$value->cl61,
                                        'CL71'=>$value->cl71,
                                        'CL81'=>$value->cl81,
                                        'ENGL11'=>$value->engl11,
                                        'ENGL21'=>$value->engl21,  
                                        'ENGL31'=>$value->engl31,
                                        'ENGL41'=>$value->engl41,
                                        'ENGL51'=>$value->engl51,
                                        'ENGL61'=>$value->engl61,
                                        'ENGL71'=>$value->engl71,
                                        'MATH11'=>$value->math11,
                                        'MATH21'=>$value->math21,
                                        'MATH31'=>$value->math31,
                                        'MATH41'=>$value->math41,
                                        'MATH51'=>$value->math51,
                                        'MATH61'=>$value->math61,
                                        'MATH71'=>$value->math71,
                                        'MATH81'=>$value->math81,
                                        'MATH91'=>$value->math91,
                                        'MATH101'=>$value->math101,
                                        'FIL11'=>$value->fil11,
                                        'FIL21'=>$value->fil21,
                                        'FIL31'=>$value->fil31,
                                        'FIL41'=>$value->fil41,
                                        'FIL51'=>$value->fil51,
                                        'FIL61'=>$value->fil61,
                                        'FIL71'=>$value->fil71,
                                        'FIL81'=>$value->fil81
                                        ];
                                    
                                   $this->upgradecompetence($idnof,'CL11',$qtrperiod->qtrperiod, $value->cl12,$sy);
                                   $this->upgradecompetence($idnof,'CL21',$qtrperiod->qtrperiod, $value->cl22,$sy);
                                   $this->upgradecompetence($idnof,'CL31',$qtrperiod->qtrperiod, $value->cl32,$sy);
                                   $this->upgradecompetence($idnof,'CL41',$qtrperiod->qtrperiod, $value->cl42,$sy);
                                   $this->upgradecompetence($idnof,'CL51',$qtrperiod->qtrperiod, $value->cl52,$sy);
                                   $this->upgradecompetence($idnof,'CL61',$qtrperiod->qtrperiod, $value->cl62,$sy);
                                   $this->upgradecompetence($idnof,'CL71',$qtrperiod->qtrperiod, $value->cl72,$sy);
                                   $this->upgradecompetence($idnof,'CL81',$qtrperiod->qtrperiod, $value->cl82,$sy);                                   
                                   $this->upgradecompetence($idnof,'ENGL11',$qtrperiod->qtrperiod, $value->engl12,$sy);
                                   $this->upgradecompetence($idnof,'ENGL21',$qtrperiod->qtrperiod, $value->engl22,$sy);
                                   $this->upgradecompetence($idnof,'ENGL31',$qtrperiod->qtrperiod, $value->engl32,$sy);
                                   $this->upgradecompetence($idnof,'ENGL41',$qtrperiod->qtrperiod, $value->engl42,$sy);
                                   $this->upgradecompetence($idnof,'ENGL51',$qtrperiod->qtrperiod, $value->engl52,$sy);
                                   $this->upgradecompetence($idnof,'ENGL61',$qtrperiod->qtrperiod, $value->engl62,$sy);
                                   $this->upgradecompetence($idnof,'ENGL71',$qtrperiod->qtrperiod, $value->engl72,$sy);
                                   $this->upgradecompetence($idnof,'MATH11',$qtrperiod->qtrperiod, $value->math12,$sy);
                                   $this->upgradecompetence($idnof,'MATH21',$qtrperiod->qtrperiod, $value->math22,$sy);
                                   $this->upgradecompetence($idnof,'MATH31',$qtrperiod->qtrperiod, $value->math32,$sy);
                                   $this->upgradecompetence($idnof,'MATH41',$qtrperiod->qtrperiod, $value->math42,$sy);
                                   $this->upgradecompetence($idnof,'MATH51',$qtrperiod->qtrperiod, $value->math52,$sy);
                                   $this->upgradecompetence($idnof,'MATH61',$qtrperiod->qtrperiod, $value->math62,$sy);
                                   $this->upgradecompetence($idnof,'MATH71',$qtrperiod->qtrperiod, $value->math72,$sy);
                                   $this->upgradecompetence($idnof,'MATH81',$qtrperiod->qtrperiod, $value->math82,$sy);
                                   $this->upgradecompetence($idnof,'MATH91',$qtrperiod->qtrperiod, $value->math92,$sy);
                                   $this->upgradecompetence($idnof,'MATH101',$qtrperiod->qtrperiod, $value->math102,$sy);
                                   $this->upgradecompetence($idnof,'FIL11',$qtrperiod->qtrperiod, $value->fil12,$sy);
                                   $this->upgradecompetence($idnof,'FIL21',$qtrperiod->qtrperiod, $value->fil22,$sy);
                                   $this->upgradecompetence($idnof,'FIL31',$qtrperiod->qtrperiod, $value->fil32,$sy);
                                   $this->upgradecompetence($idnof,'FIL41',$qtrperiod->qtrperiod, $value->fil42,$sy);
                                   $this->upgradecompetence($idnof,'FIL51',$qtrperiod->qtrperiod, $value->fil52,$sy);
                                   $this->upgradecompetence($idnof,'FIL61',$qtrperiod->qtrperiod, $value->fil62,$sy);
                                   $this->upgradecompetence($idnof,'FIL71',$qtrperiod->qtrperiod, $value->fil72,$sy);
                                   $this->upgradecompetence($idnof,'FIL81',$qtrperiod->qtrperiod, $value->fil82,$sy);
				
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
