<?php

namespace App\Controllers;

use App\Response;
use App\Controller;
use App\Entity\Dashboard;
use App\Entity\Course;
use App\Core;

class IndexController extends Controller
{
	public function index()
	{
        $core = Core::getInstance();
        $dashboard = $core->getEntityManager()
                ->getRepository(Dashboard::class)
                ->findBy([], ['l_time' => 'ASC']);
        
        $dashboard = $core->getEntityManager()
                ->getRepository(Dashboard::class)
                ->findBy([], ['l_time' => 'ASC']);
        
        $course = $core->getEntityManager()
                ->getRepository(Course::class)
                ->findBy([], ['name' => 'ASC']);
        
        $data = [];
        if ($dashboard) {
            foreach ($dashboard as $item) {
                $data[$item->getCourse()->getId()][$item->getWeekDay()][$item->getLTime()->format('H:i')] = $item;
            }
        }
        
        $time_list = $core->getTimeList(
            Dashboard::START_TIME_STR,
            Dashboard::END_TIME_STR,
            Dashboard::L_DELAY,
        );
        
        
        
		return new Response('index/index', [
            'msg' => $this->getFlashMessage(),
            'course' => $course,
            'days' => Dashboard::WEEK_DAYS,
            'time_list' => $time_list,
            'data' => $data,
        ]);
	}
}
