<?php

namespace Project\App\HTTPProcessors;

use PHPixie\HTTP\Request;

// we extend a class that allows Controller-like behavior
class Quickstart extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * The Builder will be used to access
     * various parts of the framework later on
     * @var Project\App\HTTPProcessors\Builder
     */
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    // This is the default action
    public function defaultAction(Request $request)
    {
        return "Quickstart tutorial s";
    }

    public function viewAction(Request $request)
    {
        //Output the 'id' parameter
        return $request->attributes()->get('id');
    }
    
    public function renderAction(Request $request)
    {
        $template = $this->builder->components()->template();
        
        return $template->render(
            'app:quickstart/message',
            array(
                'message' => 'hello'
            )
        );
    }
    
    public function ormAction(Request $request)
    {
        $orm = $this->builder->components()->orm();

        $projects = $orm->query('project')->find();

        //Convert enttities to simple PHP objects
        return $projects->asArray(true);
    }

    public function xxxAction(Request $request)
    {
        // TEST
        $servername = "localhost";
        $username = "root";
        $password = "1";
        $conn = new \mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM quickstart.projects";
        $result = $conn->query($sql);
        $str = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $str .= "id: " . $row["id"] . "<br>";
            }
        }
        return $str;
    }

    public function yyyAction(Request $request)
    {
        $orm = $this->builder->components()->orm();
//        $project = $orm->createEntity('project');
//
//        $project->name = 'Buy Groceries';
//        $project->save();
//
//        $task = $orm->createEntity('task');
//        $task->name = 'Milk';
//        $task->save();
//
//        $project->tasks->add($task);

// Удаление проекта
      //  $project->delete();

// Итерация по загрузчиках
        $str = '';
        $projects = $orm->query('project')->in(1)->find();
//        foreach($projects as $project) {
//            foreach($project->tasks() as $task) {
//                $str .= $task -> name;
//            }
//        }


       /* $projectQuery = $orm->query('project')
            ->where('name', 'Quickstart')->findOne();
        $str = $projectQuery->name;*/

//        $projectQuery = $orm->query('project')
//            ->where('name', 'Quickstart');
//
//        $tasksQuery = $orm->query('task')->limit(5);
//        $projectQuery->tasks->add($tasksQuery);
//        $projectQuery -> findOne();
//        var_dump($projectQuery->tasks());
//        die();
        $project = $orm->query('project')->findOne();

        $str  = (string) $project->isDone();
        return 'd' . $str;
    }
}