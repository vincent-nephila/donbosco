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

			$path = Input::file('import_file')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {
                                    
					$insert[] = ['idno' => $value->idno, 'subjectcode' => $value->subjectcode,
                                            'level'=> $value->level, 'section'=> $value->section, 'grade'=> $value->grade,
                                            'qtrperiod'=> $value->qtrperiod,'schoolyear'=> $value->schoolyear];
                                     
                                 
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
                        
			$path = Input::file('import_file1')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                   
                                    $insert[] = ['idno'=>$value->idno, 'qtrperiod'=>$value->qtrperiod, 
                                        'level'=>$value->level, 'section'=>$value->section, 'schoolyear'=>$value->schoolyear,
                                        'GC'=>$value->gc, 'SR'=>$value->sr,'PE'=>$value->pe, 'SYN'=>$value->syn,
                                        'JO'=>$value->jo,'TS'=>$value->ts,'OSR'=>$value->osr,'DPT'=>$value->dpt,'PTY'=>$value->pty,
                                        'DI'=>$value->di,'PG'=>$value->pg,'SIS'=>$value->sis];
                                   
                                 
				}

				if(!empty($insert)){

					DB::table('conduct_repos')->insert($insert);

					

				}

			}

		}
                //return $insert;
		return redirect(url('/importGrade'));

	}
        public function importExcelAttendance()

	{

		if(Input::hasFile('import_file2')){

			$path = Input::file('import_file2')->getRealPath();
                        
			$data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
                           
				foreach ($data as $key => $value) {
                                   
                                    $insert[] = ['idno'=>$value->idno, 'qtrperiod'=>$value->qtrperiod, 
                                        'level'=>$value->level, 'section'=>$value->section,'schoolyear'=>$value->schoolyear,
                                        'DAYA'=>$value->daya, 'DAYP'=>$value->dayp,'DAYT'=>$value->dayt];
                                   
                                 
				}

				if(!empty($insert)){

					DB::table('attendance_repos')->insert($insert);

					

				}

			}

		}

		return redirect(url('/importGrade'));

	}
}
