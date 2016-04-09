<?php

namespace App\Http\Controllers;

use Input, Excel;
use App\Http\Controllers\Controller;
use App\Model\Course\Course;
use App\Model\Room\Room;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Database\QueryException;

class ExcelController extends Controller
{
	public $xlsTypes = [
			'text/plain',
			'application/vnd.ms-excel',
			'application/vnd.ms-office',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	];

	public function xlsupload()
	{
		return view('xls.upload');
	}

	public function import(){
		$file = Input::file('xlsfile');
		if($file == null)
		{
			return '<script type="text/javascript">(function(){alert("未选择任何文件");history.back(-1);})();</script>';
		}

		if ($this->xlsFileMatch($file))
		{
			$fileName = $file->getRealPath();

			Excel::load($fileName, function($reader) {
				$results = $reader->all();
				dd($results);
			});
		}
		else
		{
			return '<p>Can\'t match type for excel</p><p>File Type: "'.$file->getMimeType().'"</p>';
		}
	}

	public function courselist(){
		$file = Input::file('xlsfile');
		if($file == null)
		{
			return '<script type="text/javascript">(function(){alert("未选择任何文件");history.back(-1);})();</script>';
		}
	
		if ($this->xlsFileMatch($file))
		{
			$fileName = $file->getRealPath();
	
			Excel::load($fileName, function($reader) {
				$results = $reader->all();
				foreach ($results as $sheet)
				{
					if(strstr($sheet->getTitle(), '课程')
							|| stristr($sheet->getTitle(), 'COURSE'))
					{
						foreach ($sheet as $course)
						{
							try {
								Course::create([
										'sn' => $course->sn,
										'course' => $course->course,
										'room' => $course->room,
										'time' => $course->time,
										'cycle' => $course->cycle,
										'term' => $course->term,
										'teacher' => $course->teacher,
										'remarks' => $course->remarks,
								]);
							} catch (QueryException $e) {
							}
						}
						break;
					}
				}
			});
	
				return '<script type="text/javascript">(function(){alert("OK");history.back(-1);})();</script>';
		}
		else
		{
			return '<p>Can\'t match type for excel</p><p>File Type: "'.$file->getMimeType().'"</p>';
		}
	}

	public function roomlist(){
		$file = Input::file('xlsfile');
		if($file == null)
		{
			return '<script type="text/javascript">(function(){alert("未选择任何文件");history.back(-1);})();</script>';
		}

		if ($this->xlsFileMatch($file))
		{
			$fileName = $file->getRealPath();

			Excel::load($fileName, function($reader) {
				$results = $reader->all();
				foreach ($results as $sheet)
				{
					if(strstr($sheet->getTitle(), '教室')
						|| stristr($sheet->getTitle(), 'ROOM'))
					{
						foreach ($sheet as $room)
						{
							try {
								Room::create([
										'sn' => $room->sn,
										'name' => $room->name,
										'roomtype' => $room->type,
										'addr' => $room->addr,
										'status' => $room->status,
										'user' => $room->user,
										'owner' => $room->owner,
										'remarks' => $room->remarks,
								]);
							} catch (QueryException $e) {
							}
						}
						break;
					}
				}
			});

			return '<script type="text/javascript">(function(){alert("OK");history.back(-1);})();</script>';
		}
		else
		{
			return '<p>Can\'t match type for excel</p><p>File Type: "'.$file->getMimeType().'"</p>';
		}
	}
	
	private function xlsFileMatch($file)
	{
		if($file != null && $file->isValid()) {
			$fileType = $file->getMimeType();
			foreach ($this->xlsTypes as $xlsType)
			{
				if ($xlsType == $fileType)
				{
					return true;
				}
			}
		}

		return false;
	}
}
