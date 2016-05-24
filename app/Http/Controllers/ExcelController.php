<?php

namespace App\Http\Controllers;

use Input, Excel, DB;
use App\Http\Controllers\Controller;
use App\Model\Course\Course;
use App\Model\Room\Room;
use Illuminate\Database\QueryException;
use App\Model\DBStatic\Roomtype;
use App\Model\DBStatic\Roomaddr;
use App\Model\DBStatic\Globalval;

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
						    if($course->studnums == '')
						    {
						        $course->studnums =
            						        Globalval::where('name', '=', 'studentnums')
            						        ->get()[0]
            						        ->fieldval;
						    }

						    if($course->coursenums == '')
						    {
						        $course->coursenums = 
						                  Globalval::where('name', '=', 'coursetimes')
						                              ->get()[0]
						                              ->fieldval;
						    }

							try {
								Course::create([
										'sn' => $this->genCourseSN($course->course,
																		1,
																		$course->room,
																		$course->time,
																		$course->cycle,
																		$course->term),
										'course' => $course->course,
										'coursetype' => 1,
										'room' => $course->room,
										'time' => $course->time,
										'cycle' => $course->cycle,
										'term' => $course->term,
										'teacher' => $course->teacher,
										'studnums' => $course->studnums,
										'coursenums' => $course->coursenums,
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
								$name = $room->name;
								$roomtype = $this->syncRoomType($room->type);
								$addr = $this->syncRoomAddr($room->addr);

								Room::create([
										'sn' => $this->genRoomSN($name, $roomtype, $addr),
										'name' => $name,
										'roomtype' => $roomtype,
										'addr' => $addr,
										'status' => $this->getRoomStatus($room->status),
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

	public static function genCourseSN($course, $coursetype, $room, $time, $cycle, $term)
	{
		$strs = [$course, $coursetype, $room, $time, $cycle, $term];
		$ran = '';
		foreach ($strs as $str)
		{
			if($str != null && $str != 'null')
			{
				$ran .= $str;
			}
			else
			{
				$ran .= '0';
			}
		}

		return substr(hexdec(md5($ran)), 2, 8);
	}

	public static  function genRoomSN($name, $roomtype, $addr)
	{
		$ran = substr(hexdec(md5($name)), 2, 4);

		if($addr < 10)
		{
			$addr = '0'.$addr;
		}

		if($roomtype < 10)
		{
			$roomtype = '0'.$roomtype;
		}

		return $addr.$roomtype.$ran;
	}

	private function syncRoomType($s)
	{
		if($s == null)
		{
			return 0;
		}

		$roomTypes = Roomtype::all();
		$typeId = 0;

		foreach ($roomTypes as $type)
		{
			$typeId = max([$type->roomtype, $typeId]);

			if(stristr($type->roomtype, $s)
				|| stristr($type->val, $s))
			{
				return $type->roomtype;
			}
		}

		$typeId++;

		Roomtype::create([
				'roomtype' => $typeId,
				'val' => $s,
		]);

		return $typeId;
	}

	private function syncRoomAddr($s)
	{
		if ($s == null)
		{
			return 0;
		}

		$roomaddr = DB::table('roomaddrs')->where('val', $s)->get();
		if(count($roomaddr) > 0)
		{
			return $roomaddr[0]->roomaddr;
		}
		else
		{
			$roomaddrs = Roomaddr::all();
			$addrId = 0;
			foreach ($roomaddrs as $addr)
			{
				$addrId = max([$addr->roomaddr, $addrId]);
			}
			$addrId++;

			Roomaddr::create([
				'roomaddr' => $addrId,
				'val' => $s,
				]);

			return $addrId;
		}
	}

	public static function getRoomStatus($s)
	{
		if(stristr('正使用', $s)
				|| stristr('1', $s))
		{
			return '1';
		}
	
		return '0';
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
