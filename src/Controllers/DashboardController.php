<?php

namespace App\Controllers;

use App\Response;
use App\JsonResponse;
use App\Controller;
use App\Core;
use App\Entity\Teacher;
use App\Entity\Student;
use App\Entity\Dashboard;
use App\Model\Validator\DashboardValidator;
use App\Model\Builder\DashboardBuilder;
use App\Model\CrudFactory;

class DashboardController extends Controller
{
    public function gettimes()
    {
        $core = Core::getInstance();
        
        $teacher = $core->getEntityManager()
                ->getRepository(Teacher::class)
                ->find((int)$this->request->getParam('teacher'));
        $week_day = $this->request->getParam('week_day');
        
        if (!$teacher || !in_array($week_day, array_keys(Dashboard::WEEK_DAYS))) {
            return new JsonResponse([
                'status' => 'error',
                'msg' => 'Некорректные данные'
            ]);
        }
        
        $time_list = $this->getTimeList();
        
        $dashboard = $core->getEntityManager()
                ->getRepository(Dashboard::class)
                ->findBy(['week_day' => $week_day, 'course' => $teacher->getCourse()]);
       
        if ($dashboard) {
            $delay_int = \DateInterval::createFromDateString(Dashboard::L_DELAY);
            foreach ($time_list as $k => $item) {
                $l_end = clone($item);
                $l_end = $l_end->add($delay_int);
                foreach ($dashboard as $l) {
                    $item_t = \DateTime::createFromFormat('H:i', $l->getLTime()->format('H:i'));
                    if (($item_t->getTimestamp() >= $item->getTimestamp()) &&
                        ($item_t->getTimestamp() < $l_end->getTimestamp()))
                    {
                        unset($time_list[$k]);
                        break;
                    }
                }
            }
        }
        
        $res = array_map(function($item){return $item->format('H:i');}, $time_list);
        
        return new JsonResponse([
            'status' => 'ok',
            'data' => $res
        ]);
    }
    
	public function add()
	{
        $errors = [];
        $core = Core::getInstance();
        $teachers = $core->getEntityManager()
                ->getRepository(Teacher::class)
                ->getList();
                
        $students = $core->getEntityManager()
                ->getRepository(Student::class)
                ->getList();

        $time_list = $this->getTimeList();

        if ($this->request->isPost()) {
            $validator = new DashboardValidator($core->getEntityManager());
            $builder = new DashboardBuilder($core->getEntityManager());
            $crud = (new CrudFactory($core->getEntityManager()))
                    ->getAddCrud()
                    ->setValidator($validator)
                    ->setBuilder($builder)
                    ->setData([
                        'teacher' => $this->request->getPost('teacher'),
                        'student' => $this->request->getPost('student'),
                        'week_day' => $this->request->getPost('week_day'),
                        'l_time' => $this->request->getPost('l_time'),
                        'time_list' => $time_list
                    ]);
            $errors = $crud->process();
            if (!$errors) {
                $this->setFlashMessage('success', 'Занятие успешно добавлено');
                return $this->redirect('/');
            }
        }

		return new Response('dashboard/edit', [
                'errors' => $errors,
                'mode' => 'add',
                'teachers' => $teachers,
                'students' => $students,
                'week_days' => Dashboard::WEEK_DAYS,
                'time_list' => $time_list
            ]);
	}
    
    protected function getTimeList(): array
    {
        $core = Core::getInstance();
        $time_list = $core->getTimeList(
            Dashboard::START_TIME_STR,
            Dashboard::END_TIME_STR,
            Dashboard::L_DELAY,
        );
        
        return $time_list;
    }
}
