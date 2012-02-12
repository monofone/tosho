<?php

namespace Blage\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of TaskListType
 *
 * @author srohweder
 */
class TaskListType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('listTitle');
        $builder->add('tasks', 'collection', array('type' => new TaskType()));
    }
    
    public function getName()
    {
        return 'task_list';
    }
}
